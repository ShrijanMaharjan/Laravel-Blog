<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    @vite('resources/css/app.css') {{-- Assuming you have Tailwind setup via Vite --}}
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Post</h2>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT') 

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" 
                       value="{{ old('title', $post->title) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            {{-- Body --}}
            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                <textarea id="body" name="body" rows="4"
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('body', $post->body) }}</textarea>
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="published" {{ old('status', $post->status)=='published' ? 'selected' : '' }}>Published</option>
                    <option value="pending" {{ old('status', $post->status)=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="draft" {{ old('status', $post->status)=='draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            {{-- Categories --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Categories</label>
                <div class="mt-2 space-y-2">
                    @foreach($categories as $category)
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   value="{{ $category->id }}"
                                   {{ (in_array($category->id, old('categories', $post->categories->pluck('id')->toArray()))) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex space-x-4">
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    Update Post
                </button>
                <a href="{{ route('posts.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 transition">
                    Back
                </a>
            </div>
        </form>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mt-6 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>
