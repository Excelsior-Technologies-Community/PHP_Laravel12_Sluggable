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
