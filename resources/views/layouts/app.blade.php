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
    <style>
        /* Mobile: classic phone look */
        @media (max-width: 768px) {
            .desktop-sidebar { display: none !important; }
            .desktop-topbar { display: none !important; }
            .app-wrapper { max-width: 400px; border-left: 4px solid #1e293b; border-right: 4px solid #1e293b; }
            .mobile-nav { display: flex !important; }
        }
        /* Desktop: full layout */
        @media (min-width: 769px) {
            .app-wrapper { max-width: 100%; border: none; box-shadow: none; }
            .mobile-nav { display: none !important; }
        }
    </style>
</head>
<body class="bg-slate-200 min-h-screen text-slate-800 selection:bg-pink-300 selection:text-slate-900 font-sans">

    <!-- DESKTOP LAYOUT (hidden on mobile) -->
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
            <main class="flex-1 overflow-y-auto pb-28">
                @yield('content')
            </main>

            <!-- Bottom Navigation Bar (Mobile only) -->
            <nav class="mobile-nav fixed bottom-0 w-full max-w-[400px] bg-white/95 backdrop-blur-md border-t-4 border-slate-800 px-2 py-2 pb-3 flex justify-around items-end z-50" style="border-radius: 20px 20px 0 0; box-shadow: 0px -4px 0px 0px rgba(30,41,59,1);">
                
                {{-- Beranda --}}
                <a href="{{ url('/dashboard') }}" class="flex flex-col items-center gap-0.5 group w-16">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-[22px] transition-all duration-200 {{ request()->is('dashboard') ? 'bg-lime-400 text-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] -translate-y-0.5' : 'text-slate-400 group-hover:text-slate-600 group-hover:bg-slate-100' }}">
                        <i class="ph-{{ request()->is('dashboard') ? 'fill' : 'duotone' }} ph-house"></i>
                    </div>
                    <span class="text-[10px] font-extrabold {{ request()->is('dashboard') ? 'text-slate-800' : 'text-slate-400' }}">Beranda</span>
                </a>

                {{-- Notif --}}
                <a href="{{ url('/notifications') }}" class="flex flex-col items-center gap-0.5 group w-16 relative">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-[22px] transition-all duration-200 {{ request()->is('notifications') ? 'bg-yellow-300 text-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] -translate-y-0.5' : 'text-slate-400 group-hover:text-slate-600 group-hover:bg-slate-100' }}">
                        <i class="ph-{{ request()->is('notifications') ? 'fill' : 'duotone' }} ph-bell"></i>
                    </div>
                    @php $unreadCount = \App\Http\Controllers\NotificationController::unreadCount(); @endphp
                    @if($unreadCount > 0)
                        <span class="absolute top-0 right-1 min-w-[18px] h-[18px] bg-pink-500 border-2 border-white rounded-full text-[9px] font-black text-white flex items-center justify-center px-1 animate-pulse">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                    <span class="text-[10px] font-extrabold {{ request()->is('notifications') ? 'text-slate-800' : 'text-slate-400' }}">Notif</span>
                </a>

                {{-- FAB - Tambah Kantong --}}
                <a href="{{ url('/pockets/create') }}" class="flex flex-col items-center -mt-8 group">
                    <div class="w-[56px] h-[56px] rounded-2xl border-4 border-slate-800 flex items-center justify-center text-[28px] font-black transition-all duration-200 text-slate-800 group-hover:-translate-y-1 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] group-hover:shadow-[3px_5px_0px_0px_rgba(30,41,59,1)] group-active:translate-y-0 group-active:shadow-[1px_1px_0px_0px_rgba(30,41,59,1)]" style="background: linear-gradient(135deg, #bef264, #84cc16);">
                        <i class="ph-bold ph-plus"></i>
                    </div>
                    <span class="text-[10px] font-extrabold text-lime-600 mt-0.5">Baru</span>
                </a>

                {{-- Kantong --}}
                <a href="{{ url('/dashboard') }}#kantong" class="flex flex-col items-center gap-0.5 group w-16">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-[22px] transition-all duration-200 text-slate-400 group-hover:text-slate-600 group-hover:bg-slate-100">
                        <i class="ph-duotone ph-wallet"></i>
                    </div>
                    <span class="text-[10px] font-extrabold text-slate-400">Kantong</span>
                </a>

                {{-- Profil --}}
                <a href="{{ url('/profile') }}" class="flex flex-col items-center gap-0.5 group w-16">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-[22px] transition-all duration-200 {{ request()->is('profile') || request()->is('settings') ? 'bg-pink-300 text-slate-800 shadow-[2px_2px_0px_0px_rgba(30,41,59,1)] -translate-y-0.5' : 'text-slate-400 group-hover:text-slate-600 group-hover:bg-slate-100' }}">
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
    </script>
</body>
</html>
