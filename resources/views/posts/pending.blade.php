<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Pending Posts</h1>

<div class="container mx-auto px-4">
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @forelse($posts as $post)
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 hover:shadow-lg transition duration-300 p-6 flex flex-col justify-between">
                
                <!-- Post Title -->
                <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-blue-600 transition">
                    <a href="{{ route('posts.show', $post) }}">
                        {{ $post->title }}
                    </a>
                </h2>

                <!-- Post Body -->
                <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->body }}</p>

                <!-- Post Meta -->
                <div class="text-sm text-gray-500 mb-3">
                    By <span class="font-medium text-gray-700">{{ $post->user->name }}</span> • 
                    {{ $post->created_at->diffForHumans() }}
                </div>
                <div class="text-sm text-gray-500 mb-3 flex flex-wrap gap-2">
                    💬 {{ $post->comments_count }} • 👁️ {{ $post->views }} • ❤️ {{ $post->likes }}
                </div>

                <!-- Categories -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($post->categories as $category)
                        <span class="bg-gray-200 text-gray-700 text-xs px-3 py-1 rounded-full">
                            #{{ $category->name }}
                        </span>
                    @endforeach
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap gap-4 mt-auto">
                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:underline font-medium transition">✏️ Edit</a>
                    <a href="{{ route('posts.show', $post) }}" class="text-green-600 hover:underline font-medium transition">👁️ View</a>

                    <form action="{{ route('posts.postlike', $post->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-yellow-600 hover:underline font-medium transition">❤️ Like</button>
                    </form>

                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline font-medium transition"
                            onclick="return confirm('Are you sure you want to delete this post?')">🗑 Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 col-span-full">No posts found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>

</body>
</html>