<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Dashboard - FlexSport')</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}"> {{-- Reuse admin styles for dashboard look --}}
    <style>
        :root {
            --primary: #FF4500;
            --dark: #0f172a;
            --darkl: #1e293b;
            --text-muted: #94a3b8;
        }
        body {
            background-color: var(--dark);
            color: white;
            font-family: 'Sora', sans-serif;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: var(--darkl);
            padding: 2rem;
            border-right: 1px solid rgba(255,255,255,0.05);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
        }
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }
        .brand {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255, 69, 0, 0.1);
            color: var(--primary);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: var(--darkl);
            padding: 1.5rem;
            border-radius: 16px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <a href="{{ route('home') }}" class="brand">
            FLEX<span style="color:var(--primary)">SPORT</span>
        </a>
        
        <nav>
            <a href="{{ route('seller.dashboard') }}" class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg></span> Dashboard
            </a>
            <a href="{{ route('seller.orders') }}" class="nav-link {{ request()->routeIs('seller.orders') ? 'active' : '' }}">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg></span> Orders
            </a>
            <a href="{{ route('seller.products') }}" class="nav-link {{ request()->routeIs('seller.products') ? 'active' : '' }}">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg></span> Products
            </a>
            <a href="{{ route('seller.balance') }}" class="nav-link {{ request()->routeIs('seller.balance') ? 'active' : '' }}">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></span> Balance
            </a>
            <a href="{{ route('home') }}" class="nav-link" style="margin-top: 2rem; border: 1px solid var(--primary); background: rgba(255, 69, 0, 0.1);">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></span> Back to Shop
            </a>
        </nav>

        <div style="margin-top: auto;">
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 12px;">
                <div style="width: 40px; height: 40px; background: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <div>
                    <div style="font-size: 0.9rem; font-weight: bold;">{{ auth()->user()->name }}</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">Seller Account</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
                @csrf
                <button type="submit" class="nav-link" style="width: 100%; border: none; background: none; cursor: pointer; color: #ef4444;">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg></span> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
