<?php

use App\Http\Controllers\Api\PlaceApiController;
use App\Http\Controllers\Api\ThingApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('api.user');

    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::apiResource('things', ThingApiController::class)->names([
        'index' => 'api.things.index',
        'show' => 'api.things.show',
        'store' => 'api.things.store',
        'update' => 'api.things.update',
        'destroy' => 'api.things.destroy',
    ]);

    Route::apiResource('places', PlaceApiController::class)->names([
        'index' => 'api.places.index',
        'show' => 'api.places.show',
        'store' => 'api.places.store',
        'update' => 'api.places.update',
        'destroy' => 'api.places.destroy',
    ]);
});

