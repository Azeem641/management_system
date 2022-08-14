<?php

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegistrationController;
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

Route::post('/login', [LoginController::class, 'login']);
Route::post('/registration', [RegistrationController::class, 'signUp']);


$router->group(['middleware' => 'auth:api'], function () use ($router) {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/add-product', [ProductsController::class, 'create'])->middleware('admin');
    Route::post('/get-products', [ProductsController::class, 'getAllProducts']);
    Route::post('/product-detil', [ProductsController::class, 'productDetail']);
});

// $router->group(['middleware' => 'auth:api', 'auth'], function () use ($router) {
// });
