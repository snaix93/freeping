<?php

use App\Http\Controllers\PulseController;
use Illuminate\Support\Facades\Route;

// Create a subdomain routing so people can submit the pulse to pulse.freeping.io.
preg_match("/http[s]?:\/\/(.*?)?(\/.*)*$/", config('app.pulse_url'), $match);
$pulseDomain = $match[1];
Route::domain($pulseDomain)->group(function () {
    Route::match(['get', 'post'], '/', [PulseController::class, 'update']);
});

Route::match(['get', 'post'], '/pulse', [PulseController::class, 'update']);
