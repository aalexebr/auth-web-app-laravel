<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Guest\GuestController;
// admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\MessageController;

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
Route::post('register-as-admin',[AdminController::class,'registerAdmin']);
Route::post('register',[GuestController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::group(['middleware'=>['auth:api']],function(){
    
    Route::post('auth',[AuthController::class,'checkAuth']);
    Route::post('refresh',[AuthController::class,'refresh']);
    Route::post('logout',[AuthController::class,'logout']);
});

// middleware for amdin role
Route::group(['middleware'=>['auth:api','is_admin']],function(){
    Route::get('x',[AuthController::class,'me']);
    Route::get('user',[AdminController::class,'getAdmin']);
    Route::get('appointments',[AppointmentController::class,'appointments']);
    Route::get('messages',[MessageController::class,'messages']);
});