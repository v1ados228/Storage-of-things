<?php

use App\Http\Controllers\Api\PlaceApiController;
use App\Http\Controllers\Api\ThingApiController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\ThingUseController;
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

Route::prefix('v1')->group(function () {
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
});

Route::middleware(['web', 'auth:sanctum'])->prefix('app')->group(function () {
    Route::get('/things', [ThingController::class, 'index'])->name('things.index');
    Route::get('/things/create', [ThingController::class, 'create'])->name('things.create');
    Route::post('/things', [ThingController::class, 'store'])->name('things.store');
    Route::get('/things/{thing}', [ThingController::class, 'show'])->name('things.show');
    Route::get('/things/{thing}/edit', [ThingController::class, 'edit'])->name('things.edit');
    Route::put('/things/{thing}', [ThingController::class, 'update'])->name('things.update');
    Route::delete('/things/{thing}', [ThingController::class, 'destroy'])->name('things.destroy');
    Route::post('/things/{thing}/descriptions', [ThingController::class, 'addDescription'])->name('things.descriptions.store');
    Route::post('/things/{thing}/descriptions/{description}', [ThingController::class, 'setCurrentDescription'])->name('things.descriptions.current');

    Route::get('/things/{thing}/assign', [ThingUseController::class, 'create'])->name('things.assign');
    Route::post('/things/{thing}/assign', [ThingUseController::class, 'store'])->name('things.assign.store');

    Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
    Route::get('/places/create', [PlaceController::class, 'create'])->name('places.create');
    Route::post('/places', [PlaceController::class, 'store'])->name('places.store');
    Route::get('/places/{place}/edit', [PlaceController::class, 'edit'])->name('places.edit');
    Route::put('/places/{place}', [PlaceController::class, 'update'])->name('places.update');
    Route::delete('/places/{place}', [PlaceController::class, 'destroy'])->name('places.destroy');

    Route::get('/admin/things', [ThingController::class, 'adminIndex'])->name('admin.things.index');

    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive.index');
    Route::post('/archive/{archive}/restore', [ArchiveController::class, 'restore'])->name('archive.restore');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
});
