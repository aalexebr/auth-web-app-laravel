<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login',[AuthController::class,'login']);
Route::group(['middleware'=>['auth:api']],function(){
    
    Route::post('auth',[AuthController::class,'checkAuth']);
    Route::post('refresh',[AuthController::class,'refresh']);
    Route::post('logout',[AuthController::class,'logout']);
});

// middleware for amdin role
Route::group(['middleware'=>['auth:api','is_admin']],function(){
    Route::get('user',[AuthController::class,'me']);
    
});