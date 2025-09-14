<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // public function likesChart()
    // {
    //     $likes = Post::select(
    //         DB::raw('MONTH(created_at) as month'),
    //         DB::raw('COUNT(*) as total_likes')
    //     )
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->get();

    //     // Prepare labels (Jan, Feb, etc.)
    //     $labels = $likes->map(fn($like) => date("F", mktime(0, 0, 0, $like->month, 1)));
    //     $data   = $likes->pluck('total_likes');

    //     return view('dashboard', compact('labels', 'data'));
    // }
    //show views of posts 7 days
    // public function dashboard(Request $request)
    // {

    //     $postsViews = Post::orderBy('views', 'desc')
    //         ->take(5)
    //         ->get(['title', 'views']);



    //     $labels = $postsViews->pluck('title');
    //     $data   = $postsViews->pluck('views');

    //     $postsComments = Post::withCount('comments')
    //         ->orderBy('comments_count', 'desc')
    //         ->take(5)
    //         ->get(['title', 'comments_count']);

    //     $post_title = $postsComments->pluck('title');
    //     $comments_count   = $postsComments->pluck('comments_count');

    //     return view('dashboard', compact('labels', 'data', 'post_title', 'comments_count'));
    // }

    public function dashboard(Request $request)
    {
        // base query
        $query = Post::query();

        // Apply filter based on request
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

        // Top 5 Most Viewed Posts (after filtering)
        $postsViews = $query->clone()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get(['title', 'views']);

        $labels = $postsViews->pluck('title');
        $data   = $postsViews->pluck('views');

        // Top 5 Most Commented Posts (after filtering)
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
