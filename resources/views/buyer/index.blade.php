{{-- resources/views/buyer/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlexSport - E-Commerce Olahraga Terpercaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: #f5f7fa;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 3rem;
            display: grid;
            grid-template-columns: 200px 1fr auto;
            align-items: center;
            gap: 2rem;
        }

        /* Logo Section */
        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            color: white;
            transition: transform 0.3s;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            font-size: 2rem;
        }

        /* Center Menu */
        .nav-center {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            list-style: none;
            flex-wrap: wrap;
        }

        .nav-center a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            padding: 0.7rem 1.2rem;
            border-radius: 10px;
            font-size: 0.95rem;
            white-space: nowrap;
        }

        .nav-center a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .nav-center a.active {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Right Menu */
        .nav-right {
            display: flex;
            gap: 0.8rem;
            align-items: center;
            list-style: none;
        }

        .btn-auth {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .btn-auth:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .btn-register {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            color: white;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5rem 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Search Section */
        .search-section {
            background: white;
            padding: 2rem 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            display: flex;
            gap: 1rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .search-input {
            flex: 1;
            padding: 1rem;
            border: 2px solid #E1E5EA;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
        }

        /* Categories */
        .categories {
            padding: 4rem 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: #003459;
            margin-bottom: 2rem;
            text-align: center;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .category-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .category-card h3 {
            color: #003459;
            font-size: 1rem;
        }

        /* Products */
        .products {
            padding: 4rem 0;
            background: #f5f7fa;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-category {
            color: #0077C8;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #003459;
            margin-bottom: 0.5rem;
        }

        .product-store {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .product-condition {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: #f0f0f0;
            border-radius: 15px;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: #00C49A;
            margin: 1rem 0;
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Sora', sans-serif;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            flex: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-outline {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-outline:hover {
            background: #667eea;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
        }

        .empty-state h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 1200px) {
            .header-container {
                grid-template-columns: 1fr;
                gap: 1rem;
                text-align: center;
            }

            .nav-center {
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-right {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-icon">⚽</span>
                <span>FlexSport</span>
            </a>

            <!-- Center Menu -->
            <ul class="nav-center">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        🏠 Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}#products">
                        🛍️ Produk
                    </a>
                </li>
            </ul>

            <!-- Right Menu -->
            <ul class="nav-right">
                <li>
                    <a href="{{ route('login') }}" class="btn-auth">
                        🔐 Login
                    </a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="btn-register">
                        📝 Register
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>⚡ Selamat Datang di FlexSport</h1>
            <p>Platform e-commerce olahraga terpercaya untuk semua kebutuhan Anda</p>
            <a href="#products" class="btn btn-primary">🛒 Belanja Sekarang</a>
        </div>
    </section>

    <!-- Search Bar -->
    <section class="search-section">
        <div class="container">
            <form action="{{ route('home') }}" method="GET" class="search-bar">
                <input type="text" name="search" class="search-input" 
                       placeholder="🔍 Cari produk olahraga..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories">
        <div class="container">
            <h2 class="section-title">🏆 Kategori Produk</h2>

            <div class="category-grid">
                <div class="category-card" onclick="window.location.href='{{ route('home') }}'">
                    <div class="category-icon">🌟</div>
                    <h3>Semua Produk</h3>
                </div>

                @php 
                    $icons = ['⚽', '🏀', '🎾', '🏈', '⛳', '🏐', '🥊'];
                @endphp

                @foreach($categories as $index => $category)
                <div class="category-card"
                     onclick="window.location.href='{{ route('home') }}?category={{ $category['id'] }}#products'">
                    <div class="category-icon">{{ $icons[$index % count($icons)] }}</div>
                    <h3>{{ $category['name'] }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Products -->
    <section class="products" id="products">
        <div class="container">
            <h2 class="section-title">
                🎯 
                @if(request('search'))
                    Hasil Pencarian: "{{ request('search') }}"
                @else
                    Produk Terbaru
                @endif
            </h2>

            <div class="products-grid">
                @forelse($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        @if(isset($product['image']) && $product['image'])
                            <img src="{{ $product['image'] }}" 
                                 alt="{{ $product['name'] }}">
                        @else
                            🏅
                        @endif
                    </div>

                    <div class="product-info">
                        <div class="product-category">⭐ {{ $product['category'] }}</div>
                        <h3 class="product-name">{{ $product['name'] }}</h3>
                        <p class="product-store">🏪 {{ $product['store_name'] }}</p>
                        <span class="product-condition">
                            @if($product['condition'] === 'new')
                                ✨ Baru
                            @else
                                ♻️ Bekas
                            @endif
                        </span>
                        <div class="product-price">
                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                        </div>
                        <div class="product-actions">
                            <a href="{{ route('product.detail', $product['id']) }}" 
                               class="btn btn-outline">👁️ Detail</a>
                            <button onclick="addToCart({{ $product['id'] }})" 
                                    class="btn btn-primary">🛒 Beli</button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state" style="grid-column: 1/-1;">
                    <h3>
                        😔 
                        @if(request('search'))
                            Produk tidak ditemukan
                        @else
                            Belum ada produk
                        @endif
                    </h3>
                    <p>
                        @if(request('search'))
                            Coba kata kunci lain
                        @else
                            Produk akan muncul di sini setelah seller menambahkan
                        @endif
                    </p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        function addToCart(productId) {
            alert('🛒 Produk ditambahkan ke keranjang! (ID: ' + productId + ')');
        }
    </script>
</body>
</html>