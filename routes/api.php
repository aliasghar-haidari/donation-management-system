<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\User\UserResource;

Route::post('/signin', [\App\Http\Controllers\Auth\AuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/signout', [\App\Http\Controllers\Auth\AuthController::class, 'signout']);

    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::apiResource('users', \App\Http\Controllers\User\UserController::class);
    Route::apiResource('donors', \App\Http\Controllers\Donor\DonorController::class);
    Route::apiResource('donation-causes', \App\Http\Controllers\Donor\DonationCauseController::class);

    Route::apiResource('currencies', \App\Http\Controllers\Currency\CurrencyController::class);
    Route::patch('/currencies/{currency}/toggle', [\App\Http\Controllers\Currency\CurrencyController::class, 'toggle']);

    Route::apiResource('accounts', \App\Http\Controllers\Accounting\AccountController::class);
});
