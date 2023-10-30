<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Follower\FollowerController;
use App\Http\Controllers\Post\PostController;
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

// User Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // User Post CRUD Operations
    Route::post('/posts', [PostController::class, 'create'])->name('post.create');
    Route::post('/post-update', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post-delete', [PostController::class, 'delete'])->name('post.delete');
    Route::get('/post-get', [PostController::class, 'getById'])->name('post.get');
    // User follower CRUD Operations
    Route::post('/follow/{followed_id}', [FollowerController::class, 'followUser']);
    Route::post('/follow-request/{followed_id}', [FollowerController::class,'sendFollowRequest']);
    Route::post('/accept-follow-request/{follower_id}', [FollowerController::class,'acceptFollowRequest']);
    Route::delete('/unfollow/{followed_id}', [FollowerController::class, 'unfollowUser']);
});




