<header>
    <div class="header-container">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="logo">
            FLEXSPORT
        </a>
        
        <!-- Center Menu -->
        <ul class="nav-center">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('collection') }}" class="{{ request()->routeIs('collection') ? 'active' : '' }}">Koleksi</a></li>
            @auth
                <li>
<<<<<<< HEAD
                    <a href="{{ route('cart.show') }}" class="{{ request()->routeIs('cart.show') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg> Keranjang
=======
                    <a href="{{ route('cart.show') }}" class="{{ request()->routeIs('cart.show') ? 'active' : '' }}">
                        Keranjang Saya
>>>>>>> 7ce3baf605b43bdbc748063ebb4c81e73b6e2659
                        @if(session('cart') && count(session('cart'))  > 0)
                            <span style="background: var(--primary); color: black; padding: 2px 6px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; margin-left: 0.5rem;">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                </li>
                @if(auth()->user()->store && auth()->user()->store->is_verified)
                    <li><a href="{{ route('seller.dashboard') }}">Toko Saya</a></li>
                @else
                    <li><a href="{{ route('store.register') }}" class="{{ request()->routeIs('store.register') ? 'active' : '' }}" style="font-weight: 600;">Buka Toko</a></li>
                @endif
                <li><a href="{{ route('transaction.history') }}">Pesanan Saya</a></li>
            @endauth
        </ul>
        
        <!-- Right Menu -->
        <ul class="nav-right">
            @auth
                <li>
                    <a href="{{ route('profile.edit') }}" class="btn-profile">
                        {{ Auth::user()->name }}
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">KELUAR</button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}" class="btn-profile" style="border:none; color:var(--text-muted);">
                        Login
                    </a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding:0.5rem 1.2rem; font-size:0.9rem;">
                        Join Now
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</header>