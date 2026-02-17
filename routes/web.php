<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::resource('posts', PostController::class);

Route::get('/', function ()
{
    return redirect('/posts');
});
