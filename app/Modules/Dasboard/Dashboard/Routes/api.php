<?php

use App\Modules\Dasboard\Dashboard\Controllers\DashboardController;
use Illuminate\Http\Request;
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


Route::group(['middleware' => 'auth:api'], function(){
    
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('dashboard/get-pertanyaan', [
        DashboardController::class, 'getDataPertanyaan'
    ])->name('dashboard.get_pertanyaan');

    Route::get('dashboard/get-history', [
        DashboardController::class, 'getDataHistories'
    ])->name('dashboard.get_histories');

    Route::post('dashboard/store', [
        DashboardController::class, 'store'
    ])->name('dashboard.store');
});