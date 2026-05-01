<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pocket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Pockets from user and partner
        $pockets = Pocket::where('creator_id', $user->id);
        if ($user->partner_id) {
            $pockets = $pockets->orWhere('creator_id', $user->partner_id);
        }
        $pockets = $pockets->get();

        $totalSavings = 0;
        foreach ($pockets as $pocket) {
            $totalSavings += $pocket->totalSaved();
        }

        return view('dashboard.index', compact('user', 'pockets', 'totalSavings'));
    }
}
