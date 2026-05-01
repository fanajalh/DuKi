@extends('layouts.auth')

@section('title', 'Buat Kantong')

@section('content')
<div class="flex flex-col min-h-screen bg-orange-50 relative pb-12">
    
    <!-- Header -->
    <header class="bg-white border-b-4 border-slate-800 px-6 py-4 flex items-center justify-between sticky top-0 z-50">
        <a href="{{ url('/dashboard') }}" class="w-10 h-10 bg-slate-100 border-4 border-slate-800 rounded-xl flex items-center justify-center text-lg shadow-cartoon-sm hover:bg-slate-200 text-slate-800">
            <i class="ph-bold ph-arrow-left"></i>
        </a>
        <h2 class="font-black text-xl text-slate-800">Kantong Baru</h2>
        <div class="w-10 h-10"></div> <!-- Spacer -->
    </header>

    <div class="p-6">
        <div class="w-20 h-20 bg-lime-300 border-4 border-slate-800 rounded-full mx-auto flex items-center justify-center text-4xl shadow-cartoon mb-6 animate-bounce text-slate-800">
            <i class="ph-duotone ph-backpack"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-800 mb-2 text-center">Buat Target!</h1>
        <p class="text-slate-600 font-bold mb-8 text-center">Kamu dan pasangan mau nabung untuk apa?</p>

        <!-- Create Form -->
        <form action="{{ url('/pockets') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Name Input -->
            <div>
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Nama Kantong</label>
                <input 
                    type="text" 
                    name="name"
                    placeholder="contoh: Liburan" 
                    class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all shadow-cartoon-sm"
                    required
                >
            </div>

            <!-- Target Amount -->
            <div>
                <div class="flex justify-between items-end mb-2">
                    <label class="block text-sm font-black text-slate-800 uppercase tracking-wider">Target Tabungan (Rp)</label>
                    <span class="text-xs font-bold text-slate-500 bg-white border-2 border-slate-300 rounded px-2">Opsional</span>
                </div>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl font-black text-slate-800">Rp</span>
                    <input 
                        type="number" 
                        name="target_amount"
                        placeholder="10000000" 
                        class="w-full bg-white border-4 border-slate-800 rounded-2xl py-4 pl-14 pr-4 text-xl font-black text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all shadow-cartoon-sm"
                    >
                </div>
                <p class="text-xs font-bold text-slate-500 mt-2 flex items-center gap-1"><i class="ph-fill ph-info"></i> Biarkan kosong untuk nabung tanpa target!</p>
            </div>

            <!-- Deadline -->
            <div>
                <div class="flex justify-between items-end mb-2">
                    <label class="block text-sm font-black text-slate-800 uppercase tracking-wider">Target Waktu</label>
                    <span class="text-xs font-bold text-slate-500 bg-white border-2 border-slate-300 rounded px-2">Opsional</span>
                </div>
                <input 
                    type="date" 
                    name="deadline"
                    class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all shadow-cartoon-sm"
                >
            </div>

            <!-- Emoji Selection -->
            <div>
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Pilih Ikon</label>
                <div class="flex gap-2 justify-between">
                    <label class="cursor-pointer">
                        <input type="radio" name="icon" value="ph-duotone ph-airplane-tilt" class="peer sr-only" checked>
                        <div class="w-14 h-14 bg-white border-4 border-slate-800 rounded-xl flex items-center justify-center text-2xl peer-checked:bg-lime-300 peer-checked:shadow-cartoon-sm transition-all text-blue-500"><i class="ph-duotone ph-airplane-tilt"></i></div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="icon" value="ph-duotone ph-guitar" class="peer sr-only">
                        <div class="w-14 h-14 bg-white border-4 border-slate-800 rounded-xl flex items-center justify-center text-2xl peer-checked:bg-lime-300 peer-checked:shadow-cartoon-sm transition-all text-red-500"><i class="ph-duotone ph-guitar"></i></div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="icon" value="ph-duotone ph-house" class="peer sr-only">
                        <div class="w-14 h-14 bg-white border-4 border-slate-800 rounded-xl flex items-center justify-center text-2xl peer-checked:bg-lime-300 peer-checked:shadow-cartoon-sm transition-all text-emerald-500"><i class="ph-duotone ph-house"></i></div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="icon" value="ph-duotone ph-money" class="peer sr-only">
                        <div class="w-14 h-14 bg-white border-4 border-slate-800 rounded-xl flex items-center justify-center text-2xl peer-checked:bg-lime-300 peer-checked:shadow-cartoon-sm transition-all text-yellow-500"><i class="ph-duotone ph-money"></i></div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="icon" value="ph-duotone ph-crown" class="peer sr-only">
                        <div class="w-14 h-14 bg-white border-4 border-slate-800 rounded-xl flex items-center justify-center text-2xl peer-checked:bg-lime-300 peer-checked:shadow-cartoon-sm transition-all text-amber-400"><i class="ph-duotone ph-crown"></i></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-pink-400 border-4 border-slate-800 rounded-2xl p-5 text-xl font-black text-slate-800 shadow-cartoon hover:bg-pink-300 active:translate-y-1 active:shadow-none transition-all mt-4 flex justify-center items-center gap-2">
                Buat Kantong <i class="ph-duotone ph-sparkle"></i>
            </button>
        </form>

    </div>
</div>
@endsection
