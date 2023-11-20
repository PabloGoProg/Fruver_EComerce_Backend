<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('v1/products', App\Http\Controllers\api\v1\ProductController::class);
Route::apiResource('v1/categories', App\Http\Controllers\api\v1\ProductCategoryController::class);
Route::apiResource('v1/types', App\Http\Controllers\api\v1\ProductTypeController::class);
Route::get('v1/products/{id_product}/category', App\Http\Controllers\api\v1\ProductCategoryController::class.'@show');
Route::get('v1/products/{id_product}/type', App\Http\Controllers\api\v1\ProductTypeController::class.'@show');
