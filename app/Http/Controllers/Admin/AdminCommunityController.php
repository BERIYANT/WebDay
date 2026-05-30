<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\CommunityComment;
use Illuminate\Http\Request;

class AdminCommunityController extends Controller
{
    /**
     * Display community posts and comments for moderation.
     */
    public function posts(Request $request)
    {
        $query = CommunityPost::with(['user', 'comments.user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Delete a community post.
     */
    public function destroyPost(CommunityPost $post)
    {
        $author = $post->user->name;
        $post->delete();

        return back()->with('success', "Postingan dari @{$author} berhasil dihapus oleh Moderator.");
    }

    /**
     * Delete a community comment.
     */
    public function destroyComment(CommunityComment $comment)
    {
        $author = $comment->user->name;
        $comment->delete();

        return back()->with('success', "Komentar dari @{$author} berhasil dihapus oleh Moderator.");
    }
}
