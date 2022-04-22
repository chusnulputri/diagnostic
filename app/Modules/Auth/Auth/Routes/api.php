<?php

use App\Modules\Auth\Auth\Controllers\AuthController;
use App\Notifications\GeneralNotifications;
use App\Notifications\PurchaseOrderApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
    Route::post('/auth/user/update', [AuthController::class, 'updateProfile']);
});
