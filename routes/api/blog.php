<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum', 'prefix' => '/blog'], function () {
    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Blog\PostController::class, 'list'])->name('get.api.blog.posts');
        Route::post('/search', [\App\Http\Controllers\Api\Blog\PostController::class, 'search'])->name('post.api.blog.posts.search');
        Route::post('/search/page', [\App\Http\Controllers\Api\Blog\PostController::class, 'searchAndPagination'])->name('post.api.blog.posts.search.page');
    });

    Route::group(['prefix' => 'post'], function () {
        Route::get('/{id}', [\App\Http\Controllers\Api\Blog\PostController::class, 'show'])->name('get.api.master.page.show');
        Route::post('/', [\App\Http\Controllers\Api\Blog\PostController::class, 'store'])->name('post.api.master.page.store');
        Route::patch('/{id}', [\App\Http\Controllers\Api\Blog\PostController::class, 'update'])->name('patch.api.master.page.update');
        Route::delete('/{id}', [\App\Http\Controllers\Api\Blog\PostController::class, 'destroy'])->name('delete.api.master.page.destroy');
    });
});
