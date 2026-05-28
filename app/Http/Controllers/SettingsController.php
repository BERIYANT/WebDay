<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'selected_badge' => 'required|string',
            'selected_theme' => 'required|in:light,dark'
        ]);

        // Validate Dark Theme Lock
        if ($request->selected_theme == 'dark' && !$user->theme_dark_unlocked && !$user->isPremium()) {
            return back()->with('error', 'Tema Dark Mode terkunci! Klaim reward Tema Custom terlebih dahulu di halaman Premium.');
        }

        // Validate Special Badge Lock
        if ($request->selected_badge == 'Warrior Premium' || $request->selected_badge == 'Special Challenger') {
            if (!$user->badge_unlocked && !$user->isPremium()) {
                return back()->with('error', 'Lencana Spesial terkunci! Klaim reward Lencana Spesial terlebih dahulu di halaman Premium.');
            }
        }

        // Update profile photo if uploaded
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = 'profile_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            
            // Move to public storage
            $image->move(public_path('uploads/profiles'), $imageName);
            
            // Delete old file if exists
            if ($user->profile_image && file_exists(public_path('uploads/profiles/' . $user->profile_image))) {
                @unlink(public_path('uploads/profiles/' . $user->profile_image));
            }

            $user->profile_image = $imageName;
        }

        $user->name = strtolower($request->name); // lowercase as requested
        $user->selected_badge = $request->selected_badge;
        $user->selected_theme = $request->selected_theme;
        $user->save();

        return redirect()->route('settings.index')->with('success', 'Profil dan Preferensi berhasil diperbarui!');
    }
}
