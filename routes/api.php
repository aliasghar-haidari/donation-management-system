<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/signin', [\App\Http\Controllers\Auth\AuthController::class, 'signin']);
Route::middleware('auth:sanctum')->post('/signout', [\App\Http\Controllers\Auth\AuthController::class, 'signout']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', \App\Http\Controllers\User\UserController::class);