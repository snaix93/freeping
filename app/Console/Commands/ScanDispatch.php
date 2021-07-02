<?php

namespace App\Console\Commands;

use App\Models\Batch;
use App\Models\Node;
use App\Models\Target;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\SignalAwareCommand\SignalAwareCommand;

class ScanDispatch extends SignalAwareCommand
{
    protected $signature = 'scan:dispatch {--reset}{--daemon}';

    protected $description = 'Dispatch TCP port checks to the pinger nodes';

    public function handle()
    {
        if ($this->option('reset')) {
            $this->reset();
        }

        if ($this->option('daemon')) {
            $this->info("Dispatching ports to check nodes. Daemon mode.");
            while (true) {
                $this->dispatch();
                sleep(10);
            }
        } else {
            $this->info("Dispatching ports to check nodes. Single run mode.");
            $this->dispatch();
        }
    }

    private function reset(): void
    {
        DB::table('scan_results')->truncate();
        DB::table('scan_in_progress')->truncate();
        DB::table('batches')->truncate();
        $this->info('All scan ports reset.');
    }

    public function dispatch()
    {
        if (value($targets = $this->getDueTargets())->isEmpty()) {
            $this->info($info = 'No targets due for checking. Bail.');
            logger("Scan:Dispatch:: {$info}");

            return 1;
        }

        $batchId = Str::uuid()->toString();
        foreach (Node::all() as $node) {
            // Create a new batch for each ping node
            // See https://bitbucket.org/cloudradar/pinger/src/develop/README.md
            $scanBatch = Batch::create([
                'id'                => $batchId,
                'node_id'           => $node->id,
                'checks_dispatched' => $targets->count(),
            ]);

            // Dispatch the checks to the scan node
            $payload = [
                'id'       => $scanBatch->id,
                'targets'  => $targets->all(),
                'callback' => route('scanner.callback'),
            ];

            $dispatchResponse = Http::withBody(json_encode($payload), 'application/json')
                ->withToken($node->request_token)
                ->withUserAgent('php-freeping.io')
                ->post($nodeUrl = "https://{$node->url}/scan");

            Log::info(sprintf(
                "Scan:Dispatch - Dispatched %d checks to %s. Got Http Status %d",
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

    private function getDueTargets(): Collection
    {
        return Target::alive()
            ->select('targets.connect', 'port')
            ->distinct()
            ->join('ports', 'targets.id', 'ports.target_id')
            ->join('users', 'users.id', 'ports.user_id')
            ->whereNotNull('users.email_verified_at')
            ->whereNotExists(function ($query) {
                $query
                    ->select(DB::raw(1))
                    ->from('scan_in_progress')
                    ->whereColumn('scan_in_progress.identifier', 'targets.connect');
            })
            ->whereNotExists(function ($query) {
                $query
                    ->select(DB::raw(1))
                    ->from('scan_results')
                    ->whereColumn('scan_results.connect', 'targets.connect')
                    ->where('updated_at', '>=', now()->subMinute())
                    ->latest();
            })
            ->take(100)
            ->toBase()->get()
            ->mapToGroups(fn($target) => [
                $target->connect => $target->port,
            ])
            ->map(fn($ports, $target) => [
                'ports'   => $ports->all(),
                'connect' => $target,
            ])
            ->values();
    }

    private function markTargetsInProgress(Collection $targets): void
    {
        DB::table('scan_in_progress')->upsert(
            $targets->map(fn($target) => ['identifier' => $target['connect']])->all(),
            'identifier'
        );
    }

    public function onSigint()
    {
        DB::table('scan_in_progress')->truncate();
        DB::table('batches')->truncate();
        $this->info('You stopped the command!');
    }
}
