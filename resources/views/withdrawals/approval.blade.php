@extends('layouts.auth')

@section('title', 'Persetujuan Penarikan')

@section('content')

{{-- 🐷 PIG LOADING OVERLAY --}}
<div id="pig-loading" class="fixed inset-0 z-[9999] bg-slate-900/70 backdrop-blur-sm flex flex-col items-center justify-center hidden">
    <div class="flex flex-col items-center gap-4">
        {{-- Pig Face --}}
        <div class="pig-bounce">
            <div class="pig-body">
                {{-- Ears --}}
                <div class="pig-ear pig-ear-left"></div>
                <div class="pig-ear pig-ear-right"></div>
                {{-- Head --}}
                <div class="pig-head">
                    {{-- Eyes --}}
                    <div class="pig-eye pig-eye-left"></div>
                    <div class="pig-eye pig-eye-right"></div>
                    {{-- Snout --}}
                    <div class="pig-snout">
                        <div class="pig-nostril pig-nostril-left"></div>
                        <div class="pig-nostril pig-nostril-right"></div>
                    </div>
                    {{-- Blush --}}
                    <div class="pig-blush pig-blush-left"></div>
                    <div class="pig-blush pig-blush-right"></div>
                </div>
            </div>
        </div>
        {{-- Coin coins falling --}}
        <div class="coin-container">
            <div class="coin coin-1">💰</div>
            <div class="coin coin-2">🪙</div>
            <div class="coin coin-3">💰</div>
        </div>
        <p class="text-white font-black text-xl tracking-wide">Memproses...</p>
        <div class="flex gap-1.5">
            <div class="dot dot-1"></div>
            <div class="dot dot-2"></div>
            <div class="dot dot-3"></div>
        </div>
    </div>
</div>

<style>
    /* ===== PIG STYLES ===== */
    .pig-bounce { animation: pigBounce 0.8s ease-in-out infinite alternate; }
    .pig-body { position: relative; width: 120px; height: 120px; }

    .pig-ear {
        position: absolute;
        width: 36px; height: 36px;
        background: #f9a8d4;
        border: 4px solid #1e293b;
        border-radius: 50% 50% 50% 20% / 50% 50% 20% 50%;
        top: 4px;
        z-index: 0;
    }
    .pig-ear-left  { left: 4px;  transform: rotate(-30deg); }
    .pig-ear-right { right: 4px; transform: rotate(30deg) scaleX(-1); }

    .pig-head {
        position: absolute;
        bottom: 0; left: 50%;
        transform: translateX(-50%);
        width: 110px; height: 100px;
        background: #fda4af;
        border: 4px solid #1e293b;
        border-radius: 55% 55% 50% 50% / 60% 60% 50% 50%;
        z-index: 1;
        overflow: visible;
    }

    .pig-eye {
        position: absolute;
        top: 28px;
        width: 14px; height: 17px;
        background: #1e293b;
        border-radius: 50%;
        animation: pigBlink 3s ease-in-out infinite;
    }
    .pig-eye-left  { left: 22px; }
    .pig-eye-right { right: 22px; }
    .pig-eye::after {
        content: '';
        position: absolute;
        top: 3px; left: 3px;
        width: 5px; height: 5px;
        background: white;
        border-radius: 50%;
    }

    .pig-snout {
        position: absolute;
        bottom: 20px; left: 50%;
        transform: translateX(-50%);
        width: 44px; height: 32px;
        background: #fb7185;
        border: 3px solid #1e293b;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .pig-nostril {
        width: 9px; height: 11px;
        background: #be123c;
        border-radius: 50%;
        border: 2px solid #1e293b;
    }

    .pig-blush {
        position: absolute;
        bottom: 32px;
        width: 18px; height: 10px;
        background: #fb7185;
        border-radius: 50%;
        opacity: 0.6;
    }
    .pig-blush-left  { left: 10px; }
    .pig-blush-right { right: 10px; }

    /* ===== LOADING DOTS ===== */
    .dot {
        width: 10px; height: 10px;
        background: white;
        border-radius: 50%;
        animation: dotPulse 1.2s ease-in-out infinite;
    }
    .dot-1 { animation-delay: 0s; }
    .dot-2 { animation-delay: 0.2s; }
    .dot-3 { animation-delay: 0.4s; }

    /* ===== COINS ===== */
    .coin-container { position: relative; height: 30px; display: flex; gap: 12px; }
    .coin { font-size: 20px; animation: coinFall 1.5s ease-in-out infinite; }
    .coin-1 { animation-delay: 0s; }
    .coin-2 { animation-delay: 0.3s; }
    .coin-3 { animation-delay: 0.6s; }

    /* ===== KEYFRAMES ===== */
    @keyframes pigBounce {
        from { transform: translateY(0px); }
        to   { transform: translateY(-12px); }
    }
    @keyframes pigBlink {
        0%, 92%, 100% { transform: scaleY(1); }
        96%            { transform: scaleY(0.05); }
    }
    @keyframes dotPulse {
        0%, 100% { opacity: 0.3; transform: scale(0.8); }
        50%       { opacity: 1;   transform: scale(1.2); }
    }
    @keyframes coinFall {
        0%   { transform: translateY(-20px); opacity: 0; }
        30%  { opacity: 1; }
        70%  { opacity: 1; }
        100% { transform: translateY(20px);  opacity: 0; }
    }
    @keyframes popIn {
        0%   { transform: scale(0.85) translateY(20px); opacity: 0; }
        100% { transform: scale(1)    translateY(0);    opacity: 1; }
    }
