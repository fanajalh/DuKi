@extends('layouts.auth')

@section('title', 'Persetujuan Penarikan')

@section('content')
<!-- Full-height flex container for centered alert -->
<div class="flex flex-col items-center justify-center min-h-screen px-6 bg-slate-900/40 backdrop-blur-sm relative">
    
    <!-- Close -->
    <a href="{{ url('/pockets/1') }}" class="absolute top-6 left-6 w-12 h-12 bg-white border-4 border-slate-800 rounded-full flex items-center justify-center text-xl shadow-cartoon hover:bg-slate-100 text-slate-800">
        <i class="ph-bold ph-arrow-left"></i>
    </a>

    <!-- Warning Alert Card -->
    <div class="w-full bg-pink-300 border-4 border-slate-800 rounded-3xl p-8 shadow-cartoon text-center relative overflow-hidden animate-[popIn_0.3s_ease-out]">
        
        <!-- Background Decor -->
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-300 rounded-full border-4 border-slate-800 opacity-60"></div>
        <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-pink-400 rounded-full border-4 border-slate-800 opacity-60"></div>

        <!-- Pulse Icon -->
        <div class="relative z-10 w-20 h-20 bg-yellow-300 border-4 border-slate-800 rounded-full flex items-center justify-center text-4xl shadow-cartoon mx-auto mb-6 animate-pulse text-red-500">
            <i class="ph-duotone ph-warning"></i>
        </div>

        <!-- Content -->
        <h2 class="relative z-10 text-3xl font-black text-slate-800 mb-6">Tunggu! Sebentar!</h2>
        
        <div class="relative z-10 bg-white border-4 border-slate-800 rounded-2xl p-5 mb-8 shadow-cartoon-sm text-left">
            <p class="text-slate-800 font-bold text-lg leading-snug">
                Pasanganmu ingin menarik dana <span class="text-pink-500 font-black text-xl block mt-1">Rp 500.000</span> 
                <span class="block mt-2">dari <span class="bg-lime-200 px-2 py-0.5 rounded-md border-2 border-slate-800 inline-flex items-center gap-1 mt-1"><i class="ph-duotone ph-airplane-tilt"></i> Holiday Trip</span></span>
            </p>
            <p class="mt-4 text-xl font-black text-slate-800 flex items-center gap-2 border-t-2 border-dashed border-slate-300 pt-3">
                "Buy snacks"
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="relative z-10 flex gap-3">
            <!-- Hold On -->
            <a href="{{ url('/pockets/1') }}" class="flex-1 flex justify-center items-center gap-2 bg-pink-400 border-4 border-slate-800 rounded-2xl py-4 font-black text-slate-800 text-lg shadow-cartoon hover:bg-pink-500 active:translate-y-1 active:shadow-none transition-all">
                Tunggu Dulu <i class="ph-bold ph-x"></i>
            </a>
            
            <!-- Approve -->
            <a href="{{ url('/pockets/1') }}" class="flex-1 flex justify-center items-center gap-2 bg-lime-400 border-4 border-slate-800 rounded-2xl py-4 font-black text-slate-800 text-lg shadow-cartoon hover:bg-lime-300 active:translate-y-1 active:shadow-none transition-all">
                Setuju <i class="ph-bold ph-check"></i>
            </a>
        </div>

    </div>
</div>

<style>
    @keyframes popIn {
        0% { transform: scale(0.9); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
@endsection
