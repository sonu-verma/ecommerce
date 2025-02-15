<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
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
    Route::get("admin/brands", [BrandController::class, 'index'])->name('brands');
    Route::get("admin/brand/add", [BrandController::class, 'add'])->name('brand.add');
    Route::post("admin/brand/store", [BrandController::class,'store'])->name('brand.store');
    Route::get("admin/brand/edit/{brand}", [BrandController::class, 'edit'])->name('brand.edit');
    Route::post("admin/brand/update", [BrandController::class, 'update'])->name('brand.update');
    Route::post("admin/brand/delete/{brand}", [BrandController::class, 'delete'])->name('brand.delete');
});