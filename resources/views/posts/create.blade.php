<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>
    <form action="{{route('posts.store')}}" method="POST">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="body">Body:</label>
        <textarea id="body" name="body" required></textarea><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="published">Published</option>
            <option value="pending">Pending</option>
            
        </select><br><br>

        <div class="mb-3">
            <label class="form-label">Categories</label>
            <div class="form-check">
                @foreach($categories as $category)
                    <input class="form-check-input" type="checkbox"
                           name="categories[]" value="{{ $category->id }}"
                           id="category{{ $category->id }}"
                           {{ (collect(old('categories'))->contains($category->id)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category{{ $category->id }}">
                        {{ $category->name }}
                    </label><br>
                @endforeach
            </div>
        </div>
       

        <button type="submit">Create Post</button>
        <button><a href="{{route('posts.index')}}">Back</a></button>
    </form>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        
    @endif
    
    
</body>
</html>
