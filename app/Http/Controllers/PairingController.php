<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PairingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->partner_id) {
            return redirect('/dashboard');
        }
        return view('pairing.index', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pairing_code' => 'required|string|size:8'
        ]);

        $user = Auth::user();
        $partner = User::where('pairing_code', strtoupper($request->pairing_code))->first();

        if (!$partner) {
            return back()->with('error', 'Pairing code not found!');
        }

        if ($partner->id === $user->id) {
            return back()->with('error', 'You cannot pair with yourself!');
        }

        // Link both ways
        $user->partner_id = $partner->id;
        $user->save();

        $partner->partner_id = $user->id;
        $partner->save();

        return redirect('/dashboard')->with('success', 'Successfully paired with ' . $partner->name . '!');
    }

    public function skipPairing()
    {
        return redirect('/dashboard');
    }

    public function setSingleMode()
    {
        $user = Auth::user();
        $user->is_single_mode = true;
        $user->save();

        return redirect('/dashboard')->with('success', 'Single mode activated!');
    }
}
