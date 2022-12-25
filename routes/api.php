<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/blogs/{id}/like', [LikesController::class, 'likeBlogApi']);
Route::post('/blogs/{bid}/comments/{cid}/like', [LikesController::class, 'likeBlogComment']);
Route::post('/blogs/{bid}/comments/{cid}/replies/{rid}/like', [LikesController::class, 'likeBlogReply']);

Route::post('users/{id}/recover', [AdminController::class,'recoverApi']);
Route::post('users/{id}/delete', [AdminController::class,'destroyApi']);
