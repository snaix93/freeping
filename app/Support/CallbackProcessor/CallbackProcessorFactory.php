<?php

namespace App\Support\CallbackProcessor;

use App\Http\Requests\PingCallbackRequest;
use App\Http\Requests\ScanCallbackRequest;
use App\Http\Requests\WebCheckCallbackRequest;
use App\Support\CallbackProcessor\Data\PingPayload;
use App\Support\CallbackProcessor\Data\ScanPayload;
use App\Support\CallbackProcessor\Data\WebCheckPayload;

class CallbackProcessorFactory
{
    public static function ping(PingCallbackRequest $request): PingCallbackProcessor
    {
        return new PingCallbackProcessor(new PingPayload(
            results: $request->results,
            nodeId: $request->node_id,
            batchId: $request->id,
            jobType: $request->job_type,
            jobDurationInSeconds: $request->job_duration_sec,
            date: $request->input('date.datetime')
        ));
    }

    public static function scan(ScanCallbackRequest $request): ScanCallbackProcessor
    {
        return new ScanCallbackProcessor(new ScanPayload(
            results: $request->results,
            nodeId: $request->node_id,
            batchId: $request->id,
            jobType: $request->job_type,
            jobDurationInSeconds: $request->job_duration_sec,
            date: $request->input('date.datetime')
        ));
    }

    public static function webCheck(WebCheckCallbackRequest $request): WebCheckCallbackProcessor
    {
        return new WebCheckCallbackProcessor(new WebCheckPayload(
            results: $request->results,
            nodeId: $request->node_id,
            batchId: $request->id,
            jobType: $request->job_type,
            jobDurationInSeconds: $request->job_duration_sec,
            date: $request->input('date.datetime')
        ));
    }
}
