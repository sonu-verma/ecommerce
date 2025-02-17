<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
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

    
});

Route::get("shop", [ShopController::class, 'shop'])->name('shop');
Route::get("shop/{slug}", [ShopController::class, 'detail'])->name('shop.detail');