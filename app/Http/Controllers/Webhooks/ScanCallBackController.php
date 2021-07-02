<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScanCallbackRequest;
use App\Support\CallbackProcessor\CallbackProcessorFactory;

class ScanCallBackController extends Controller
{
    public function __invoke(ScanCallbackRequest $request)
    {
        CallbackProcessorFactory::scan($request)->process();

        return response(['success' => true]);
    }
}
