<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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
    return view('dashboard');
})->name('home');
Route::middleware(['auth'])->group(function(){
    Route::post('/logout',[Controllers\AuthController::class,'logout'])->name('logout');
    Route::resource('/post',Controllers\PostController::class)->names('post');
});
Route::middleware(['guest'])->group(function(){
Route::get('/login',[Controllers\AuthController::class,'login'])->name('login');
Route::post('/login',[Controllers\AuthController::class,'proceedLogin'])->name('proceed_login');
Route::get('/register',[Controllers\AuthController::class,'register'])->name('register');
Route::post('/register',[Controllers\AuthController::class,'proceedRegister'])->name('proceed_register');
});