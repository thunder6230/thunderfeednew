<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\MessageController;

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
Route::get('/allusers', [ContactController::class, 'getAllUsers']);



Route::get('/getposts', [PostsController::class, 'getposts']);
Route::get('/getuserposts', [PostsController::class, 'getUserPosts']);
Route::get('/getmoreposts', [PostsController::class, 'loadMorePosts']);
Route::get('/user_pictures', [PostsController::class, 'userPictures']);

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

    //endpoint for Post Likes, Comment Likes Picture likes and Reply likes
    Route::post('/posts/like', [LikeController::class, 'storePostLike']);
    Route::post('/comments/like', [LikeController::class, 'storeCommentLike']);
    Route::post('/pictures/{id}/like', [LikeController::class, 'storeCommentLike']);
    Route::delete('/like/{id}/unlike', [LikeController::class, 'destroy']);

    //endpoints for Post Comments, Picture Comments and Comment replies
    Route::post('/posts/{id}/comment', [CommentController::class, 'storePostComment']);
    Route::post('/posts/comments/{id}/like', [LikeController::class, 'storePostComment']);
    Route::post('/picture/{id}/comment', [CommentController::class, 'storePictureComment']);
    Route::post('/comments/{id}/reply', [CommentController::class, 'storeCommentReply']);
    Route::delete('/posts/comments/{id}', [CommentController::class, 'destroy']);

});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});