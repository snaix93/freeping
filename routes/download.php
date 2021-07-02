<?php

use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/download/{file}', [DownloadController::class, 'show']);
