<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\SalesController;
use App\Http\Middleware\ApiAuthMiddleware;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(ApiAuthMiddleware::class)->group(function () {
    Route::get('/inventories', [InventoriesController::class, 'index']);
    Route::post('/inventories', [InventoriesController::class, 'addInventory']);
    Route::put('/inventories/{id}', [InventoriesController::class, 'updateInventory']);
    Route::delete('/inventories/{id}', [InventoriesController::class, 'deleteInventory']);

    Route::get('/product', [ProductController::class, 'index']);
    Route::post('/product', [ProductController::class, 'addProduct']);
    Route::delete('/product/{id}', [ProductController::class, 'deleteProduct']);
    Route::put('/product/{id}', [ProductController::class, 'updateProduct']);

    Route::post('/variant', [VariantController::class, 'addVariant']);

    Route::post('/sales', [SalesController::class, 'addSales']);
    Route::get('/sales', [SalesController::class, 'index']);
    Route::delete('/sales/{id}', [SalesController::class, 'updateSales']);
});