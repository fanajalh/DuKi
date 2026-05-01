<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function settings()
    {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->name = $request->name;
        $user->save();

        return redirect('/settings')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return redirect('/settings')->with('success', 'Password updated successfully!');
    }

    public function unpair()
    {
        $user = Auth::user();
        
        if ($user->partner_id) {
            $partner = \App\Models\User::find($user->partner_id);
            if ($partner) {
                $partner->partner_id = null;
                $partner->save();
            }
            $user->partner_id = null;
            $user->save();
        }

        return redirect('/settings')->with('success', 'Berhasil memutus akun dari pasangan.');
    }

    public function toggleMode()
    {
        $user = Auth::user();

        if ($user->is_single_mode) {
            // Switch to couple mode
            $user->is_single_mode = false;
            $user->save();
            return redirect('/settings')->with('success', 'Mode Pasangan diaktifkan! Cari kode pairing pasanganmu di halaman Profil.');
        } else {
            // Switch to single mode — auto-unpair if paired
            if ($user->partner_id) {
                $partner = \App\Models\User::find($user->partner_id);
                if ($partner) {
                    $partner->partner_id = null;
                    $partner->save();
                }
                $user->partner_id = null;
            }
            $user->is_single_mode = true;
            $user->save();
            return redirect('/settings')->with('success', 'Mode Tunggal diaktifkan! Pairing telah diputus otomatis.');
        }
    }
}
