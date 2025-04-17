<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::controller(SupplierController::class)->group(function(){
    Route::get('/', 'index')->name('index');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/product', 'index')->name('index');
});