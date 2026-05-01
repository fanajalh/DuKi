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
        @media (max-width: 768px) {
            .auth-wrapper { width: 100%; max-width: 100%; border-left: 4px solid #1e293b; border-right: 4px solid #1e293b; box-shadow: none !important; }
            .auth-desktop-panel { display: none !important; }
        }
        @media (min-width: 769px) {
            .auth-wrapper { max-width: 480px; border: 4px solid #1e293b; border-radius: 32px; box-shadow: 8px 8px 0px 0px #1e293b; margin: auto; min-height: auto; }
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

    <!-- 🐷 PIG GLOBAL LOADING OVERLAY -->
    <div id="pig-loading-global" class="fixed inset-0 z-[99999] bg-slate-900/75 backdrop-blur-sm flex flex-col items-center justify-center hidden">
        <div class="flex flex-col items-center gap-4">
            <div class="pig-bounce">
                <div class="pig-body">
                    <div class="pig-ear pig-ear-left"></div>
                    <div class="pig-ear pig-ear-right"></div>
                    <div class="pig-head">
                        <div class="pig-eye pig-eye-left"></div>
                        <div class="pig-eye pig-eye-right"></div>
                        <div class="pig-snout">
                            <div class="pig-nostril"></div>
                            <div class="pig-nostril"></div>
                        </div>
                        <div class="pig-blush pig-blush-left"></div>
                        <div class="pig-blush pig-blush-right"></div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <span class="pig-coin pig-coin-1">💰</span>
                <span class="pig-coin pig-coin-2">🪙</span>
                <span class="pig-coin pig-coin-3">💰</span>
            </div>
            <p class="text-white font-black text-lg tracking-widest">Loading...</p>
            <div class="flex gap-2">
                <div class="pig-dot pig-dot-1"></div>
                <div class="pig-dot pig-dot-2"></div>
                <div class="pig-dot pig-dot-3"></div>
            </div>
        </div>
    </div>

    <!-- 🐷 PULL TO REFRESH INDICATOR -->
    <div id="ptr-wrap" class="fixed top-0 inset-x-0 z-[99998] flex justify-center" style="pointer-events:none; transform:translateY(-140px); transition:none;">
        <div class="bg-orange-50 border-4 border-t-0 border-slate-800 rounded-b-3xl px-8 pt-2 pb-4 shadow-[0_6px_0_0_rgba(30,41,59,1)] flex flex-col items-center gap-1.5 min-w-[180px]">
            <div id="ptr-pig-wrap" style="font-size:48px; transition: transform 0.2s ease; display:inline-block;">🐷</div>
            <p id="ptr-text" class="text-xs font-black text-slate-700 whitespace-nowrap">Tarik untuk refresh</p>
            <div class="w-full bg-slate-200 border-2 border-slate-400 rounded-full h-2 overflow-hidden">
                <div id="ptr-bar" class="h-full rounded-full transition-all duration-100" style="width:0%; background:#f9a8d4;"></div>
            </div>
        </div>
    </div>

    <!-- Desktop: Two-panel layout -->
    <div class="min-h-screen flex items-center justify-center p-0 md:p-8">
        <div class="flex items-center gap-8 max-w-5xl w-full">
            
            <!-- Left Panel: Branding (Desktop only) -->
            <div class="auth-desktop-panel hidden md:flex flex-col items-center flex-1 text-center px-8">
                <div class="w-24 h-24 bg-pink-400 border-4 border-slate-800 rounded-3xl flex items-center justify-center text-5xl shadow-cartoon text-white mb-6 animate-bounce" style="animation-duration: 3s;">
                    <i class="ph-duotone ph-piggy-bank"></i>
                </div>
                <h1 class="text-5xl font-black text-slate-800 mb-2">DuKi</h1>
                <p class="text-lg font-bold text-slate-500 mb-6">Nabung Bareng, Senyum Terus! 💖</p>
                
                <div class="space-y-4 text-left w-full max-w-xs">
                    <div class="flex items-center gap-3 bg-white border-4 border-slate-800 rounded-2xl p-4 shadow-cartoon-sm">
                        <div class="w-10 h-10 bg-lime-300 border-4 border-slate-800 rounded-xl flex items-center justify-center text-xl text-slate-800 flex-shrink-0">
                            <i class="ph-duotone ph-piggy-bank"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Buat kantong tabungan bersama pasanganmu!</p>
                    </div>
                    <div class="flex items-center gap-3 bg-white border-4 border-slate-800 rounded-2xl p-4 shadow-cartoon-sm">
                        <div class="w-10 h-10 bg-pink-300 border-4 border-slate-800 rounded-xl flex items-center justify-center text-xl text-slate-800 flex-shrink-0">
                            <i class="ph-duotone ph-chart-line-up"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Lacak progres menabung secara real-time!</p>
                    </div>
                    <div class="flex items-center gap-3 bg-white border-4 border-slate-800 rounded-2xl p-4 shadow-cartoon-sm">
                        <div class="w-10 h-10 bg-yellow-300 border-4 border-slate-800 rounded-xl flex items-center justify-center text-xl text-slate-800 flex-shrink-0">
                            <i class="ph-duotone ph-robot"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Ngobrol bareng DukiBot, asisten AI lucu!</p>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Auth Form -->
            <div class="auth-wrapper w-full md:flex-1 min-h-screen md:min-h-0 bg-orange-50 relative overflow-x-hidden flex flex-col shadow-2xl">
                
                <!-- Main Content Area -->
                <main class="flex-1 overflow-y-auto">
                    @yield('content')
                </main>

            </div>
        </div>
    </div>

    <script>
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
                showPigLoader();
                document.getElementById(formId).submit();
            }
        });
    }

    // ===== GLOBAL PIG LOADING INTERCEPTOR =====
    function showPigLoader() {
        var el = document.getElementById('pig-loading-global') || document.getElementById('pig-loading');
        if (el) el.classList.remove('hidden');
    }
    document.addEventListener('click', function(e) {
        var link = e.target.closest('a');
        if (!link) return;
        var href = link.getAttribute('href');
        if (!href || href === '' || href.startsWith('#') || href.startsWith('javascript:')) return;
        if (link.target === '_blank' || link.hasAttribute('download')) return;
        try {
            var url = new URL(href, window.location.origin);
            if (url.origin !== window.location.origin) return;
        } catch(err) { return; }
        if (document.querySelector('.swal2-container')) return;
        showPigLoader();
    });
    document.addEventListener('submit', function(e) { showPigLoader(); });
    window.addEventListener('pageshow', function(e) {
        var el = document.getElementById('pig-loading-global') || document.getElementById('pig-loading');
        if (el) el.classList.add('hidden');
        var ptr = document.getElementById('ptr-wrap');
        if (ptr) { ptr.style.transition = 'none'; ptr.style.transform = 'translateY(-140px)'; }
    });

    // ===== CUSTOM PULL-TO-REFRESH =====
    (function() {
        var ptrWrap   = document.getElementById('ptr-wrap');
        var ptrText   = document.getElementById('ptr-text');
        var ptrBar    = document.getElementById('ptr-bar');
        var ptrPig    = document.getElementById('ptr-pig-wrap');
        if (!ptrWrap) return;
        var startY = 0, currentY = 0, isPulling = false, isRefreshing = false;
        var THRESHOLD = 100, MAX_PULL = 120;
        function snapBack() {
            ptrWrap.style.transition = 'transform 0.4s cubic-bezier(0.34,1.56,0.64,1)';
            ptrWrap.style.transform  = 'translateY(-140px)';
            if (ptrBar)  { ptrBar.style.width = '0%'; ptrBar.style.background = '#f9a8d4'; }
            if (ptrText)  ptrText.textContent = 'Tarik untuk refresh';
            if (ptrPig)  ptrPig.style.transform = 'scale(1) rotate(0deg)';
        }
        document.addEventListener('touchstart', function(e) {
            if (isRefreshing) return;
            if (window.scrollY <= 0) { startY = currentY = e.touches[0].pageY; isPulling = true; ptrWrap.style.transition = 'none'; }
        }, { passive: true });
        document.addEventListener('touchmove', function(e) {
            if (!isPulling || isRefreshing) return;
            currentY = e.touches[0].pageY;
            var dy = Math.max(0, currentY - startY);
            if (dy <= 0 || window.scrollY > 0) return;
            var pull = Math.min(dy * 0.55, MAX_PULL);
            var prog = Math.min(dy / THRESHOLD, 1);
            ptrWrap.style.transform = 'translateY(' + (pull - 140) + 'px)';
            if (ptrBar) ptrBar.style.width = (prog * 100) + '%';
            if (prog >= 1) {
                if (ptrText) ptrText.textContent = '🎉 Lepas untuk refresh!';
                if (ptrBar)  ptrBar.style.background = '#86efac';
                if (ptrPig)  ptrPig.style.transform = 'scale(1.25) rotate(-15deg)';
            } else {
                if (ptrText) ptrText.textContent = '🐷 Tarik untuk refresh...';
                if (ptrBar)  ptrBar.style.background = '#f9a8d4';
                if (ptrPig)  ptrPig.style.transform = 'scale(1) rotate(0deg)';
            }
        }, { passive: true });
        document.addEventListener('touchend', function(e) {
            if (!isPulling || isRefreshing) return;
            isPulling = false;
            var dy = currentY - startY;
            if (dy >= THRESHOLD && window.scrollY <= 0) {
                isRefreshing = true;
                ptrWrap.style.transition = 'transform 0.25s ease';
                ptrWrap.style.transform  = 'translateY(-20px)';
                if (ptrText) ptrText.textContent = '🐷 Refreshing...';
                setTimeout(function() { showPigLoader(); setTimeout(function() { window.location.reload(); }, 400); }, 350);
            } else { snapBack(); }
            currentY = 0;
        }, { passive: true });
    })();
    </script>
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

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
    });

    window.addEventListener('appinstalled', () => {
        deferredPrompt = null;
        if (typeof Swal !== 'undefined') {
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
        }
    });

    function installPWA() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choice) => {
                deferredPrompt = null;
            });
        } else {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'Cara Install DuKi 📲',
                    html: '<div style="text-align:left; font-weight:700; font-size:13px; line-height:1.8;">' +
                          '<b>Android Chrome:</b><br>Klik ⋮ (titik tiga) → "Install app" atau "Add to Home Screen"<br><br>' +
                          '<b>iPhone Safari:</b><br>Klik ikon Share (kotak+panah) → "Add to Home Screen"<br><br>' +
                          '<b>Desktop Chrome:</b><br>Klik ikon 📥 di ujung address bar</div>',
                    confirmButtonText: 'Oke, paham!',
                    confirmButtonColor: '#a3e635',
                    background: '#fffbeb',
                    color: '#1e293b',
                    customClass: { popup: 'rounded-3xl border-4 border-slate-800', confirmButton: 'font-black text-slate-800' }
                });
            } else {
                alert('Android: Klik titik tiga → Install app\niPhone: Klik Share → Add to Home Screen');
            }
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
            navigator.clipboard.writeText(shareData.url + '\n\n' + shareData.text).then(() => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Link Disalin! 📋',
                        text: 'Tinggal paste dan kirim ke teman/pasanganmu!',
                        confirmButtonText: 'Oke!',
                        confirmButtonColor: '#a3e635',
                        background: '#fffbeb',
                        color: '#1e293b',
                        customClass: { popup: 'rounded-3xl border-4 border-slate-800', confirmButton: 'font-black text-slate-800' }
                    });
                } else {
                    alert('Link berhasil disalin!');
                }
            });
        }
    }
    </script>
</body>
</html>
