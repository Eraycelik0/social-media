<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', function () {
    $a = new App\Helpers\GoogleBookApi\GoogleBookApiHelper();
    $a->getBook();
});

Route::get('/test-v1', function () {
    $a = new App\Helpers\GoogleBookApi\GoogleBookApiHelper();
    $a->getBooks_v1();
});

Route::get('password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class,'showLinkRequestForm'])->name('password.reset');
