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
Route::get('/orders', 'App\Http\Controllers\Api\OrderController@index');
Route::post('/orders', 'App\Http\Controllers\Api\OrderController@store');
Route::get('/orders/{id}', 'App\Http\Controllers\Api\OrderController@show');
Route::put('/orders/{id}', 'App\Http\Controllers\Api\OrderController@update');
Route::delete('/orders/{id}', 'App\Http\Controllers\Api\OrderController@destroy');
Route::post('/orders/{id}/add', 'App\Http\Controllers\Api\OrderController@addproducttoorder');
Route::post('/orders/{id}/pay', 'App\Http\Controllers\Api\OrderController@payorder');

