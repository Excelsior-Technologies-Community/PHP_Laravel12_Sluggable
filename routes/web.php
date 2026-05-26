<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/posts/toggle/{post}', [PostController::class, 'toggleStatus']);

Route::resource('posts', PostController::class);

Route::get('/', function () {
    return redirect('/posts');
});