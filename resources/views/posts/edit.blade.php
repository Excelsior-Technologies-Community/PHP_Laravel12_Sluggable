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
