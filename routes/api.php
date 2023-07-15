<?php

use App\Http\Controllers\cartController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\productController;
use App\Http\Controllers\userController;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\TestController;

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

// // Private Url's

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::apiResource('category', categoryController::class);
    Route::apiResource('product', productController::class);
    Route::apiResource('cart', cartController::class);
    Route::apiResource('order', OrderController::class);
    Route::apiResource('users', userController::class);
    Route::post('change_password', [LoginController::class, 'change_password']);
});


// Public Url's

Route::post('login', [LoginController::class, 'login']);
Route::post('signup', [LoginController::class,'signup']);
Route::post('logout', [LoginController::class, 'logout']);
