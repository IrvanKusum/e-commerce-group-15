@extends('layouts.app')

@section('title', 'Shopping Cart - FlexSport')

@section('content')
<div class="container" style="padding-top: 8rem; padding-bottom: 4rem;">
    <h1 style="font-family: 'Orbitron'; margin-bottom: 2rem;">YOUR CART</h1>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1rem; color: var(--primary);">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 1rem; color: var(--danger);">{{ session('error') }}</div>
    @endif

    @if(count($cart) > 0)
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        
        <div class="cart-items">
            @php 
                $total = 0; 
                $groupedCart = collect($cart)->groupBy('store_name');
            @endphp
            
            @foreach($groupedCart as $storeName => $items)
            <div class="store-group" style="margin-bottom: 2rem;">
                <div class="store-header" style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1rem; padding-bottom:0.5rem; border-bottom:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-store" style="color:var(--primary);"></i>
                    <h3 style="margin:0; font-size:1.1rem; color:white;">{{ $storeName }}</h3>
                </div>

                @foreach($items as $id => $details)
                @php $total += $details['price'] * $details['qty']; @endphp
                <div class="cart-item" style="background: var(--darkl); padding: 1.5rem; border-radius: 12px; display: flex; gap: 1.5rem; margin-bottom: 1rem; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="width: 100px; height: 100px; background: #333; border-radius: 8px;">
                        @if($details['image'])
                        <img src="{{ $details['image'] }}" style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <h3 style="margin-bottom: 0.5rem;">{{ $details['name'] }}</h3>
                        <p style="color: var(--primary); font-weight: bold;">Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1rem;">
                            <span style="color: var(--text-muted);">Qty: {{ $details['qty'] }}</span>
                            
                            {{-- Find original key in session cart from loop or assume ID matches if not re-keyed. 
                                 Correct way with grouping is complicated without ID. 
                                 Let's actually pass ID in addToCart stored data or just iterate main cart and sort?
                                 Grouping in Blade is easiest but we need the original ID for remove.
                                 Workaround: We loop over main $cart and check store, or rework controller.
                                 Simple fix: Add 'id' to stored cart item in addToCart. --}}
                            
                            {{-- Revert to simple loop for now but with visual headers inserted? --}}
                            {{-- Better: Iterate $groupedCart but we need the key (Product ID). 
                                 Since collect($cart) preserves keys, $id here IS the product ID. --}}
                                 
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: var(--danger); cursor: pointer; font-size: 0.9rem;">REMOVE</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>

        <div class="cart-summary" style="background: var(--darkl); padding: 2rem; border-radius: 16px; height: fit-content; border: 1px solid rgba(255,255,255,0.05);">
            <h3 style="margin-bottom: 1.5rem; font-family: 'Orbitron';">SUMMARY</h3>
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span style="color: var(--text-muted);">Subtotal</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            \<!-- Shipping calculated at checkout -->
            
            <div style="border-top: 1px solid rgba(255,255,255,0.1); margin: 1.5rem 0;"></div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; font-size: 1.2rem; font-weight: bold;">
                <span>Total</span>
                <span style="color: var(--primary);">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <a href="{{ route('checkout') }}" class="btn btn-primary" style="width: 100%; text-align: center; display: block;">PROCEED TO CHECKOUT</a>
        </div>
    </div>
    @else
    <div style="text-align: center; padding: 4rem;">
        <h3>Your Cart is Empty</h3>
        <a href="{{ route('home') }}" class="btn btn-outline" style="margin-top: 1rem;">CONTINUE SHOPPING</a>
    </div>
    @endif
</div>
@endsection
