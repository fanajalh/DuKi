@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 relative min-h-full">
    @php
        $isSingle = $user->is_single_mode;
        $isMale = $user->gender === 'male';
        
        $theme = [
            'bg-main' => $isSingle && $isMale ? 'bg-blue-400' : 'bg-pink-400',
            'bg-light' => $isSingle && $isMale ? 'bg-blue-300' : 'bg-pink-300',
            'bg-dark' => $isSingle && $isMale ? 'bg-blue-500' : 'bg-pink-500',
            'text-main' => $isSingle && $isMale ? 'text-blue-500' : 'text-pink-500',
            'icon' => $isSingle ? 'ph-user' : 'ph-users-three',
            'title_savings' => $isSingle ? 'Total Tabungan Saya' : 'Total Tabungan Bersama',
            'title_pockets' => $isSingle ? 'Kantong Saya' : 'Kantong Kita'
        ];
    @endphp
    
    <header class="flex justify-between items-center mb-8 pt-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-2">Halo, {{ explode(' ', $user->name)[0] }}! <i class="ph-duotone ph-hand-waving text-yellow-500"></i></h1>
            <p class="text-slate-500 font-bold">Yuk lihat tabungan kita hari ini</p>
        </div>
        <div class="w-14 h-14 {{ $theme['bg-light'] }} border-4 border-slate-800 rounded-full shadow-cartoon flex items-center justify-center text-2xl overflow-hidden relative text-slate-800">
            <i class="ph-duotone {{ $theme['icon'] }}"></i>
        </div>
    </header>

    <div class="{{ $theme['bg-main'] }} border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-10 relative overflow-hidden text-slate-800">
        <div class="absolute -right-10 -top-10 w-32 h-32 {{ $theme['bg-light'] }} rounded-full opacity-50 border-4 border-slate-800"></div>
        <div class="absolute -left-6 -bottom-6 w-20 h-20 {{ $theme['bg-dark'] }} rounded-full opacity-30 border-4 border-slate-800"></div>
        
        <p class="font-black uppercase tracking-wider text-sm mb-1 z-10 relative flex items-center gap-2">
            {{ $theme['title_savings'] }} <i class="ph-duotone ph-bank text-yellow-300 text-lg"></i>
        </p>
        <h2 class="text-4xl font-black z-10 relative mb-4">Rp {{ number_format($totalSavings, 0, ',', '.') }}</h2>
    </div>

    <div class="flex justify-between items-end mb-4">
        <h3 class="text-2xl font-black text-slate-800 flex items-center gap-2">{{ $theme['title_pockets'] }} <i class="ph-duotone ph-piggy-bank {{ $theme['text-main'] }}"></i></h3>
        <a href="#" class="text-sm font-black {{ $theme['text-main'] }} hover:underline">Lihat Semua</a>
    </div>

    <div class="space-y-4">
        @forelse($pockets as $pocket)
            @php
                $saved = $pocket->totalSaved();
                $percentage = $pocket->target_amount > 0 ? round(($saved / $pocket->target_amount) * 100) : 0;
                $isCompleted = $percentage >= 100;
            @endphp
            <a href="{{ url('/pockets/'.$pocket->id) }}" class="block bg-white border-4 border-slate-800 rounded-3xl p-5 shadow-cartoon hover:bg-slate-50 transition-colors">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-lime-300 border-4 border-slate-800 rounded-2xl flex items-center justify-center text-2xl shadow-cartoon-sm text-slate-800">
                            <i class="{{ $pocket->icon }}"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-lg text-slate-800 leading-tight">{{ $pocket->name }}</h4>
                            @if($pocket->target_amount)
                                <p class="text-xs font-bold text-slate-500">Target: Rp {{ number_format($pocket->target_amount, 0, ',', '.') }}</p>
                            @else
                                <p class="text-xs font-bold {{ $theme['text-main'] }} flex items-center gap-1"><i class="ph-fill ph-infinity"></i> Nabung untuk masa depan</p>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        @if($pocket->target_amount)
                            @if($isCompleted)
                                <span class="font-black text-lime-500 block text-lg animate-bounce">100%</span>
                            @else
                                <span class="font-black text-slate-800 block text-lg">{{ $percentage }}%</span>
                            @endif
                        @else
                            <span class="font-black text-slate-800 block text-lg"><i class="ph-duotone ph-plant"></i></span>
                        @endif
                    </div>
                </div>
                
                @if($pocket->target_amount)
                <div>
                    <div class="flex justify-between text-xs font-black {{ $isCompleted ? 'text-lime-600' : 'text-slate-800' }} mb-1">
                        <span class="flex items-center gap-1">Rp {{ number_format($saved, 0, ',', '.') }} {!! $isCompleted ? '<i class="ph-duotone ph-confetti"></i> Target Tercapai!' : '' !!}</span>
                        @if(!$isCompleted && $pocket->deadline)
                            <span class="text-slate-500">{{ \Carbon\Carbon::parse($pocket->deadline)->diffForHumans() }}</span>
                        @endif
                    </div>
                    <div class="w-full h-6 bg-slate-200 border-4 border-slate-800 rounded-full overflow-hidden p-[2px]">
                        <div class="h-full {{ $isCompleted ? $theme['bg-main'] : 'bg-lime-400' }} rounded-full border-r-4 border-slate-800 relative overflow-hidden" style="width: {{ $percentage > 100 ? 100 : $percentage }}%;">
                            @if($isCompleted)
                                <div class="absolute inset-0 bg-white/30 w-full animate-[shimmer_2s_infinite]"></div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div>
                    <div class="flex justify-between items-end text-xs font-black text-slate-800 mb-1">
                        <span class="text-lg">Rp {{ number_format($saved, 0, ',', '.') }}</span>
                        <span class="text-slate-500 bg-slate-200 px-2 py-1 rounded-lg">Tanpa Target</span>
                    </div>
                </div>
                @endif
            </a>
        @empty
            <div class="text-center p-6 bg-orange-50 border-4 border-slate-800 rounded-3xl border-dashed">
                <p class="text-slate-500 font-bold mb-2">Belum ada kantong!</p>
                <a href="{{ url('/pockets/create') }}" class="{{ $theme['text-main'] }} font-black hover:underline">Buat kantong sekarang</a>
            </div>
        @endforelse
    </div>



</div>

<style>
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
</style>
@endsection
