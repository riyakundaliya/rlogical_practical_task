<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {

    Route::get('/index', [AdminController::class, 'index'])->name('admin.index');

    /** Category crud routes */
    Route::get('/category/add', [CategoryController::class, 'add'])->name('admin.category.add');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('/category/update', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->name('admin.category.delete');

    /** Product crud routes */
    Route::get('/product/index', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/product/add', [ProductController::class, 'add'])->name('admin.product.add');
    Route::post('/product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::post('/product/update', [ProductController::class, 'update'])->name('admin.product.update');
    Route::get('/product/delete/{id}', [ProductController::class, 'delete'])->name('admin.product.delete');

    Route::get('/user_cart', [AdminController::class, 'user_cart'])->name('user.cart');
});


Route::prefix('front')->middleware(['auth:user'])->group(function () {

    Route::get('/', [FrontController::class, 'products'])->name('front.products');
    Route::post('/cart/add/{productId}', [FrontController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [FrontController::class, 'viewCart'])->name('front.cart.view');
    Route::get('/cart/remove/{cartItem}', [FrontController::class, 'removeFromCart'])->name('cart.remove'); 
    
});