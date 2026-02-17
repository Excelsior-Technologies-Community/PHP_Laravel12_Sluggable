# PHP_Laravel12_Sluggable

## Project Description

PHP_Laravel12_Sluggable is a Laravel 12 web application that demonstrates how to implement SEO-friendly URLs using the Spatie Laravel Sluggable package.

The project allows users to create, read, update, and delete posts, with each post automatically generating a unique, human-readable slug from the post title. These slugs are used in URLs instead of numeric IDs to improve SEO and readability.


### This project is ideal for learning how to:

- Use Laravel Models, Migrations, and Controllers for CRUD operations

- Implement automatic slug generation

- Use route-model binding with slugs

- Build a simple, clean frontend interface using Blade templates


## Features

- Create, Read, Update, Delete posts (CRUD)

- Automatic slug generation from post title

- Slug-based route URLs for SEO-friendly links

- Form validation for required fields

- Clean and responsive frontend using simple CSS

- Route-model binding using slugs

- Success messages after create, update, and delete actions


## Technology Used

- PHP 8+ – Server-side programming language

- Laravel 12 – PHP framework

- MySQL – Database for storing posts and slugs

- Spatie Laravel Sluggable – Auto-generate unique slugs

- Blade Templates – Frontend views with HTML/CSS



---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Sluggable "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Sluggable

```

#### Explanation:

This command creates a new Laravel 12 project folder with all required Laravel files.




## STEP 2: Database Setup 

### Open .env and set:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_sluggable
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_sluggable

```

#### Explanation:

We configure Laravel to connect to MySQL database where posts and slugs will be stored.



## STEP 3: Install Sluggable Package

### Run:

```
composer require spatie/laravel-sluggable

```

#### Explanation:
 
This package automatically generates slugs from your post titles and stores them in the database.




## STEP 4: Create Model + Migration + Controller

### Run command:

```
php artisan make:model Post -mcr

```

### This creates:

```
Model

Migration

Controller (resource)

```

#### Explanation: 

This creates Post model, migration file for posts table, and a resource controller for CRUD operations.




## STEP 5: Setup Migration

### Open: database/migrations/create_posts_table.php

#### Replace code:

```
<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->string('slug')->unique();

            $table->text('content');   // REQUIRED

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

```

### Run migration:

```
php artisan migrate

```

#### Explanation: 

This creates posts table with title, slug, content and timestamp columns in the database.




## STEP 6: Setup Model 

### Open: app/Models/Post.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasSlug;

    protected $fillable =
    [
        'title',
        'slug',
        'content'
    ];

    /*
    |--------------------------------------------------------------------------
    | Slug Configuration
    |--------------------------------------------------------------------------
    */

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()

            ->generateSlugsFrom('title')

            ->saveSlugsTo('slug')

            ->slugsShouldBeNoLongerThan(50)

            ->doNotGenerateSlugsOnUpdate(false);
    }

    /*
    |--------------------------------------------------------------------------
    | Route Binding with Slug
    |--------------------------------------------------------------------------
    */

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

```

#### Explanation:
- `HasSlug` trait automatically generates slug from the title.

- `getRouteKeyName()` allows URLs to use slug instead of ID.





## STEP 7: Setup Resource Route

### Open routes/web.php

```
<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::resource('posts', PostController::class);

Route::get('/', function ()
{
    return redirect('/posts');
});

```

#### Explanation: 

This registers all CRUD routes for posts using Laravel’s resource controller. Homepage redirects to posts listing.


## STEP 8: Full Controller Code (Reference Structure)

### Open: app/Http/Controllers/PostController.php

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Display All Posts
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $posts = Post::latest()->get();

        return view('posts.index', compact('posts'));
    }

    /*
    |--------------------------------------------------------------------------
    | Show Create Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('posts.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Post
    |--------------------------------------------------------------------------
    */

  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string'
    ]);

    Post::create([
        'title' => $request->title,
        'content' => $request->content
    ]);

    return redirect()->route('posts.index')
                     ->with('success','Post Created Successfully');
}


    /*
    |--------------------------------------------------------------------------
    | Show Single Post (Slug)
    |--------------------------------------------------------------------------
    */

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /*
    |--------------------------------------------------------------------------
    | Show Edit Form
    |--------------------------------------------------------------------------
    */

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Post
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Post $post)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()->route('posts.index')
                         ->with('success','Post Updated Successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Post
    |--------------------------------------------------------------------------
    */

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
                         ->with('success','Post Deleted Successfully');
    }
}

```

#### Explanation:

Handles all CRUD operations: index, create, store, show, edit, update, destroy.

Uses route-model binding with slug for SEO-friendly URLs.



## STEP 9: Create Views Folder

### Create folder:

```
resources/views/posts

```


### resources/views/posts/index.blade.php

