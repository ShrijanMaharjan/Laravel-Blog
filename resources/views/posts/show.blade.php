<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-3xl mx-auto p-6">
    
    {{-- Post Details --}}
    <div class="bg-white p-8 rounded-xl shadow-lg mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $post->title }}</h1>
        <p class="text-gray-700 leading-relaxed mb-6">{{ $post->body }}</p>

        <div class="flex items-center justify-between text-sm text-gray-500 border-t pt-4">
            <span>By <span class="font-semibold">{{ $post->user->name }}</span></span>
            <span>{{ $post->created_at->format('M d, Y') }}</span>
        </div>

        {{-- Categories --}}
        <div class="mt-4">
            @foreach($post->categories as $category)
                <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium mr-2">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>
    </div>

    {{-- Comments Form --}}
    <div class="bg-white p-6 rounded-xl shadow-md mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Add a Comment</h2>
        <form action="{{ route('comments.store', $post) }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea name="content" placeholder="Write your comment..." rows="3"
                      class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content') }}</textarea>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                Submit
            </button>
        </form>

        {{-- Display Errors --}}
        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- Comments List --}}
    <div class="space-y-4 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Comments ({{ $post->comments->count() }})</h2>
        @forelse($post->comments as $comment)
            <div class="bg-white shadow-sm rounded-lg p-4">
                <p class="text-gray-700 mb-2">{{ $comment->content }}</p>
                <p class="text-gray-500 text-xs">
                    By <span class="font-medium">{{ $comment->user->name }}</span> • {{ $comment->created_at->diffForHumans() }}
                </p>
            </div>
        @empty
            <p class="text-gray-500 italic">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>

    {{-- Back Button --}}
    <div class="text-right">
        <a href="{{ route('posts.index') }}" 
           class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
            ← Back to Posts
        </a>
    </div>

</div>
</body>
</html>
