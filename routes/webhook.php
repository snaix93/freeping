<?php

use App\Http\Controllers\Webhooks\PingCallBackController;
use App\Http\Controllers\Webhooks\ScanCallBackController;
use App\Http\Controllers\Webhooks\WebCheckCallBackController;
use Illuminate\Support\Facades\Route;

Route::prefix('callback')->group(function () {
    Route::post('pinger', PingCallBackController::class)->name('pinger.callback');
    Route::post('scanner', ScanCallBackController::class)->name('scanner.callback');
    Route::post('web-check', WebCheckCallBackController::class)->name('web-check.callback');
});
