<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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



// Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LogoutController::class, 'store'])->name('logout');
Route::post('/pwreset', [LoginController::class, 'pwreset'])->name('reset');

Route::get('/posts', [PostController::class, 'index'] )->name('posts');
Route::get('/posts/{id}', [PostController::class, 'show'] )->name('posts.show');
Route::get('/about', [AboutController::class, 'index'] );
Route::get('/profile/{user:username}', [ProfileController::class, 'index'])->name('profile');
Route::get('/profile/{user:username}/pictures/{id}', [ProfileController::class, 'showPicture'])->name('profile.picture');
Route::get('/profile/{user:username}/settings', [ProfileController::class, 'showSettings'])->name('profile.settings');

Route::get('/notifications', [NotificationController::class, 'index'])->name('user.notifications');

Route::get('/messages', [MessagesController::class, 'index'])->name('user.messages');

Route::get('/friends', [FriendsController::class, 'index']);
Route::get('/users', [UsersController::class, 'index']);

Route::get('/',  [PostController::class, 'index'] )->name('home');

//Email verification
// Route::name('auth.resend_confirmation')->get('/register/confirm/resend', 'Auth\RegisterController@resendConfirmation');

// Route::name('auth.confirm')->get('/register/confirm/{confirmation_code}', 'Auth\RegisterController@confirm');



// Route::post('/profile/{user}/add', [FriendController::class, 'addFriend'])->name('user.friend.add');
// Route::post('/profile/{user}/accept', [FriendController::class, 'acceptFriend'])->name('user.friend.accept');
// Route::delete('/profile/{user}/delete', [FriendController::class, 'destroy'])->name('user.friend.delete');
// Route::post('post/{post}/likes', [PostLikeController::class, 'store'])->name('posts.likes');
// Route::delete('post/{post}/likes', [PostLikeController::class, 'destroy'])->name('posts.likes');
// Route::post('post/{post}/comment', [PostCommentController::class, 'store'])->name('posts.comment');
// Route::delete('post/{postComment}', [PostCommentController::class, 'destroy'])->name('posts.comment.delete');
// Route::post('/posts', [PostController::class, 'store'] )->name('posts');
// Route::delete('/posts/{post}', [PostController::class, 'destroy'] )->name('posts.delete');
