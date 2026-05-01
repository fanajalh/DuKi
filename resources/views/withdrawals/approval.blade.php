@extends('layouts.auth')

@section('title', 'Persetujuan Penarikan')

@section('content')
<div class="flex flex-col items-center justify-start min-h-screen px-4 py-8 bg-slate-900/40 backdrop-blur-sm relative">

    {{-- Close Button --}}
    <a href="{{ url('/dashboard') }}" class="fixed top-6 right-6 z-20 w-12 h-12 bg-white border-4 border-slate-800 rounded-full flex items-center justify-center text-xl shadow-cartoon hover:bg-slate-100 text-slate-800">
        <i class="ph-bold ph-x"></i>
    </a>

    {{-- Header --}}
    <div class="w-full md:max-w-[420px] mb-6 pt-2 text-center">
        <div class="inline-flex items-center gap-2 bg-pink-300 border-4 border-slate-800 rounded-2xl px-5 py-2 shadow-cartoon">
            <i class="ph-duotone ph-warning text-2xl text-red-600"></i>
            <span class="font-black text-slate-800 text-lg">{{ $pendingRequests->count() }} Permintaan Penarikan</span>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="w-full md:max-w-[420px] mb-4 bg-lime-300 border-4 border-slate-800 rounded-2xl p-4 flex items-center gap-3 shadow-cartoon-sm">
            <i class="ph-duotone ph-check-circle text-2xl text-green-700"></i>
            <p class="font-bold text-slate-800">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="w-full md:max-w-[420px] mb-4 bg-red-300 border-4 border-slate-800 rounded-2xl p-4 flex items-center gap-3 shadow-cartoon-sm">
            <i class="ph-duotone ph-x-circle text-2xl text-red-700"></i>
            <p class="font-bold text-slate-800">{{ session('error') }}</p>
        </div>
    @endif
    @if(session('info'))
        <div class="w-full md:max-w-[420px] mb-4 bg-yellow-200 border-4 border-slate-800 rounded-2xl p-4 flex items-center gap-3 shadow-cartoon-sm">
            <i class="ph-duotone ph-info text-2xl text-yellow-700"></i>
            <p class="font-bold text-slate-800">{{ session('info') }}</p>
        </div>
    @endif

    {{-- Request Cards --}}
    <div class="w-full md:max-w-[420px] flex flex-col gap-5 pb-10">
        @foreach($pendingRequests as $index => $req)
        <div class="w-full bg-pink-100 border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon relative overflow-hidden animate-[popIn_0.3s_ease-out_{{ $index * 0.1 }}s_both]">

            {{-- Background Decor --}}
            <div class="absolute -right-5 -top-5 w-20 h-20 bg-yellow-300 rounded-full border-4 border-slate-800 opacity-50 pointer-events-none"></div>
            <div class="absolute -left-6 -bottom-6 w-28 h-28 bg-pink-300 rounded-full border-4 border-slate-800 opacity-40 pointer-events-none"></div>

            {{-- Request # Badge --}}
            <div class="relative z-10 flex items-center justify-between mb-4">
                <span class="text-xs font-black uppercase tracking-widest text-slate-500">#{{ $index + 1 }} dari {{ $pendingRequests->count() }}</span>
                <span class="bg-pink-400 border-2 border-slate-800 rounded-full px-3 py-1 text-xs font-black text-slate-800">
                    ⏳ Menunggu
                </span>
            </div>

            {{-- Pulse Warning Icon --}}
            <div class="relative z-10 w-16 h-16 bg-yellow-300 border-4 border-slate-800 rounded-full flex items-center justify-center text-3xl shadow-cartoon mx-auto mb-4 animate-pulse text-red-500">
                <i class="ph-duotone ph-hand-coins"></i>
            </div>

            {{-- Requester Info --}}
            <h2 class="relative z-10 text-center text-xl font-black text-slate-800 mb-1">
                {{ $req->user->name }} ingin menarik:
            </h2>

            {{-- Detail Card --}}
            <div class="relative z-10 bg-white border-4 border-slate-800 rounded-2xl p-4 mb-5 shadow-cartoon-sm">
                {{-- Amount --}}
                <div class="flex items-center justify-between mb-3 pb-3 border-b-2 border-dashed border-slate-200">
                    <span class="text-sm font-black text-slate-500 uppercase tracking-wider">Jumlah</span>
                    <span class="text-2xl font-black text-pink-600">
                        Rp {{ number_format($req->amount, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Pocket --}}
                <div class="flex items-center justify-between mb-3 pb-3 border-b-2 border-dashed border-slate-200">
                    <span class="text-sm font-black text-slate-500 uppercase tracking-wider">Dari Kantong</span>
                    <span class="bg-lime-200 border-2 border-slate-800 rounded-xl px-3 py-1 text-sm font-black text-slate-800 flex items-center gap-1">
                        {{ $req->pocket->icon ?? '💰' }} {{ $req->pocket->name }}
                    </span>
                </div>

                {{-- Saldo saat ini --}}
                <div class="flex items-center justify-between mb-3 pb-3 border-b-2 border-dashed border-slate-200">
                    <span class="text-sm font-black text-slate-500 uppercase tracking-wider">Saldo Kantong</span>
                    <span class="text-sm font-black {{ $req->pocket->totalSaved() >= $req->amount ? 'text-green-600' : 'text-red-500' }}">
                        Rp {{ number_format($req->pocket->totalSaved(), 0, ',', '.') }}
                        @if($req->pocket->totalSaved() < $req->amount)
                            <span class="block text-xs text-red-500">(Tidak cukup!)</span>
                        @endif
                    </span>
                </div>

                {{-- Reason --}}
                <div class="flex items-start gap-2 pt-1">
                    <i class="ph-duotone ph-chat-text text-slate-400 text-lg mt-0.5 flex-shrink-0"></i>
                    <p class="text-base font-black text-slate-800 italic">"{{ $req->message }}"</p>
                </div>
            </div>

            {{-- Requested At --}}
            <p class="relative z-10 text-center text-xs text-slate-500 font-bold mb-5">
                Diajukan {{ $req->created_at->diffForHumans() }}
            </p>

            {{-- Action Buttons --}}
            <div class="relative z-10 flex gap-3">
                {{-- Reject --}}
                <form action="{{ url('/withdraw/' . $req->id . '/reject') }}" method="POST" class="flex-1"
                      onsubmit="return confirm('Tolak permintaan penarikan ini?')">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-pink-400 border-4 border-slate-800 rounded-2xl py-4 font-black text-slate-800 text-base shadow-cartoon hover:bg-pink-500 active:translate-y-1 active:shadow-none transition-all">
                        <i class="ph-bold ph-x"></i> Tolak
                    </button>
                </form>

                {{-- Approve --}}
                @if($req->pocket->totalSaved() >= $req->amount)
                @php
                    $confirmMsg = 'Setujui penarikan Rp ' . number_format($req->amount, 0, ',', '.') . ' dari kantong ' . $req->pocket->name . '?';
                @endphp
                <form action="{{ url('/withdraw/' . $req->id . '/approve') }}" method="POST" class="flex-1"
                      onsubmit="return confirm({{ json_encode($confirmMsg) }})">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-lime-400 border-4 border-slate-800 rounded-2xl py-4 font-black text-slate-800 text-base shadow-cartoon hover:bg-lime-300 active:translate-y-1 active:shadow-none transition-all">
                        <i class="ph-bold ph-check"></i> Setuju
                    </button>
                </form>
                @else
                <div class="flex-1">
                    <div class="w-full flex justify-center items-center gap-2 bg-slate-200 border-4 border-slate-400 rounded-2xl py-4 font-black text-slate-500 text-base cursor-not-allowed" title="Saldo tidak mencukupi">
                        <i class="ph-bold ph-prohibit"></i> Tidak Bisa
                    </div>
                </div>
                @endif
            </div>

        </div>
        @endforeach
    </div>

</div>

<style>
    @keyframes popIn {
        0% { transform: scale(0.85) translateY(20px); opacity: 0; }
        100% { transform: scale(1) translateY(0); opacity: 1; }
    }
</style>
@endsection
