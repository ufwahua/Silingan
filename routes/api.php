<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\EmergencyContactDetailController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ElectionController;

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
  //Check if User is Logged in
    Route::get('/user_logged', function(){
        return Auth::user();
    });
Route::get('/user/index2', [UserController::class, 'index2']);



 Route::apiResources([
    'block'             => BlockController::class,
    'lot'             => LotController::class,
    'user'             => UserController::class,
    'group'             => GroupController::class,
    'post'             => PostController::class,
    'comment'             => CommentController::class,
    'reply'             => ReplyController::class,
    'announcement'             => AnnouncementController::class,
    'chat_room'             => ChatRoomController::class,
    'chat'             => ChatController::class,
    'position'             => PositionController::class,
    'emergency_contact_detail' => EmergencyContactDetailController::class,
    'candidate'             => CandidateController::class,
    'election'             => ElectionController::class,


]);

  


