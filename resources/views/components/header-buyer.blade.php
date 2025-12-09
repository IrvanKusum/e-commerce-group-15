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
                    <a href="{{ route('cart.show') }}" class="{{ request()->routeIs('cart.show') ? 'active' : '' }}">
                        Keranjang Saya
                        @if(session('cart') && count(session('cart'))  > 0)
                            <span style="background: var(--primary); color: black; padding: 2px 6px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; margin-left: 0.5rem;">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                </li>
                @if(Auth::user()->isSeller())
                    <li><a href="{{ route('seller.dashboard') }}">Pusat Penjual</a></li>
                    <li><a href="{{ route('seller.products') }}">Produk</a></li>
                    <li><a href="{{ route('seller.orders') }}">Pesanan</a></li>
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