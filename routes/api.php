<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlockController;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AnnouncementController;

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
Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);


 Route::apiResources([
    'block'             => BlockController::class,
    'lot'             => LotController::class,
    'user'             => UserController::class,
    'group'             => GroupController::class,
    'post'             => PostController::class,
    'comment'             => CommentController::class,
    'reply'             => ReplyController::class,
    'announcement'             => AnnouncementController::class,
    'position'             => PositionController::class,

]);

    //Check if User is Logged in
    Route::get('/user/logged', [UserController::class, 'getUserLogged']);


