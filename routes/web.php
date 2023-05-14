<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\LoginController;
use app\Http\Controllers\ErrorController;
use app\Http\Controllers\ResetPassController;
use app\Http\Controllers\LoginWithGoogleController;
use app\Http\Controllers\Register;
use app\Http\Controllers\JwtController;
/*
|--------------------------------------------------------------------------
| Web Routes2
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/error','ErrorController@handling');
Route::get('authorized/google', 'LoginController@redirectToGoogle');
Route::get('authorized/google/callback', 'LoginController@handleGoogleCallback');
Route::get('/', function () {
    return view('page.welcome');
});
Route::get('/password/reset',function (){
    return view('page.forgotPassword');
});
Route::get('/refresh_token','JwtController@get');
Route::group(["prefix"=>"/password"],function(){
    Route::post('/reset/test','ResetPassController@test');
    Route::post('/password/reset/testing','ResetPassController@testing');
    Route::post('/password/reset','ResetPassController@sendReset');
    Route::get('/password/reset/{token}', 'ResetPassController@handleResetView')->where('token', '.*')->name('password.reset');
});
// Route::post('/forgot-form',['ResetPassController@handleReset','ResetPassController@changePass']);
Route::group(['middleware'=>'auth'],function(){
    // Route::post('/logout','');
    Route::get('/login',function(){
        return response()->view('page.login')->header('error','dataaaa');
    })->name('login');
    Route::get('/register',function(){
        return view('page.register');
    })->name('register');
    Route::get('/dashboard',function(){
        return view('page.dashboard');
    });
    // Route::post('/login-form','Login@Login');
    Route::group(["prefix"=>"/users"],function(){
        Route::post('/login','LoginController@Login');
        Route::post('/register','RegisterController@Register');
        Route::get('/pengaturan',function(){
            return view('pengaturan');
        });
    });
    Route::group(["prefix"=>"/api"],function(){
        Route::post("/logout",function(){
            // return view('dashboard');
        });
        Route::post("/weather","TestController@weather");
    });
});
?>