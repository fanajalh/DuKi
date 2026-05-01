<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = (string) random_int(100000, 999999);

        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(15),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        // Send OTP via email
        try {
            Mail::to($request->email)->send(new \App\Mail\OtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send OTP email: " . $e->getMessage());
            return back()->withErrors(['email' => 'Gagal mengirim email OTP. Silakan coba lagi nanti.']);
        }

        // Store email in session to carry over to verify step
        session(['reset_email' => $request->email]);

        return redirect('/verify-otp')->with('success', 'Kode OTP sudah dikirim ke email kamu! Cek inbox atau folder spam ya.');
    }

    public function showVerifyOtpForm()
    {
        if (!session()->has('reset_email')) {
            return redirect('/forgot-password');
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $email = session('reset_email');

        $record = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || Carbon::parse($record->expires_at)->isPast()) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // OTP verified successfully, move to reset password form
        session(['otp_verified' => true]);
        return redirect('/reset-password');
    }

    public function showResetPasswordForm()
    {
        if (!session('otp_verified') || !session('reset_email')) {
            return redirect('/forgot-password');
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = session('reset_email');

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Clean up DB and session
        DB::table('password_reset_otps')->where('email', $email)->delete();
        session()->forget(['reset_email', 'otp_verified']);

        return redirect('/login')->with('success', 'Password has been reset successfully. Please login.');
    }
}
