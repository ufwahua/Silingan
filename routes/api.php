<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\admin\LotController;
use App\Http\Controllers\admin\BlockController;


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
//NEEDS AUTHENTICATION
Route::middleware(['auth:sanctum'])->group(function () {
  
});
//PUBLIC
Route::post('forgot-password', [UserController::class, 'forgotPassword']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');


 Route::apiResources([
    'block'             => BlockController::class,
    'lot'             => LotController::class,
    'user'             => UserController::class,
    'group'             => GroupController::class,
    'post'             => PostController::class,
]);

    //Check if User is Logged in
    Route::get('/user/logged', [UserController::class, 'getUserLogged']);


