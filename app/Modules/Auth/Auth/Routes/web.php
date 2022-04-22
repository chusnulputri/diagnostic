<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

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

Route::group(['middleware' => 'guest'], function(){
    Route::get('login', function () {
       return view('Auth::index');
    })->name('login');

    Route::get('register', function () {
        return view('Auth::register');
    })->name('register');
});

Route::group(['middleware' => 'auth'], function(){

    Route::get('profile', function () {
        return view('Auth::profile');
    })->name('profile');

});


