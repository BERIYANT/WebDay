<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    /**
     * Display the About Us & FAQ page.
     */
    public function index()
    {
        return view('about');
    }

    /**
     * Store a newly created suggestion/feedback in database.
     */
    public function storeSaran(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string|min:5|max:2000',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi.',
            'phone.required' => 'No. Telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'content.required' => 'Pesan wajib diisi.',
            'content.min' => 'Pesan Anda terlalu pendek, minimal 5 karakter.',
        ]);

        Feedback::create([
            'user_id' => Auth::id(), // Can be null if guest
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => $request->subject,
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Terima kasih telah menghubungi kami.');
    }
}
