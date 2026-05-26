<!DOCTYPE html>
<html>
<head>
<title>Edit Post</title>
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
    background: #ffc107;
    color: black;
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
    <h2>Edit Post</h2>

    <form action="{{ route('posts.update', $post->slug) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Title</label>
        <input type="text" name="title" id="titleInput" value="{{ $post->title }}" required>

        <div class="slug-text">Live Slug: <span id="slugPreview">{{ $post->slug }}</span></div>

        <label>Content</label>
        <textarea name="content" rows="5" required>{{ $post->content }}</textarea>

        <label>Status</label>
        <select name="status" required>
            <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>
                Draft
            </option>
            <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>
                Published
            </option>
        </select>

        <button type="submit">Update Post</button>
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