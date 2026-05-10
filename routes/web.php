<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginSubmit'])->name('auth.login.submit');

Route::middleware(['auth'])->prefix('panel')->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('dropdowns-country', [DropdownController::class, 'country'])->name('dropdowns.country');
    Route::get('dropdowns-state', [DropdownController::class, 'state'])->name('dropdowns.state');
    Route::get('dropdowns-city', [DropdownController::class, 'city'])->name('dropdowns.city');
    Route::get('dropdowns-area', [DropdownController::class, 'area'])->name('dropdowns.area');

    Route::get('web-data', [SettingController::class, 'webData'])->name('settings.web-data');
    Route::post('web-data-submit', [SettingController::class, 'webDataSubmit'])->name('settings.web-data-submit');

    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('areas', AreaController::class);

    // Vendors
    Route::resource('vendors', VendorController::class);
    Route::get('vendors-joining-request', [VendorController::class, 'joiningRequest'])->name('vendors.joining.request');
    Route::get('vendors-blocked-list', [VendorController::class, 'blockedList'])->name('vendors.blocked.list');
});
