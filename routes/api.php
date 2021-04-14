<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
Route::get('/contacts/{user}', [ContactController::class, 'get']);
Route::get('/users', [ContactController::class, 'getAll']);
Route::get('/conversation/{user}', [MessageController::class, 'getMessages']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/conversation', [MessageController::class, 'store']);
    Route::delete('/conversation/{id}', [MessageController::class, 'destroy']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});