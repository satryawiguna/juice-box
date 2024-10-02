<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "product" middleware group. Make something great!
|
*/


Route::post('/register', [\App\Http\Controllers\Api\UserController::class, 'register'])->name('post.api.register');
Route::post('/login', [\App\Http\Controllers\Api\UserController::class, 'login'])->name('post.api.login');
Route::get('/verify', [\App\Http\Controllers\Api\UserController::class, 'verify'])->name('get.api.verify');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [\App\Http\Controllers\Api\UserController::class, 'logout'])->name('post.api.logout');
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'user'], function () {
    Route::get('/{id}', [\App\Http\Controllers\Api\UserController::class, 'show'])->name('get.api.user.show');
});

require __DIR__ . '/api/blog.php';
