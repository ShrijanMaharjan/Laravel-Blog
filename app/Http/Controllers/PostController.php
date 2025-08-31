<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Post::with(['user', 'categories'])->withCount('comments');
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:published,pending',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post = Post::create([
            'title'   => $request->title,
            'body' => $request->body,
            'status'  => $request->status,
            'user_id' => Auth::id(),
        ]);

        $post->categories()->sync($request->categories ?? []);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
