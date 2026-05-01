<?php

namespace App\Http\Controllers;

use App\Models\Pocket;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function showDeposit($pocket_id = null)
    {
        $user = Auth::user();
        $pockets = $user->pockets()->get();
        return view('transactions.deposit-modal', compact('pockets', 'pocket_id'));
    }

    public function storeDeposit(Request $request)
    {
        $request->validate([
            'pocket_id' => 'required|exists:pockets,id',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string|max:255',
            'emoji' => 'nullable|string|max:100',
        ]);

        $emojiMap = [
            'ph-duotone ph-heart'    => '❤️',
            'ph-duotone ph-confetti' => '🎉',
            'ph-duotone ph-fire'     => '🔥',
            'ph-fill ph-star'        => '⭐',
        ];
        $emojiValue = $emojiMap[$request->emoji] ?? '💸';

        $transaction = Transaction::create([
            'pocket_id' => $request->pocket_id,
            'user_id'   => Auth::id(),
            'type'      => 'deposit',
            'amount'    => $request->amount,
            'message'   => $request->message,
            'emoji'     => $emojiValue,
            'status'    => 'completed',
        ]);

        // Notify partner about deposit
        $user = Auth::user();
        $pocket = Pocket::find($request->pocket_id);
        $formattedAmount = 'Rp ' . number_format($request->amount, 0, ',', '.');
        if ($user->partner_id) {
            Notification::notify(
                $user->partner_id,
                'deposit',
                'Nabung Baru Diterima! 💰',
                $user->name . " menambahkan {$formattedAmount} ke kantong {$pocket->name}" . ($request->message ? ": \"{$request->message}\"" : ''),
                '/pockets/' . $request->pocket_id,
                'ph-duotone ph-money',
                'bg-lime-100'
            );
        }

        return redirect('/pockets/' . $request->pocket_id)->with('success', 'Setoran berhasil ditambahkan!');
    }

    public function showWithdraw($pocket_id = null)
    {
        // For simplicity, we just show the first pending withdrawal for approval
        $user = Auth::user();
        if (!$user->partner_id) {
            return redirect('/dashboard');
        }

        $pendingRequest = Transaction::where('type', 'withdrawal')
            ->where('status', 'pending')
            ->where('user_id', $user->partner_id)
            ->with(['pocket', 'user'])
            ->first();

        if (!$pendingRequest) {
            return redirect('/dashboard')->with('info', 'No pending withdrawal requests.');
        }

        return view('withdrawals.approval', compact('pendingRequest'));
    }
    public function showWithdrawRequest($pocket_id = null)
    {
        $user = Auth::user();
        $pockets = $user->pockets()->get();
        return view('transactions.withdraw-request-modal', compact('pockets', 'pocket_id'));
    }

    public function requestWithdraw(Request $request)
    {
        // Simulate requesting a withdrawal
        $request->validate([
            'pocket_id' => 'required|exists:pockets,id',
            'amount' => 'required|numeric|min:1',
            'message' => 'required|string|max:255',
        ]);

        $transaction = Transaction::create([
            'pocket_id' => $request->pocket_id,
            'user_id' => Auth::id(),
            'type' => 'withdrawal',
            'amount' => $request->amount,
            'message' => $request->message,
            'emoji' => '🚨',
            'status' => 'pending',
        ]);

        // Notify partner about withdrawal request
        $user = Auth::user();
        $pocket = Pocket::find($request->pocket_id);
        $formattedAmount = 'Rp ' . number_format($request->amount, 0, ',', '.');
        if ($user->partner_id) {
            Notification::notify(
                $user->partner_id,
                'withdrawal_request',
                'Permintaan Penarikan! ⚠️',
                $user->name . " ingin menarik {$formattedAmount} dari kantong {$pocket->name}: \"{$request->message}\"",
                '/withdraw',
                'ph-duotone ph-warning',
                'bg-pink-100'
            );
        }

        return redirect('/dashboard')->with('success', 'Permintaan penarikan dikirim ke pasangan!');
    }

    public function approveWithdraw($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'completed']);

        // Notify the requester
        $pocket = Pocket::find($transaction->pocket_id);
        $formattedAmount = 'Rp ' . number_format($transaction->amount, 0, ',', '.');
        Notification::notify(
            $transaction->user_id,
            'withdrawal_approved',
            'Penarikan Disetujui! ✅',
            "Permintaan tarik {$formattedAmount} dari kantong {$pocket->name} telah disetujui!",
            '/pockets/' . $transaction->pocket_id,
            'ph-duotone ph-check-circle',
            'bg-lime-100'
        );

        return redirect('/dashboard')->with('success', 'Penarikan disetujui!');
    }

    public function rejectWithdraw($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'rejected']);

        // Notify the requester
        $pocket = Pocket::find($transaction->pocket_id);
        $formattedAmount = 'Rp ' . number_format($transaction->amount, 0, ',', '.');
        Notification::notify(
            $transaction->user_id,
            'withdrawal_rejected',
            'Penarikan Ditolak ❌',
            "Permintaan tarik {$formattedAmount} dari kantong {$pocket->name} ditolak.",
            '/pockets/' . $transaction->pocket_id,
            'ph-duotone ph-x-circle',
            'bg-pink-100'
        );

        return redirect('/dashboard')->with('info', 'Penarikan ditahan!');
    }
}
