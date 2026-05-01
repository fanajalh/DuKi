@extends('layouts.auth')

@section('title', 'Welcome to DuKi')

@section('content')
<div class="flex flex-col min-h-screen relative overflow-hidden" style="background: #fef9f0;">

    <!-- Fun zigzag top decoration -->
    <div class="w-full h-4 bg-lime-400 border-b-4 border-slate-800" style="clip-path: polygon(0 0, 5% 100%, 10% 0, 15% 100%, 20% 0, 25% 100%, 30% 0, 35% 100%, 40% 0, 45% 100%, 50% 0, 55% 100%, 60% 0, 65% 100%, 70% 0, 75% 100%, 80% 0, 85% 100%, 90% 0, 95% 100%, 100% 0, 100% 0, 0 0);"></div>

    <!-- Floating decoration blobs -->
    <div class="absolute top-20 right-4 w-16 h-16 bg-pink-300 border-4 border-slate-800 rounded-full animate-bounce opacity-70" style="animation-delay: 0.2s;"></div>
    <div class="absolute top-32 left-2 w-10 h-10 bg-yellow-300 border-4 border-slate-800 rounded-full animate-bounce opacity-60" style="animation-delay: 0.5s;"></div>
    <div class="absolute bottom-48 right-2 w-12 h-12 bg-lime-300 border-4 border-slate-800 rounded-2xl rotate-12 opacity-60 animate-pulse"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col justify-center items-center px-6 pt-8 pb-4 text-center relative z-10">

        <!-- Big Illustration -->
        <div class="relative mb-8">
            <!-- Main card -->
            <div class="w-64 h-64 border-4 border-slate-800 rounded-[3rem] shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] flex items-center justify-center relative overflow-hidden text-pink-500" style="background: linear-gradient(145deg, #f9a8d4, #fda4af);">
                <!-- Background dots -->
                <div class="absolute inset-0" style="background-image: radial-gradient(circle, rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 16px 16px;"></div>
                <span class="text-8xl relative z-10 animate-[wiggle_2s_ease-in-out_infinite]"><i class="ph-duotone ph-users-three"></i></span>
            </div>

            <!-- Floating accent cards -->
            <div class="absolute -top-4 -right-4 w-14 h-14 bg-lime-400 border-4 border-slate-800 rounded-2xl shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] flex items-center justify-center text-2xl rotate-12 text-slate-800"><i class="ph-duotone ph-money"></i></div>
            <div class="absolute -bottom-3 -left-4 w-12 h-12 bg-yellow-300 border-4 border-slate-800 rounded-2xl shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] flex items-center justify-center text-xl -rotate-12 text-slate-800"><i class="ph-duotone ph-piggy-bank"></i></div>
            <div class="absolute top-1/2 -right-5 w-10 h-10 bg-white border-4 border-slate-800 rounded-full shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] flex items-center justify-center text-lg text-yellow-500"><i class="ph-fill ph-star"></i></div>
        </div>

        <!-- Heading with sticker style -->
        <div class="mb-4">
            <div class="inline-block bg-lime-400 border-4 border-slate-800 rounded-2xl px-4 py-1 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] mb-3 -rotate-1">
                <span class="text-sm font-black text-slate-800 uppercase tracking-wider flex items-center gap-1">Untuk Pasangan <i class="ph-duotone ph-heart text-pink-500"></i></span>
            </div>
            <h1 class="text-4xl font-black text-slate-800 leading-tight">
                Nabung Bareng,<br>
                <span class="text-pink-500">Senyum</span> Terus!
            </h1>
        </div>

        <p class="text-slate-600 font-bold text-base mb-8 max-w-xs leading-relaxed flex items-center gap-1">
            Pantau target tabungan bersama, lihat siapa yang nabung, dan rayakan pencapaian bareng-bareng! <i class="ph-duotone ph-confetti text-yellow-500"></i>
        </p>

        <!-- Feature pills -->
        <div class="flex flex-wrap gap-2 justify-center mb-8">
            <div class="bg-white border-4 border-slate-800 rounded-full px-3 py-1 text-xs font-black shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] flex items-center gap-1"><i class="ph-bold ph-link text-blue-500"></i> Pasangkan Langsung</div>
            <div class="bg-pink-200 border-4 border-slate-800 rounded-full px-3 py-1 text-xs font-black shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] flex items-center gap-1"><i class="ph-bold ph-chart-bar text-pink-600"></i> Pantau Bareng</div>
            <div class="bg-lime-200 border-4 border-slate-800 rounded-full px-3 py-1 text-xs font-black shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] flex items-center gap-1"><i class="ph-bold ph-target text-lime-700"></i> Capai Target</div>
        </div>
    </div>

    <!-- Bottom Buttons -->
    <div class="px-6 pb-10 space-y-4 relative z-10">
        <a href="{{ url('/register') }}" class="flex justify-center items-center gap-2 w-full text-center py-5 text-xl font-black text-slate-800 border-4 border-slate-800 rounded-3xl shadow-[5px_5px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-0.5 hover:shadow-[5px_8px_0px_0px_rgba(30,41,59,1)] active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] transition-all" style="background: linear-gradient(135deg, #a3e635, #84cc16);">
            Mulai Nabung Bareng! <i class="ph-duotone ph-rocket-launch"></i>
        </a>
        <a href="{{ url('/login') }}" class="flex justify-center items-center gap-2 w-full text-center py-4 text-lg font-black text-slate-600 border-4 border-slate-300 rounded-3xl bg-white hover:border-slate-800 hover:text-slate-800 hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] active:translate-y-0.5 transition-all">
            Aku sudah punya akun <i class="ph-duotone ph-hand-waving text-yellow-500"></i>
        </a>
    </div>

    <!-- Bottom zigzag -->
    <div class="absolute bottom-0 left-0 w-full h-3 bg-pink-400 border-t-4 border-slate-800"></div>
</div>

<style>
    @keyframes wiggle {
        0%, 100% { transform: rotate(-3deg); }
        50% { transform: rotate(3deg); }
    }
</style>
@endsection
