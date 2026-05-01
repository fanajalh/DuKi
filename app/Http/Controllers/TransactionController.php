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

        // Notify about deposit
        $user = Auth::user();
        $pocket = Pocket::find($request->pocket_id);
        $formattedAmount = 'Rp ' . number_format($request->amount, 0, ',', '.');

        // Notif ke diri sendiri
        Notification::notify(
            $user->id,
            'deposit',
            'Nabung Berhasil! 💰',
            "Kamu menambahkan {$formattedAmount} ke kantong {$pocket->name}" . ($request->message ? ": \"{$request->message}\"" : ''),
            '/pockets/' . $request->pocket_id,
            'ph-duotone ph-piggy-bank',
            'bg-lime-100'
        );

        // Notif ke pasangan
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
        $user = Auth::user();
        if (!$user->partner_id) {
            return redirect('/dashboard')->with('info', 'Kamu belum punya pasangan.');
        }

        // Ambil semua pending withdrawal dari pasangan
        $pendingRequests = Transaction::where('type', 'withdrawal')
            ->where('status', 'pending')
            ->where('user_id', $user->partner_id)
            ->with(['pocket', 'user'])
            ->latest()
            ->get();

        if ($pendingRequests->isEmpty()) {
            return redirect('/dashboard')->with('info', 'Tidak ada permintaan penarikan yang menunggu persetujuan.');
        }

        return view('withdrawals.approval', compact('pendingRequests'));
    }
    public function showWithdrawRequest($pocket_id = null)
    {
        $user = Auth::user();
        $pockets = $user->pockets()->get();
        return view('transactions.withdraw-request-modal', compact('pockets', 'pocket_id'));
    }

    public function requestWithdraw(Request $request)
    {
        $request->validate([
            'pocket_id' => 'required|exists:pockets,id',
            'amount'    => 'required|numeric|min:1',
            'message'   => 'required|string|max:255',
        ]);

        $user   = Auth::user();
        $pocket = Pocket::find($request->pocket_id);

        // Pastikan pocket milik user atau pasangannya
        if ($pocket->creator_id !== $user->id && $pocket->creator_id !== $user->partner_id) {
            return back()->withErrors(['pocket_id' => 'Kantong tidak ditemukan.']);
        }

        // Cek saldo mencukupi
        $currentBalance = $pocket->totalSaved();
        if ($request->amount > $currentBalance) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi. Saldo tersedia: Rp ' . number_format($currentBalance, 0, ',', '.')])
                         ->withInput();
        }

        $formattedAmount = 'Rp ' . number_format($request->amount, 0, ',', '.');

        // Kalau tidak punya pasangan / single mode, langsung selesai (auto-approve)
        if (!$user->partner_id || $user->is_single_mode) {
            Transaction::create([
                'pocket_id' => $request->pocket_id,
                'user_id'   => Auth::id(),
                'type'      => 'withdrawal',
                'amount'    => $request->amount,
                'message'   => $request->message,
                'emoji'     => '💸',
                'status'    => 'completed',
            ]);
            Notification::notify(
                $user->id,
                'withdrawal',
                'Penarikan Berhasil! 💸',
                "Kamu menarik {$formattedAmount} dari kantong {$pocket->name}: \"{$request->message}\"",
                '/pockets/' . $request->pocket_id,
                'ph-duotone ph-hand-coins',
                'bg-yellow-100'
            );
            return redirect('/pockets/' . $request->pocket_id)->with('success', 'Penarikan berhasil! Saldo kantong sudah dikurangi.');
        }

        // Kalau punya pasangan, buat pending dan minta persetujuan
        Transaction::create([
            'pocket_id' => $request->pocket_id,
            'user_id'   => Auth::id(),
            'type'      => 'withdrawal',
            'amount'    => $request->amount,
            'message'   => $request->message,
            'emoji'     => '🚨',
            'status'    => 'pending',
        ]);

        // Notif ke diri sendiri
        Notification::notify(
            $user->id,
            'withdrawal_request',
            'Permintaan Dikirim! 🚨',
            "Kamu mengajukan penarikan {$formattedAmount} dari kantong {$pocket->name}. Menunggu persetujuan pasangan.",
            '/notifications',
            'ph-duotone ph-paper-plane-tilt',
            'bg-yellow-100'
        );

        // Notif ke pasangan
        Notification::notify(
            $user->partner_id,
            'withdrawal_request',
            'Permintaan Penarikan! ⚠️',
            $user->name . " ingin menarik {$formattedAmount} dari kantong {$pocket->name}: \"{$request->message}\"",
            '/withdraw',
            'ph-duotone ph-warning',
            'bg-pink-100'
        );

        return redirect('/dashboard')->with('success', 'Permintaan penarikan dikirim ke pasangan!');
    }

    public function approveWithdraw($id)
    {
        $approver     = Auth::user();
        $transaction  = Transaction::with('pocket')->findOrFail($id);

        // Hanya pasangan dari pengaju yang boleh approve
        if ($transaction->user_id !== $approver->partner_id) {
            abort(403, 'Kamu tidak punya wewenang untuk menyetujui permintaan ini.');
        }

        // Pastikan masih pending
        if ($transaction->status !== 'pending') {
            return redirect('/dashboard')->with('info', 'Permintaan ini sudah diproses sebelumnya.');
        }

        // Cek saldo kantong masih cukup (bisa berubah sejak request dibuat)
        $pocket          = $transaction->pocket;
        $currentBalance  = $pocket->totalSaved();
        if ($transaction->amount > $currentBalance) {
            $transaction->update(['status' => 'rejected']);
            $formattedBalance = 'Rp ' . number_format($currentBalance, 0, ',', '.');
            Notification::notify(
                $transaction->user_id,
                'withdrawal_rejected',
                'Penarikan Gagal ❌',
                "Permintaan tarikmu otomatis ditolak karena saldo kantong {$pocket->name} tidak mencukupi (sisa {$formattedBalance}).",
                '/pockets/' . $transaction->pocket_id,
                'ph-duotone ph-x-circle',
                'bg-pink-100'
            );
            return redirect('/withdraw')->with('error', 'Saldo tidak mencukupi, permintaan otomatis ditolak.');
        }

        $transaction->update(['status' => 'completed']);

        $formattedAmount = 'Rp ' . number_format($transaction->amount, 0, ',', '.');

        // Notif ke pengaju
        Notification::notify(
            $transaction->user_id,
            'withdrawal_approved',
            'Penarikan Disetujui! ✅',
            "Permintaan tarik {$formattedAmount} dari kantong {$pocket->name} telah disetujui oleh pasanganmu!",
            '/pockets/' . $transaction->pocket_id,
            'ph-duotone ph-check-circle',
            'bg-lime-100'
        );

        // Notif ke approver sendiri
        Notification::notify(
            $approver->id,
            'withdrawal_approved',
            'Kamu Menyetujui Penarikan ✅',
            "{$transaction->user->name} menarik {$formattedAmount} dari kantong {$pocket->name}.",
            '/pockets/' . $transaction->pocket_id,
            'ph-duotone ph-check-circle',
            'bg-lime-100'
        );

        // Cek apakah masih ada pending lainnya
        $remainingCount = Transaction::where('type', 'withdrawal')
            ->where('status', 'pending')
            ->where('user_id', $approver->partner_id)
            ->count();

        if ($remainingCount > 0) {
            return redirect('/withdraw')->with('success', 'Penarikan disetujui! Masih ada ' . $remainingCount . ' permintaan lagi.');
        }

        return redirect('/dashboard')->with('success', 'Penarikan disetujui!');
    }

    public function rejectWithdraw($id)
    {
        $rejecter    = Auth::user();
        $transaction = Transaction::with('pocket')->findOrFail($id);

        // Hanya pasangan dari pengaju yang boleh reject
        if ($transaction->user_id !== $rejecter->partner_id) {
            abort(403, 'Kamu tidak punya wewenang untuk menolak permintaan ini.');
        }

        // Pastikan masih pending
        if ($transaction->status !== 'pending') {
            return redirect('/dashboard')->with('info', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $transaction->update(['status' => 'rejected']);

        $pocket          = $transaction->pocket;
        $formattedAmount = 'Rp ' . number_format($transaction->amount, 0, ',', '.');

        // Notif ke pengaju
        Notification::notify(
            $transaction->user_id,
            'withdrawal_rejected',
            'Penarikan Ditolak ❌',
            "Permintaan tarik {$formattedAmount} dari kantong {$pocket->name} ditolak oleh pasanganmu.",
            '/pockets/' . $transaction->pocket_id,
            'ph-duotone ph-x-circle',
            'bg-pink-100'
        );

        // Notif ke rejecter sendiri
        Notification::notify(
            $rejecter->id,
            'withdrawal_rejected',
            'Kamu Menolak Penarikan ❌',
            "Kamu menolak permintaan tarik {$formattedAmount} dari kantong {$pocket->name} oleh {$transaction->user->name}.",
            '/pockets/' . $transaction->pocket_id,
            'ph-duotone ph-x-circle',
            'bg-pink-100'
        );

        // Cek apakah masih ada pending lainnya
        $remainingCount = Transaction::where('type', 'withdrawal')
            ->where('status', 'pending')
            ->where('user_id', $rejecter->partner_id)
            ->count();

        if ($remainingCount > 0) {
            return redirect('/withdraw')->with('info', 'Permintaan ditolak. Masih ada ' . $remainingCount . ' permintaan lagi.');
        }

        return redirect('/dashboard')->with('info', 'Permintaan penarikan ditolak.');
    }
}
