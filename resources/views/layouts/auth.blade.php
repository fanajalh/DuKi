<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DuKi - @yield('title', 'Duo & Kita')</title>
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
            .auth-wrapper { max-width: 400px; border-left: 4px solid #1e293b; border-right: 4px solid #1e293b; }
            .auth-desktop-panel { display: none !important; }
        }
        @media (min-width: 769px) {
            .auth-wrapper { max-width: 480px; border: 4px solid #1e293b; border-radius: 32px; box-shadow: 8px 8px 0px 0px #1e293b; margin: auto; min-height: auto; }
        }
    </style>
</head>
<body class="bg-slate-200 min-h-screen text-slate-800 selection:bg-pink-300 selection:text-slate-900 font-sans">

    <!-- Desktop: Two-panel layout -->
    <div class="min-h-screen flex items-center justify-center p-4 md:p-8">
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
            <div class="auth-wrapper w-full md:flex-1 min-h-screen md:min-h-0 bg-orange-50 relative overflow-x-hidden flex flex-col shadow-2xl mx-auto">
                
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
    </script>
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(reg => console.log('SW registered:', reg.scope))
                .catch(err => console.log('SW failed:', err));
        });
    }
    </script>
</body>
</html>
