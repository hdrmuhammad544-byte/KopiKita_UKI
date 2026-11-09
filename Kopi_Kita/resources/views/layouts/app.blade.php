
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Kopi Kita') - Kopi Kita</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --olive: #626F4B;
            --olive-dark: #4F5D3B;
            --cream: #F5F3EB;
            --sidebar: #EDEAE0;
            --text: #34352D;
            --muted: #858579;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--text);
            font-family: 'Segoe UI', sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 245px;
            position: fixed;
            inset: 0 auto 0 0;
            background: var(--sidebar);
            border-right: 1px solid #E3E0D6;
            padding: 22px 15px;
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: transform .25s ease;
            overflow-y: auto;
        }

        .main-area {
            margin-left: 245px;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            height: 66px;
            background: #FFFEFB;
            border-bottom: 1px solid #EAE7DE;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .main-content {
            padding: 27px 30px;
            max-width: 1650px;
            margin: auto;
        }

        /* NAVIGATION */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 13px;
            border-radius: 9px;
            color: #68695F;
            font-size: 13px;
            margin-bottom: 5px;
            transition: .2s;
            text-decoration: none;
            width: 100%;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #E1E8D7;
            color: var(--olive-dark);
            font-weight: 600;
        }

        .nav-link i {
            width: 17px;
            height: 17px;
        }

        /* BUTTON */
        .sidebar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            cursor: pointer;
            color: #4B5563;
        }

        /* OVERLAY */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.35);
            z-index: 30;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* RESPONSIVE */
        @media(max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-area {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: flex;
            }

            .topbar {
                padding: 0 16px;
            }

            .main-content {
                padding: 20px 16px;
            }
        }

        @media(max-width: 480px) {
            .main-content {
                padding: 16px 12px;
            }

            .topbar {
                height: 60px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

@if(auth()->check())

    @php
        $user = auth()->user();
        $role = $user->role;
        $isAdmin = $role === 'admin';
        $isKasir = $role === 'kasir';
    @endphp

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar">

        <!-- BRAND -->
        <div class="flex items-center gap-3 mb-9 px-2">

            <div class="w-10 h-10 rounded-xl bg-[#626F4B] text-white
                        flex items-center justify-center">
                <i data-lucide="coffee"></i>
            </div>

            <div>
                <h2 class="text-xl font-bold text-[#39412F]">
                    Kopi Kita
                </h2>

                <p class="text-[9px] tracking-[2px] text-gray-500">
                    {{ strtoupper($role) }} PANEL
                </p>
            </div>

        </div>

        <!-- CABANG -->
        <div class="bg-white border border-[#E5E1D6] rounded-lg p-3 mb-8">

            <p class="text-[9px] text-gray-500 font-bold tracking-wider">
                CABANG AKTIF
            </p>

            <p class="text-sm font-semibold mt-1">
                Pati · Pusat
            </p>

        </div>

        <!-- NAVIGATION TITLE -->
        <p class="text-[10px] font-bold text-gray-400 tracking-widest mb-3 px-2">
            RUANG KERJA
        </p>

        <nav class="flex-1">

            <!-- MENU BERSAMA -->
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <i data-lucide="layout-dashboard"></i>
                Dashboard

            </a>

            <!-- MENU KHUSUS ADMIN -->
            @if($isAdmin)

                <p class="text-[10px] font-bold text-gray-400
                          tracking-widest mb-3 mt-5 px-2">
                    MANAJEMEN
                </p>

                <a href="{{ route('menus.index') }}"
                   class="nav-link {{ request()->routeIs('menus.*') ? 'active' : '' }}">

                    <i data-lucide="coffee"></i>
                    Data Menu

                </a>

                <a href="{{ route('reports.index') }}"
                   class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">

                    <i data-lucide="file-chart-column"></i>
                    Laporan Penjualan

                </a>

            @endif

            <!-- MENU KHUSUS KASIR -->
            @if($isKasir)

                <p class="text-[10px] font-bold text-gray-400
                          tracking-widest mb-3 mt-5 px-2">
                    OPERASIONAL
                </p>

                <a href="{{ route('pos.index') }}"
                   class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">

                    <i data-lucide="shopping-bag"></i>
                    Transaksi Kasir

                </a>

            @endif

        </nav>

        <!-- STATUS GERAI -->
        <div class="bg-white border border-[#E5E1D6] rounded-lg p-3 mb-4">

            <div class="flex items-center gap-2">

                <span class="w-2 h-2 rounded-full bg-green-500"></span>

                <span class="text-xs font-semibold">
                    Gerai sedang buka
                </span>

            </div>

            <p class="text-[10px] text-gray-400 mt-1">
                Setiap hari · 08.00–22.00
            </p>

        </div>

        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                    class="nav-link hover:text-red-600 text-left">

                <i data-lucide="log-out"></i>
                Keluar dari akun

            </button>
        </form>

    </aside>

    <!-- SIDEBAR OVERLAY -->
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <!-- MAIN AREA -->
    <div class="main-area">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="flex items-center gap-3">

                <!-- MOBILE SIDEBAR BUTTON -->
                <button id="sidebarToggle"
                        type="button"
                        class="sidebar-toggle">

                    <i data-lucide="menu"></i>

                </button>

                <!-- BREADCRUMB -->
                <div class="text-xs text-gray-500">

                    Kopi Kita

                    <span class="mx-2">/</span>

                    <span class="font-semibold text-gray-800">
                        @yield('heading', 'Dashboard')
                    </span>

                </div>

            </div>

            <!-- USER PROFILE -->
            <div class="flex items-center gap-3">

                <div class="hidden sm:block text-right">

                    <p class="text-xs font-semibold">
                        {{ $user->name }}
                    </p>

                    <p class="text-[10px] text-gray-400">
                        {{ ucfirst($role) }} · Kopi Kita
                    </p>

                </div>

                <div class="w-9 h-9 rounded-full bg-[#E1E8D7]
                            text-[#626F4B] flex items-center justify-center
                            font-bold text-xs">

                    {{ strtoupper(substr($user->name, 0, 2)) }}

                </div>

            </div>

        </header>

        <!-- MAIN CONTENT -->
        <main class="main-content">

            <!-- SUCCESS MESSAGE -->
            @if(session('success'))

                <div class="bg-green-100 text-green-800
                            p-3 rounded-lg mb-5 text-sm">

                    {{ session('success') }}

                </div>

            @endif

            <!-- ERROR MESSAGE -->
            @if($errors->any())

                <div class="bg-red-100 text-red-700
                            p-3 rounded-lg mb-5 text-sm">

                    <ul class="list-disc ml-5">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <!-- PAGE CONTENT -->
            @yield('content')

        </main>

    </div>

@else

    <!-- GUEST / LOGIN PAGE -->
    <main>
        @yield('content')
    </main>

@endif

<!-- JAVASCRIPT -->
<script>

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle = document.getElementById('sidebarToggle');

    function closeSidebar() {

        sidebar?.classList.remove('open');
        overlay?.classList.remove('show');

    }

    toggle?.addEventListener('click', function () {

        sidebar?.classList.toggle('open');
        overlay?.classList.toggle('show');

    });

    overlay?.addEventListener('click', closeSidebar);

    // Lucide Icons
    if (window.lucide) {
        window.lucide.createIcons();
    }

</script>

@stack('scripts')

</body>
</html>
