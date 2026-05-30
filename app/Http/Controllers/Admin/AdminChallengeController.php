<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class AdminChallengeController extends Controller
{
    /**
     * Display a listing of the challenges.
     */
    public function index(Request $request)
    {
        $query = Challenge::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('premium')) {
            $query->where('is_premium', $request->premium === 'yes');
        }

        $challenges = $query->orderBy('category')->orderBy('difficulty')->paginate(10)->withQueryString();

        // Get unique categories for filtering
        $categories = Challenge::select('category')->distinct()->pluck('category');

        return view('admin.challenges.index', compact('challenges', 'categories'));
    }

    /**
     * Show the form for creating a new challenge.
     */
    public function create()
    {
        return view('admin.challenges.create');
    }

    /**
     * Store a newly created challenge in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'points_reward' => 'required|integer|min:1',
            'time_estimate' => 'required|integer|min:1',
            'is_premium' => 'required|boolean',
            'youtube_link' => 'nullable|url'
        ]);

        $challenge = Challenge::create([
            'category' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'difficulty' => $request->difficulty,
            'points_reward' => $request->points_reward,
            'time_estimate' => $request->time_estimate,
            'is_premium' => $request->is_premium,
            'youtube_link' => $request->youtube_link
        ]);

        return redirect()->route('admin.challenges.index')->with('success', "Daily Challenge '{$challenge->name}' berhasil ditambahkan!");
    }

    /**
     * Show the form for editing the specified challenge.
     */
    public function edit(Challenge $challenge)
    {
        return view('admin.challenges.edit', compact('challenge'));
    }

    /**
     * Update the specified challenge in database.
     */
    public function update(Request $request, Challenge $challenge)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'points_reward' => 'required|integer|min:1',
            'time_estimate' => 'required|integer|min:1',
            'is_premium' => 'required|boolean',
            'youtube_link' => 'nullable|url'
        ]);

        $challenge->update([
            'category' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'difficulty' => $request->difficulty,
            'points_reward' => $request->points_reward,
            'time_estimate' => $request->time_estimate,
            'is_premium' => $request->is_premium,
            'youtube_link' => $request->youtube_link
        ]);

        return redirect()->route('admin.challenges.index')->with('success', "Daily Challenge '{$challenge->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified challenge from database.
     */
    public function destroy(Challenge $challenge)
    {
        $name = $challenge->name;
        $challenge->delete();

        return redirect()->route('admin.challenges.index')->with('success', "Daily Challenge '{$name}' berhasil dihapus permanen!");
    }
}
