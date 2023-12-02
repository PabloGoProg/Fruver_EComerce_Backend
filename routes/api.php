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

Route::middleware('auth:api')->group(function () {

    /**
     * User routes which use auth
     */
    Route::get('/v1/users', [App\Http\Controllers\api\v1\UserController::class, 'index']);
    Route::get('/v1/users/{id}', [App\Http\Controllers\api\v1\UserController::class, 'show']);
    Route::put('/v1/users/{id}', [App\Http\Controllers\api\v1\UserController::class, 'update']);
    Route::delete('/v1/users/{id}', [App\Http\Controllers\api\v1\UserController::class, 'destroy']);

    Route::get('/v1/suppliers', [App\Http\Controllers\api\v1\SupplierController::class, 'index']);
    Route::get('/v1/suppliers/{id}', [App\Http\Controllers\api\v1\SupplierController::class, 'show']);
    Route::post('/v1/suppliers', [App\Http\Controllers\api\v1\SupplierController::class, 'store']);
    Route::put('/v1/suppliers/{id}', [App\Http\Controllers\api\v1\SupplierController::class, 'update']);
    Route::delete('/v1/suppliers/{id}', [App\Http\Controllers\api\v1\SupplierController::class, 'destroy']);
});
Route::group([


    'middleware' => 'api',
    'prefix' => '/v1/auth'

], function ($router) {

    Route::post('login', [App\Http\Controllers\api\v1\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\api\v1\AuthController::class, 'logut']);
    Route::post('refresh', [App\Http\Controllers\api\v1\AuthController::class, 'refresh']);
    Route::post('me', [App\Http\Controllers\api\v1\AuthController::class, 'me']);
});

Route::apiResource('v1/products', App\Http\Controllers\api\v1\ProductController::class);
Route::apiResource('v1/categories', App\Http\Controllers\api\v1\ProductCategoryController::class);
Route::apiResource('v1/types', App\Http\Controllers\api\v1\ProductTypeController::class);
Route::get('v1/products/{id_product}/category', App\Http\Controllers\api\v1\ProductCategoryController::class . '@show');
Route::get('v1/products/{id_product}/type', App\Http\Controllers\api\v1\ProductTypeController::class . '@show');

Route::get('/v1/user_types', [App\Http\Controllers\api\v1\UserTypeController::class, 'index']);
Route::get('/v1/user_types/{id}', [App\Http\Controllers\api\v1\UserTypeController::class, 'show']);
Route::post('/v1/user_types', [App\Http\Controllers\api\v1\UserTypeController::class, 'store']);
Route::put('/v1/user_types/{id}', [App\Http\Controllers\api\v1\UserTypeController::class, 'update']);
Route::delete('/v1/user_types/{id}', [App\Http\Controllers\api\v1\UserTypeController::class, 'destroy']);
