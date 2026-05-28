<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CommunityPost;
use App\Models\CommunityComment;
use App\Models\PostLike;
use App\Models\User;
use Carbon\Carbon;

class CommunityController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Premium Wall restriction
        if (!$user->isPremium()) {
            return view('community.locked');
        }

        // 2. Fetch all posts with associations
        $posts = CommunityPost::with(['user', 'comments.user', 'likes'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Daily Inspiration: consistent per day (same quote for the whole day, changes daily)
        $inspirations = [
            "Hari ini adalah kesempatan baru untuk tumbuh lebih kuat, lebih pintar, dan lebih bahagia.",
            "Kebiasaan kecil yang diulang setiap hari akan menghasilkan perubahan masif dalam jangka panjang.",
            "Jangan batasi tantanganmu, tapi tantanglah batasanmu.",
            "Disiplin adalah melakukan apa yang harus dilakukan bahkan ketika kamu tidak menyukainya.",
            "Kamu tidak harus sempurna. Kamu hanya perlu terus bergerak maju, satu langkah per hari.",
            "Kepercayaan diri dibangun dari konsistensi kecil yang terus-menerus, bukan dari satu momen besar.",
            "Setiap hari kamu memilih: tumbuh atau stagnan. Pilih tumbuh, selalu.",
        ];
        // Use day-of-year so quote is stable all day but changes daily
        $dayIndex = (int) Carbon::today()->dayOfYear % count($inspirations);
        $dailyInspiration = $inspirations[$dayIndex];

        return view('community.index', compact('posts', 'dailyInspiration'));
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:5|max:1000'
        ]);

        $user = Auth::user();
        if (!$user->isPremium()) {
            return back()->with('error', 'Akses Premium diperlukan untuk memposting.');
        }

        CommunityPost::create([
            'user_id' => $user->id,
            'content' => $request->content,
            'likes_count' => 0
        ]);

        // Award +10 points for sharing positivity in community
        $user->points += 10;
        $user->save();

        return redirect()->route('community.index')->with('success', 'Postingan berhasil dibagikan! Anda mendapatkan +10 poin.');
    }

    public function toggleLike(CommunityPost $post)
    {
        $user = Auth::user();
        if (!$user->isPremium()) {
            return response()->json(['error' => 'Akses Premium diperlukan.'], 403);
        }

        $existingLike = PostLike::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $post->decrement('likes_count');
            $liked = false;
        } else {
            PostLike::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
            $post->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $post->likes_count
        ]);
    }

    public function storeComment(Request $request, CommunityPost $post)
    {
        $request->validate([
            'content' => 'required|string|min:1|max:500'
        ]);

        $user = Auth::user();
        if (!$user->isPremium()) {
            return back()->with('error', 'Akses Premium diperlukan.');
        }

        CommunityComment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $request->content
        ]);

        return redirect()->route('community.index')->with('success', 'Komentar berhasil ditambahkan!');
    }
}
