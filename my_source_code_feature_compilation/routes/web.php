<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/',[PageController::class, 'index']);

// Crud
Route::get('/products', function () {
    return view('products'); 
});

// Crud
Route::get('/products/list', [ProductController::class, 'index']);
