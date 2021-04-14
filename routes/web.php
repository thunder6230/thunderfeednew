<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Notifications\TestNotification;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostLikeController;
use App\Notifications\PostLikedNotification;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisterController;

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



Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LogoutController::class, 'store'])->name('logout');
// Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/posts', [PostController::class, 'index'] )->name('posts');
Route::post('/posts', [PostController::class, 'store'] )->name('posts');
Route::delete('/posts/{post}', [PostController::class, 'destroy'] )->name('posts.delete');
Route::get('/posts/{post}', [PostController::class, 'show'] )->name('posts.show');

Route::post('post/{post}/likes', [PostLikeController::class, 'store'])->name('posts.likes');
Route::delete('post/{post}/likes', [PostLikeController::class, 'destroy'])->name('posts.likes');
Route::post('post/{post}/comment', [PostCommentController::class, 'store'])->name('posts.comment');
Route::delete('post/{postComment}', [PostCommentController::class, 'destroy'])->name('posts.comment.delete');

Route::get('/messages', [RegisterController::class, 'index'])->name('messages');
Route::get('/profile/{user:username}', [ProfileController::class, 'index'])->name('profile');

Route::post('/profile/{user}/add', [FriendController::class, 'addFriend'])->name('user.friend.add');
Route::post('/profile/{user}/accept', [FriendController::class, 'acceptFriend'])->name('user.friend.accept');
Route::delete('/profile/{user}/delete', [FriendController::class, 'destroy'])->name('user.friend.delete');

Route::get('/profile/{user:username}/notifications', [NotificationController::class, 'index'])->name('user.notifications');


Route::get('/{user:username}/messages', [MessagesController::class, 'index'])->name('user.messages');

Route::get('/',  [PostController::class, 'index'] )->name('home');

