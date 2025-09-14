<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    //

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Comment added successfully.');
    }
    public function destroy(Comment $comment)
    {

        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->route('posts.index')->with('success', 'Comment deleted successfully.');
    }
}
