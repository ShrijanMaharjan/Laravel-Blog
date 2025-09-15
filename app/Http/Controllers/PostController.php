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
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }
        if ($request->filled('comments_count')) {
            $query->orderBy('comments_count', $request->comments_count);
        }
        if ($request->filled('sort_by')) {
            $query->orderBy('created_at', $request->sort_by);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();
        return view('posts.index', compact('posts', 'categories'));
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
        $post = Post::findOrFail($id);
        if ($post->user_id == Auth::id()) {
            $post->views = $post->views;
        } else {
            $post->views = $post->views + 1;
        };
        $post->save();

        $post = Post::with(['user', 'comments.user', 'categories'])->findOrFail($id);
        $latestComments = $post->comments()->latest()->take(5)->get();
        return view('posts.show', compact('post', 'latestComments'));
    }
    public function postlike(string $id)
    {
        //
        $post = Post::findOrFail($id);
        if ($post->user_id == Auth::id()) {
            return redirect()->route('posts.index')
                ->with('error', 'You cannot like your own post.');
        } else {
            $post->likes = $post->likes + 1;
            $post->save();
            return redirect()->route('posts.index')
                ->with('success', 'Post liked successfully.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorizeUser(Post::findOrFail($id));

        return view('posts.edit', [
            'post' => Post::with('categories')->findOrFail($id),
            'categories' => Category::all()
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->authorizeUser(Post::findOrFail($id));
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:published,pending',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);
        $post = Post::findOrFail($id);
        $post->update([
            'title'   => $request->title,
            'body' => $request->body,
            'status'  => $request->status,
        ]);
        $post->categories()->sync($request->categories ?? []);
        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->authorizeUser(Post::findOrFail($id));
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }
    public function showDeletedPosts()
    {
        $deletedPosts = Post::onlyTrashed()->where('user_id', Auth::id())->get();
        return view('posts.deleted', compact('deletedPosts'));
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorizeUser($post);
        $post->restore();
        return redirect()->route('posts.index')
            ->with('success', 'Post restored successfully.');
    }
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorizeUser($post);
        $post->forceDelete();
        return redirect()->route('posts.index')
            ->with('success', 'Post permanently deleted successfully.');
    }

    public function authorizeUser(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
