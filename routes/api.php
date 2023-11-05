<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Follower\FollowerController;
use App\Http\Controllers\Like\LikeController;
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
Route::post('/send-password-reset-link',  [AuthController::class, 'sendPasswordResetLink'] );
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // User Post CRUD Operations
    Route::post('/posts', [PostController::class, 'create'])->name('post.create');
    Route::post('/post-update', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post-delete', [PostController::class, 'delete'])->name('post.delete');
    Route::get('/post-get', [PostController::class, 'getById'])->name('post.get');
    Route::post('/user/posts', [PostController::class, 'getPostsByUserId'])->name('user.posts');

    // User follower CRUD Operations
    Route::post('/follow/{followed_id}', [FollowerController::class, 'followUser']);
    Route::post('/follow-request/{followed_id}', [FollowerController::class,'sendFollowRequest']);
    Route::post('/accept-follow-request/{follower_id}', [FollowerController::class,'acceptFollowRequest']);
    Route::delete('/unfollow/{followed_id}', [FollowerController::class, 'unfollowUser']);

    // Comment
    Route::prefix('/comment')->name('comment.')->group(function (){
        Route::get('/get',[CommentController::class,'get'])->name('get');
        Route::get('/getAll',[CommentController::class,'getAll'])->name('getAll');
        Route::post('/create',[CommentController::class,'create'])->name('create');
        Route::put('/update',[CommentController::class,'update'])->name('update');
        Route::delete('/delete',[CommentController::class,'delete'])->name('delete');
    });

    Route::prefix('/like')->name('like.')->group(function (){
        Route::get('/get',[LikeController::class,'get'])->name('get');
        Route::get('/getAll',[LikeController::class,'getAll'])->name('getAll');
        Route::post('/create',[LikeController::class,'create'])->name('create');
        Route::delete('/delete',[LikeController::class,'delete'])->name('delete');
    });
});




