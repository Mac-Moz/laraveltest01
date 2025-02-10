<?php

use App\Http\Controllers\ProfileController;
// ⭐️1行追加⭐️
use App\Http\Controllers\TweetController;

// ⭐️追加⭐️
use App\Http\Controllers\TweetLikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/demo', function () {
    return '<h1>デモページ</h1>';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // ⭐️ 追加 ⭐️
    Route::resource('tweets', TweetController::class);

    // ⭐️ 追加 ⭐️
    Route::post('/tweets/{tweet}/like', [TweetLikeController::class, 'store'])->name('tweets.like');
    Route::delete('/tweets/{tweet}/like', [TweetLikeController::class, 'destroy'])->name('tweets.dislike');
});

require __DIR__.'/auth.php';
