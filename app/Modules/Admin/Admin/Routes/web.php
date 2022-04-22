<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Modules\Admin\Admin\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('admin-area', function () {
        return view('Admin::index');
    })->name('Admin');

    Route::get('admin-area/hasil-diagnosa', function () {
        return view('Admin::diagnosa');
    })->name('Admin.diagnosa');

    Route::get('admin-area/hasil-gejala', function () {
        return view('Admin::gejala');
    })->name('Admin.gejala');

    Route::get('admin-area/hasil-penyakit', function () {
        return view('Admin::penyakit');
    })->name('Admin.penyakit');

    Route::get('admin-area/hasil-kasus', function () {
        return view('Admin::kasus');
    })->name('Admin.kasus');

    Route::get('admin-area/hasil-rule', function () {
        return view('Admin::rule');
    })->name('Admin.rule');

    Route::post('admin/rule', [AdminController::class, 'tambahRule'])
    ->name('Admin.tambah-rule');

    Route::get('admin/rule/{id}', [AdminController::class, 'detailRule'])
    ->name('Admin.edit-rule');  

    Route::put('admin/rule/{id}', [AdminController::class, 'updateRule'])
    ->name('Admin.update-rule');

    Route::delete('admin/rule/{id}', [AdminController::class, 'hapusRule'])
    ->name('Admin.hapus-rule');

    Route::post('admin/gejala', [AdminController::class, 'tambahGejala'])
    ->name('Admin.tambah-gejala');

    Route::get('admin/gejala/{id}', [AdminController::class, 'detailGejala'])
    ->name('Admin.edit-gejala');  

    Route::put('admin/gejala/{id}', [AdminController::class, 'updateGejala'])
    ->name('Admin.update-gejala');

    Route::delete('admin/gejala/{id}', [AdminController::class, 'hapusGejala'])
    ->name('Admin.hapus-gejala');

    Route::post('admin/penyakit', [AdminController::class, 'tambahPenyakit'])
    ->name('Admin.tambah-penyakit');

    Route::get('admin/penyakit/{id}', [AdminController::class, 'detailPenyakit'])
    ->name('Admin.edit-penyakit');    

    Route::put('admin/penyakit/{id}', [AdminController::class, 'updatePenyakit'])
    ->name('Admin.update-penyakit');

    Route::delete('admin/penyakit/{id}', [AdminController::class, 'hapusPenyakit'])
    ->name('Admin.hapus-penyakit');

     Route::delete('admin/diagnosa/{id}', [AdminController::class, 'hapusDiagnosa'])
    ->name('Admin.hapus-diagnosa');

     Route::delete('admin/index/{id}', [AdminController::class, 'hapusUser'])
    ->name('Admin.hapus-User');

    Route::post('admin/kasus', [AdminController::class, 'tambahKasus'])
    ->name('Admin.tambah-kasus');

    // Route::get('admin/kasus/{id}', [AdminController::class, 'detailKasus'])
    // ->name('Admin.edit-kasus');  

    Route::put('admin/kasus/{id}', [AdminController::class, 'updateKasus'])
    ->name('Admin.update-Kasus');

    // Route::delete('admin/Kasus/{id}', [AdminController::class, 'deleteKasus'])
    // ->name('Admin.hapus-Kasus');
});
 

