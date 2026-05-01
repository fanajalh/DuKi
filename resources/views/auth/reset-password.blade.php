@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="flex flex-col min-h-screen px-6 py-12 bg-orange-50">
    
    <h1 class="text-4xl font-black text-slate-800 mb-2 flex items-center gap-2">New Password <i class="ph-duotone ph-key text-blue-600"></i></h1>
    <p class="text-slate-600 font-bold mb-10">OTP verified successfully. Please create a new password for {{ session('reset_email') }}.</p>

    <form class="space-y-6" action="{{ url('/reset-password') }}" method="POST">
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

        <div>
            <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">New Password</label>
            <input 
                name="password"
                type="password" 
                placeholder="••••••••" 
                class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all shadow-cartoon-sm"
                required
            >
        </div>

        <div>
            <label class="block text-sm font-black mb-2 text-slate-800 uppercase tracking-wider">Confirm Password</label>
            <input 
                name="password_confirmation"
                type="password" 
                placeholder="••••••••" 
                class="w-full bg-white border-4 border-slate-800 rounded-2xl p-4 text-lg font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-lime-300 transition-all shadow-cartoon-sm"
                required
            >
        </div>

        <button type="submit" class="w-full bg-blue-400 border-4 border-slate-800 rounded-2xl p-5 text-xl font-black text-white shadow-cartoon hover:bg-blue-500 active:translate-y-1 active:shadow-none transition-all mt-4 flex items-center justify-center gap-2">
            Reset Password <i class="ph-bold ph-check-circle"></i>
        </button>
    </form>

</div>
@endsection
