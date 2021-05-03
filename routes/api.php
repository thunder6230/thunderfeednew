<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PostCommentsController;
use App\Http\Controllers\Api\PostLikeController;

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
Route::get('/users', [ContactController::class, 'getAll']);



Route::get('/getposts', [PostsController::class, 'getposts']);
Route::get('/getuserposts', [PostsController::class, 'getUserPosts']);
Route::get('/getmoreposts', [PostsController::class, 'loadMorePosts']);

//Private Endpoint only for authenticated users
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Endpoints for Chatapp
    Route::get('/contacts/{user}', [ContactController::class, 'get']);
    Route::get('/conversation/{user}', [MessageController::class, 'getMessages']);
    Route::post('/conversation', [MessageController::class, 'store']);
    Route::put('/messages/{id}', [MessageController::class, 'update']);
    Route::delete('/conversation/{id}', [MessageController::class, 'destroy']);

    //endpoints for Posts CRUD
    Route::post('/posts', [PostsController::class, 'store']);
    Route::get('/posts/{post}', [PostsController::class, 'show']);
    Route::delete('/posts/{id}', [PostsController::class, 'destroy']);
    //endpoint for Post Likes
    Route::post('/posts/like', [PostLikeController::class, 'store']);
    Route::delete('/posts/{id}/like', [PostLikeController::class, 'destroy']);
    //endpoints for Post Comments
    Route::post('/posts/{id}/comment', [PostCommentsController::class, 'store']);
    Route::delete('/posts/{id}/comment', [PostCommentsController::class, 'destroy']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});