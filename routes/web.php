<?php

use App\Http\Controllers\{
    HomeController,
    CommentController,
    MessageController,
    ProfileController
};
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('messages')->name('messages.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('index');
    Route::get('/create', [MessageController::class, 'create'])->name('create');
    Route::get('/show/{message}', [MessageController::class, 'show'])->name('show');
    Route::get('/edit/{message}', [MessageController::class, 'edit'])->name('edit');
    Route::put('/{message}', [MessageController::class, 'update'])->name('update');
    Route::post('/', [MessageController::class, 'store'])->name('store');
    Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
});

Route::prefix('message/comments')->name('comments.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/create/{message}', [CommentController::class, 'create'])->name('create');
    Route::get('/edit/{comment}', [CommentController::class, 'edit'])->name('edit');
    Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
    Route::post('/{message}', [CommentController::class, 'store'])->name('store');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
