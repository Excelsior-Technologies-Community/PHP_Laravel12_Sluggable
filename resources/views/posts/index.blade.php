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

.btn-toggle{
    background:#6f42c1;
    color:white;
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

.search-box{
    margin:15px 0;
    display:flex;
    gap:10px;
}

.search-box input{
    flex:1;
    padding:8px;
    border:1px solid #ccc;
    border-radius:5px;
}

.search-box button{
    padding:8px 14px;
    background:#007bff;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.status{
    margin-top:8px;
    font-size:14px;
}

.status.published{
    color:green;
    font-weight:bold;
}

.status.draft{
    color:orange;
    font-weight:bold;
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

<form method="GET" action="{{ route('posts.index') }}" class="search-box">

    <input type="text" name="search" placeholder="Search posts by title..." value="{{ request('search') }}">

    <button type="submit">Search</button>

</form>

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

<div class="status {{ $post->status }}">
    Status:
    {{ ucfirst($post->status) }}
</div>

<div class="actions">

<a href="/posts/toggle/{{ $post->slug }}" class="btn btn-toggle">
    {{ $post->status == 'draft' ? 'Publish Now' : 'Revert to Draft' }}
</a>

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