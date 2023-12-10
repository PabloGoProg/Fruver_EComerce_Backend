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

/* Route::apiResource('v1/products', App\Http\Controllers\api\v1\ProductController::class);
Route::apiResource('v1/categories', App\Http\Controllers\api\v1\ProductCategoryController::class);
Route::apiResource('v1/types', App\Http\Controllers\api\v1\ProductTypeController::class);
Route::get('v1/products/{id_product}/category', App\Http\Controllers\api\v1\ProductCategoryController::class.'@show');
Route::get('v1/products/{id_product}/type', App\Http\Controllers\api\v1\ProductTypeController::class.'@show');

Route::get('/v1/users', [App\Http\Controllers\api\v1\UserController::class, 'index']);
Route::get('/v1/users/{id}', [App\Http\Controllers\api\v1\UserController::class, 'show']);
Route::post('/v1/users', [App\Http\Controllers\api\v1\UserController::class, 'store']);
Route::put('/v1/users/{id}', [App\Http\Controllers\api\v1\UserController::class, 'update']);
Route::delete('/v1/users/{id}', [App\Http\Controllers\api\v1\UserController::class, 'destroy']);

Route::get('/v1/user_types', [App\Http\Controllers\api\v1\UserTypeController::class, 'index']);
Route::get('/v1/user_types/{id}', [App\Http\Controllers\api\v1\UserTypeController::class, 'show']);
Route::post('/v1/user_types', [App\Http\Controllers\api\v1\UserTypeController::class, 'store']);
Route::put('/v1/user_types/{id}', [App\Http\Controllers\api\v1\UserTypeController::class, 'update']);
Route::delete('/v1/user_types/{id}', [App\Http\Controllers\api\v1\UserTypeController::class, 'destroy']);

Route::get('/v1/suppliers', [App\Http\Controllers\api\v1\SupplierController::class, 'index']);
Route::get('/v1/suppliers/{id}', [App\Http\Controllers\api\v1\SupplierController::class, 'show']);
Route::post('/v1/suppliers', [App\Http\Controllers\api\v1\SupplierController::class, 'store']);
Route::put('/v1/suppliers/{id}', [App\Http\Controllers\api\v1\SupplierController::class, 'update']);
Route::delete('/v1/suppliers/{id}', [App\Http\Controllers\api\v1\SupplierController::class, 'destroy']);

 */

 /* Route::apiResource('v1/sells'
,App\Http\Controllers\api\v1\SellController::class);
/* Route::get('v1/sells/{id_sell}/products/{id_product}', App\Http\Controllers\api\v1\SellController::class.'@showProduct');
Route::get('v1/products/{id_product}/sells', App\Http\Controllers\api\v1\ProductController::class.'@showProductSells');
Route::get('v1/sells/{id_sell}/products', App\Http\Controllers\api\v1\SellController::class.'@showSellProducts');
 */


// Rutas para ProductSellController */

/* Route::get('v1/products/{productId}/sells', [App\Http\Controllers\api\v1\ProductSellController::class, 'showSellsForProduct']);
/* Route::prefix('v1/products/{productId}/sells')->group(function () {
    Route::get('/', [App\Http\Controllers\api\v1\ProductSellController::class, 'showSells']);
    Route::post('/', [App\Http\Controllers\api\v1\ProductSellController::class, 'createSell']);
    Route::put('/{sellId}', [App\Http\Controllers\api\v1\ProductSellController::class, 'updateSell']);
    Route::delete('/{sellId}', [App\Http\Controllers\api\v1\ProductSellController::class, 'removeSell']);
    Route::get('/search', [App\Http\Controllers\api\v1\ProductSellController::class, 'searchSellsForProducts']);
});
// Rutas para ProductSupplierController
/* Route::prefix('v1/products/{productId}/suppliers')->group(function () {
    Route::get('/', [ProductSupplierController::class, 'showSuppliers']);
    Route::post('/', [ProductSupplierController::class, 'addSupplier']);
    Route::put('/{supplierId}', [ProductSupplierController::class, 'updateSupplier']);
    Route::delete('/{supplierId}', [ProductSupplierController::class, 'removeSupplier']);
    Route::get('/search', [ProductSupplierController::class, 'searchSuppliersForProducts']);
});


Route::apiResource('v1/sells'
,App\Http\Controllers\api\v1\ProductSellController::class); */



Route::get('productos/ventas/{productId}','App\Http\Controllers\api\v1\ProductSellController@index');
//rutas para el controlador productos
Route::apiResource('v1/products', App\Http\Controllers\api\v1\ProductController::class);
