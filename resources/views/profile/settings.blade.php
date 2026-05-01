@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="p-6 relative min-h-full bg-slate-200 pb-24">
    
    <header class="flex items-center gap-4 mb-8 pt-4">
        <a href="{{ url('/profile') }}" class="w-10 h-10 bg-white border-4 border-slate-800 rounded-xl flex items-center justify-center text-lg shadow-cartoon-sm hover:bg-slate-100 text-slate-800">
            <i class="ph-bold ph-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Pengaturan</h1>
    </header>



    @if($errors->any())
        <div class="w-full bg-pink-100 border-2 border-pink-500 text-pink-700 p-3 rounded-xl mb-4 font-bold">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Section -->
    <div class="bg-white border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8">
        <h2 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2"><i class="ph-duotone ph-user text-blue-500"></i> Ubah Profil</h2>
        <form action="{{ url('/settings/profile') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Nama Kamu</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-slate-100 border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all" required>
            </div>
            <button type="submit" class="w-full bg-lime-400 border-4 border-slate-800 rounded-2xl p-4 font-black text-slate-800 shadow-cartoon hover:bg-lime-300 active:translate-y-1 active:shadow-none transition-all">
                Simpan Nama
            </button>
        </form>
    </div>

    <!-- Security Section -->
    <div class="bg-white border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8">
        <h2 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2"><i class="ph-duotone ph-lock-key text-pink-500"></i> Ubah Kata Sandi</h2>
        <form action="{{ url('/settings/password') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" class="w-full bg-slate-100 border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Kata Sandi Baru</label>
                <input type="password" name="password" class="w-full bg-slate-100 border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" class="w-full bg-slate-100 border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all" required>
            </div>
            <button type="submit" class="w-full bg-blue-400 border-4 border-slate-800 rounded-2xl p-4 font-black text-white shadow-cartoon hover:bg-blue-500 active:translate-y-1 active:shadow-none transition-all">
                Perbarui Kata Sandi
            </button>
        </form>
    </div>

    <!-- Mode Toggle Section -->
    <div class="bg-white border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8">
        <h2 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2">
            <i class="ph-duotone ph-swap text-purple-500"></i> Mode Aplikasi
        </h2>
        
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="font-black text-slate-800">Status Saat Ini:</p>
                @if($user->is_single_mode)
                    <span class="inline-flex items-center gap-1 bg-blue-100 border-2 border-blue-400 text-blue-700 rounded-full px-3 py-1 text-sm font-black">
                        <i class="ph-bold ph-user"></i> Mode Tunggal
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 bg-pink-100 border-2 border-pink-400 text-pink-700 rounded-full px-3 py-1 text-sm font-black">
                        <i class="ph-bold ph-users"></i> Mode Pasangan
                    </span>
                @endif
            </div>
        </div>

        @if($user->is_single_mode)
            <p class="text-sm font-bold text-slate-600 mb-4">Kamu sedang dalam Mode Tunggal. Beralih ke Mode Pasangan agar bisa menghubungkan akun dengan orang lain dan berbagi kantong.</p>
            <form action="{{ url('/settings/toggle-mode') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-pink-400 border-4 border-slate-800 rounded-2xl p-4 font-black text-slate-800 shadow-cartoon hover:bg-pink-300 active:translate-y-1 active:shadow-none transition-all flex justify-center items-center gap-2">
                    <i class="ph-bold ph-users"></i> Beralih ke Mode Pasangan
                </button>
            </form>
        @else
            <p class="text-sm font-bold text-slate-600 mb-4">Kamu sedang dalam Mode Pasangan. Jika beralih ke Mode Tunggal, koneksi pairing akan <strong>otomatis terputus</strong>.</p>
            <form id="toggle-mode-form" action="{{ url('/settings/toggle-mode') }}" method="POST">
                @csrf
                <button type="button" onclick="swalConfirm('toggle-mode-form', 'Ganti Mode? 🔄', 'Jika kamu sudah dipasangkan, koneksi dengan pasangan akan diputus otomatis. Yakin mau lanjut?')" class="w-full bg-blue-400 border-4 border-slate-800 rounded-2xl p-4 font-black text-white shadow-cartoon hover:bg-blue-500 active:translate-y-1 active:shadow-none transition-all flex justify-center items-center gap-2">
                    <i class="ph-bold ph-user"></i> Beralih ke Mode Tunggal
                </button>
            </form>
        @endif
    </div>

    <!-- Danger Zone Section -->
    <div class="bg-pink-100 border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8">
        <h2 class="text-xl font-black text-red-600 mb-4 flex items-center gap-2"><i class="ph-duotone ph-warning-circle"></i> Zona Bahaya</h2>
        <p class="text-sm font-bold text-slate-700 mb-4">Putuskan akunmu dari pasangan. Kalian tidak akan lagi berbagi kantong.</p>
        <form id="unpair-form" action="{{ url('/settings/unpair') }}" method="POST">
            @csrf
            <button type="button" onclick="swalConfirm('unpair-form', 'Putus Akun? 💔', 'Yakin mau memutus akun dengan pasangan? Kalian tidak akan lagi berbagi kantong.')" class="w-full bg-slate-800 border-4 border-slate-800 rounded-2xl p-4 font-black text-white shadow-cartoon hover:bg-slate-700 active:translate-y-1 active:shadow-none transition-all">
                Putuskan Akun
            </button>
        </form>
    </div>

    <!-- Install & Share Section -->
    <div class="bg-lime-100 border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8">
        <h2 class="text-xl font-black text-slate-800 mb-2 flex items-center gap-2"><i class="ph-duotone ph-device-mobile text-lime-600"></i> Pasang Aplikasi</h2>
        <p class="text-sm font-bold text-slate-600 mb-4">Install DuKi di HP-mu biar bisa akses langsung tanpa buka browser!</p>
        <div class="flex gap-3">
            <a href="{{ asset('duki.apk') }}" download class="flex-1 bg-lime-400 border-4 border-slate-800 rounded-2xl p-3 font-black text-slate-800 shadow-cartoon hover:bg-lime-500 active:translate-y-1 active:shadow-none transition-all flex justify-center items-center gap-2">
                <i class="ph-bold ph-download-simple"></i> Install
            </a>
            <button onclick="shareDuKi()" class="flex-1 bg-pink-300 border-4 border-slate-800 rounded-2xl p-3 font-black text-slate-800 shadow-cartoon hover:bg-pink-400 active:translate-y-1 active:shadow-none transition-all flex justify-center items-center gap-2">
                <i class="ph-bold ph-share-network"></i> Bagikan
            </button>
        </div>
    </div>

</div>
@endsection
