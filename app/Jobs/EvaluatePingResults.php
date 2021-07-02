<?php

namespace App\Jobs;

use App\Actions\Ping\ResultsEvaluation\EvaluatePingResultsAction;
use App\Support\CallbackProcessor\Data\PingPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;

class EvaluatePingResults implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public Collection $connects;

    public function __construct(PingPayload $payload)
    {
        $this->connects = $payload->results->pluck('connect')->unique();
        $this->onQueue('evaluation');
    }

    public function handle(EvaluatePingResultsAction $evaluateConnectsAction)
    {
        $evaluateConnectsAction($this->connects);
    }

    public function uniqueId()
    {
        return md5('ping'.$this->connects->sort()->toJson());
    }
}
