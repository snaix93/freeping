<?php

namespace App\Jobs;

use App\Actions\Scan\ResultsEvaluation\EvaluateScanResultsAction;
use App\Support\CallbackProcessor\Data\ScanPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;

class EvaluateScanResults implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public Collection $connects;

    public function __construct(ScanPayload $payload)
    {
        $this->connects = $payload->results->pluck('connect')->unique();
        $this->onQueue('evaluation');
    }

    public function handle(EvaluateScanResultsAction $evaluateScanResultsAction)
    {
        $evaluateScanResultsAction($this->connects);
    }

    public function uniqueId()
    {
        return md5('scan'.$this->connects->sort()->toJson());
    }
}
