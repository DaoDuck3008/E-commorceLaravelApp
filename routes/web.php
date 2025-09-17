<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\OrderController;

# Public routes (Customer có thể vào)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/search',[ProductController::class,'searchForCus'])->name('products.searchCustomer');
Route::get('products/{productID}',[ProductController::class,'show'])->name('product.show');
Route::get('/api/promotions', [PromotionController::class, 'getPromotions']);

Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class,'create']);
Route::get('/login',[AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class,'login']);

Route::get('/find-all-categories', [CategoryController::class,'getAllCategories']);
Route::get('/brands-by-category/{categoryID}', [BrandController::class,'getByCategory']);

// Chỉ khi đăng nhập mới có thể vào
Route::middleware('auth')->group(function () {
    // Route hồ sơ người dùng
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
    Route::get('user/profile/{userID}',[UserController::class,'profile'])->name('user.profile');
    Route::get('/user/overall/{userID}',[UserController::class,'overall'])->name('user.overall');
    Route::get('/user/edit/{userID}',[UserController::class,'editCustomer'])->name('user.edit');
    Route::put('/user/{userID}',[UserController::class,'update']);
    // Route giỏ hàng
    Route::get('/cart',[CartController::class,'index'])->name('cart.index');
    Route::post('/cart',[CartController::class,'addItem'])->name('cart.addItem');
    route::post('/cart/increase_quantity/{cartitemID}',[CartController::class,'increaseQuantity'])->name('cart.increase');
    route::post('/cart/decrease_quantity/{cartitemID}',[CartController::class,'decreaseQuantity'])->name('cart.decrease');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    // Route đơn hàng
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('processCheckout');
    Route::get('/order/confirmation/{orderId}', [OrderController::class,'confirmation'])->name('order.confirmation');
    Route::get('/order/history', [OrderController::class,'history'])->name('order.history');
    Route::get('/api/order/history', [OrderController::class,'historyAPI'])->name('api.order.history');
    Route::get('/order/{orderId}', [OrderController::class,'show'])->name('order.show');
    Route::delete('/order/{orderId}', [OrderController::class,'cancel'])->name('order.cancel');
    Route::post('/buy_now',[OrderController::class,'buyNow'])->name('order.buyNow');
    Route::post('/checkout_buy_now', [OrderController::class, 'processCheckoutBuyNow'])->name('processCheckoutBuyNow');
    //Route thanh toán chuyển khoản
   
});


# Admin routes (chỉ cho Admin)
Route::middleware(['role:Admin'])->prefix('/admin')->group(function () {
    Route::get('/',[ ProductController::class, 'dashboard' ])->name('admin.products.dashboard');

    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::resource('/products', ProductController::class);

    Route::resource('/category', CategoryController::class)->except(['show']);

    Route::get('/brand/search',[BrandController::class,'search'])->name('admin.brand.search');
    Route::resource('/brand', BrandController::class)->except(['show']);
    Route::get('/brands-by-category/{categoryID}', [BrandController::class,'getByCategory']);

    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/user/search',[UserController::class,'search'])->name('admin.user.search');
    Route::get('/user/{UserID}/edit', [UserController::class,'edit'])->name('admin.user.edit');
    Route::put('/user/{UserID}',[UserController::class,'update'])->name('admin.user.update');
    Route::delete('/user/{UserID}',[UserController::class,'destroy'])->name('admin.user.destroy');

    Route::resource('/promotion', App\Http\Controllers\PromotionController::class)->except(['show']);
    // Dashboard order
    Route::get('/order',[OrderController::class,'dashboard'])->name('admin.order.dashboard');
    Route::get('/order/{orderId}',[OrderController::class,'showAdmin'])->name('admin.order.detail');
    Route::put('/order/update/{orderId}',[OrderController::class,'updateSTATUS'])->name('admin.order.updateStatus');
    route::delete('/order/delete/{orderId}',[OrderController::class,'cancelByAdmin'])->name('admin.order.cancel');
});


