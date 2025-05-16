<?php

use App\Http\Controllers\Donor\DonationCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\User\UserResource;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Donor\DonorController;

Route::post('/signin', [AuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/signout', [AuthController::class, 'signout']);

    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::apiResource('users', UserController::class);
    Route::apiResource('donors', DonorController::class);
    Route::apiResource('donation-categories', DonationCategoryController::class);
});
