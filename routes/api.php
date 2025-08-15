<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Extra\ExtraController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/extras', ExtraController::class);

    Route::post('/orders', [OrderController::class, 'store']);
});