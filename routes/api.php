<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/auth/register',[Controllers\Api\AuthController::class,'register']);
Route::post('/auth/login', [Controllers\Api\AuthController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/post',[Controllers\Api\PostController::class,'index']);
    Route::post('/post',[Controllers\Api\PostController::class,'store']);
    Route::post('/auth/logout',[Controllers\Api\AuthController::class,'logout']);
});