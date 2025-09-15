<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Deleted Posts</h1>

        @forelse ($deletedPosts as $deletedPost) 
            <div class="bg-white border border-gray-200 rounded-lg p-5 mb-4 shadow-sm hover:shadow-md transition">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $deletedPost->title }}</h2>
                <p class="text-gray-700 mb-4">{{ $deletedPost->body }}</p>

                <form action="{{ route('posts.restore', $deletedPost->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        Restore
                    </button>
                </form>
                <form action="{{ route('posts.forceDelete', $deletedPost->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                        Delete Permanently
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 italic">No deleted posts!</p>
        @endforelse
    </div>

</body>
</html>
