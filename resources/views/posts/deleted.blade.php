<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Deleted Posts</h1>
    @foreach ($deletedPosts as $deletedPost)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <h2>{{ $deletedPost->title }}</h2>
            <p>{{ $deletedPost->body }}</p>
            <form action="{{ route('posts.restore', $deletedPost->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;">
                    Restore
                </button>
            </form>
        </div>
        
    @endforeach
</body>
</html>
