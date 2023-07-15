<?php

use App\Http\Controllers\DummyController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('facebook/login', [FacebookController::class, 'provider'])->name('fb-auth');
Route::get('facebook/callback', [FacebookController::class, 'callback']);

Route::get('/posts',[DummyController::class,'getPostData']);

// Route::get('payment',[PaymentController::class,'index']);
Route::post('payment',[PaymentController::class,'pay'])->named('pay');
Route::get('success',[PaymentController::class,'success']);

