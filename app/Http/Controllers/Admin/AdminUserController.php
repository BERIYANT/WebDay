<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by premium status
        if ($request->filled('status')) {
            if ($request->status === 'premium') {
                $query->where('is_premium', true);
            } elseif ($request->status === 'regular') {
                $query->where('is_premium', false);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'points' => 'required|integer|min:0',
            'streak' => 'required|integer|min:0',
            'role' => 'required|in:user,admin',
            'password' => 'nullable|string|min:6'
        ]);

        $data = [
            'name' => strtolower($request->name),
            'email' => $request->email,
            'points' => $request->points,
            'streak' => $request->streak,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', "Data pengguna @{$user->name} berhasil diperbarui!");
    }

    /**
     * Toggle the premium status for a user.
     */
    public function togglePremium(User $user)
    {
        if ($user->is_premium) {
            $user->is_premium = false;
            $user->premium_until = null;
            $msg = "Akses premium untuk @{$user->name} dinonaktifkan.";
        } else {
            $user->is_premium = true;
            $user->premium_until = Carbon::now()->addMonth();
            $msg = "Akses premium untuk @{$user->name} diaktifkan selama 1 bulan.";
        }

        $user->save();

        return back()->with('success', $msg);
    }

    /**
     * Remove the specified user from database.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "Akun @{$name} berhasil dihapus permanen!");
    }
}
