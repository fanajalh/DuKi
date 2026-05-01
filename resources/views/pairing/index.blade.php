@extends('layouts.auth')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[90vh] px-6 pt-12 text-center bg-orange-50">
    
    <div class="w-40 h-40 bg-pink-300 border-4 border-slate-800 rounded-[3rem] shadow-cartoon flex items-center justify-center text-6xl mb-8 animate-bounce relative text-pink-600">
        <i class="ph-fill ph-heart"></i>
        <div class="absolute -right-2 -bottom-2 w-12 h-12 bg-white rounded-full border-4 border-slate-800 flex items-center justify-center text-xl text-slate-800">
            <i class="ph-duotone ph-device-mobile"></i>
        </div>
    </div>

    <h1 class="text-3xl font-black mb-2 text-slate-800">Hubungkan dengan Pasangan!</h1>
    <p class="text-slate-600 font-bold mb-10">Hubungkan akun kalian untuk sinkronisasi tabungan dan pantau target bersama secara real-time.</p>

    <!-- Error/Success Messages -->
    @if(session('error'))
        <div class="w-full bg-pink-100 border-2 border-pink-500 text-pink-700 p-3 rounded-xl mb-4 font-bold">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Container -->
    <div class="w-full bg-white border-4 border-slate-800 rounded-3xl p-6 shadow-cartoon mb-8">
        <form action="{{ url('/pairing') }}" method="POST">
            @csrf
            <label for="pairing_code" class="block text-left text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Masukkan Kode Pasangan</label>
            <input 
                type="text" 
                name="pairing_code"
                id="pairing_code" 
                placeholder="contoh: DUKI-1234" 
                class="w-full bg-slate-100 border-4 border-slate-800 rounded-2xl p-4 text-xl font-black text-center uppercase tracking-widest text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-pink-300 transition-all shadow-cartoon-sm"
                required
            >
            
            <div class="flex items-center my-6">
                <div class="flex-1 border-t-2 border-slate-300"></div>
                <span class="px-4 text-slate-500 font-bold text-sm">ATAU</span>
                <div class="flex-1 border-t-2 border-slate-300"></div>
            </div>

            <button type="submit" class="w-full bg-lime-400 border-4 border-slate-800 rounded-2xl p-4 text-xl font-black text-slate-800 shadow-cartoon hover:bg-lime-300 active:translate-y-1 active:shadow-none transition-all flex justify-center items-center gap-2">
                Hubungkan Akun <i class="ph-bold ph-link"></i>
            </button>
        </form>

        <div class="mt-4 space-y-3">
            <form action="{{ url('/pairing/skip') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-white border-4 border-slate-800 rounded-2xl p-3 text-lg font-black text-slate-800 shadow-cartoon-sm hover:bg-slate-100 active:translate-y-1 active:shadow-none transition-all flex justify-center items-center gap-2">
                    Lewati Dulu <i class="ph-bold ph-arrow-right"></i>
                </button>
            </form>
            
            <form action="{{ url('/pairing/single') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-blue-300 border-4 border-slate-800 rounded-2xl p-3 text-lg font-black text-slate-800 shadow-cartoon-sm hover:bg-blue-400 active:translate-y-1 active:shadow-none transition-all flex justify-center items-center gap-2">
                    Pakai Sendiri (Single Mode) <i class="ph-bold ph-user"></i>
                </button>
            </form>
        </div>
    </div>
    
    <a href="{{ url('/profile') }}" class="mt-6 text-slate-500 font-bold hover:text-pink-500 transition-colors">
        Tampilkan kode pasanganku saja
    </a>
</div>
@endsection
