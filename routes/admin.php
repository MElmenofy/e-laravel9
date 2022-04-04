<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Admin" middleware group. Now create something great!
|
*/
//  all prefix -> admin
Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin'], function (){
    Route::get('', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin'],function (){
    Route::get('/login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'postLogin'])->name('admin.post.login');
});
