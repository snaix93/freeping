<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Http\Requests\PingCallbackRequest;
use App\Support\CallbackProcessor\CallbackProcessorFactory;

class PingCallBackController extends Controller
{
    public function __invoke(PingCallbackRequest $request)
    {
        CallbackProcessorFactory::ping($request)->process();

        return response(['success' => true]);
    }
}
