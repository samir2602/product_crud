<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

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

Auth::routes();


Route::resource('/product', App\Http\Controllers\ProductController::class)->middleware(AdminMiddleware::class);
Route::post('/change_status/{id}', [App\Http\Controllers\ProductController::class, 'change_status'])->name('change_status')->middleware(AdminMiddleware::class);    


Route::middleware('auth')->group(function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');    
    Route::get('/add_to_cart/{id}', [App\Http\Controllers\CartController::class, 'add_to_cart'])->name('add_to_cart');    
    Route::get('/chekcout', [App\Http\Controllers\CartController::class, 'chekcout'])->name('chekcout');    
    Route::post('/order', [App\Http\Controllers\CartController::class, 'order'])->name('order');    
    Route::resource('/cart', App\Http\Controllers\CartController::class);
});