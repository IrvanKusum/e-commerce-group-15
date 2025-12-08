@extends('layouts.app')

@section('title', $product['name'] . ' - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')
<div class="product-detail">
    <div class="container">
        <div class="product-grid">
            <div class="product-images">
                <div class="main-image" id="mainImage">
                    @if($product->productImages->isNotEmpty())
                        @php $mainImg = $product->productImages->first()->image; @endphp
                        <img src="{{ Str::startsWith($mainImg, ['http', 'https']) ? $mainImg : asset('storage/' . $mainImg) }}" style="width:100%; height:100%; object-fit:cover; border-radius:15px;">
                    @else
                        <div style="width:100%; height:100%; background:#333; display:flex; align-items:center; justify-content:center; border-radius:15px; color:#666;">
                            NO IMAGE
                        </div>
                    @endif
                </div>
                
                @if($product->productImages->count() > 1)
                <div class="thumbnails">
                    @foreach($product->productImages as $imgObj)
                    @php $img = $imgObj->image; $src = Str::startsWith($img, ['http', 'https']) ? $img : asset('storage/' . $img); @endphp
                    <img src="{{ $src }}" class="thumbnail {{ $loop->first ? 'active' : '' }}" onclick="changeImage('{{ $src }}')">
                    @endforeach
                </div>
                @endif
            </div>
            
            <div class="product-info">
                <div class="product-meta">
                    <span class="badge badge-primary">{{ $product->productCategory?->name ?? 'Uncategorized' }}</span>
                    <span class="badge {{ $product->condition == 'new' ? 'badge-success' : 'badge-warning' }}">{{ $product->condition == 'new' ? 'NEW COND' : 'USED COND' }}</span>
                </div>
                
                <h1 style="color:white; margin-top:1rem;">{{ $product->name }}</h1>
                
                <div class="rating">
                    <div class="stars" style="color:#ffd700;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= 4) ★ @else ☆ @endif
                        @endfor
                    </div>
                    <span style="color:#aaa;">({{ $product->productReviews->count() }} Reviews)</span>
                </div>
                
                <div class="price" style="font-size:2rem; font-weight:bold; color:var(--primary); margin:1rem 0;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                
                <div class="store-info" style="background:rgba(255,255,255,0.05); padding:1rem; border-radius:10px; margin-bottom:1.5rem;">
                    <h3 style="color:white; font-size:1.1rem; margin-bottom:0.2rem;">Store: {{ $product->store?->name ?? 'No Store' }}</h3>
                    <p style="color:#aaa; font-size:0.9rem;">Location: {{ $product->store?->city ?? 'Unknown City' }}</p>
                </div>
                
                <div class="stock-info" style="margin-bottom:1.5rem;">
                    @if($product->stock > 0)
                        <span style="color:var(--success); font-weight:bold;">In Stock: {{ $product->stock }} units</span>
                    @else
                        <span style="color:var(--danger); font-weight:bold;">Out of Stock</span>
                    @endif
                </div>
                
                <div class="description">
                    <h3>Description</h3>
                    <p>{{ $product->description }}</p>
                </div>
                
                <p style="color:#aaa; margin-bottom:1.5rem;"><strong>Weight:</strong> {{ $product->weight }} gram</p>
                
                @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" style="display: flex; gap: 1rem; align-items: stretch;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="quantity-wrapper">
                        <button type="button" class="qty-btn" onclick="updateQty(-1)">-</button>
                        <input type="number" name="qty" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="qty-input" readonly>
                        <button type="button" class="qty-btn" onclick="updateQty(1)">+</button>
                    </div>

                    <button type="submit" class="btn btn-primary" style="flex: 1; font-size: 1.2rem; border-radius: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Add to Cart</button>
                </form>
                @else
                <div style="background:rgba(220,53,69,0.1); padding:1rem; border-radius:12px; text-align:center; color:#ef4444; border: 1px solid rgba(239, 68, 68, 0.3);">
                    Product Currently Unavailable
                </div>
                @endif
            </div>
        </div>
        
        <div class="reviews-section" style="margin-top:3rem;">
            <h2 style="color:white; margin-bottom:1.5rem;">Product Reviews</h2>
            @forelse($product->productReviews as $review)
            <div class="review-item" style="background:rgba(255,255,255,0.05); padding:1rem; border-radius:10px; margin-bottom:1rem;">
                <div class="review-header" style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                    <span class="reviewer-name" style="font-weight:bold; color:white;">{{ $review->user->name }}</span>
                    <span class="review-stars" style="color:#ffd700;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating) ★ @else ☆ @endif
                        @endfor
                    </span>
                </div>
                <p style="color:#ddd;">{{ $review->review }}</p>
            </div>
            @empty
            <p style="text-align:center; color:#666;">No reviews yet.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
function changeImage(src) {
    document.getElementById('mainImage').innerHTML = `<img src="${src}" style="width:100%; height:100%; object-fit:cover; border-radius:15px;">`;
    document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');
}

function updateQty(change) {
    const input = document.getElementById('quantity');
    let val = parseInt(input.value) + change;
    if (val < 1) val = 1;
    if (val > parseInt(input.max)) val = parseInt(input.max);
    input.value = val;
}

function addToCart(productId) {
    const qty = document.getElementById('quantity').value;
    alert(`✅ Produk ditambahkan ke keranjang! (${qty} item)`);
    // TODO: Implement cart system
}
</script>
@endpush
@endsection