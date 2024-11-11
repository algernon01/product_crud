<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);
Route::delete('product-images/{image}', [ProductController::class, 'destroyImage'])->name('product.images.destroy');
Route::delete('/products/images/{image}', [ProductImageController::class, 'destroy'])->name('product.images.destroy');
Route::delete('/product/images/{id}', [ProductController::class, 'destroyImage'])->name('product.images.destroy');
Route::put('/product/images/update', [ProductImageController::class, 'update'])->name('product.images.update');


