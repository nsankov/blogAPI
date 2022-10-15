<?php

use App\Http\Controllers\APIv1\CategoryController;
use App\Http\Controllers\APIv1\ArticleController;
use App\Http\Controllers\APIv1\ArticleVoteController;
use App\Http\Controllers\APIv1\AvatarController;
use App\Http\Controllers\APIv1\CommentController;
use App\Http\Controllers\APIv1\CommentVoteController;
use App\Http\Controllers\APIv1\UserController;
use App\Http\Controllers\APIv1\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/user/register', [UserController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('categories/top', [CategoryController::class, 'top'])->name('categories.top')->withoutMiddleware('auth:sanctum');
    Route::apiResource('avatar', AvatarController::class)->only(['show', 'store', 'destroy']);
    Route::apiResource('categories', CategoryController::class);

    Route::prefix('articles/{article_id}')->name('articles.')->group(function () {
        Route::apiResource('comments', CommentController::class);
        Route::prefix('comments/{comment_id}')->name('comments.')->group(function () {
            Route::apiResource('vote', CommentVoteController::class)->only(['index', 'show', 'store']);
        });
        Route::apiResource('vote', ArticleVoteController::class)->only(['index', 'show', 'store']);
    });
    Route::apiResource('articles', ArticleController::class);
});
