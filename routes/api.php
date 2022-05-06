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
use App\Http\Controllers\CollectionTypeController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SmsController;

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
Route::get('/user/search/', [UserController::class, 'getSearchUser']);
Route::get('/user/officers/', [UserController::class, 'getOfficers']);
Route::get('/user/user-verified/', [UserController::class, 'getUsersVerified']);
Route::get('/user/filter-resident/{user}', [UserController::class, 'filterResident']);
Route::put('/user/vote/{user}', [UserController::class, 'updateHasVoted']);
Route::get('/user/filter-resident/block-lot/{user}', [UserController::class, 'getResidentInBlockLot']);
Route::put('/candidate/vote/{candidate}', [CandidateController::class, 'vote']);
Route::delete('/candidate/election/{candidate}', [CandidateController::class, 'deleteAllCandidate']);
Route::get('/post/marketplace/verified/{post}', [PostController::class, 'getMarketPlaceVerified']);
Route::get('/post/marketplace/not-verified/{post}', [PostController::class, 'getMarketPlaceNotVerified']);
Route::get('/post/specific-post/{post}', [PostController::class, 'getSpecificPost']);
Route::post('/sms',[SmsController::class, 'sendSmsNotification']);
Route::post('/log/filter',[LogController::class, 'filterFromTo']);
Route::post('/notification/chat',[NotificationController::class, 'notificationChat']);
Route::post('/notification/announcement',[NotificationController::class, 'notificationAnnouncement']);
Route::post('/notification/election',[NotificationController::class, 'notificationElection']);
Route::post('/notification/comment',[NotificationController::class, 'notificationComment']);
Route::get('/post/search/', [PostController::class, 'getMarketPlacePost']);
Route::post('/invoice/bill-all/', [InvoiceController::class, 'billToAll']);
Route::post('/invoice/bill-specific/', [InvoiceController::class, 'billSpecificBlockLot']);
Route::get('/invoice/block-lot/{invoice}', [InvoiceController::class, 'getInvoicesByBlockLotID']);


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
    'emergency-contact-detail' => EmergencyContactDetailController::class,
    'candidate'             => CandidateController::class,
    'election'             => ElectionController::class,
    'card'             => CardController::class,
    'log'             => LogController::class,
    'block_user'             => BlockUserController::class,
    'vehicle'             => VehicleController::class,
    'collection_type' => CollectionTypeController::class,
    'collection' => CollectionController::class,
    'expense' => ExpenseController::class,
    'fund' => FundController::class,
    'notification'     => NotificationController::class,
    'expense_type' => ExpenseTypeController::class,
    'invoice' => InvoiceController::class,
]);
