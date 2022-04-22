<?php

use App\Modules\Admin\Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
    Route::get('admin-area/get-data-user', [
        AdminController::class, 'getDataUser'
    ])->name('admin.get_data_user');

    Route::get('admin-area/get-data-diagnosa', [
        AdminController::class, 'getDataDiagnosa'
    ])->name('admin.get_data_diagnosa');

    Route::get('admin-area/get-data-gejala', [
        AdminController::class, 'getDataGejala'
    ])->name('admin.get_data_gejala');

    Route::get('admin-area/get-data-penyakit', [
        AdminController::class, 'getDataPenyakit'
    ])->name('admin.get_data_penyakit');

    Route::get('admin-area/get-data-kasus', [
        AdminController::class, 'getDataKasus'
    ])->name('admin.get_data_kasus');

    Route::get('admin-area/get-data-rule', [
        AdminController::class, 'getDataRule'
    ])->name('admin.get_data_rule');

     Route::get('admin-area/get-tambah-data', [
        AdminController::class, 'getTambahData'
    ])->name('admin.get_tambah_data');
});