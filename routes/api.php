<?php

use App\Http\Controllers\Auth\AuthController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/posts', [PostController::class, 'create'])->name('post.create');
Route::post('/post-update', [PostController::class, 'update'])->name('post.update');
Route::delete('/post-delete', [PostController::class, 'delete'])->name('post.delete');
Route::get('/post-get', [PostController::class, 'getById'])->name('post.get');


