<?php


use App\Http\Controllers\Api\V1\User\AuthController;
use App\Http\Controllers\Api\V1\User\PasswordController;
use Illuminate\Support\Facades\Route;
//authentication
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:api');

//password operations
Route::post('update-password',[PasswordController::class,'updatePassword'])->middleware('auth:api');
Route::post('forgot-password',[PasswordController::class,'forgotPassword']);
Route::post('reset-password',[PasswordController::class,'resetPassword']);
