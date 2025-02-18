<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;





// Load frontend
Route::get('/', function () {
    return view('products'); 
});
Route::get('/products/list', [ProductController::class, 'index']);  // List Products
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);  // Show Product (for editing)
Route::put('/products/{id}', [ProductController::class, 'update']);  // Update Product
Route::delete('/products/{id}', [ProductController::class, 'destroy']);  // Delete Product
