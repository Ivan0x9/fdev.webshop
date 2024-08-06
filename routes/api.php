<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CatalogCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'store');
    Route::post('login', 'login');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(AddressController::class)->group(function () {
        Route::post('user/save/address', 'saveAddress');
    });

    Route::controller(CatalogCategoryController::class)->group(function () {
        Route::get('categories', 'catalogCategories');
        Route::get('category/{id}/products', 'products');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('products', 'productsAll');
        Route::get('products/filter', 'productsFilter');
        Route::get('product/{sku}', 'product');
    });

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::post('logout', [AuthController::class, 'logout']);
});