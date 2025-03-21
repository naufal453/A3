<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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

// Define the home route
Route::get('/', [PostController::class, 'index'])->name('home.index');

// Guest middleware routes
Route::group(['middleware' => ['guest']], function () {
    // Register Routes
    Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');

    // Login Routes
    Route::get('/login', [LoginController::class, 'show'])->name('login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
});

// Auth middleware routes
Route::group(['middleware' => ['auth']], function () {
    // Logout Route
    Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');

    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::resource('posts', PostController::class)->except(['index', 'show']);
});

// Post detail route
Route::get('/post/{id}', [PostController::class, 'show'])->name('home.post.detail');

Route::resource('posts', PostController::class);

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::get('/posts/{id}/comments', [CommentController::class, 'show'])->name('posts.comments');

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
