<?php

namespace App\Console\Commands;

use App\Models\Batch;
use App\Models\Node;
use App\Models\WebCheck;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\SignalAwareCommand\SignalAwareCommand;

class WebCheckDispatch extends SignalAwareCommand
{
    protected $signature = 'web-check:dispatch {--reset}{--daemon}';

    protected $description = 'Dispatch web checks to the pinger nodes';

    public function handle()
    {
        if ($this->option('reset')) {
            $this->reset();
        }

        if ($this->option('daemon')) {
            $this->info("Dispatching web checks to check nodes. Daemon mode.");
            while (true) {
                $this->dispatch();
                sleep(10);
            }
        } else {
            $this->info("Dispatching web checks to check nodes. Single run mode.");
            $this->dispatch();
        }
    }

    private function reset(): void
    {
        DB::table('web_check_results')->truncate();
        DB::table('web_check_in_progress')->truncate();
        DB::table('batches')->truncate();
        $this->info('All web check targets reset.');
    }

    public function dispatch()
    {
        if (value($targets = $this->getDueWebChecks())->isEmpty()) {
            $this->info($info = 'No web checks due for checking. Bail.');
            logger("WebCheck:Dispatch:: {$info}");

            return 1;
        }

        $batchId = Str::uuid()->toString();
        foreach (Node::all() as $node) {
            // Create a new batch for each ping node
            // See https://bitbucket.org/cloudradar/pinger/src/develop/README.md
            $webCheckBatch = Batch::create([
                'id'                => $batchId,
                'node_id'           => $node->id,
                'checks_dispatched' => $targets->count(),
            ]);

            // Dispatch the checks to the webcheck node
            $payload = [
                'id'       => $webCheckBatch->id,
                'targets'  => $targets->all(),
                'callback' => route('web-check.callback'),
            ];

            $dispatchResponse = Http::withBody(json_encode($payload), 'application/json')
                ->withToken($node->request_token)
                ->withUserAgent('php-freeping.io')
                ->post($nodeUrl = "https://{$node->url}/webcheck");

            Log::info(sprintf(
                "WebCheck:Dispatch - Dispatched %d checks to %s. Got Http Status %d",
                $targets->count(),
                $nodeUrl,
                $dispatchResponse->status()
            ));

            if ($dispatchResponse->status() !== 200) {
                Log::error(
                    sprintf('Dispatching checks to %s failed', $nodeUrl),
                    ['requestPayload' => $payload, 'responseBody' => $dispatchResponse->body()]
                );
            }
        }

        $this->markTargetsInProgress($targets);

        return 0;
    }

    private function getDueWebChecks(): Collection
    {
        return WebCheck::query()
            ->select([
                'web_checks.uuid',
                'web_checks.url',
                'web_checks.method',
                'web_checks.expected_http_status',
                'web_checks.search_html_source',
                'web_checks.expected_pattern',
                'web_checks.headers',
            ])
            ->join('users', 'users.id', 'web_checks.user_id')
            ->whereNotNull('users.email_verified_at')
            ->whereNotExists(function ($query) {
                $query
                    ->select(DB::raw(1))
                    ->from('web_check_in_progress')
                    ->whereColumn('web_check_in_progress.identifier', 'web_checks.uuid');
            })
            ->whereNotExists(function ($query) {
                $query
                    ->select(DB::raw(1))
                    ->from('web_check_results')
                    ->whereColumn('web_check_results.uuid', 'web_checks.uuid')
                    ->where('updated_at', '>=', now()->subMinute())
                    ->latest();
            })
            ->take(100)
            ->toBase()->get()
            ->map(function ($webCheck) {
                if (! is_null($webCheck->headers)) {
                    $webCheck->headers = collect(json_decode($webCheck->headers, true))
                        ->mapWithKeys(fn($item) => [$item['key'] => $item['value']])
                        ->all();
                }

                return [
                    'id'                   => $webCheck->uuid,
                    'url'                  => $webCheck->url,
                    'method'               => Str::lower($webCheck->method),
                    'expected_http_status' => $webCheck->expected_http_status,
                    'search_html_source'   => (bool) $webCheck->search_html_source,
                    'expected_pattern'     => $webCheck->expected_pattern,
                    'headers'              => $webCheck->headers,
                ];
            });
    }

    private function markTargetsInProgress(Collection $targets): void
    {
        DB::table('web_check_in_progress')->upsert(
            $targets->pluck('id')->map(fn($id) => ['identifier' => $id])->all(),
            'identifier'
        );
    }

    public function onSigint()
    {
        DB::table('web_check_in_progress')->truncate();
        DB::table('batches')->truncate();
        $this->info('You stopped the command!');
    }
}
