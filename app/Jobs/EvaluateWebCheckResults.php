<?php

namespace App\Jobs;

use App\Actions\WebCheck\ResultsEvaluation\EvaluateWebCheckResultsAction;
use App\Support\CallbackProcessor\Data\WebCheckPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;

class EvaluateWebCheckResults implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public Collection $uuids;

    public function __construct(WebCheckPayload $payload)
    {
        $this->uuids = $payload->results->pluck('id')->unique();
        $this->onQueue('evaluation');
    }

    public function handle(EvaluateWebCheckResultsAction $evaluateWebCheckResultsAction)
    {
        $evaluateWebCheckResultsAction($this->uuids);
    }

    public function uniqueId()
    {
        return md5('web-check'.$this->uuids->sort()->toJson());
    }
}
