<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController as Posts;
use App\Http\Controllers\Api\AuthController as Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user() ;
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout',[Auth::class,'logout']);
});

Route::get('post/list',[PostController::class,'getPostsApi']);
Route::get("auth/list", [Auth::class, "getPostsApi"]);
Route::post('auth/register',[Auth::class,'register']);
Route::post('auth/login',[Auth::class,'login']);
Route::resource('posts',Posts::class);
