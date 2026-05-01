<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DuKi - @yield('title', 'Duo & Kita')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="shortcut icon" href="{{ asset('icons/icon-192x192.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                    },
                    boxShadow: {
                        'cartoon': '4px 4px 0px 0px rgba(30,41,59,1)',
                        'cartoon-sm': '2px 2px 0px 0px rgba(30,41,59,1)',
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#a3e635">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <style>
        /* Mobile: classic phone look */
        @media (max-width: 768px) {
            .desktop-sidebar { display: none !important; }
            .desktop-topbar { display: none !important; }
            .app-wrapper { width: 100%; max-width: 100%; border-left: 4px solid #1e293b; border-right: 4px solid #1e293b; box-shadow: none !important; }
            .mobile-nav { display: flex !important; border-radius: 28px !important; }
        }
        /* Desktop: full layout */
        @media (min-width: 769px) {
            .app-wrapper { max-width: 100%; border: none; box-shadow: none; }
            .mobile-nav { display: none !important; }
        }
        /* ===== PIG LOADING ===== */
        .pig-bounce { animation: pigBounce 0.8s ease-in-out infinite alternate; }
        .pig-body   { position: relative; width: 120px; height: 120px; }
        .pig-ear    { position: absolute; width: 36px; height: 36px; background: #f9a8d4; border: 4px solid #1e293b; border-radius: 50% 50% 50% 20% / 50% 50% 20% 50%; top: 4px; z-index: 0; }
        .pig-ear-left  { left: 4px;  transform: rotate(-30deg); }
        .pig-ear-right { right: 4px; transform: rotate(30deg) scaleX(-1); }
        .pig-head   { position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 110px; height: 100px; background: #fda4af; border: 4px solid #1e293b; border-radius: 55% 55% 50% 50% / 60% 60% 50% 50%; z-index: 1; }
        .pig-eye    { position: absolute; top: 28px; width: 14px; height: 17px; background: #1e293b; border-radius: 50%; animation: pigBlink 3s ease-in-out infinite; }
        .pig-eye-left  { left: 22px; }
        .pig-eye-right { right: 22px; }
        .pig-eye::after { content: ''; position: absolute; top: 3px; left: 3px; width: 5px; height: 5px; background: white; border-radius: 50%; }
        .pig-snout  { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); width: 44px; height: 32px; background: #fb7185; border: 3px solid #1e293b; border-radius: 50%; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .pig-nostril{ width: 9px; height: 11px; background: #be123c; border-radius: 50%; border: 2px solid #1e293b; }
        .pig-blush  { position: absolute; bottom: 32px; width: 18px; height: 10px; background: #fb7185; border-radius: 50%; opacity: 0.6; }
        .pig-blush-left  { left: 10px; }
        .pig-blush-right { right: 10px; }
        .pig-dot    { width: 10px; height: 10px; background: white; border-radius: 50%; animation: pigDotPulse 1.2s ease-in-out infinite; }
        .pig-dot-1  { animation-delay: 0s;   }
        .pig-dot-2  { animation-delay: 0.2s; }
        .pig-dot-3  { animation-delay: 0.4s; }
        .pig-coin   { font-size: 20px; animation: pigCoinFall 1.5s ease-in-out infinite; }
        .pig-coin-1 { animation-delay: 0s;   }
        .pig-coin-2 { animation-delay: 0.3s; }
        .pig-coin-3 { animation-delay: 0.6s; }
        @keyframes pigBounce   { from { transform: translateY(0px); } to { transform: translateY(-12px); } }
        @keyframes pigBlink    { 0%,92%,100% { transform: scaleY(1); } 96% { transform: scaleY(0.05); } }
        @keyframes pigDotPulse { 0%,100% { opacity:.3; transform:scale(.8); } 50% { opacity:1; transform:scale(1.2); } }
        @keyframes pigCoinFall { 0% { transform:translateY(-20px); opacity:0; } 30%,70% { opacity:1; } 100% { transform:translateY(20px); opacity:0; } }
    </style>

</head>
<body class="bg-slate-200 min-h-screen text-slate-800 selection:bg-pink-300 selection:text-slate-900 font-sans" style="overscroll-behavior-y: contain;">

    <!-- 🐷 PULL TO REFRESH - floating pig only -->
    <div id="ptr-wrap" class="fixed top-0 inset-x-0 z-[99998] flex justify-center" style="pointer-events:none; transform:translateY(-80px); transition:none;">
        <div id="ptr-pig-wrap" style="font-size:72px; line-height:1; display:inline-block; transition: transform 0.15s ease; filter: drop-shadow(0 6px 8px rgba(0,0,0,0.25));">🐷</div>
    </div>

    <div class="hidden md:flex min-h-screen">


        <!-- Sidebar -->
        <aside class="desktop-sidebar w-72 bg-orange-50 border-r-4 border-slate-800 flex flex-col min-h-screen sticky top-0 h-screen">
            <!-- Logo -->
            <div class="p-6 border-b-4 border-slate-800">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                    <span class="w-12 h-12 bg-pink-400 border-4 border-slate-800 rounded-2xl flex items-center justify-center text-xl shadow-cartoon-sm text-white">
                        <i class="ph-duotone ph-piggy-bank"></i>
                    </span>
                    DuKi
                </h1>
                <p class="text-xs font-bold text-slate-500 mt-1 ml-14">Nabung Bareng, Senyum Terus!</p>
            </div>

            <!-- Nav Items -->
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl border-4 font-black text-lg transition-all hover:-translate-y-0.5 {{ request()->is('dashboard') ? 'bg-lime-300 border-slate-800 shadow-cartoon-sm text-slate-800' : 'bg-transparent border-transparent text-slate-500 hover:bg-white hover:border-slate-800' }}">
                    <i class="ph-duotone ph-house text-2xl"></i>
                    Beranda
                </a>
                <a href="{{ url('/pockets/create') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl border-4 font-black text-lg transition-all hover:-translate-y-0.5 {{ request()->is('pockets/create') ? 'bg-lime-300 border-slate-800 shadow-cartoon-sm text-slate-800' : 'bg-transparent border-transparent text-slate-500 hover:bg-white hover:border-slate-800' }}">
                    <i class="ph-duotone ph-plus-circle text-2xl"></i>
                    Kantong Baru
                </a>
                <a href="{{ url('/notifications') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl border-4 font-black text-lg transition-all hover:-translate-y-0.5 relative {{ request()->is('notifications') ? 'bg-lime-300 border-slate-800 shadow-cartoon-sm text-slate-800' : 'bg-transparent border-transparent text-slate-500 hover:bg-white hover:border-slate-800' }}">
                    <i class="ph-duotone ph-bell text-2xl"></i>
                    Notifikasi
                    @php $sidebarUnread = \App\Http\Controllers\NotificationController::unreadCount(); @endphp
                    @if($sidebarUnread > 0)
                        <span class="ml-auto w-6 h-6 bg-pink-500 border-2 border-slate-800 rounded-full text-xs font-black text-white flex items-center justify-center">{{ $sidebarUnread > 9 ? '9+' : $sidebarUnread }}</span>
                    @endif
                </a>
                <a href="{{ url('/profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl border-4 font-black text-lg transition-all hover:-translate-y-0.5 {{ request()->is('profile') ? 'bg-pink-300 border-slate-800 shadow-cartoon-sm text-slate-800' : 'bg-transparent border-transparent text-slate-500 hover:bg-white hover:border-slate-800' }}">
                    <i class="ph-duotone ph-user text-2xl"></i>
                    Profil
                </a>
                <a href="{{ url('/settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl border-4 font-black text-lg transition-all hover:-translate-y-0.5 {{ request()->is('settings') ? 'bg-pink-300 border-slate-800 shadow-cartoon-sm text-slate-800' : 'bg-transparent border-transparent text-slate-500 hover:bg-white hover:border-slate-800' }}">
                    <i class="ph-duotone ph-gear text-2xl"></i>
                    Pengaturan
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t-4 border-slate-800">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 {{ Auth::user()->gender == 'female' ? 'bg-pink-300' : 'bg-blue-300' }} border-4 border-slate-800 rounded-full flex items-center justify-center text-lg text-slate-800">
                        <i class="ph-duotone ph-gender-{{ Auth::user()->gender == 'female' ? 'female' : 'male' }}"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 text-sm leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-xs font-bold text-slate-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-slate-800 border-4 border-slate-800 rounded-2xl py-2 text-sm font-black text-white shadow-cartoon-sm hover:bg-slate-700 active:translate-y-1 transition-all">
                        Keluar <i class="ph-bold ph-sign-out"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area (Desktop) -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Top Bar -->
            <header class="desktop-topbar bg-white border-b-4 border-slate-800 px-8 py-4 flex items-center justify-between sticky top-0 z-40">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-black text-slate-800">@yield('title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ url('/notifications') }}" class="w-10 h-10 bg-orange-100 border-4 border-slate-800 rounded-xl flex items-center justify-center text-lg shadow-cartoon-sm hover:bg-orange-200 text-slate-800 relative">
                        <i class="ph-duotone ph-bell"></i>
                    </a>
                    <a href="{{ url('/profile') }}" class="w-10 h-10 {{ Auth::user()->gender == 'female' ? 'bg-pink-300' : 'bg-blue-300' }} border-4 border-slate-800 rounded-xl flex items-center justify-center text-lg shadow-cartoon-sm text-slate-800">
                        <i class="ph-duotone ph-user"></i>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8 bg-slate-100">
                <div class="max-w-3xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- MOBILE LAYOUT (hidden on desktop) -->
    <div class="md:hidden flex justify-center min-h-screen">
        <div class="app-wrapper w-full max-w-[400px] min-h-screen bg-orange-50 relative overflow-x-hidden flex flex-col shadow-2xl">
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto pb-32">
                @yield('content')
            </main>

            <!-- Bottom Navigation Bar (Mobile only) -->
            <nav class="mobile-nav fixed bottom-4 w-[calc(100%-24px)] left-3 max-w-[376px] bg-white/95 backdrop-blur-md border-4 border-slate-800 px-3 py-2.5 flex justify-around items-end z-50" style="border-radius: 28px; box-shadow: 0px 4px 0px 0px rgba(30,41,59,1);">
                
                {{-- Beranda --}}
                <a href="{{ url('/dashboard') }}" class="flex flex-col items-center gap-1 group w-16">
                    <div class="w-12 h-10 rounded-2xl flex items-center justify-center text-[24px] transition-all duration-200 {{ request()->is('dashboard') ? 'bg-lime-400 text-slate-800 border-2 border-slate-800' : 'text-slate-400 group-hover:text-slate-600 group-hover:bg-slate-100' }}">
                        <i class="ph-{{ request()->is('dashboard') ? 'fill' : 'duotone' }} ph-house"></i>
                    </div>
                    <span class="text-[10px] font-extrabold {{ request()->is('dashboard') ? 'text-slate-800' : 'text-slate-400' }}">Beranda</span>
                </a>

                {{-- Notif --}}
                <a href="{{ url('/notifications') }}" class="flex flex-col items-center gap-1 group w-16 relative">
                    <div class="w-12 h-10 rounded-2xl flex items-center justify-center text-[24px] transition-all duration-200 {{ request()->is('notifications') ? 'bg-yellow-300 text-slate-800 border-2 border-slate-800' : 'text-slate-400 group-hover:text-slate-600 group-hover:bg-slate-100' }}">
                        <i class="ph-{{ request()->is('notifications') ? 'fill' : 'duotone' }} ph-bell"></i>
                    </div>
                    @php $unreadCount = \App\Http\Controllers\NotificationController::unreadCount(); @endphp
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 right-2 min-w-[18px] h-[18px] bg-pink-500 border-2 border-white rounded-full text-[9px] font-black text-white flex items-center justify-center px-1 animate-pulse">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                    <span class="text-[10px] font-extrabold {{ request()->is('notifications') ? 'text-slate-800' : 'text-slate-400' }}">Notif</span>
                </a>

                {{-- FAB - Tambah Kantong --}}
                <a href="{{ url('/pockets/create') }}" class="flex flex-col items-center -mt-6 group relative z-10">
                    <div class="w-[52px] h-[52px] rounded-full border-4 border-slate-800 flex items-center justify-center text-[24px] font-black transition-all duration-200 text-slate-800 group-hover:-translate-y-1 group-active:translate-y-0 shadow-[0px_4px_0px_0px_rgba(30,41,59,1)] group-active:shadow-none" style="background: linear-gradient(135deg, #bef264, #84cc16);">
                        <i class="ph-bold ph-plus"></i>
                    </div>
                    <span class="text-[10px] font-extrabold text-lime-600 mt-1.5">Baru</span>
                </a>

                {{-- Kantong --}}
                <a href="{{ url('/dashboard') }}#kantong" class="flex flex-col items-center gap-1 group w-16">
                    <div class="w-12 h-10 rounded-2xl flex items-center justify-center text-[24px] transition-all duration-200 text-slate-400 group-hover:text-slate-600 group-hover:bg-slate-100">
                        <i class="ph-duotone ph-wallet"></i>
                    </div>
                    <span class="text-[10px] font-extrabold text-slate-400">Kantong</span>
                </a>

                {{-- Profil --}}
                <a href="{{ url('/profile') }}" class="flex flex-col items-center gap-1 group w-16">
                    <div class="w-12 h-10 rounded-2xl flex items-center justify-center text-[24px] transition-all duration-200 {{ request()->is('profile') || request()->is('settings') ? 'bg-pink-300 text-slate-800 border-2 border-slate-800' : 'text-slate-400 group-hover:text-slate-600 group-hover:bg-slate-100' }}">
                        <i class="ph-{{ request()->is('profile') || request()->is('settings') ? 'fill' : 'duotone' }} ph-user-circle"></i>
                    </div>
                    <span class="text-[10px] font-extrabold {{ request()->is('profile') || request()->is('settings') ? 'text-slate-800' : 'text-slate-400' }}">Profil</span>
                </a>

            </nav>
        </div>
    </div>

    @include('components.chatbot')

    <script>
    // Global SweetAlert for session flash messages
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil! 🎉',
            text: '{{ session("success") }}',
            confirmButtonText: 'Oke!',
            confirmButtonColor: '#a3e635',
            background: '#fffbeb',
            color: '#1e293b',
            customClass: { popup: 'rounded-3xl border-4 border-slate-800', confirmButton: 'font-black text-slate-800' }
        });
    @endif
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops! 😵',
            text: '{{ session("error") }}',
            confirmButtonText: 'Oke deh',
            confirmButtonColor: '#f472b6',
            background: '#fffbeb',
            color: '#1e293b',
            customClass: { popup: 'rounded-3xl border-4 border-slate-800', confirmButton: 'font-black text-white' }
        });
    @endif
    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Info 📢',
            text: '{{ session("info") }}',
            confirmButtonText: 'Oke!',
            confirmButtonColor: '#fbbf24',
            background: '#fffbeb',
            color: '#1e293b',
            customClass: { popup: 'rounded-3xl border-4 border-slate-800', confirmButton: 'font-black text-slate-800' }
        });
    @endif

    // Global SweetAlert confirm function
    function swalConfirm(formId, title, text) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f472b6',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Lanjut!',
            cancelButtonText: 'Batal',
            background: '#fffbeb',
            color: '#1e293b',
            customClass: { popup: 'rounded-3xl border-4 border-slate-800', confirmButton: 'font-black', cancelButton: 'font-black' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    function showPigLoader() {
        var el = document.getElementById('pig-loading-global') || document.getElementById('pig-loading');
        if (el) el.classList.remove('hidden');
    }

    // Reset PTR on bfcache (back/forward)
    window.addEventListener('pageshow', function(e) {
        var ptr = document.getElementById('ptr-wrap');
        var pig = document.getElementById('ptr-pig-wrap');
        if (ptr) { ptr.style.transition = 'none'; ptr.style.transform = 'translateY(-80px)'; }
        if (pig) pig.style.transform = 'scale(1) rotate(0deg)';
    });

    // ===== CUSTOM PULL-TO-REFRESH =====
    (function() {
        var ptrWrap = document.getElementById('ptr-wrap');
        var ptrPig  = document.getElementById('ptr-pig-wrap');
        if (!ptrWrap) return;

        var startY = 0, currentY = 0;
        var isPulling = false, isRefreshing = false;
        var THRESHOLD = 90, MAX_PULL = 110;

        function snapBack() {
            ptrWrap.style.transition = 'transform 0.4s cubic-bezier(0.34,1.56,0.64,1)';
            ptrWrap.style.transform  = 'translateY(-80px)';
            if (ptrPig) ptrPig.style.transform = 'scale(1) rotate(0deg)';
        }

        document.addEventListener('touchstart', function(e) {
            if (isRefreshing) return;
            if (window.scrollY <= 0) {
                startY = currentY = e.touches[0].pageY;
                isPulling = true;
                ptrWrap.style.transition = 'none';
            }
        }, { passive: true });

        document.addEventListener('touchmove', function(e) {
            if (!isPulling || isRefreshing) return;
            currentY = e.touches[0].pageY;
            var dy = Math.max(0, currentY - startY);
            if (dy <= 0) { isPulling = false; return; }
            if (window.scrollY > 2) { isPulling = false; snapBack(); return; }

            // Blokir native Chrome pull-to-refresh
            if (e.cancelable) e.preventDefault();

            var pull = Math.min(dy * 0.55, MAX_PULL);
            var prog = Math.min(dy / THRESHOLD, 1);

            ptrWrap.style.transform = 'translateY(' + (pull - 80) + 'px)';

            // Pig animasi: makin ditarik makin besar + miring
            if (ptrPig) ptrPig.style.transform = 'scale(' + (1 + prog * 0.4) + ') rotate(' + (prog * -20) + 'deg)';
        }, { passive: false });

        document.addEventListener('touchend', function(e) {
            if (!isPulling || isRefreshing) return;
            isPulling = false;
            var dy = currentY - startY;
            if (dy >= THRESHOLD && window.scrollY <= 2) {
                isRefreshing = true;
                // Pig senang sebelum reload
                ptrWrap.style.transition = 'transform 0.15s ease';
                ptrWrap.style.transform  = 'translateY(-10px)';
                if (ptrPig) ptrPig.style.transform = 'scale(1.5) rotate(10deg)';
                setTimeout(function() { window.location.reload(); }, 450);
            } else {
                snapBack();
            }
            currentY = 0;
        }, { passive: true });
    })();
    </script>





    <!-- PWA Install Banner -->
    <div id="pwa-install-banner" class="fixed bottom-24 md:bottom-6 left-1/2 -translate-x-1/2 z-[9999] w-[360px] max-w-[92vw] hidden" style="animation: slideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);">
        <div class="bg-white border-4 border-slate-800 rounded-3xl p-4 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] relative">
            <!-- Close button -->
            <button onclick="dismissInstallBanner()" class="absolute -top-3 -right-3 w-8 h-8 bg-slate-800 rounded-full flex items-center justify-center text-white text-sm font-black border-2 border-white hover:bg-slate-700 transition-colors">
                <i class="ph-bold ph-x"></i>
            </button>
            
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 bg-lime-400 border-3 border-slate-800 rounded-2xl flex items-center justify-center text-2xl text-white flex-shrink-0" style="border-width: 3px;">
                    <i class="ph-duotone ph-piggy-bank"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 text-sm leading-tight">Install DuKi App! 🐷</h3>
                    <p class="text-[11px] font-bold text-slate-500">Akses lebih cepat tanpa buka browser</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ asset('duki.apk') }}" download id="pwa-install-btn" class="flex-1 bg-lime-400 border-3 border-slate-800 rounded-xl py-2.5 font-black text-sm text-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-0.5 hover:shadow-[2px_4px_0px_0px_rgba(30,41,59,1)] active:translate-y-0 active:shadow-none transition-all flex items-center justify-center gap-1.5" style="border-width: 3px;">
                    <i class="ph-bold ph-download-simple"></i> Install
                </a>
                <button onclick="shareDuKi()" class="flex-1 bg-pink-300 border-3 border-slate-800 rounded-xl py-2.5 font-black text-sm text-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-0.5 hover:shadow-[2px_4px_0px_0px_rgba(30,41,59,1)] active:translate-y-0 active:shadow-none transition-all flex items-center justify-center gap-1.5" style="border-width: 3px;">
                    <i class="ph-bold ph-share-network"></i> Bagikan
                </button>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideUp {
            from { opacity: 0; transform: translate(-50%, 30px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
    </style>

    <script>
    // Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(reg => console.log('SW registered:', reg.scope))
                .catch(err => console.log('SW failed:', err));
        });
    }

    // PWA Install Logic
    let deferredPrompt = null;
    const installBanner = document.getElementById('pwa-install-banner');

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        // Show banner after 2 seconds
        setTimeout(() => {
            if (!localStorage.getItem('pwa-dismissed')) {
                installBanner.classList.remove('hidden');
            }
        }, 2000);
    });

    window.addEventListener('appinstalled', () => {
        installBanner.classList.add('hidden');
        deferredPrompt = null;
        localStorage.setItem('pwa-installed', 'true');
        Swal.fire({
            icon: 'success',
            title: 'DuKi Ter-install! 🎉🐷',
            text: 'Cek home screen HP kamu, DuKi sudah siap!',
            confirmButtonText: 'Yay!',
            confirmButtonColor: '#a3e635',
            background: '#fffbeb',
            color: '#1e293b',
            customClass: { popup: 'rounded-3xl border-4 border-slate-800', confirmButton: 'font-black text-slate-800' }
        });
    });

    function installPWA() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choice) => {
                if (choice.outcome === 'accepted') {
                    console.log('User accepted install');
                }
                deferredPrompt = null;
            });
        } else {
            // Fallback: show instructions
            Swal.fire({
                icon: 'info',
                title: 'Cara Install DuKi 📲',
                html: '<div style="text-align:left; font-weight:700; font-size:14px; line-height:1.8;">' +
                      '<b>Android Chrome:</b><br>Klik ⋮ (titik tiga) → "Install app"<br><br>' +
                      '<b>iPhone Safari:</b><br>Klik <i class="ph-bold ph-export"></i> (share) → "Add to Home Screen"<br><br>' +
                      '<b>Desktop Chrome:</b><br>Klik ikon 📥 di address bar</div>',
                confirmButtonText: 'Oke, paham!',
                confirmButtonColor: '#a3e635',
                background: '#fffbeb',
                color: '#1e293b',
                customClass: { popup: 'rounded-3xl border-4 border-slate-800', confirmButton: 'font-black text-slate-800' }
            });
        }
    }

    function shareDuKi() {
        const shareData = {
            title: 'DuKi - Tabungan Bersama',
            text: 'Yuk nabung bareng pakai DuKi! Aplikasi tabungan seru buat pasangan 🐷💰',
            url: window.location.origin
        };

        if (navigator.share) {
            navigator.share(shareData).catch(() => {});
        } else {
            // Fallback: copy link
            navigator.clipboard.writeText(shareData.url + '\n\n' + shareData.text).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Link Disalin! 📋',
                    text: 'Link DuKi sudah disalin ke clipboard, tinggal paste dan kirim ke pasanganmu!',
                    confirmButtonText: 'Oke!',
                    confirmButtonColor: '#a3e635',
                    background: '#fffbeb',
                    color: '#1e293b',
                    customClass: { popup: 'rounded-3xl border-4 border-slate-800', confirmButton: 'font-black text-slate-800' }
                });
            });
        }
    }

    function dismissInstallBanner() {
        installBanner.classList.add('hidden');
        localStorage.setItem('pwa-dismissed', 'true');
    }

    // Also show banner if on mobile but PWA not installable yet (no beforeinstallprompt - e.g. iOS)
    setTimeout(() => {
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;
        if (isIOS && !isStandalone && !localStorage.getItem('pwa-dismissed')) {
            deferredPrompt = null; // Force fallback mode
            installBanner.classList.remove('hidden');
        }
    }, 3000);
    </script>
</body>
</html>
