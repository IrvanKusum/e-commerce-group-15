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
            <h1>OUR COLLECTION</h1>
            <form action="{{ route('collection') }}" method="GET" class="search-box">
                <input type="text" name="search" class="search-input" 
                       placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit" class="search-btn">SEARCH</button>
            </form>
        </div>
    </div>

    <div class="container">
        <!-- Categories -->
        <div class="category-scroll">
            <div class="category-card {{ !request('category') ? 'active' : '' }}" onclick="window.location.href='{{ route('collection') }}'">
                <div class="category-icon">⚡</div>
                <div class="category-name">All Items</div>
            </div>
            
            @foreach($categories as $category)
            <div class="category-card {{ request('category') == $category->id ? 'active' : '' }}" 
                 onclick="window.location.href='{{ route('collection') }}?category={{ $category->id }}'">
                <div class="category-icon">
                    @auth
                        💠
                    @else
                        💠
                    @endauth
                </div>
                <div class="category-name">{{ $category->name }}</div>
            </div>
            @endforeach
        </div>

        <!-- Products -->
        <div class="section-header">
            <h2 class="section-title">
                @if(request('search'))
                    SEARCH RESULTS
                @else
                    ALL PRODUCTS
                @endif
            </h2>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
            <div class="product-card">
                <div class="product-img">
                    @if($product->productImages->isNotEmpty())
                        @php $img = $product->productImages->first()->image; @endphp
                        <img src="{{ Str::startsWith($img, ['http', 'https']) ? $img : asset('storage/' . $img) }}" alt="{{ $product->name }}">
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
                            {{ $product->condition === 'new' ? 'NEW COND' : 'USED COND' }}
                        </span>
                        
                        <div style="display:flex; width: 100%;">
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary" style="flex: 1; text-align: center;">VIEW DETAILS</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem; color: var(--text-muted);">
                <h3>No Equipment Found</h3>
                <p>Try different keywords or check back later.</p>
            </div>
            @endforelse
        </div>
        
        <div style="height: 4rem;"></div>
    </div>
@endsection

@push('scripts')
    <script>
        function addToCart(id) {
            alert('Item added to cart!');
        }
    </script>
@endpush
