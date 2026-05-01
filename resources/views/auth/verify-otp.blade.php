@extends('layouts.auth')

@section('title', 'Verify OTP')

@section('content')
<div class="flex flex-col min-h-screen px-6 py-12 bg-orange-50">
    
    <!-- Back Button -->
    <a href="{{ url('/forgot-password') }}" class="w-12 h-12 bg-white border-4 border-slate-800 rounded-2xl flex items-center justify-center text-xl shadow-cartoon mb-8 hover:bg-slate-100 transition-colors text-slate-800">
        <i class="ph-bold ph-arrow-left"></i>
    </a>

    <h1 class="text-4xl font-black text-slate-800 mb-2 flex items-center gap-2">Enter OTP <i class="ph-duotone ph-lock-key text-lime-600"></i></h1>
    <p class="text-slate-600 font-bold mb-10">We've sent a 6-digit code to {{ session('reset_email') }}.</p>

    <form class="space-y-6" action="{{ url('/verify-otp') }}" method="POST">
        @csrf
        
        @if(session('success'))
            <div class="w-full bg-lime-100 border-2 border-lime-500 text-lime-700 p-3 rounded-xl mb-4 font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="w-full bg-pink-100 border-2 border-pink-500 text-pink-700 p-3 rounded-xl mb-4 font-bold">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider text-center">6-Digit Code</label>
            <input 
                name="otp"
                type="text" 
                maxlength="6"
                placeholder="000000" 
                class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-3xl tracking-[1em] font-black text-center text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all shadow-cartoon-sm"
                required
            >
        </div>

        <button type="submit" class="w-full bg-lime-400 border-4 border-slate-800 rounded-2xl p-5 text-xl font-black text-slate-800 shadow-cartoon hover:bg-lime-300 active:translate-y-1 active:shadow-none transition-all mt-4 flex items-center justify-center gap-2">
            Verify <i class="ph-bold ph-check"></i>
        </button>
    </form>

</div>
@endsection
