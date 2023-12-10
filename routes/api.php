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
});

// ----------------------------------------------------------------------------------------------------

// Api users endpoints

Route::get(
    '/v1/users',
    [App\Http\Controllers\api\v1\UserController::class, 'index']
);
Route::get(
    '/v1/users/{id}',
    [App\Http\Controllers\api\v1\UserController::class, 'show']
);
Route::post(
    '/v1/users',
    [App\Http\Controllers\api\v1\UserController::class, 'store']
);
Route::put(
    '/v1/users/{id}',
    [App\Http\Controllers\api\v1\UserController::class, 'update']
);
Route::delete(
    '/v1/users/{id}',
    [App\Http\Controllers\api\v1\UserController::class, 'destroy']
);

// ----------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------

// Api Customers endpoints

Route::get(
    '/v1/customers',
    [App\Http\Controllers\api\v1\CustomerController::class, 'index']
);
Route::get(
    '/v1/customers/{id}',
    [App\Http\Controllers\api\v1\CustomerController::class, 'show']
);
Route::post(
    '/v1/customers',
    [App\Http\Controllers\api\v1\CustomerController::class, 'store']
);
Route::delete(
    '/v1/customers/{id}',
    [App\Http\Controllers\api\v1\CustomerController::class, 'destroy']
);

// ----------------------------------------------------------------------------------------------------

// Api Supplier endpoints

Route::get(
    '/v1/suppliers',
    [App\Http\Controllers\api\v1\SupplierController::class, 'index']
);
Route::get(
    '/v1/suppliers/{id}',
    [App\Http\Controllers\api\v1\SupplierController::class, 'show']
);
Route::post(
    '/v1/suppliers',
    [App\Http\Controllers\api\v1\SupplierController::class, 'store']
);
Route::put(
    '/v1/suppliers/{id}',
    [App\Http\Controllers\api\v1\SupplierController::class, 'update']
);
Route::delete(
    '/v1/suppliers/{id}',
    [App\Http\Controllers\api\v1\SupplierController::class, 'destroy']
);

// ----------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------

// Api Shopping Cart endpoints

Route::get(
    '/v1/users/{user_id}/products',
    [App\Http\Controllers\api\v1\CartController::class, 'getShoppingCart']
);
Route::post(
    '/v1/users/{user_id}/products/{product_id}',
    [App\Http\Controllers\api\v1\CartController::class, 'attachProduct']
);
Route::delete(
    '/v1/users/{user_id}/products/{product_id}',
    [App\Http\Controllers\api\v1\CartController::class, 'detachProduct']
);
Route::put(
    '/v1/users/{user_id}/products/{product_id}',
    [App\Http\Controllers\api\v1\CartController::class, 'updateProductQuantity']
);

// ----------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------

// Api User Types endpoints

Route::get(
    '/v1/user_types',
    [App\Http\Controllers\api\v1\UserTypeController::class, 'index']
);
Route::get(
    '/v1/user_types/{id}',
    [App\Http\Controllers\api\v1\UserTypeController::class, 'show']
);
Route::post(
    '/v1/user_types',
    [App\Http\Controllers\api\v1\UserTypeController::class, 'store']
);
Route::put(
    '/v1/user_types/{id}',
    [App\Http\Controllers\api\v1\UserTypeController::class, 'update']
);
Route::delete(
    '/v1/user_types/{id}',
    [App\Http\Controllers\api\v1\UserTypeController::class, 'destroy']
);

// ----------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------

// Api Products endpoints

Route::apiResource(
    'v1/products',
    App\Http\Controllers\api\v1\ProductController::class
);

Route::get(
    'v1/products/{id_product}/category',
    App\Http\Controllers\api\v1\ProductCategoryController::class . '@show'
);

Route::get(
    'v1/products/{id_product}/type',
    App\Http\Controllers\api\v1\ProductTypeController::class . '@show'
);

// ----------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------

Route::apiResource(
    'v1/categories',
    App\Http\Controllers\api\v1\ProductCategoryController::class
);
Route::get(
    'v1/categories/{category_id}',
    App\Http\Controllers\api\v1\ProductCategoryController::class . '@showProducts'
);
Route::post(
    'v1/categories',
    App\Http\Controllers\api\v1\ProductCategoryController::class . '@store'
);
Route::put(
    'v1/categories/{category_id}',
    App\Http\Controllers\api\v1\ProductCategoryController::class . '@update'
);
Route::delete(
    'v1/categories/{category_id}',
    App\Http\Controllers\api\v1\ProductCategoryController::class . '@destroy'
);

// ----------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------

Route::apiResource(
    'v1/types',
    App\Http\Controllers\api\v1\ProductTypeController::class
);
Route::get(
    'v1/types/{type_id}',
    App\Http\Controllers\api\v1\ProductTypeController::class . 'showProducts'
);
Route::post(
    'v1/types',
    App\Http\Controllers\api\v1\ProductTypeController::class . 'store'
);
Route::put(
    'v1/types/{type_id}',
    App\Http\Controllers\api\v1\ProductTypeController::class . 'update'
);
Route::delete(
    'v1/types/{type_id}',
    App\Http\Controllers\api\v1\ProductTypeController::class . 'destroy'
);

// ----------------------------------------------------------------------------------------------------

Route::group([
    'middleware' => 'api',
    'prefix' => '/v1/auth'
], function ($router) {

    Route::post('login', [App\Http\Controllers\api\v1\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\api\v1\AuthController::class, 'logut']);
    Route::post('refresh', [App\Http\Controllers\api\v1\AuthController::class, 'refresh']);
    Route::post('me', [App\Http\Controllers\api\v1\AuthController::class, 'me']);
});



Route::apiResource(
    'v1/sells',
    App\Http\Controllers\api\v1\SellController::class
);
Route::get('v1/sells/{id_sell}/products/{id_product}', App\Http\Controllers\api\v1\SellController::class . '@showProduct');
Route::get('v1/products/{id_product}/sells', App\Http\Controllers\api\v1\ProductController::class . '@showProductSells');
Route::get('v1/sells/{id_sell}/products', App\Http\Controllers\api\v1\SellController::class . '@showSellProducts');