<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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



Route::middleware('auth:sanctum')->get('/authenticated', function (Request $request) {
    return true;
});

Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
//Check if User is Logged in
Route::get('/user/logged', [UserController::class, 'getUserLogged']);

Route::apiResources([
    'block'             => BlockController::class,
    'lot'             => LotController::class,
    'user'             => UserController::class,
]);


