<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            $this->updateStreak(Auth::user());
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => strtolower($request->name), // enforce user requested lowercase names
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'points' => 0,
            'streak' => 1,
            'last_login_date' => Carbon::today(),
            'is_premium' => false,
            'selected_badge' => 'Beginner',
            'selected_theme' => 'light'
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function redirectToGoogle()
    {
        if (config('services.google.client_id') && config('services.google.client_secret')) {
            $redirectUrl = config('services.google.redirect') ?: (request()->schemeAndHttpHost() . '/auth/google/callback');
            return \Laravel\Socialite\Facades\Socialite::driver('google')
                ->redirectUrl($redirectUrl)
                ->redirect();
        }

        // Fallback to simulated Google chooser if credentials are not configured
        $names = ['salma', 'rafiqoh', 'nurul', 'anargya', 'almira', 'putri', 'putra', 'aji', 'ilham', 'aninda', 'nathania'];
        $seededUsers = User::whereIn('name', $names)->get();

        return view('auth.google_chooser', compact('seededUsers'));
    }

    public function handleGoogleCallback()
    {
        try {
            $redirectUrl = config('services.google.redirect') ?: (request()->schemeAndHttpHost() . '/auth/google/callback');
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')
                ->redirectUrl($redirectUrl)
                ->user();
            
            // Find or create user
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => strtolower($googleUser->getName()),
                    'password' => Hash::make(\Illuminate\Support\Str::random(24)),
                    'points' => 15,
                    'streak' => 1,
                    'last_login_date' => Carbon::today(),
                    'is_premium' => false,
                    'selected_badge' => 'Beginner',
                    'selected_theme' => 'light'
                ]
            );

            Auth::login($user);
            $this->updateStreak($user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal masuk dengan Google: ' . $e->getMessage()
            ]);
        }
    }

    public function selectGoogleAccount(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'custom_name' => 'nullable|string|max:255',
            'custom_email' => 'nullable|email|max:255'
        ]);

        if ($request->filled('user_id')) {
            $user = User::find($request->user_id);
        } else {
            // Register a new custom user via Google Login
            $name = strtolower($request->custom_name ?: 'Almira');
            $email = $request->custom_email ?: ($name . rand(10,99) . '@gmail.com');

            // Block registration if email is already taken
            if (User::where('email', $email)->exists()) {
                return back()->withErrors([
                    'custom_email' => 'Email ini sudah terdaftar! Gunakan email lain atau pilih dari daftar.'
                ])->withInput();
            }

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('google-auth-secret-123'),
                'points' => 15,
                'streak' => 1,
                'last_login_date' => Carbon::today(),
                'is_premium' => false,
                'selected_badge' => 'Beginner',
                'selected_theme' => 'light'
            ]);
        }

        Auth::login($user);
        $this->updateStreak($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }

    private function updateStreak(User $user)
    {
        $today = Carbon::today();
        $lastLogin = $user->last_login_date;

        if ($lastLogin) {
            $diffInDays = $today->diffInDays($lastLogin);

            if ($diffInDays == 1) {
                // Logged in on consecutive day, increment streak
                $user->streak += 1;
            } elseif ($diffInDays > 1) {
                // Missed a day, reset streak to 1
                $user->streak = 1;
            }
            // If diffInDays is 0 (same day), do nothing - keep the streak as is
        } else {
            // No previous login, start with 1
            $user->streak = 1;
        }

        $user->last_login_date = $today;
        $user->save();
    }
}