```
<!DOCTYPE html>
<html>
<head>
<title>All Posts</title>

<style>

body{
    font-family: Arial;
    background:#f4f6f9;
    margin:0;
    padding:20px;
}

.container{
    width:800px;
    margin:auto;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.btn{
    padding:8px 14px;
    text-decoration:none;
    border-radius:5px;
    font-size:14px;
}

.btn-create{
    background:#28a745;
    color:white;
}

.btn-view{
    background:#007bff;
    color:white;
}

.btn-edit{
    background:#ffc107;
    color:black;
}

.btn-delete{
    background:#dc3545;
    color:white;
    border:none;
    cursor:pointer;
}

.card{
    background:white;
    padding:15px;
    margin-top:15px;
    border-radius:6px;
    box-shadow:0 0 5px rgba(0,0,0,0.1);
}

.slug{
    color:gray;
    font-size:14px;
}

.success{
    background:#d4edda;
    padding:10px;
    color:#155724;
    margin-top:10px;
    border-radius:5px;
}

.actions{
    margin-top:10px;
}

.actions a, .actions form{
    display:inline-block;
}

</style>

</head>
<body>

<div class="container">

<div class="header">

<h2>All Posts</h2>

<a href="{{ route('posts.create') }}" class="btn btn-create">
Create Post
</a>

</div>

@if(session('success'))
<div class="success">
{{ session('success') }}
</div>
@endif

@foreach($posts as $post)

<div class="card">

<h3>{{ $post->title }}</h3>

<div class="slug">
Slug: {{ $post->slug }}
</div>

<div class="actions">

<a href="{{ route('posts.show',$post->slug) }}" class="btn btn-view">
View
</a>

<a href="{{ route('posts.edit',$post->slug) }}" class="btn btn-edit">
Edit
</a>

<form action="{{ route('posts.destroy',$post->slug) }}" method="POST">

@csrf
@method('DELETE')

<button class="btn btn-delete" onclick="return confirm('Are You Sure?')">
Delete
</button>

</form>

</div>

</div>

@endforeach

</div>

</body>
</html>

```


### resources/views/posts/create.blade.php

```
<!DOCTYPE html>
<html>
<head>

<title>Create Post</title>

<style>

body{
    font-family: Arial;
    background:#f4f6f9;
    padding:20px;
}

.container{
    width:500px;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:6px;
    box-shadow:0 0 5px rgba(0,0,0,0.1);
}

input, textarea{
    width:100%;
    padding:8px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:4px;
}

button{
    background:#28a745;
    color:white;
    padding:10px 15px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.back{
    display:inline-block;
    margin-top:10px;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

<h2>Create Post</h2>

<form action="{{ route('posts.store') }}" method="POST">

@csrf

<label>Title</label>

<input type="text" name="title" required>

<label>Content</label>

<textarea name="content" rows="5" required></textarea>

<button type="submit">
Save Post
</button>

</form>

<a href="{{ route('posts.index') }}" class="back">
← Back
</a>

</div>

</body>
</html>

```


### resources/views/posts/edit.blade.php

```
<!DOCTYPE html>
<html>
<head>

<title>Edit Post</title>

<style>

body{
    font-family: Arial;
    background:#f4f6f9;
    padding:20px;
}

.container{
    width:500px;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:6px;
    box-shadow:0 0 5px rgba(0,0,0,0.1);
}

input, textarea{
    width:100%;
    padding:8px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:4px;
}

button{
    background:#ffc107;
    color:black;
    padding:10px 15px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.back{
    display:inline-block;
    margin-top:10px;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

<h2>Edit Post</h2>

<form action="{{ route('posts.update',$post->slug) }}" method="POST">

@csrf
@method('PUT')

<label>Title</label>

<input type="text" name="title" value="{{ $post->title }}" required>

<label>Content</label>

<textarea name="content" rows="5" required>{{ $post->content }}</textarea>

<button type="submit">
Update Post
</button>

</form>

<a href="{{ route('posts.index') }}" class="back">
← Back
</a>

</div>

</body>
</html>

```

### resources/views/posts/show.blade.php

```
<!DOCTYPE html>
<html>
<head>

<title>View Post</title>

<style>

body{
    font-family: Arial;
    background:#f4f6f9;
    padding:20px;
}

.container{
    width:600px;
    margin:auto;
}

.card{
    background:white;
    padding:20px;
    border-radius:6px;
    box-shadow:0 0 5px rgba(0,0,0,0.1);
}

.slug{
    color:gray;
    margin-bottom:10px;
}

.back{
    display:inline-block;
    margin-top:15px;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h2>{{ $post->title }}</h2>

<div class="slug">
Slug: {{ $post->slug }}
</div>

<p>
{{ $post->content }}
</p>

<a href="{{ route('posts.index') }}" class="back">
← Back
</a>

</div>

</div>

</body>
</html>

```


## STEP 10: Launch the Server

### Run:

```
php artisan serve

```
### Then open your browser:

```
http://localhost:8000

```

#### Explanation: 

Start Laravel development server and check your application.

## So you can see this type Output:

### Create Page:


<img width="1913" height="931" alt="Screenshot 2026-02-17 105006" src="https://github.com/user-attachments/assets/78c94df8-ea3c-4ba5-ad14-047d24e3ef7a" />


### Post Created Successfully:


<img width="1917" height="738" alt="Screenshot 2026-02-17 105021" src="https://github.com/user-attachments/assets/42b7373e-7aa9-44cf-8b22-6ec1a1fb84fe" />


### View Post Page:


<img width="1910" height="860" alt="Screenshot 2026-02-17 105038" src="https://github.com/user-attachments/assets/00cb3c41-6647-4d94-875a-c49639058254" />


### Edit Post Page:


<img width="1915" height="888" alt="Screenshot 2026-02-17 105057" src="https://github.com/user-attachments/assets/26706162-df52-4318-864e-b186e0e4563d" />


### Post Updated Successfully:


<img width="1919" height="902" alt="Screenshot 2026-02-17 105107" src="https://github.com/user-attachments/assets/5a4d3ea2-3216-49a8-b76a-1141c4242ebe" />


### Delete Post:


<img width="1919" height="897" alt="Screenshot 2026-02-17 105117" src="https://github.com/user-attachments/assets/9596ccee-7f7d-4c04-ad24-1639e6224353" />



---

# Project Folder Structure:

```
PHP_Laravel12_Sluggable
│
├── app
│   ├── Models
│   │   └── Post.php
│   │
│   └── Http
│       └── Controllers
│           └── PostController.php
│
├── database
│   └── migrations
│       └── create_posts_table.php
│
├── resources
│   └── views
│       └── posts
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
│
└── routes
    └── web.php
```
