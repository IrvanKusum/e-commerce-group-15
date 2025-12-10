@extends('layouts.app')

@section('title', 'Collection - FlexSport')

@push('styles')
<style>
    /* Mini Header for Collection */
    .collection-header {
        padding: 4rem 0 2rem;
        text-align: center;
    }

    .collection-header h1 {
        font-family: 'Orbitron', sans-serif;
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 1rem;
        color: white;
    }
</style>
@endpush

@section('content')
    <div class="collection-header">
        <div class="container">
            <h1>KOLEKSI KAMI</h1>
            <form action="{{ route('collection') }}" method="GET" class="search-box">
                <input type="text" name="search" class="search-input" 
                       placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="search-btn">CARI</button>
            </form>
        </div>
    </div>

    <div class="container">
        <!-- Categories -->
        <div class="category-scroll">
            <div class="category-card {{ !request('category') ? 'active' : '' }}" onclick="window.location.href='{{ route('collection') }}'">
                <div class="category-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg></div>
                <div class="category-name">Semua Produk</div>
            </div>
            
            @foreach($categories as $category)
            <div class="category-card {{ request('category') == $category->id ? 'active' : '' }}" 
                 onclick="window.location.href='{{ route('collection') }}?category={{ $category->id }}'">
                 <!-- Dynamic Icon based on Category ID or Name interaction could be here, but using standard tag icon for now as per homepage -->
                <div class="category-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                </div>
                <div class="category-name">{{ $category->name }}</div>
            </div>
            @endforeach
        </div>

        <!-- Products -->
        <div class="section-header">
            <h2 class="section-title">
                @if(request('search'))
                    HASIL PENCARIAN
                @else
                    SEMUA PRODUK
                @endif
            </h2>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
            <div class="product-card">
                <div class="product-img">
                    @if($product->productImages->isNotEmpty())
                        @php $img = $product->productImages->first()->image; @endphp
                        <img src="{{ $img }}" alt="{{ $product->name }}">
                    @else
                        <span style="font-size: 3rem; opacity: 0.5;">⚡</span>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-cat">{{ $product->productCategory?->name ?? 'Uncategorized' }}</div>
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    
                    <div class="product-footer">
                        <span class="badge {{ $product->condition === 'new' ? 'badge-new' : 'badge-used' }}">
                            {{ $product->condition === 'new' ? 'BARU' : 'BEKAS' }}
                        </span>
                        
                        <div style="display:flex; gap: 0.5rem; width: 100%;">
                            <button onclick="addToCart({{ $product->id }})" class="btn btn-secondary" style="flex: 1; padding:0.4rem 0.6rem; font-size: 0.75rem;">+ KERANJANG</button>
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary" style="flex: 1; text-align: center; padding:0.4rem 0.6rem; font-size: 0.75rem;">LIHAT DETAIL</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem; color: var(--text-muted);">
                <h3>Tidak Ada Produk Ditemukan</h3>
                <p>Coba kata kunci lain atau kembali lagi nanti.</p>
            </div>
            @endforelse
        </div>
        
        <div style="height: 4rem;"></div>
    </div>
@endsection

@push('scripts')
    <script>
        function addToCart(id) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({
                    product_id: id,
                    qty: 1
                })
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                return response.json().then(data => ({ status: response.status, body: data }));
            })
            .then(result => {
                if (result && result.status === 200) {
                    alert('✅ Produk ditambahkan ke keranjang!');
                    location.reload();
                } else if (result) {
                    alert(result.body.message || 'Error adding to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            });
        }
    </script>
@endpush
