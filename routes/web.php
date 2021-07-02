<?php

use App\Http\Controllers\BackdoorController;
use App\Http\Controllers\CreatePasswordController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Livewire\Pinger\PingerIndex;
use App\Http\Livewire\ProblemIndex;
use App\Http\Livewire\Pulse\PulseIndex;
use App\Http\Livewire\SslCheck\SslCheckIndex;
use App\Http\Livewire\WebCheck\WebCheckIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'public.home')->name('home');

Route::get('/LgsTMR/9pv1Yq/backdoor/{state}', BackdoorController::class)
    ->where(['state' => 'open|close'])
    ->name('spam.backdoor');

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('create-password')->name('create-password.')->group(function () {
        Route::view('/', 'public.auth.create-password')->name('index');
        Route::post('/', CreatePasswordController::class)->name('store');
    });

    Route::middleware(['password.exists', 'verified'])->group(function () {
        Route::get('pingers', PingerIndex::class)->name('pingers');
        Route::get('web-checks', WebCheckIndex::class)->name('web-checks');
        Route::get('pulses', PulseIndex::class)->name('pulses');
        Route::get('problems', ProblemIndex::class)->name('problems');
        Route::view('settings', 'settings.show')->name('settings.show');
        Route::get('ssl-certificates', SslCheckIndex::class)->name('ssl-certificates');

        Route::view('captures', 'pages.coming-soon')->name('captures');
    });

});
