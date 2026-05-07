<?php

use App\Enum\GoogleDriveFolder;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SaveController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::get("ping" , function(){
    return "back-end works fine ";
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get("auth/{provider}/redirect" , [SocialAuthController::class , 'redirectToProvider']);
Route::get("auth/{provider}/callback" , [SocialAuthController::class , 'handleProviderCallback']);

Route::apiResource('books', BookController::class)->only(['index', 'show']);
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {

    Route::apiResource('books', BookController::class)->except(['index', 'show']);
Route::apiResource('authors', AuthorController::class)->except(['index', 'show']);
    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);

    Route::apiResource('reviews', ReviewController::class)->except('show');
    Route::get('/books/{book_id}/reviews', [ReviewController::class, 'show']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('favorites', [UserController::class, 'favorites']);
    Route::post('books/{bookId}/favorites', [FavoriteController::class, 'store']);
    Route::delete('books/{bookId}/favorites', [FavoriteController::class, 'destroy']);

    Route::get('saves', [UserController::class, 'saves']);
    Route::post('books/{bookId}/saves', [SaveController::class, 'store']);
    Route::delete('books/{bookId}/saves', [SaveController::class, 'destroy']);
});
