<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="max-w-3xl mx-auto mt-6">
            <div class="flex items-center justify-between bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="text-green-600 hover:text-green-800" onclick="this.closest('div').remove()">
                    ✕
                </button>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="max-w-3xl mx-auto mt-6">
            <div class="flex items-center justify-between bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" class="text-red-600 hover:text-red-800" onclick="this.closest('div').remove()">
                    ✕
                </button>
            </div>
        </div>
    @endif

    <div class="container mx-auto p-6">

        {{-- Header --}}
        <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
    <h1 class="text-3xl font-extrabold text-gray-800">📖 Blog Posts</h1>

    <div class="flex items-center gap-4">
        <a href="{{ route('posts.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-md transition">
            + Create Post
        </a>

        <span class="text-gray-700 font-medium">Hi, {{ auth()->user()->name }}</span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition">
                Logout
            </button>
        </form>
    </div>
</div>


        {{-- Filters --}}
        <form action="{{ route('posts.index') }}" method="GET" 
              class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-3">
            
            <select name="category_id" class="border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="sort_by" class="border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Sort by Date</option>
                <option value="asc" {{ request('sort_by') == 'asc' ? 'selected' : '' }}>Oldest → Newest</option>
                <option value="desc" {{ request('sort_by') == 'desc' ? 'selected' : '' }}>Newest → Oldest</option>
            </select>

            <select name="comments_count" class="border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Sort by Comments</option>
                <option value="asc" {{ request('comments_count') == 'asc' ? 'selected' : '' }}>Fewest → Most</option>
                <option value="desc" {{ request('comments_count') == 'desc' ? 'selected' : '' }}>Most → Fewest</option>
            </select>

            <div class="flex gap-2">
                <input type="search" name="search" value="{{ request('search') }}" 
                       placeholder="🔍 Search posts..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                    Apply
                </button>
            </div>
        </form>
        <button class="mb-5 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition"><a href="{{route('posts.deleted')}}">Deleted Posts</a></button>

        
        <button class="ml-5 mb-5 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md transition"><a href="{{route('posts.pending')}}">Pending Posts</a></button>
        
        {{-- Posts --}}
        <div class="grid gap-6 md:grid-cols-2">
            @forelse($posts as $post)
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition border border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">
                        <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">{{ $post->title }}</a>
                    </h2>
                    <p class="text-gray-600 mb-3 line-clamp-3">{{ $post->body }}</p>
                    
                    <div class="text-sm text-gray-500 mb-2">
                        By <span class="font-medium text-gray-700">{{ $post->user->name }}</span> • 
                        {{ $post->created_at->diffForHumans() }}
                    </div>

                    <div class="text-sm text-gray-500 mb-2">
                        💬 {{ $post->comments_count }} • 👁️ {{ $post->views }} • ❤️ {{$post->likes}}
                    </div>

                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($post->categories as $category)
                            <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-lg">
                                #{{ $category->name }}
                            </span>
                        @endforeach
                    </div>

                    <div class="flex gap-4 mt-4">
                        <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:underline">✏️ Edit</a>
                        <a href="{{ route('posts.show', $post) }}" class="text-green-600 hover:underline">👁️ View</a>
                            <form action="{{ route('posts.postlike', $post->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-yellow-600 hover:underline">❤️ Like</button>
                            </form>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="confirm('Are you sure?')">🗑 Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No posts found.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    </div>

</body>
</html>
