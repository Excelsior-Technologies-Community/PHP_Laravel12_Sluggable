<!DOCTYPE html>
<html>
<head>
<title>Create Post</title>
<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    padding: 20px;
}
.container {
    width: 500px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 6px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}
input, textarea, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
button {
    background: #28a745;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.back {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
}
.slug-text {
    font-size: 13px;
    color: #555;
    margin-top: -10px;
    margin-bottom: 15px;
}
#slugPreview {
    color: #28a745;
    font-weight: bold;
    font-family: monospace;
}
</style>
</head>
<body>

<div class="container">
    <h2>Create Post</h2>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <label>Title</label>
        <input type="text" name="title" id="titleInput" required>
        
        <div class="slug-text">Live Slug: <span id="slugPreview"></span></div>

        <label>Content</label>
        <textarea name="content" rows="5" required></textarea>

        <label>Status</label>
        <select name="status" required>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>

        <button type="submit">Save Post</button>
    </form>

    <a href="{{ route('posts.index') }}" class="back">← Back</a>
</div>

<script>
    document.getElementById('titleInput').addEventListener('input', function(e) {
        let slug = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        document.getElementById('slugPreview').textContent = slug;
    });
</script>

</body>
</html>