<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::controller(SupplierController::class)->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'storeSupplier')->name('store');
    Route::get('/get-suppliers', 'getSupplier')->name('getSupplier');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/product', 'index')->name('index');
    Route::post('/product/store', 'storeProduct')->name('product.store');
    Route::get('/product/get-products', 'getProducts')->name('product.getProducts');
    Route::get('/product/get-product', 'getProduct')->name('product.getProduct');
    Route::post('/product/update','updateProduct')->name('product.updateProduct');
});