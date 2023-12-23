<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Follower\FollowerController;
use App\Http\Controllers\Like\LikeController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\User\UserController;
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
Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot_password_mail']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset_password']);
});



Route::middleware('auth:sanctum')->group(function () {
    // User profile CRUD Operations
    Route::prefix('/profile')->group(function () {
        Route::get('/detail', [ProfileController::class, 'detail']);
        Route::post('/update', [ProfileController::class, 'update']);
    });
    // User CRUD Operations
    Route::prefix('/users')->group(function () {
        Route::get('/',[UserController::class,'getAll'])->name('users.getAll');
        Route::get('/get/{id}', [UserController::class, 'get'])->name('users.get');
    });
    // User Post CRUD Operations
    Route::prefix('/posts')->group(function () {
        Route::post('/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/update', [PostController::class, 'update'])->name('post.update');
        Route::delete('/{uuid}/delete', [PostController::class, 'delete'])->name('post.delete');
        Route::get('/{uuid}', [PostController::class, 'getBy'])->name('post.get');
        Route::post('/user', [PostController::class, 'getPostsByUser'])->name('user.posts');
    });
    // Comment
    Route::prefix('/comment')->name('comment.')->group(function (){
        Route::post('/create', [CommentController::class, 'create'])->name('comment.create');
        Route::post('/update', [CommentController::class, 'update'])->name('comment.update');
        Route::delete('/{uuid}/delete', [CommentController::class, 'delete'])->name('comment.delete');
        Route::get('/{uuid}', [CommentController::class, 'getBy'])->name('comment.get');
        Route::post('/user-comment', [CommentController::class, 'getCommentsByUser'])->name('user.comments');
    });
    // Messages CRUD Operations
    Route::prefix('/messages')->group(function () {
        Route::get('/getList/{id}',[MessageController::class,'getList']);
        Route::get('/{from}/{to}/getAll', [MessageController::class,'get']);
        Route::post('/create', [MessageController::class, 'create']);
    });

    // User follower CRUD Operations
    Route::prefix('/follow')->group(function () {
        Route::post('/{username}', [FollowerController::class, 'followUser']);
        Route::post('/follow-request/{username}', [FollowerController::class,'sendFollowRequest']);
        Route::post('/accept-follow-request/{username}', [FollowerController::class,'acceptFollowRequest']);
        Route::delete('/unfollow/{to}', [FollowerController::class, 'unfollowUser']);
        Route::get('follow-requests', [FollowerController::class, 'getFollowRequests']);
        Route::get('follower-count/{username}', [FollowerController::class, 'getFollowerList']);
        Route::get('following-count/{username}', [FollowerController::class, 'getFollowingList']);
    });
    // User like CRUD Operations
    Route::prefix('/like')->name('like.')->group(function (){
        Route::get('/get',[LikeController::class,'get'])->name('get');
        Route::get('/getAll',[LikeController::class,'getAll'])->name('getAll');
        Route::post('/create',[LikeController::class,'create'])->name('create');
        Route::delete('/delete',[LikeController::class,'delete'])->name('delete');
    });
});




