<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginSubmit'])->name('auth.login.submit');

Route::middleware(['auth'])->prefix('panel')->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');
    Route::get('change-password', [AuthController::class, 'changePassword'])->name('auth.change-password');
    Route::post('change-password-submit', [AuthController::class, 'changePasswordSubmit'])->name('auth.change-password-submit');
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
    Route::get('vendors-resignation-request', [VendorController::class, 'resignationRequest'])->name('vendors.resignation.request');
    Route::get('vendors-suspended-list', [VendorController::class, 'suspendedList'])->name('vendors.suspended.list');

    // Customer
    Route::resource('customers', CustomerController::class);
    Route::get('customer-search', [CustomerController::class, 'customerSearch'])->name('customers.search');
    Route::post('customers-plan-store', [CustomerController::class, 'planStore'])->name('customers.plan.store');
    Route::post('customers-payment-store', [CustomerController::class, 'paymentStore'])->name('customers.payment.store');
    Route::put('subscriptions-status/{id}',[CustomerController::class, 'updateSubscriptionStatus'])->name('subscriptions.status.update');
    Route::delete('subscriptions/{id}',[CustomerController::class, 'subscriptionDestroy'])->name('subscriptions.destroy');
    Route::post('customers-address-store', [CustomerController::class, 'addressStore'])->name('customers.address.store');
    
    // Plans
    Route::resource('plans', PlanController::class);

    // Subscription
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');


    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');

    // Leave
    Route::resource('leaves', LeaveController::class);

    // Transaction
    Route::resource('transactions', TransactionController::class);

    Route::get('ledgers', [LedgerController::class, 'index'])->name('ledgers.index');
});
