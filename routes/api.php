<?php

use App\Models\User;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BlockUserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\EmergencyContactDetailController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\VehicleController;

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
//Check if User is Logged in
Route::get('/user-logged', [UserController::class, 'userLogged']);
//PUBLIC
Route::get('/getAllCards', [CardController::class, 'getAllCards']);
Route::put('/change-password/{user}', [UserController::class, 'changePassword']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/user/not-blocked/{user}', [UserController::class, 'notBlockedUsers']);
Route::delete('/candidate/election/{candidate}', [CandidateController::class, 'deleteAllCandidate']);
Route::get('/post/marketplace/verified/{post}', [PostController::class, 'getMarketPlaceVerified']);
Route::get('/post/marketplace/not-verified/{post}', [PostController::class, 'getMarketPlaceNotVerified']);



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
    'card'             => CardController::class,
    'log'             => LogController::class,
    'block_user'             => BlockUserController::class,
    'vehicle'             => VehicleController::class,
]);
