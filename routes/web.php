<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::controller(SupplierController::class)->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'storeSupplier')->name('store');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/product', 'index')->name('index');
    Route::post('/product/store', 'storeProduct')->name('product.store');
});