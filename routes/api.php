<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Api')->prefix('api')->group(function () {
    
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
//    Route::post('password/reset', [\App\Http\Controllers\Api\AuthController::class, 'register']);
//    Route::post('password/reset/{token}', [\App\Http\Controllers\Api\AuthController::class, 'register']);

    
    Route::middleware('auth:api')->group(function () {
//        Route::view('email/verify', 'auth.verify')->middleware('throttle:6,1')->name('verification.notice');
//        Route::get('email/verify/{id}/{hash}', 'Auth\EmailVerificationController')->middleware('signed')->name('verification.verify');
        Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
        Route::post('refresh-token', [\App\Http\Controllers\Api\AuthController::class, 'refresh']);
        Route::post('me', [\App\Http\Controllers\Api\AuthController::class, 'me']);
    });
});
