<?php

namespace App\Http\Controllers;

use App\Support\Backdoor;
use Illuminate\Support\Str;

class BackdoorController extends Controller
{
    public function __invoke(string $state)
    {
        Backdoor::$state();

        $state = $state === 'open' ? 'open' : 'closed';

        return response(Str::upper("🚪🕵 Backdoor is {$state}"));
    }
}
