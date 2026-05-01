@extends('layouts.auth')

@section('title', 'Edit Kantong')

@section('content')
<div class="flex flex-col min-h-screen bg-orange-50 relative pb-12">
    
    <!-- Header -->
    <header class="bg-white border-b-4 border-slate-800 px-6 py-4 flex items-center justify-between sticky top-0 z-50">
        <a href="{{ url('/pockets/'.$pocket->id) }}" class="w-10 h-10 bg-slate-100 border-4 border-slate-800 rounded-xl flex items-center justify-center text-lg shadow-cartoon-sm hover:bg-slate-200 text-slate-800">
            <i class="ph-bold ph-arrow-left"></i>
        </a>
        <h2 class="font-black text-xl text-slate-800">Edit Kantong</h2>
        <div class="w-10 h-10"></div> <!-- Spacer -->
    </header>

    <div class="p-6">
        <div class="w-20 h-20 bg-yellow-300 border-4 border-slate-800 rounded-full mx-auto flex items-center justify-center text-4xl shadow-cartoon mb-6 text-slate-800">
            <i class="ph-duotone ph-pencil-simple"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-800 mb-8 text-center">Ubah Targetmu!</h1>

        <!-- Update Form -->
        <form action="{{ url('/pockets/'.$pocket->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Name Input -->
            <div>
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Nama Kantong</label>
                <input 
                    type="text" 
                    name="name"
                    value="{{ $pocket->name }}"
                    class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition-all shadow-cartoon-sm"
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
                        value="{{ $pocket->target_amount }}"
                        class="w-full bg-white border-4 border-slate-800 rounded-2xl py-4 pl-14 pr-4 text-xl font-black text-slate-800 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition-all shadow-cartoon-sm"
                    >
                </div>
            </div>

            <!-- Deadline -->
            <div>
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Target Waktu</label>
                <input 
                    type="date" 
                    name="deadline"
                    value="{{ $pocket->deadline ? \Carbon\Carbon::parse($pocket->deadline)->format('Y-m-d') : '' }}"
                    class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition-all shadow-cartoon-sm"
                >
            </div>

            <!-- Emoji Selection -->
            <div>
                <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Pilih Ikon</label>
                <div class="flex gap-2 justify-between">
                    @php
                        $icons = [
                            'ph-duotone ph-airplane-tilt' => 'text-blue-500',
                            'ph-duotone ph-guitar' => 'text-red-500',
                            'ph-duotone ph-house' => 'text-emerald-500',
                            'ph-duotone ph-money' => 'text-yellow-500',
                            'ph-duotone ph-crown' => 'text-amber-400'
                        ];
                    @endphp
                    @foreach($icons as $iconClass => $colorClass)
                    <label class="cursor-pointer">
                        <input type="radio" name="icon" value="{{ $iconClass }}" class="peer sr-only" {{ $pocket->icon == $iconClass ? 'checked' : '' }}>
                        <div class="w-14 h-14 bg-white border-4 border-slate-800 rounded-xl flex items-center justify-center text-2xl peer-checked:bg-yellow-300 peer-checked:shadow-cartoon-sm transition-all {{ $colorClass }}">
                            <i class="{{ $iconClass }}"></i>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-yellow-400 border-4 border-slate-800 rounded-2xl p-5 text-xl font-black text-slate-800 shadow-cartoon hover:bg-yellow-300 active:translate-y-1 active:shadow-none transition-all mt-4 flex justify-center items-center gap-2">
                Simpan Perubahan <i class="ph-bold ph-floppy-disk"></i>
            </button>
        </form>

    </div>
</div>
@endsection
