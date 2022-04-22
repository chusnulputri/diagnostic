<?php

use App\Helpers\Keuangan;
use App\Modules\Inventory\StockMonitoring\Controllers\StockMonitoringController;
use App\Modules\Master\COA\Controllers\COAController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/test', function () {
    return Keuangan::cek();
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});

Route::get('/make-unique-code',[COAController::class,'makeUniqueCode']);
Route::get('/cek-stok-period',[StockMonitoringController::class,'checkStocks']);

Route::get('generate-saldo', [COAController::class, 'generateSaldo']);