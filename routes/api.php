<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/user/checkout', [App\Http\Controllers\userController::class, 'checkOut']);
Route::post('/user/checkout/detail', [App\Http\Controllers\userController::class, 'checkOutDetail']);
Route::post('/user/checkout/detail_all', [App\Http\Controllers\userController::class, 'checkOutDetailAll']);
Route::get('/seller/order', [App\Http\Controllers\sellerController::class, 'listOrder']);
Route::post('/seller/confirmed', [App\Http\Controllers\sellerController::class, 'confirmed']);
Route::get('/admin/order', [App\Http\Controllers\adminController::class, 'listOrder']);
Route::post('/admin/nonactive', [App\Http\Controllers\adminController::class, 'nonactiveUser']);
Route::post('/admin/order/delete', [App\Http\Controllers\adminController::class, 'deleteOrder']);