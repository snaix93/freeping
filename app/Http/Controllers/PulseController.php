<?php

namespace App\Http\Controllers;

use App\Data\Omc\PulseData;
use App\Http\Requests\PulseRequest;
use App\Http\Resources\OmcResource;
use App\Models\Pulse;

class PulseController extends Controller
{
    public function update(PulseRequest $request)
    {
        Pulse::store(PulseData::fromStoreRequest($request));

        return OmcResource::make([]);
    }
}
