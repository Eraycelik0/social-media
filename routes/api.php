<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Follower\FollowerController;
use App\Http\Controllers\Like\LikeController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Post\PostController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-password-reset-link',  [AuthController::class, 'sendPasswordResetLink'] );
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // User CRUD Operations
    Route::prefix('/users')->group(function () {
        Route::get('/',[UserController::class,'getAll'])->name('users.getAll');
        Route::get('/get/{id}', [UserController::class, 'get'])->name('users.get');
        Route::post('/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    });

    // User Post CRUD Operations
    Route::prefix('/posts')->group(function () {
        Route::post('/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/update', [PostController::class, 'update'])->name('post.update');
        Route::delete('/delete', [PostController::class, 'delete'])->name('post.delete');
        Route::get('/get', [PostController::class, 'getById'])->name('post.get');
        Route::post('/user', [PostController::class, 'getPostsByUserId'])->name('user.posts');
    });

    // Messages CRUD Operations
    Route::prefix('/messages')->group(function () {
        Route::get('/getList/{id}',[MessageController::class,'getList']);
        Route::get('/{from}/{to}/getAll', [MessageController::class,'get']);
        Route::post('/create', [MessageController::class, 'create']);
    });

    // User follower CRUD Operations
    Route::prefix('/follow')->group(function () {
        Route::post('/{followed_id}', [FollowerController::class, 'followUser']);
        Route::post('/follow-request/{followed_id}', [FollowerController::class,'sendFollowRequest']);
        Route::post('/accept-follow-request/{follower_id}', [FollowerController::class,'acceptFollowRequest']);
        Route::delete('/unfollow/{to}', [FollowerController::class, 'unfollowUser']);
    });

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




