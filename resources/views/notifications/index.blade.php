@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="p-6 relative min-h-full bg-orange-50">
    
    <!-- Header -->
    <header class="flex justify-between items-center mb-6 pt-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-2">Pembaruan <i class="ph-duotone ph-bell-ringing text-yellow-500"></i></h1>
            <p class="text-slate-500 font-bold">Ada apa akhir-akhir ini?</p>
        </div>
    </header>

    <!-- Notification List -->
    <div class="space-y-4">
        @forelse($notifications as $notif)
            <a href="{{ $notif->link ? url($notif->link) : '#' }}" class="block {{ $notif->is_read ? 'bg-white opacity-80' : $notif->color }} border-4 border-slate-800 rounded-2xl p-4 {{ $notif->is_read ? 'shadow-cartoon-sm' : 'shadow-cartoon' }} relative transition-all hover:scale-[1.01]">
                @if(!$notif->is_read)
                    <div class="absolute -top-2 -right-2 w-4 h-4 bg-pink-500 rounded-full border-2 border-slate-800 animate-pulse"></div>
                @endif
                <div class="flex gap-3">
                    <div class="w-12 h-12 {{ $notif->is_read ? 'bg-slate-200' : $notif->color }} border-2 border-slate-800 rounded-full flex items-center justify-center text-2xl shrink-0 text-slate-800">
                        <i class="{{ $notif->icon }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-black text-slate-800">{{ $notif->title }}</h4>
                        <p class="text-sm font-bold text-slate-700 leading-tight mb-2">{{ $notif->message }}</p>
                        <p class="text-xs font-black {{ $notif->is_read ? 'text-slate-400' : 'text-slate-600' }}">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-slate-200 border-4 border-slate-800 rounded-full mx-auto flex items-center justify-center text-4xl mb-4 text-slate-400">
                    <i class="ph-duotone ph-bell-slash"></i>
                </div>
                <p class="text-slate-500 font-bold text-lg">Belum ada notifikasi</p>
                <p class="text-slate-400 font-bold text-sm mt-1">Notifikasi akan muncul saat ada aktivitas di kantongmu!</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
