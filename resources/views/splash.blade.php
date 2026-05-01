@extends('layouts.auth')

@section('title', 'DuKi')

@section('content')
<div class="relative flex flex-col items-center justify-center min-h-screen overflow-hidden" style="background: linear-gradient(135deg, #a3e635 0%, #84cc16 40%, #fde68a 100%);">
    
    <!-- Floating decorative blobs -->
    <div class="absolute top-8 left-4 w-20 h-20 bg-pink-400 border-4 border-slate-800 rounded-full opacity-70 animate-bounce" style="animation-delay: 0.3s;"></div>
    <div class="absolute top-16 right-6 w-12 h-12 bg-white border-4 border-slate-800 rounded-full opacity-60 animate-bounce" style="animation-delay: 0.6s;"></div>
    <div class="absolute bottom-24 left-8 w-16 h-16 bg-pink-300 border-4 border-slate-800 rounded-full opacity-60 animate-bounce" style="animation-delay: 0.9s;"></div>
    <div class="absolute bottom-16 right-4 w-10 h-10 bg-yellow-300 border-4 border-slate-800 rounded-full opacity-80 animate-bounce" style="animation-delay: 0.2s;"></div>
    <div class="absolute top-1/3 left-2 w-8 h-8 bg-lime-200 border-4 border-slate-800 rotate-12 rounded-lg opacity-70 animate-pulse"></div>
    <div class="absolute top-1/4 right-2 w-10 h-10 bg-orange-300 border-4 border-slate-800 -rotate-12 rounded-lg opacity-70 animate-pulse" style="animation-delay: 0.5s;"></div>

    <!-- Main Logo Card -->
    <div class="relative z-10 flex flex-col items-center">
        <!-- Logo Container -->
        <div class="relative mb-6">
            <div class="w-36 h-36 bg-pink-400 border-4 border-slate-800 rounded-[2.5rem] shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] flex items-center justify-center text-7xl rotate-3 hover:rotate-6 transition-transform duration-300 text-yellow-200">
                <i class="ph-duotone ph-lemon"></i>
            </div>
            <!-- Small accent -->
            <div class="absolute -top-3 -right-3 w-10 h-10 bg-white border-4 border-slate-800 rounded-full flex items-center justify-center text-lg animate-spin text-pink-500" style="animation-duration: 4s;">
                <i class="ph-fill ph-heart"></i>
            </div>
        </div>

        <!-- App Name -->
        <div class="relative">
            <h1 class="text-7xl font-black text-slate-800 tracking-tighter drop-shadow-lg" style="text-shadow: 4px 4px 0px rgba(30,41,59,0.2);">DuKi</h1>
        </div>
        
        <p class="text-slate-700 font-black text-xl mt-2 tracking-wider uppercase flex items-center gap-2">Duo &amp; Kita <i class="ph-duotone ph-users-three text-pink-600"></i></p>

        <!-- Tagline pill -->
            <p class="text-slate-800 font-black text-sm flex items-center gap-1">Nabung bareng, senyum terus <i class="ph-duotone ph-sparkle text-yellow-500"></i></p>
        </div>

        <!-- Loading dots -->
        <div class="flex gap-2 mt-10">
            <div class="w-3 h-3 bg-slate-800 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
            <div class="w-3 h-3 bg-slate-800 rounded-full animate-bounce" style="animation-delay: 0.15s;"></div>
            <div class="w-3 h-3 bg-slate-800 rounded-full animate-bounce" style="animation-delay: 0.3s;"></div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ url('/onboarding') }}";
        }, 2500);
    </script>
</div>
@endsection
