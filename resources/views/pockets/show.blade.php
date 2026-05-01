@extends('layouts.auth')

@section('title', $pocket->name)

@section('content')
<div class="flex flex-col min-h-screen bg-orange-50 relative pb-24">
    @php
        $isSingle = $user->is_single_mode;
        $isMale = $user->gender === 'male';
        $theme = [
            'bg-main' => $isSingle && $isMale ? 'bg-blue-400' : 'bg-pink-400',
            'bg-light' => $isSingle && $isMale ? 'bg-blue-300' : 'bg-pink-300',
            'text-main' => $isSingle && $isMale ? 'text-blue-500' : 'text-pink-500',
            'chart-icon' => $isSingle ? 'ph-chart-pie-slice' : 'ph-chart-bar'
        ];
    @endphp
    
    <header class="bg-white border-b-4 border-slate-800 px-6 py-4 flex items-center justify-between sticky top-0 z-50">
        <a href="{{ url('/dashboard') }}" class="w-10 h-10 bg-slate-100 border-4 border-slate-800 rounded-xl flex items-center justify-center text-lg shadow-cartoon-sm hover:bg-slate-200 text-slate-800">
            <i class="ph-bold ph-arrow-left"></i>
        </a>
        <h2 class="font-black text-xl text-slate-800">Detail Kantong</h2>
        @if($pocket->creator_id === $user->id)
            <div class="flex gap-2">
                <a href="{{ url('/pockets/'.$pocket->id.'/edit') }}" class="w-10 h-10 bg-yellow-300 border-4 border-slate-800 rounded-xl flex items-center justify-center text-lg shadow-cartoon-sm hover:bg-yellow-400 text-slate-800">
                    <i class="ph-bold ph-pencil-simple"></i>
                </a>
                <form id="delete-pocket-form" action="{{ url('/pockets/'.$pocket->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="swalConfirm('delete-pocket-form', 'Hapus Kantong? 🗑️', 'Yakin ingin menghapus kantong ini? Semua transaksi di dalamnya juga akan terhapus lho!')" class="w-10 h-10 bg-pink-400 border-4 border-slate-800 rounded-xl flex items-center justify-center text-lg shadow-cartoon-sm hover:bg-pink-500 text-slate-800">
                        <i class="ph-bold ph-trash"></i>
                    </button>
                </form>
            </div>
        @else
            <div class="w-10 h-10"></div>
        @endif
    </header>

    <div class="p-6">
        <div class="bg-lime-300 border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8 text-center relative overflow-hidden">
            <div class="w-16 h-16 bg-white border-4 border-slate-800 rounded-2xl mx-auto flex items-center justify-center text-4xl shadow-cartoon-sm mb-4 relative z-10 text-slate-800">
                <i class="{{ $pocket->icon }}"></i>
            </div>
            <h1 class="text-3xl font-black text-slate-800 mb-1 relative z-10">{{ $pocket->name }}</h1>
            @if($pocket->deadline)
                <p class="text-slate-700 font-bold mb-4 relative z-10">Tenggat: {{ \Carbon\Carbon::parse($pocket->deadline)->format('d M Y') }}</p>
            @endif
            
            <div class="bg-white border-4 border-slate-800 rounded-2xl p-4 relative z-10">
                <p class="text-sm font-black text-slate-500 uppercase">Saldo Saat Ini</p>
                <h2 class="text-3xl font-black text-slate-800">Rp {{ number_format($totalSaved, 0, ',', '.') }}</h2>
                
                @if($pocket->target_amount)
                <div class="mt-4">
                    <div class="flex justify-between text-xs font-black text-slate-800 mb-1">
                        <span>{{ $isSingle ? $myPercentage : $myPercentage + $partnerPercentage }}%</span>
                        <span>Target: Rp {{ number_format($pocket->target_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-4 bg-slate-200 border-4 border-slate-800 rounded-full overflow-hidden p-[1px]">
                        <div class="h-full {{ $theme['bg-main'] }} rounded-full border-r-4 border-slate-800" style="width: {{ $isSingle ? $myPercentage : $myPercentage + $partnerPercentage }}%;"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <h3 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2">Lacak Kontribusi <i class="ph-duotone {{ $theme['chart-icon'] }} {{ $theme['text-main'] }}"></i></h3>
        <div class="flex gap-4 mb-8">
            <div class="flex-1 bg-white border-4 border-slate-800 rounded-2xl p-4 shadow-cartoon-sm text-center">
                <div class="w-10 h-10 {{ $user->gender == 'female' ? 'bg-pink-200' : 'bg-blue-200' }} border-4 border-slate-800 rounded-full mx-auto flex items-center justify-center text-xl mb-2 text-slate-800"><i class="ph-duotone ph-gender-{{ $user->gender == 'female' ? 'female' : 'male' }}"></i></div>
                <p class="font-black text-slate-800">Kamu</p>
                <p class="text-sm font-bold text-slate-500">Rp {{ number_format($myContribution, 0, ',', '.') }}</p>
                <div class="mt-2 text-xs font-black bg-lime-200 border-2 border-slate-800 rounded-full py-1">{{ $myPercentage }}%</div>
            </div>
            @if($user->partner_id)
            <div class="flex-1 bg-white border-4 border-slate-800 rounded-2xl p-4 shadow-cartoon-sm text-center">
                <div class="w-10 h-10 {{ $user->partner->gender == 'female' ? 'bg-pink-200' : 'bg-blue-200' }} border-4 border-slate-800 rounded-full mx-auto flex items-center justify-center text-xl mb-2 text-slate-800"><i class="ph-duotone ph-gender-{{ $user->partner->gender == 'female' ? 'female' : 'male' }}"></i></div>
                <p class="font-black text-slate-800">{{ $user->partner->name ?? 'Pasangan' }}</p>
                <p class="text-sm font-bold text-slate-500">Rp {{ number_format($partnerContribution, 0, ',', '.') }}</p>
                <div class="mt-2 text-xs font-black bg-pink-200 border-2 border-slate-800 rounded-full py-1">{{ $partnerPercentage }}%</div>
            </div>
            @endif
        </div>

        <h3 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2">Riwayat Transaksi <i class="ph-duotone ph-book-open text-lime-600"></i></h3>
        <div class="space-y-4">
            @forelse($transactions as $txn)
            <div class="bg-white border-4 border-slate-800 rounded-2xl p-4 shadow-cartoon-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 {{ $txn->user->gender == 'female' ? 'bg-pink-200' : 'bg-blue-200' }} border-2 border-slate-800 rounded-full flex items-center justify-center text-lg text-slate-800">
                            <i class="ph-duotone ph-gender-{{ $txn->user->gender == 'female' ? 'female' : 'male' }}"></i>
                        </div>
                        <div>
                            <p class="font-black text-slate-800 leading-none">{{ $txn->user_id === $user->id ? 'Kamu' : ($txn->user->name ?? 'Pasangan') }} {{ $txn->type == 'deposit' ? 'nabung' : 'narik' }}</p>
                            <p class="text-xs font-bold text-slate-400">{{ $txn->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="font-black {{ $txn->type == 'deposit' ? 'text-lime-500' : 'text-pink-500' }}">
                        {{ $txn->type == 'deposit' ? '+' : '-' }} Rp {{ number_format($txn->amount, 0, ',', '.') }}
                    </span>
                </div>
                @if($txn->message)
                <div class="bg-orange-50 border-2 border-slate-800 rounded-xl p-3 flex gap-2 items-start mt-2">
                    <span class="text-2xl text-slate-800"><i class="ph-duotone ph-chat-circle-text"></i></span>
                    <p class="text-sm font-bold text-slate-700 leading-tight">{{ $txn->message }}</p>
                </div>
                @endif
            </div>
            @empty
                <p class="text-slate-500 font-bold text-center py-4">Belum ada transaksi.</p>
            @endforelse
        </div>
    </div>

    <div class="fixed bottom-0 w-full max-w-full md:max-w-[400px] bg-white border-t-4 border-slate-800 p-4 flex gap-4 z-50">
        <a href="{{ url('/withdraw/request/'.$pocket->id) }}" class="flex-1 flex items-center justify-center gap-2 bg-white border-4 border-slate-800 rounded-2xl py-3 text-center font-black text-slate-800 shadow-cartoon-sm hover:bg-slate-100 active:translate-y-1">
            Tarik Dana <i class="ph-bold ph-upload-simple"></i>
        </a>
        <a href="{{ url('/deposit/'.$pocket->id) }}" class="flex-1 flex items-center justify-center gap-2 bg-lime-400 border-4 border-slate-800 rounded-2xl py-3 text-center font-black text-slate-800 shadow-cartoon-sm hover:bg-lime-300 active:translate-y-1">
            Nabung <i class="ph-bold ph-download-simple"></i>
        </a>
    </div>
</div>
@endsection
