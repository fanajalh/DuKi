@extends('layouts.auth')

@section('title', 'Buat Akun')

@section('content')
<div class="flex flex-col min-h-screen relative overflow-hidden" style="background: #fef9f0;">

    <!-- Top Header Wave (Pink this time!) -->
    <div class="relative w-full h-52 overflow-hidden flex-shrink-0">
        <div class="absolute inset-0 border-b-4 border-slate-800" style="background: linear-gradient(135deg, #f9a8d4 0%, #ec4899 100%);"></div>
        <!-- Dots pattern -->
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, rgba(255,255,255,0.2) 2px, transparent 2px); background-size: 18px 18px;"></div>
        <!-- Floating shapes -->
        <div class="absolute top-6 right-6 w-12 h-12 bg-lime-400 border-4 border-slate-800 rounded-2xl -rotate-12 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]"></div>
        <div class="absolute top-10 left-8 w-8 h-8 bg-yellow-300 border-4 border-slate-800 rounded-full animate-bounce"></div>
        <div class="absolute bottom-6 right-10 w-10 h-10 bg-white border-4 border-slate-800 rounded-xl rotate-6 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)]"></div>

        <!-- Big centered icon -->
        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
            <div class="w-20 h-20 bg-white border-4 border-slate-800 rounded-[1.5rem] shadow-[5px_5px_0px_0px_rgba(30,41,59,1)] flex items-center justify-center text-4xl -rotate-3 text-pink-500">
                <i class="ph-duotone ph-sparkle"></i>
            </div>
        </div>

        <!-- Back Button -->
        <a href="{{ url('/onboarding') }}" class="absolute top-6 left-6 w-12 h-12 bg-white border-4 border-slate-800 rounded-2xl flex items-center justify-center text-xl shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] hover:bg-pink-100 active:translate-y-0.5 transition-all text-slate-800">
            <i class="ph-duotone ph-arrow-left"></i>
        </a>
    </div>

    <!-- Form Area -->
    <div class="flex-1 px-6 pt-14 pb-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-800 mb-1 flex items-center justify-center gap-2">Gabung DuKi! <i class="ph-duotone ph-confetti text-pink-500"></i></h1>
            <p class="text-slate-500 font-bold">Buat akun gratismu hari ini</p>
        </div>

        <form action="{{ url('/register') }}" method="POST" class="space-y-5">
            @csrf
            
            <!-- Name -->
            <div>
                <label class="block text-xs font-black mb-2 text-slate-700 uppercase tracking-widest">Nama Kamu</label>
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-7 h-7 bg-yellow-300 border-2 border-slate-800 rounded-lg flex items-center justify-center text-lg text-slate-800"><i class="ph-duotone ph-smiley"></i></div>
                    <input 
                        type="text" 
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="contoh: Budi Santoso" 
                        class="w-full bg-white border-4 border-slate-800 rounded-2xl py-4 pl-14 pr-4 text-base font-bold text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-slate-800 transition-all shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]"
                        required
                    >
                </div>
                @error('name')
                <p class="text-pink-500 text-xs font-bold mt-1 flex items-center gap-1"><i class="ph-duotone ph-warning-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-xs font-black mb-2 text-slate-700 uppercase tracking-widest">Aku seorang...</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer group">
                        <input type="radio" name="gender" value="male" class="peer sr-only" required>
                        <div class="border-4 border-slate-300 rounded-2xl py-3 px-4 flex items-center gap-3 bg-white peer-checked:border-slate-800 peer-checked:bg-blue-100 peer-checked:shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] transition-all group-hover:border-slate-400">
                            <div class="w-8 h-8 bg-blue-300 border-2 border-slate-800 rounded-full flex items-center justify-center text-slate-800 text-lg">
                                <i class="ph-duotone ph-gender-male"></i>
                            </div>
                            <span class="font-black text-slate-700">Cowok</span>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input type="radio" name="gender" value="female" class="peer sr-only" required>
                        <div class="border-4 border-slate-300 rounded-2xl py-3 px-4 flex items-center gap-3 bg-white peer-checked:border-slate-800 peer-checked:bg-pink-100 peer-checked:shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] transition-all group-hover:border-slate-400">
                            <div class="w-8 h-8 bg-pink-400 border-2 border-slate-800 rounded-full flex items-center justify-center text-slate-800 text-lg">
                                <i class="ph-duotone ph-gender-female"></i>
                            </div>
                            <span class="font-black text-slate-700">Cewek</span>
                        </div>
                    </label>
                </div>
                @error('gender')
                <p class="text-pink-500 text-xs font-bold mt-1 flex items-center gap-1"><i class="ph-duotone ph-warning-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-black mb-2 text-slate-700 uppercase tracking-widest">Alamat Email</label>
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-7 h-7 bg-pink-300 border-2 border-slate-800 rounded-lg flex items-center justify-center text-lg text-slate-800"><i class="ph-duotone ph-envelope-simple"></i></div>
                    <input 
                        type="email" 
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="kamu@contoh.com" 
                        class="w-full bg-white border-4 border-slate-800 rounded-2xl py-4 pl-14 pr-4 text-base font-bold text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-pink-200 focus:border-slate-800 transition-all shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]"
                        required
                    >
                </div>
                @error('email')
                <p class="text-pink-500 text-xs font-bold mt-1 flex items-center gap-1"><i class="ph-duotone ph-warning-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-black mb-2 text-slate-700 uppercase tracking-widest">Buat Kata Sandi</label>
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-7 h-7 bg-lime-300 border-2 border-slate-800 rounded-lg flex items-center justify-center text-lg text-slate-800"><i class="ph-duotone ph-lock-key"></i></div>
                    <input 
                        type="password" 
                        name="password"
                        placeholder="min. 8 karakter" 
                        class="w-full bg-white border-4 border-slate-800 rounded-2xl py-4 pl-14 pr-4 text-base font-bold text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-lime-200 focus:border-slate-800 transition-all shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]"
                        required
                    >
                </div>
                @error('password')
                <p class="text-pink-500 text-xs font-bold mt-1 flex items-center gap-1"><i class="ph-duotone ph-warning-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Terms mini note -->
            <p class="text-center text-xs text-slate-400 font-bold flex items-center justify-center gap-1">Dengan mendaftar, kamu setuju dengan <span class="text-pink-500 underline cursor-pointer">Syarat</span> kami <i class="ph-duotone ph-handshake text-slate-500"></i></p>

            <!-- Submit -->
            <button type="submit" class="w-full py-5 text-xl font-black text-slate-800 border-4 border-slate-800 rounded-3xl shadow-[5px_5px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-0.5 hover:shadow-[5px_8px_0px_0px_rgba(30,41,59,1)] active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] transition-all mt-1 flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #f9a8d4, #ec4899);">
                Buat Akunku <i class="ph-duotone ph-rocket-launch"></i>
            </button>
        </form>

        <!-- Divider -->
        <div class="flex items-center gap-3 my-6">
            <div class="flex-1 h-0.5 bg-slate-200 rounded-full"></div>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">atau</span>
            <div class="flex-1 h-0.5 bg-slate-200 rounded-full"></div>
        </div>

        <div class="text-center">
            <p class="text-slate-600 font-bold text-sm">Sudah mulai nabung? 
                <a href="{{ url('/login') }}" class="text-lime-600 font-black hover:underline inline-flex items-center gap-1">Masuk Di Sini <i class="ph-duotone ph-key"></i></a>
            </p>
        </div>
    </div>
</div>
@endsection
