<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::middleware(['auth'])->group(function(){
    Route::get("account-dashboard", [UserController::class, 'index'])->name('user.index');
});

Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get("admin", [AdminController::class, 'index'])->name('admin.index');
   
    // Brand routes
    Route::get("admin/brands", [BrandController::class, 'index'])->name('brands');
    Route::get("admin/brand/add", [BrandController::class, 'add'])->name('brand.add');
    Route::post("admin/brand/store", [BrandController::class,'store'])->name('brand.store');
    Route::get("admin/brand/edit/{brand}", [BrandController::class, 'edit'])->name('brand.edit');
    Route::post("admin/brand/update", [BrandController::class, 'update'])->name('brand.update');
    Route::post("admin/brand/delete/{brand}", [BrandController::class, 'delete'])->name('brand.delete');


    // categories routes
    Route::get("admin/category", [CategoryController::class, 'index'])->name('categories');
    Route::get("admin/category/add", [CategoryController::class, 'add'])->name('category.add');
    Route::post("admin/category/store", [CategoryController::class,'store'])->name('category.store');
    Route::get("admin/category/edit/{category}", [CategoryController::class, 'edit'])->name('category.edit');
    Route::post("admin/category/update", [CategoryController::class, 'update'])->name('category.update');
    Route::post("admin/category/delete/{category}", [CategoryController::class, 'delete'])->name('category.delete');


    // products routes
    Route::get('admin/products', [ProductController::class, 'index'])->name('products');
    Route::get("admin/product/add", [ProductController::class, 'add'])->name('product.add');
    Route::post("admin/product/store", [ProductController::class,'store'])->name('product.store');
    Route::get("admin/product/edit/{product}", [ProductController::class, 'edit'])->name('product.edit');
    Route::post("admin/product/update", [ProductController::class, 'update'])->name('product.update');
    Route::post("admin/product/delete/{product}", [ProductController::class, 'delete'])->name('product.delete');

    // coupons
    Route::get("admin/coupons", [CouponController::class, 'index'])->name('coupons');
    Route::get("admin/coupon/add", [CouponController::class, 'add'])->name('coupon.add');
    Route::post("admin/coupon/store", [CouponController::class, 'store'])->name('coupon.store');
    Route::get("admin/coupon/edit/{coupon}", [CouponController::class, 'edit'])->name('coupon.edit');
    Route::post("admin/coupon/update", [CouponController::class, 'update'])->name('coupon.update');
    Route::DELETE("admin/coupon/delete/{coupon}", [CouponController::class, 'delete'])->name('coupon.delete');

    // orders
    Route::get("admin/orders", [OrderController::class, 'index'])->name('orders');
    ROute::get("admin/order/{id_order}/details", [OrderController::class, 'orderDetails'])->name('order.details');
    ROute::post("admin/order/{id_order}/update", [OrderController::class, 'updateStatus'])->name('order.updateStatus');
});

Route::get("shop", [ShopController::class, 'shop'])->name('shop');
Route::get("shop/{slug}", [ShopController::class, 'detail'])->name('shop.detail');
Route::get("cart", [CartController::class, 'cart'])->name('shop.cart');
Route::post("cart/add", [CartController::class, 'addToCart'])->name('cart.addToCart');

Route::put("cart/qty/add/{rowId}", [CartController::class, 'increaseQty'])->name('qty.increase');
Route::put("cart/qty/remove/{rowId}", [CartController::class, 'decreaseQty'])->name('qty.decrease');
Route::get("cart/item/remove/{rowId}", [CartController::class, 'deleteCartItem'])->name('cart.item.remove');
Route::delete("cart/clear", [CartController::class, 'clearCart'])->name('cart.empty');


# wishlist routes
Route::get("wishlist", [WishlistController::class, 'index'])->name("wishlist");
Route::post("wishlist/add", [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::DELETE("wishlist/remove/{rowId}", [WishlistController::class, 'removeWishlist'])->name('wishlist.remove');
Route::DELETE("wishlist/clear", [WishlistController::class, 'clearWishlist'])->name('wishlist.clear');
Route::post("wishlist/move-to-cart/{rowId}", [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');


# Apply Coupon Code
Route::post("/cart/apply/coupon-code", [CartController::class, 'applyCouponCode'])->name('cart.applyCouponCode');
Route::post("/cart/remove/coupon-code", [CartController::class, 'removeCouponCode'])->name('cart.removeCouponCode');

Route::get("/checkout", [CartController::class, 'checkout'])->name('checkout');


# Order
    # Cash on delivery
Route::post("/cart/place-order", [OrderController::class, 'placeOrder'])->name('placeOrder');
Route::get("/order/confirm", [OrderController::class, 'orderConfirmation'])->name('order.confirmation');


# User Routes
Route::get("account-orders", [UserController::class, 'orders'])->name('user.orders');
Route::get("account-order/{id_order}/details", [UserController::class, 'orderDetails'])->name('user.orderDetails');
Route::put("account-order/cancel-order", [OrderController::class, 'cancelOrder'])->name('user.orderCancel');