<?php

use Illuminate\Support\Facades\Route;


// API routes for Auth module (add as needed)

use Modules\Auth\Http\Controllers\AuthController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('auths', AuthController::class)->names('auth');
});

