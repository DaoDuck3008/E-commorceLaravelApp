<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;

# Public routes (Customer có thể vào)
Route::get('/', [HomeController::class, 'index']);
Route::get('/products/search',[ProductController::class,'searchForCus'])->name('products.searchCustomer');
Route::get('products/{productID}',[ProductController::class,'show'])->name('product.show');


Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class,'create']);
Route::get('/login',[AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class,'login']);

Route::get('/find-all-categories', [CategoryController::class,'getAllCategories']);
Route::get('/brands-by-category/{categoryID}', [BrandController::class,'getByCategory']);

// Chỉ khi đăng nhập mới có thể vào
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
    Route::get('user/profile/{userID}',[UserController::class,'profile'])->name('user.profile');
    Route::get('/user/overall/{userID}',[UserController::class,'overall'])->name('user.overall');
    Route::get('/user/edit/{userID}',[UserController::class,'editCustomer'])->name('user.edit');
    Route::put('/user/{userID}',[UserController::class,'update']);
    Route::middleware('auth')->group(function () {
    Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('product.review');
});

    // Route giỏ hàng
    Route::get('/cart',[CartController::class,'index'])->name('cart.index');
    Route::post('/cart',[CartController::class,'addItem'])->name('cart.addItem');
});


# Admin routes (chỉ cho Admin)
Route::middleware(['role:Admin'])->prefix('/admin')->group(function () {
    Route::get('/',[ ProductController::class, 'dashboard' ])->name('admin.products.dashboard');

    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::resource('/products', ProductController::class);

    Route::resource('/category', CategoryController::class)->except(['show']);

    Route::resource('/brand', BrandController::class)->except(['show']);
    Route::get('/brands-by-category/{categoryID}', [BrandController::class,'getByCategory']);

    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/user/{UserID}/edit', [UserController::class,'edit'])->name('admin.user.edit');
    Route::put('/user/{UserID}',[UserController::class,'update'])->name('admin.user.update');
    Route::delete('/user/{UserID}',[UserController::class,'destroy'])->name('admin.user.destroy');
});
