<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::controller(SupplierController::class)->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'storeSupplier')->name('store');
    Route::get('/get-suppliers', 'getSuppliers')->name('getSuppliers');
    Route::get('/get-supplier', 'getSupplier')->name('getSupplier');
    Route::post('/update', 'updateSupplier')->name('updateSupplier');
    Route::post('/delete', 'deleteSupplier')->name('deleteSupplier');
    Route::post('/delete-multiple','deleteMultipleSupplier')->name('deleteMultipleSupplier');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/product', 'index')->name('index');
    Route::post('/product/store', 'storeProduct')->name('product.store');
    Route::get('/product/get-products', 'getProducts')->name('product.getProducts');
    Route::get('/product/get-product', 'getProduct')->name('product.getProduct');
    Route::post('/product/update','updateProduct')->name('product.updateProduct');
    Route::post('/product/delete','deleteProduct')->name('product.delete');
    Route::post('/product/delete-multiple','deleteMultipleProduct')->name('product.deleteMultipleProduct');
});