<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\ThingUseController;
use App\Http\Controllers\WebAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('things.index');
});

Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::prefix('app')->middleware(['auth:sanctum'])->group(function () {
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
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
});
