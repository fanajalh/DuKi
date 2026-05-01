@extends('layouts.auth')

@section('content')
<div class="flex flex-col min-h-screen px-6 py-12 bg-orange-50">
    
    <!-- Back Button -->
    <a href="{{ url('/login') }}" class="w-12 h-12 bg-white border-4 border-slate-800 rounded-2xl flex items-center justify-center text-xl shadow-cartoon mb-8 hover:bg-slate-100 transition-colors text-slate-800">
        <i class="ph-bold ph-arrow-left"></i>
    </a>

    <h1 class="text-4xl font-black text-slate-800 mb-2 flex items-center gap-2">Lupa Kata Sandi? <i class="ph-duotone ph-smiley-sad text-lime-600"></i></h1>
    <p class="text-slate-600 font-bold mb-10">Jangan khawatir! Masukkan emailmu dan kami akan mengirim link pemulihan.</p>

    <!-- Forgot Password Form -->
    <form class="space-y-6" action="{{ url('/forgot-password') }}" method="POST">
        @csrf
        
        @if($errors->any())
            <div class="w-full bg-pink-100 border-2 border-pink-500 text-pink-700 p-3 rounded-xl mb-4 font-bold">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Email Input -->
        <div>
            <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Alamat Email</label>
            <input 
                name="email"
                type="email" 
                placeholder="kamu@contoh.com" 
                class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all shadow-cartoon-sm"
                required
            >
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-lime-400 border-4 border-slate-800 rounded-2xl p-5 text-xl font-black text-slate-800 shadow-cartoon hover:bg-lime-300 active:translate-y-1 active:shadow-none transition-all mt-4 flex items-center justify-center gap-2">
            Kirim Link <i class="ph-duotone ph-paper-plane-right"></i>
        </button>
    </form>

</div>
@endsection
