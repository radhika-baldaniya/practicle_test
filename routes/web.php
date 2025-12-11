<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Customers
    Route::resource('customers', CustomerController::class)->names('customers');

    // Orders (index, create, store, show)
    Route::resource('orders', OrderController::class)->except(['edit','update','destroy'])->names('orders');

    // Order status update (separate route)
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});



