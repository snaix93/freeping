<?php

use App\Http\Controllers\CaptureController;
use Illuminate\Support\Facades\Route;

Route::domain('capture.freeping.{tld}')->group(function () {
    Route::post('/capture', [CaptureController::class, 'show']);
});

Route::post('/capture', [CaptureController::class, 'show']);
