<?php

use App\Events\CallNotification;
use App\Http\Controllers\CallController;
use App\Models\Call;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/calls', [CallController::class, 'store']);
