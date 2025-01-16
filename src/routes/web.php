<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
});
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/mypage/profile', [ProfileController::class, 'profile']);
Route::post('/mypage/profile/update', [ProfileController::class, 'storeProfile']);

Route::get('/item', [ItemController::class, 'detail']);
Route::post('/purchase', [ItemController::class, 'procedure']);
Route::post('/purchase/address', [ItemController::class, 'edit']);
Route::post('/purchase/address/update', [ItemController::class, 'update']);