</style>

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

    {{-- Request Cards --}}
    <div class="w-full md:max-w-[420px] flex flex-col gap-5 pb-10">
        @foreach($pendingRequests as $index => $req)
        <div class="w-full bg-pink-100 border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon relative overflow-hidden"
             style="animation: popIn 0.35s ease-out {{ $index * 0.1 }}s both;">

            {{-- Background Decor --}}
            <div class="absolute -right-5 -top-5 w-20 h-20 bg-yellow-300 rounded-full border-4 border-slate-800 opacity-50 pointer-events-none"></div>
            <div class="absolute -left-6 -bottom-6 w-28 h-28 bg-pink-300 rounded-full border-4 border-slate-800 opacity-40 pointer-events-none"></div>

            {{-- Request # Badge --}}
            <div class="relative z-10 flex items-center justify-between mb-4">
                <span class="text-xs font-black uppercase tracking-widest text-slate-500">#{{ $index + 1 }} dari {{ $pendingRequests->count() }}</span>
                <span class="bg-pink-400 border-2 border-slate-800 rounded-full px-3 py-1 text-xs font-black text-slate-800">⏳ Menunggu</span>
            </div>

            {{-- Pulse Warning Icon --}}
            <div class="relative z-10 w-16 h-16 bg-yellow-300 border-4 border-slate-800 rounded-full flex items-center justify-center text-3xl shadow-cartoon mx-auto mb-4 animate-pulse text-red-500">
                <i class="ph-duotone ph-hand-coins"></i>
            </div>

            {{-- Requester Info --}}
            <h2 class="relative z-10 text-center text-xl font-black text-slate-800 mb-3">
                {{ $req->user->name }} ingin menarik:
            </h2>

            {{-- Detail Card --}}
            <div class="relative z-10 bg-white border-4 border-slate-800 rounded-2xl p-4 mb-5 shadow-cartoon-sm">
                {{-- Amount --}}
                <div class="flex items-center justify-between mb-3 pb-3 border-b-2 border-dashed border-slate-200">
                    <span class="text-sm font-black text-slate-500 uppercase tracking-wider">Jumlah</span>
                    <span class="text-2xl font-black text-pink-600">Rp {{ number_format($req->amount, 0, ',', '.') }}</span>
                </div>

                {{-- Pocket --}}
                <div class="flex items-center justify-between mb-3 pb-3 border-b-2 border-dashed border-slate-200">
                    <span class="text-sm font-black text-slate-500 uppercase tracking-wider">Dari Kantong</span>
                    <span class="bg-lime-200 border-2 border-slate-800 rounded-xl px-3 py-1 text-sm font-black text-slate-800 flex items-center gap-1">
                        {{ $req->pocket->icon ?? '💰' }} {{ $req->pocket->name }}
                    </span>
                </div>

                {{-- Saldo saat ini --}}
                @php $balance = $req->pocket->totalSaved(); @endphp
                <div class="flex items-center justify-between mb-3 pb-3 border-b-2 border-dashed border-slate-200">
                    <span class="text-sm font-black text-slate-500 uppercase tracking-wider">Saldo</span>
                    <span class="text-sm font-black {{ $balance >= $req->amount ? 'text-green-600' : 'text-red-500' }}">
                        Rp {{ number_format($balance, 0, ',', '.') }}
                        @if($balance < $req->amount)
                            <span class="block text-xs">(Tidak cukup!)</span>
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
            @php
                $rejectFormId  = 'reject-form-'  . $req->id;
                $approveFormId = 'approve-form-' . $req->id;
                $fmtAmt        = 'Rp ' . number_format($req->amount, 0, ',', '.');
                $pocketName    = $req->pocket->name;
                $requester     = $req->user->name;
            @endphp

            <div class="relative z-10 flex gap-3">
                {{-- Reject Form --}}
                <form id="{{ $rejectFormId }}" action="{{ url('/withdraw/' . $req->id . '/reject') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="button"
                        onclick="swalWithdrawReject('{{ $rejectFormId }}', {{ json_encode($requester) }}, {{ json_encode($fmtAmt) }}, {{ json_encode($pocketName) }})"
                        class="w-full flex justify-center items-center gap-2 bg-pink-400 border-4 border-slate-800 rounded-2xl py-4 font-black text-slate-800 text-base shadow-cartoon hover:bg-pink-500 active:translate-y-1 active:shadow-none transition-all">
                        <i class="ph-bold ph-x"></i> Tolak
                    </button>
                </form>

                {{-- Approve Form --}}
                @if($balance >= $req->amount)
                <form id="{{ $approveFormId }}" action="{{ url('/withdraw/' . $req->id . '/approve') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="button"
                        onclick="swalWithdrawApprove('{{ $approveFormId }}', {{ json_encode($requester) }}, {{ json_encode($fmtAmt) }}, {{ json_encode($pocketName) }})"
                        class="w-full flex justify-center items-center gap-2 bg-lime-400 border-4 border-slate-800 rounded-2xl py-4 font-black text-slate-800 text-base shadow-cartoon hover:bg-lime-300 active:translate-y-1 active:shadow-none transition-all">
                        <i class="ph-bold ph-check"></i> Setuju
                    </button>
                </form>
                @else
                <div class="flex-1">
                    <div class="w-full flex justify-center items-center gap-2 bg-slate-200 border-4 border-slate-400 rounded-2xl py-4 font-black text-slate-500 text-base cursor-not-allowed">
                        <i class="ph-bold ph-prohibit"></i> Tidak Bisa
                    </div>
                </div>
                @endif
            </div>

        </div>
        @endforeach
    </div>

</div>

<script>
function showPigLoading() {
    document.getElementById('pig-loading').classList.remove('hidden');
}

function swalWithdrawApprove(formId, requester, amount, pocket) {
    Swal.fire({
        title: 'Setujui Penarikan? ✅',
        html: '<div style="font-size:15px;font-weight:700;line-height:1.8;color:#1e293b;">' +
              requester + ' ingin menarik<br>' +
              '<span style="font-size:22px;font-weight:900;color:#16a34a;">' + amount + '</span><br>' +
              'dari kantong <b>' + pocket + '</b>' +
              '</div>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '✅ Ya, Setuju!',
        cancelButtonText: 'Batal dulu',
        confirmButtonColor: '#86efac',
        cancelButtonColor: '#94a3b8',
        background: '#fffbeb',
        color: '#1e293b',
        customClass: {
            popup: 'rounded-3xl border-4 border-slate-800',
            confirmButton: 'font-black text-slate-800',
            cancelButton: 'font-black text-white'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            showPigLoading();
            document.getElementById(formId).submit();
        }
    });
}

function swalWithdrawReject(formId, requester, amount, pocket) {
    Swal.fire({
        title: 'Tolak Penarikan? ❌',
        html: '<div style="font-size:15px;font-weight:700;line-height:1.8;color:#1e293b;">' +
              'Yakin menolak permintaan <b>' + requester + '</b>?<br>' +
              '<span style="font-size:20px;font-weight:900;color:#e11d48;">' + amount + '</span><br>' +
              'dari kantong <b>' + pocket + '</b>' +
              '</div>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '❌ Ya, Tolak!',
        cancelButtonText: 'Hmm, tunggu dulu',
        confirmButtonColor: '#fb7185',
        cancelButtonColor: '#94a3b8',
        background: '#fffbeb',
        color: '#1e293b',
        customClass: {
            popup: 'rounded-3xl border-4 border-slate-800',
            confirmButton: 'font-black text-white',
            cancelButton: 'font-black text-white'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            showPigLoading();
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endsection
