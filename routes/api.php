<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// guest
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\Guest\AppointmentController as GuestAppointmentController;
use App\Http\Controllers\Guest\MessageController as GuestMessageController;
// admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;

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

    // guest
    Route::get('appointments',[GuestAppointmentController::class,'appointments']);
    Route::get('messages',[GuestMessageController::class,'messages']);
});

// middleware for amdin role
Route::group(['middleware'=>['auth:api','is_admin']],function(){
    // Route::get('x',[AuthController::class,'me']);
    Route::get('user',[AdminController::class,'getAdmin']);
    Route::get('admin/appointments',[AdminAppointmentController::class,'appointments']);
    Route::get('admin/messages',[AdminMessageController::class,'messages']);
});