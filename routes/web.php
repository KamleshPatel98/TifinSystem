<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginSubmit'])->name('auth.login.submit');

Route::middleware(['auth'])->prefix('panel')->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('dropdowns-state', [DropdownController::class, 'state'])->name('dropdowns.state');


    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('areas', AreaController::class);
});
