<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-2xl bg-white shadow-lg rounded-xl p-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Create Post</h1>

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" id="title" name="title" 
                   value="{{ old('title') }}"
                   class="w-full px-4 py-2 border border-gray-300 bg-gray-50 text-gray-800 rounded-lg shadow-sm 
                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>

        {{-- Body --}}
        <div>
            <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Body</label>
            <textarea id="body" name="body" rows="5"
                      class="w-full px-4 py-2 border border-gray-300 bg-gray-50 text-gray-800 rounded-lg shadow-sm 
                             focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('body') }}</textarea>
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="status" name="status"
                    class="w-full px-4 py-2 border border-gray-300 bg-gray-50 text-gray-800 rounded-lg shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="published" {{ old('status')=='published' ? 'selected' : '' }}>Published</option>
                <option value="pending" {{ old('status')=='pending' ? 'selected' : '' }}>Pending</option>
                
            </select>
        </div>

        {{-- Categories --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
            <div class="mt-2 flex flex-wrap gap-4">
                @foreach($categories as $category)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" 
                               name="categories[]" 
                               value="{{ $category->id }}"
                               {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                               class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-gray-700 text-sm">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end space-x-3">
            <a href="{{ route('posts.index') }}" 
               class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow transition">
               Back
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                Create Post
            </button>
        </div>
    </form>
</div>

</body>
</html>
