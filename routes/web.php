<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BlogPostController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Signup New User
Route::post('/signup', [UserController::class, 'signup']);

// Log In User
Route::get('/login', [UserController::class, 'login']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// blog APIs
Route::post('/blog-posts', [BlogPostController::class, 'store'])->middleware('auth');
Route::put('/blog-posts/{id}', [BlogPostController::class, 'update'])->middleware('auth');
Route::get('/blog-posts/{id}', [BlogPostController::class, 'show'])->middleware('auth');
Route::delete('/blog-posts/{id}', [BlogPostController::class, 'destroy'])->middleware('auth');

// comment APIs

Route::post('/comments', [CommentController::class, 'store'])->middleware('auth');
Route::put('/comments/{id}', [CommentController::class, 'update'])->middleware('auth');
Route::get('/comments/{id}', [CommentController::class, 'show'])->middleware('auth');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->middleware('auth');




