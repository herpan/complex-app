<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

//Route Soal No. 5
Route::post('/users', [UserController::class, 'store']);

//Route Soal No. 10
Route::post('/login', [UserController::class, 'login']);



Route::middleware('jwt.auth')->group(function () {
    //Route Soal No. 6 
    Route::post('/posts', [PostController::class, 'store']);
    
    //Route Soal No. 7
    Route::get('/users/{id}/posts', [UserController::class, 'userPosts']);
    
    //Route Soal No. 8
    Route::get('/posts', [PostController::class, 'index']);

    //Route Soal No. 11
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
