<?php

namespace App\Http\Controllers;

use App\Data\Omc\CaptureData;
use App\Http\Requests\CaptureRequest;
use App\Http\Resources\OmcResource;
use App\Jobs\ProcessCaptureRequest;

class CaptureController extends Controller
{
    public function show(CaptureRequest $request)
    {
        ProcessCaptureRequest::dispatch(CaptureData::fromStoreRequest($request));

        //return ['data' => $request->input()];
        return OmcResource::make([]);
    }
}
