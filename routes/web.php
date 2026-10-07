<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatkerController;
use App\Http\Controllers\SbmController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [
    DashboardController::class,
    'index',
])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:manage master data'])
    ->group(function () {
        Route::resource('satker', SatkerController::class);
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('place', PlaceController::class);
        Route::resource('sbm', SbmController::class);
    });

Route::middleware(['auth', 'permission:view users'])
    ->group(function () {
        Route::resource('user', UserController::class);
    });

require __DIR__.'/auth.php';
