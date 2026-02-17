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
