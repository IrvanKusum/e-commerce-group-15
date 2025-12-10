@extends('layouts.seller')

@section('title', 'Seller Dashboard - FlexSport')

@section('content')
<div class="header">
    <div>
        <h1 style="margin: 0; font-size: 2rem;">👋 Welcome, {{ auth()->user()->name }}!</h1>
        <p style="margin: 0.5rem 0 0 0; color: var(--text-muted);">Manage your store and track your business</p>
    </div>
</div>

<!-- Seller Stats -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: var(--darkl); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📦</div>
        <div style="font-size: 2rem; font-weight: bold; color: var(--primary);">{{ $stats['products_count'] }}</div>
        <div style="color: var(--text-muted);">Total Products</div>
    </div>
    <div style="background: var(--darkl); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📋</div>
        <div style="font-size: 2rem; font-weight: bold; color: var(--primary);">{{ $stats['transactions_count'] }}</div>
        <div style="color: var(--text-muted);">Total Orders</div>
    </div>
    <div style="background: var(--darkl); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">💰</div>
        <div style="font-size: 1.3rem; font-weight: bold; color: var(--primary);">Rp {{ number_format($stats['balance'], 0, ',', '.') }}</div>
        <div style="color: var(--text-muted);">Store Balance</div>
    </div>
    <div style="background: var(--darkl); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🛍️</div>
        <div style="font-size: 2rem; font-weight: bold; color: var(--primary);">{{ $stats['buyer_transactions'] }}</div>
        <div style="color: var(--text-muted);">My Purchases</div>
    </div>
</div>

<!-- Products Section -->
<div class="card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="margin: 0; font-size: 1.5rem;">Your Products</h2>
        <a href="{{ route('seller.products') }}" class="btn btn-primary">View All Products</a>
    </div>

    @if($products->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
        @foreach($products as $product)
        <div style="background: rgba(0,0,0,0.3); border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="height: 200px; background: #222; display: flex; align-items: center; justify-content: center; position: relative;">
                @if($product->productImages->first())
                <img src="{{ $product->productImages->first()->image }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                <span style="font-size: 3rem;">📦</span>
                @endif
                <div style="position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.7); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">
                    Stock: {{ $product->stock }}
                </div>
            </div>
            <div style="padding: 1rem;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $product->name }}</h3>
                <div style="color: var(--primary); font-weight: bold; font-size: 1.2rem; margin-bottom: 0.5rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <div style="display: flex; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted);">
                    <span>{{ ucfirst($product->condition) }}</span>
                    <span>•</span>
                    <span>{{ $product->weight }}g</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
        <h3>No Products Yet</h3>
        <p>Start adding products to your store</p>
        <a href="{{ route('seller.products') }}" class="btn btn-primary" style="margin-top: 1rem;">Add Product</a>
    </div>
    @endif
</div>

<!-- Quick Actions -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
    <a href="{{ route('seller.orders') }}" class="card" style="text-decoration: none; color: white; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'; this.style.transform='translateY(0)'">
        <div style="font-size: 2.5rem; margin-bottom: 1rem;">📋</div>
        <h3 style="margin: 0 0 0.5rem 0;">Manage Orders</h3>
        <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">View and process customer orders</p>
    </a>
    <a href="{{ route('seller.balance') }}" class="card" style="text-decoration: none; color: white; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'; this.style.transform='translateY(0)'">
        <div style="font-size: 2.5rem; margin-bottom: 1rem;">💰</div>
        <h3 style="margin: 0 0 0.5rem 0;">Balance & Withdrawal</h3>
        <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">Manage your earnings</p>
    </a>
    <a href="{{ route('transaction.history') }}" class="card" style="text-decoration: none; color: white; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'; this.style.transform='translateY(0)'">
        <div style="font-size: 2.5rem; margin-bottom: 1rem;">🛍️</div>
        <h3 style="margin: 0 0 0.5rem 0;">My Purchases</h3>
        <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">View your shopping history</p>
    </a>
</div>
@endsection