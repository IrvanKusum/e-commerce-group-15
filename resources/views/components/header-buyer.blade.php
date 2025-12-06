<header>
    <div class="header-container">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="logo">
            <span class="logo-icon">⚽</span>
            <span>FlexSport</span>
        </a>
        
        <!-- Center Menu -->
        <ul class="nav-center">
            <li><a href="{{ route('home') }}#products">Produk</a></li>
            <li><a href="{{ route('seller.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('seller.products') }}">Kelola Produk</a></li>
            <li><a href="{{ route('seller.orders') }}">Pesanan Masuk</a></li>
            <li><a href="{{ route('seller.balance') }}">Saldo</a></li>
            <li><a href="{{ route('transaction.history') }}">Pesanan Saya</a></li>
        </ul>
        
        <!-- Right Menu -->
        <ul class="nav-right">
            <li>
                <a href="{{ route('profile') }}" class="btn-profile">
                    <span class="profile-icon">👤</span>
                    <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
            </li>
        </ul>
    </div>
</header>