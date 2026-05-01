@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="p-6 relative min-h-full bg-slate-200">
    
    <header class="mb-8 pt-4">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-2">Profil <i class="ph-duotone ph-smiley-wink text-lime-600"></i></h1>
        <p class="text-slate-500 font-bold">Kelola akun{{ !$user->is_single_mode ? ' & pasanganmu' : '' }}</p>
    </header>

    <!-- My Profile Card -->
    <div class="bg-white border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8 flex items-center gap-4">
        <div class="w-16 h-16 {{ $user->gender == 'female' ? 'bg-pink-300' : 'bg-blue-300' }} border-4 border-slate-800 rounded-full flex items-center justify-center text-3xl text-slate-800">
            <i class="ph-duotone ph-gender-{{ $user->gender == 'female' ? 'female' : 'male' }}"></i>
        </div>
        <div>
            <h2 class="text-xl font-black text-slate-800 leading-none">{{ $user->name }}</h2>
            <p class="text-sm font-bold text-slate-500">{{ $user->email }}</p>
        </div>
    </div>

    @if(!$user->is_single_mode)
    <!-- Partner Info -->
    <h3 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2">Pasanganku <i class="ph-duotone ph-heart text-pink-500"></i></h3>
    @if($user->partner_id)
        <div class="bg-pink-300 border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8 flex items-center gap-4 relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-pink-400 rounded-full border-4 border-slate-800 opacity-50"></div>
            
            <div class="w-16 h-16 {{ $user->partner->gender == 'female' ? 'bg-pink-300' : 'bg-blue-300' }} border-4 border-slate-800 rounded-full flex items-center justify-center text-3xl relative z-10 text-slate-800">
                <i class="ph-duotone ph-gender-{{ $user->partner->gender == 'female' ? 'female' : 'male' }}"></i>
            </div>
            <div class="relative z-10">
                <h2 class="text-xl font-black text-slate-800 leading-none">{{ $user->partner->name ?? 'Pasangan' }}</h2>
                <p class="text-sm font-bold text-slate-700 flex items-center gap-1">Berhasil dipasangkan <i class="ph-duotone ph-confetti text-yellow-500"></i></p>
            </div>
        </div>
    @else
        <!-- Pairing Code Display -->
        <div class="bg-orange-50 border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8 text-center">
            <p class="text-slate-600 font-bold mb-2">Kamu belum punya pasangan.</p>
            <p class="text-sm font-black text-slate-800 uppercase tracking-wider mb-2">Kode Pasanganmu</p>
            <div class="bg-white border-4 border-slate-800 rounded-2xl py-3 px-6 inline-block text-2xl font-black text-pink-500 tracking-widest shadow-cartoon-sm mb-4">
                {{ $user->pairing_code }}
            </div>
            <p class="text-xs text-slate-500 font-bold">Berikan kode ini ke pasanganmu agar mereka bisa terhubung dengan akunmu.</p>
        </div>
    @endif
    @endif

    <!-- Actions -->
    <div class="space-y-4">
        <a href="{{ url('/settings') }}" class="block w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-black text-slate-800 shadow-cartoon-sm hover:bg-slate-50 transition-colors flex justify-between items-center">
            <span class="flex items-center gap-2"><i class="ph-duotone ph-gear"></i> Pengaturan</span>
            <span><i class="ph-bold ph-caret-right"></i></span>
        </a>
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button type="submit" class="w-full bg-slate-800 border-4 border-slate-800 rounded-2xl p-4 text-lg font-black text-white shadow-cartoon-sm hover:bg-slate-700 transition-colors flex justify-center items-center gap-2">
                Keluar <i class="ph-bold ph-sign-out"></i>
            </button>
        </form>
    </div>

</div>
@endsection
