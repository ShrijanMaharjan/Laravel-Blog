<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function dashboard(Request $request)
    {
        $query = Post::query();

        if ($request->filled('sort_by')) {
            if ($request->sort_by === '7_days') {
                $query->where('created_at', '>=', now()->subDays(7));
            } elseif ($request->sort_by === '1_month') {
                $query->where('created_at', '>=', now()->subMonth());
            }
        }

        $postsLikes = $query->clone()
            ->orderBy('likes', 'desc')
            ->take(5)
            ->get(['title', 'likes']);
        $like_labels = $postsLikes->pluck('title');
        $like_data   = $postsLikes->pluck('likes');

        $postsViews = $query->clone()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get(['title', 'views']);

        $labels = $postsViews->pluck('title');
        $data   = $postsViews->pluck('views');

        $postsComments = $query->clone()
            ->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get(['title']);

        $post_title      = $postsComments->pluck('title');
        $comments_count  = $postsComments->pluck('comments_count');

        return view('dashboard', compact('like_labels', 'like_data', 'labels', 'data', 'post_title', 'comments_count'));
    }
}
