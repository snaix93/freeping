<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebCheckCallbackRequest;
use App\Support\CallbackProcessor\CallbackProcessorFactory;

class WebCheckCallBackController extends Controller
{
    public function __invoke(WebCheckCallbackRequest $request)
    {
        CallbackProcessorFactory::webCheck($request)->process();

        return response(['success' => true]);
    }
}
