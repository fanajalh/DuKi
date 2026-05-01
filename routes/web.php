<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PairingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PocketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () { return view('splash'); });
Route::get('/onboarding', function () { return view('onboarding'); });

use App\Http\Controllers\ForgotPasswordController;

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
Route::post('/logout', [AuthController::class, 'logout']);

// Forgot Password via OTP
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp']);
Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm']);
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

Route::middleware('auth')->group(function() {
    // Pairing
    Route::get('/pairing', [PairingController::class, 'index']);
    Route::post('/pairing', [PairingController::class, 'store']);
    Route::post('/pairing/skip', [PairingController::class, 'skipPairing']);
    Route::post('/pairing/single', [PairingController::class, 'setSingleMode']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Pockets
    Route::get('/pockets/create', [PocketController::class, 'create']);
    Route::post('/pockets', [PocketController::class, 'store']);
    Route::get('/pockets/{id}', [PocketController::class, 'show']);
    Route::get('/pockets/{id}/edit', [PocketController::class, 'edit']);
    Route::put('/pockets/{id}', [PocketController::class, 'update']);
    Route::delete('/pockets/{id}', [PocketController::class, 'destroy']);

    // Transactions
    Route::get('/deposit/{pocket_id?}', [TransactionController::class, 'showDeposit']);
    Route::post('/deposit', [TransactionController::class, 'storeDeposit']);
    
    // Withdrawals
    Route::get('/withdraw', [TransactionController::class, 'showWithdraw']);
    Route::post('/withdraw/request', [TransactionController::class, 'requestWithdraw']);
    Route::post('/withdraw/{id}/approve', [TransactionController::class, 'approveWithdraw']);
    Route::post('/withdraw/{id}/reject', [TransactionController::class, 'rejectWithdraw']);

    // Notifications & Profile
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/settings', [ProfileController::class, 'settings']);
    Route::post('/settings/profile', [ProfileController::class, 'updateProfile']);
    Route::post('/settings/password', [ProfileController::class, 'updatePassword']);
    Route::post('/settings/unpair', [ProfileController::class, 'unpair']);
    Route::post('/settings/toggle-mode', [ProfileController::class, 'toggleMode']);

    // Chatbot
    Route::post('/api/chat', [ChatbotController::class, 'chat']);
});
