@extends('layouts.auth')

@section('title', 'Nabung ke Kantong')

@section('content')
<div class="flex flex-col min-h-screen bg-slate-900/60 justify-end items-center backdrop-blur-sm relative">
    
    <a href="{{ url('/dashboard') }}" class="absolute top-6 right-6 w-12 h-12 bg-white border-4 border-slate-800 rounded-full flex items-center justify-center text-xl shadow-cartoon hover:bg-slate-100 text-slate-800">
        <i class="ph-bold ph-x"></i>
    </a>

    <div class="w-full md:max-w-[400px] bg-orange-50 md:border-x-4 border-t-4 border-slate-800 rounded-t-[2.5rem] p-6 shadow-[0px_-8px_0px_0px_rgba(30,41,59,1)] animate-[slideUp_0.3s_ease-out]">
        <div class="w-16 h-2 bg-slate-800 rounded-full mx-auto mb-6"></div>
        <h2 class="text-2xl font-black text-slate-800 mb-6 text-center flex items-center justify-center gap-2">Nabung ke Kantong <i class="ph-duotone ph-piggy-bank text-pink-500"></i></h2>

        <form action="{{ url('/deposit') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Jumlah (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl font-black text-slate-800">Rp</span>
                    <input 
                        type="number" 
                        name="amount"
                        placeholder="0" 
                        class="w-full bg-white border-4 border-slate-800 rounded-2xl py-4 pl-14 pr-4 text-2xl font-black text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all shadow-cartoon-sm"
                        required
                    >
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Pilih Kantong</label>
                <select name="pocket_id" class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-black text-slate-800 focus:outline-none focus:ring-4 focus:ring-lime-300 shadow-cartoon-sm appearance-none">
                    @foreach($pockets as $pocket)
                        <option value="{{ $pocket->id }}" {{ $pocket_id == $pocket->id ? 'selected' : '' }}>{{ $pocket->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Beri Reaksi!</label>
                <div class="flex justify-between gap-2">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="emoji" value="ph-duotone ph-heart" class="peer sr-only" checked>
                        <div class="bg-white border-4 border-slate-800 rounded-2xl py-3 text-3xl shadow-cartoon-sm peer-checked:bg-lime-300 peer-checked:scale-110 peer-checked:rotate-3 text-center transition-all text-pink-500"><i class="ph-duotone ph-heart"></i></div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="emoji" value="ph-duotone ph-confetti" class="peer sr-only">
                        <div class="bg-white border-4 border-slate-800 rounded-2xl py-3 text-3xl shadow-cartoon-sm peer-checked:bg-lime-300 peer-checked:scale-110 peer-checked:rotate-3 text-center transition-all text-yellow-500"><i class="ph-duotone ph-confetti"></i></div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="emoji" value="ph-duotone ph-fire" class="peer sr-only">
                        <div class="bg-white border-4 border-slate-800 rounded-2xl py-3 text-3xl shadow-cartoon-sm peer-checked:bg-lime-300 peer-checked:scale-110 peer-checked:rotate-3 text-center transition-all text-orange-500"><i class="ph-duotone ph-fire"></i></div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="emoji" value="ph-duotone ph-star" class="peer sr-only">
                        <div class="bg-white border-4 border-slate-800 rounded-2xl py-3 text-3xl shadow-cartoon-sm peer-checked:bg-lime-300 peer-checked:scale-110 peer-checked:rotate-3 text-center transition-all text-yellow-400"><i class="ph-fill ph-star"></i></div>
                    </label>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Pesan (Opsional)</label>
                <input 
                    type="text" 
                    name="message"
                    placeholder="contoh: Sisa uang jajan" 
                    class="w-full bg-white border-4 border-slate-800 rounded-2xl p-3 text-md font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all shadow-cartoon-sm"
                >
            </div>

            <button type="submit" class="w-full bg-lime-400 border-4 border-slate-800 rounded-2xl p-5 text-xl font-black text-slate-800 shadow-cartoon hover:bg-lime-300 active:translate-y-1 active:shadow-none transition-all flex justify-center items-center gap-2">
                Simpan! <i class="ph-duotone ph-money"></i>
            </button>
        </form>
    </div>
</div>
@endsection
