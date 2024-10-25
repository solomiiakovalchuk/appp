<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/more', [PostController::class, 'more'])->name('posts.more');
//Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('/posts/all', [PostController::class, 'allPosts'])->name('posts.all');
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/categories/{category:slug}', [CategoryController::class, 'posts'])->name('categories.posts');
Route::get('/tags/{tag:slug}', [TagController::class, 'posts'])->name('tags.posts');

//Route::post('/posts/{post:slug}/comment', [CommentController::class, 'store'])->name('comments.store');


require __DIR__.'/auth.php';
require __DIR__.'/socialstream.php';
