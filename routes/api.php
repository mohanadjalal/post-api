<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return $request->user();
});

Route::post('login' , [UserController::class , 'login']);
Route::post('register' , [UserController::class , 'register']);


        
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('posts', PostController::class);
    
    Route::get('users/{user}' , [UserController::class  , 'show']);
  
    Route::get('comments/{post}' , [CommentController::class , 'index']);
    Route::Post('comments' , [CommentController::class , 'store']);
    Route::get('comments/one/{comment}' , [CommentController::class , 'show']);
    Route::patch('comments/{comment}' , [CommentController::class , 'update']);
    Route::delete('comments/{comment}' , [CommentController::class , 'destroy']);



});