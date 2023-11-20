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

Route::group([

    'middleware' => 'api',
    'prefix' => '/v1/auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

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
