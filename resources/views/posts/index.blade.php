<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="{{route('posts.index')}}">
        <input type="search" name="search" value="{{request('search')}}" placeholder="Search...">
    <button type="submit">Search</button>
    </form>
    
    <a href="{{route('posts.create')}}">Create Post</a>
    @foreach($posts as $post)
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->body }}</p>
        <p>By: {{ $post->user->name }}</p>
        <p>Categories: 
            @foreach($post->categories as $category)
                {{ $category->name }}{{ !$loop->last ? ',' : '' }}
            @endforeach
        </p>
        <hr>
    @endforeach
    {{$posts->links()}}
</body>
</html>