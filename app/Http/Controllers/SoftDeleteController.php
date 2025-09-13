<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class SoftDeleteController extends Controller
{
    //
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
    public function authorizeUser(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
