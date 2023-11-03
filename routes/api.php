<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\ProductController;
  
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

// User Routes
Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('users', 'getUsers');
    Route::post('logout', 'logout');
});
        
// Product Routes
Route::controller(ProductController::class)->group( function () {
    Route::get('products', 'getAllProducts');
    Route::get('products/{id}', 'getSingleProduct');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('products', 'createProduct'); 
        Route::delete('products/{id}', 'deleteProduct'); 
    });
});
