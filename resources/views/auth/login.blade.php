@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
<div class="flex flex-col min-h-screen relative overflow-hidden" style="background: #fef9f0;">

    <!-- Top Wave -->
    <div class="relative w-full h-52 overflow-hidden flex-shrink-0">
        <div class="absolute inset-0 border-b-4 border-slate-800" style="background: linear-gradient(135deg, #a3e635 0%, #84cc16 100%);"></div>
        <!-- Dots pattern -->
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, rgba(255,255,255,0.2) 2px, transparent 2px); background-size: 18px 18px;"></div>
        <!-- Floating shapes -->
        <div class="absolute top-4 right-8 w-12 h-12 bg-pink-400 border-4 border-slate-800 rounded-2xl rotate-12 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]"></div>
        <div class="absolute top-8 left-6 w-10 h-10 bg-white border-4 border-slate-800 rounded-full shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]"></div>
        <div class="absolute bottom-4 right-4 w-8 h-8 bg-yellow-300 border-4 border-slate-800 rounded-full animate-bounce" style="animation-delay:0.3s"></div>

        <!-- Big centered icon -->
        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
            <div class="w-20 h-20 bg-white border-4 border-slate-800 rounded-[1.5rem] shadow-[5px_5px_0px_0px_rgba(30,41,59,1)] flex items-center justify-center text-4xl rotate-3 text-lime-500">
                <i class="ph-duotone ph-hand-waving"></i>
            </div>
        </div>

        <!-- Back Button -->
        <a href="{{ url('/onboarding') }}" class="absolute top-6 left-6 w-12 h-12 bg-white border-4 border-slate-800 rounded-2xl flex items-center justify-center text-xl shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] hover:bg-lime-100 active:translate-y-0.5 transition-all text-slate-800">
            <i class="ph-duotone ph-arrow-left"></i>
        </a>
    </div>

    <!-- Form Area -->
    <div class="flex-1 px-6 pt-14 pb-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-800 mb-1">Selamat Datang Kembali!</h1>
            <p class="text-slate-500 font-bold flex items-center justify-center gap-1">Masuk untuk lanjut nabung <i class="ph-duotone ph-heart text-pink-500"></i></p>
        </div>

        @if(session('error'))
        <div class="mb-4 bg-pink-100 border-4 border-pink-400 rounded-2xl p-3 flex items-center gap-2">
            <span class="text-xl text-pink-600"><i class="ph-duotone ph-warning-octagon"></i></span>
            <p class="text-pink-700 font-bold text-sm">{{ session('error') }}</p>
        </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf
            
            <!-- Email -->
            <div>
                <label class="block text-xs font-black mb-2 text-slate-700 uppercase tracking-widest">Alamat Email</label>
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-7 h-7 bg-lime-300 border-2 border-slate-800 rounded-lg flex items-center justify-center text-lg text-slate-800"><i class="ph-duotone ph-envelope-simple"></i></div>
                    <input 
                        type="email" 
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="kamu@contoh.com" 
                        class="w-full bg-white border-4 border-slate-800 rounded-2xl py-4 pl-14 pr-4 text-base font-bold text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-lime-300 focus:border-slate-800 transition-all shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]"
                        required
                    >
                </div>
                @error('email')
                <p class="text-pink-500 text-xs font-bold mt-1 flex items-center gap-1"><i class="ph-duotone ph-warning-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-black mb-2 text-slate-700 uppercase tracking-widest">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-7 h-7 bg-pink-300 border-2 border-slate-800 rounded-lg flex items-center justify-center text-lg text-slate-800"><i class="ph-duotone ph-lock-key"></i></div>
                    <input 
                        type="password" 
                        name="password"
                        placeholder="min. 8 karakter" 
                        class="w-full bg-white border-4 border-slate-800 rounded-2xl py-4 pl-14 pr-4 text-base font-bold text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-pink-300 focus:border-slate-800 transition-all shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]"
                        required
                    >
                </div>
                <div class="text-right mt-2">
                    <a href="{{ url('/forgot-password') }}" class="text-xs font-black text-pink-500 hover:underline">Lupa Kata Sandi?</a>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-5 text-xl font-black text-slate-800 border-4 border-slate-800 rounded-3xl shadow-[5px_5px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-0.5 hover:shadow-[5px_8px_0px_0px_rgba(30,41,59,1)] active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] transition-all mt-2 flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #a3e635, #84cc16);">
                Masuk <i class="ph-duotone ph-sign-in"></i>
            </button>
        </form>

        <!-- Divider -->
        <div class="flex items-center gap-3 my-6">
            <div class="flex-1 h-0.5 bg-slate-200 rounded-full"></div>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">atau</span>
            <div class="flex-1 h-0.5 bg-slate-200 rounded-full"></div>
        </div>

        <div class="text-center">
            <p class="text-slate-600 font-bold text-sm">Belum punya akun? 
                <a href="{{ url('/register') }}" class="text-pink-500 font-black hover:underline inline-flex items-center gap-1">Daftar Gratis <i class="ph-duotone ph-confetti"></i></a>
            </p>
        </div>
    </div>
</div>
@endsection
