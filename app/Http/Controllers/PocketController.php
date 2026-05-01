<?php

namespace App\Http\Controllers;

use App\Models\Pocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PocketController extends Controller
{
    public function create()
    {
        return view('pockets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date',
            'icon' => 'nullable|string|max:100',
        ]);

        $pocket = Pocket::create([
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'deadline' => $request->deadline,
            'icon' => $request->icon ?? '🐷',
            'creator_id' => Auth::id(),
        ]);

        return redirect('/dashboard')->with('success', 'Pocket created successfully!');
    }

    public function show($id)
    {
        $pocket = Pocket::findOrFail($id);
        $user = Auth::user();

        // Check permission
        if ($pocket->creator_id !== $user->id && $pocket->creator_id !== $user->partner_id) {
            abort(403);
        }

        $transactions = $pocket->transactions()->with('user')->orderBy('created_at', 'desc')->get();
        $totalSaved = $pocket->totalSaved();

        // Contribution Tracker
        $myContribution = $pocket->transactions()->where('user_id', $user->id)->where('type', 'deposit')->where('status', 'completed')->sum('amount');
        
        $partnerContribution = 0;
        if ($user->partner_id) {
            $partnerContribution = $pocket->transactions()->where('user_id', $user->partner_id)->where('type', 'deposit')->where('status', 'completed')->sum('amount');
        }

        $myPercentage = $totalSaved > 0 ? round(($myContribution / $totalSaved) * 100) : 0;
        $partnerPercentage = $totalSaved > 0 ? round(($partnerContribution / $totalSaved) * 100) : 0;

        return view('pockets.show', compact('pocket', 'transactions', 'totalSaved', 'myContribution', 'partnerContribution', 'myPercentage', 'partnerPercentage', 'user'));
    }

    public function edit($id)
    {
        $pocket = Pocket::findOrFail($id);
        
        // Only creator can edit
        if ($pocket->creator_id !== Auth::id()) {
            abort(403);
        }

        return view('pockets.edit', compact('pocket'));
    }

    public function update(Request $request, $id)
    {
        $pocket = Pocket::findOrFail($id);
        
        if ($pocket->creator_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date',
            'icon' => 'nullable|string|max:100',
        ]);

        $pocket->update([
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'deadline' => $request->deadline,
            'icon' => $request->icon ?? '🐷',
        ]);

        return redirect('/pockets/'.$pocket->id)->with('success', 'Kantong berhasil diubah!');
    }

    public function destroy($id)
    {
        $pocket = Pocket::findOrFail($id);
        
        if ($pocket->creator_id !== Auth::id()) {
            abort(403);
        }

        $pocket->delete();

        return redirect('/dashboard')->with('success', 'Kantong berhasil dihapus!');
    }
}
