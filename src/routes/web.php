<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [ItemController::class, 'index']);

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/mypage', [ProfileController::class, 'mypageView']);
Route::get('/mypage/profile', [ProfileController::class, 'editProfile']);
Route::post('/mypage/profile/update', [ProfileController::class, 'storeProfile']);

Route::get('/item', [ItemController::class, 'detail']);
Route::get('/purchase', [ItemController::class, 'procedureView']);
Route::get('/purchase/address', [ItemController::class, 'editAddress']);
Route::post('/purchase/address/update', [ItemController::class, 'updateAddress']);
Route::get('/sell', [ItemController::class, 'sellView']);
Route::post('/sale', [ItemController::class, 'sale']);
Route::get('/find', [ItemController::class, 'search']);

Route::post('/posts/{item}/like', [LikeController::class, 'store'])->middleware('auth');
Route::delete('/posts/{item}/like', [LikeController::class, 'destroy'])->middleware('auth');

Route::post('/items/{item}/comments', [CommentController::class, 'store'])->middleware('auth');

Route::post('/create-checkout-session', [PaymentController::class, 'createCheckoutSession']);

Route::post('/purchase-procedure', [PurchaseController::class, 'purchase']);





