<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(
    [
        'middleware' => LocaleMiddleware::class,
        'prefix' => LocaleMiddleware::getLocale(),
    ],
    function () {
        Route::get('/search', [PostController::class, 'search'])->name('search');

        Route::get('locale/{locale}', LocaleController::class)->name('change-locale');

        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
        Route::get('/more', [PostController::class, 'more'])->name('posts.more');
        Route::get('/categories/{category:slug}', [PostController::class, 'more'])->name('categories.posts');
        Route::get('/tags/{tag:slug}', [PostController::class, 'more'])->name('tags.posts');

        Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');
        Route::post('/post/{post}/like', [PostController::class, 'like'])->name('post.like');
    }
);

require __DIR__ . '/auth.php';
require __DIR__ . '/socialstream.php';
