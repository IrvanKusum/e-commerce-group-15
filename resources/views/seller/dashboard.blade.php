@extends('layouts.app')

@section('title', 'Dashboard - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<div class="hero">
    <div class="container">
        <h1>👋 Selamat Datang, User!</h1>
        <p>🏪 Kelola toko dan produk Anda</p>
    </div>
</div>

<!-- Seller Stats -->
<div class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div>📦</div>
                <div class="stat-value">{{ $stats['products_count'] }}</div>
                <div class="stat-label">Total Produk</div>
            </div>
            <div class="stat-card">
                <div>📋</div>
                <div class="stat-value">{{ $stats['transactions_count'] }}</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
            <div class="stat-card">
                <div>💰</div>
                <div class="stat-value" style="font-size:1.3rem;">Rp {{ number_format($stats['balance'], 0, ',', '.') }}</div>
                <div class="stat-label">Saldo Toko</div>
            </div>
            <div class="stat-card">
                <div>🛍️</div>
                <div class="stat-value">{{ $stats['buyer_transactions'] }}</div>
                <div class="stat-label">Pesanan Saya</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <h2 class="section-title">⚡ Menu Cepat</h2>
    <div class="action-grid">
        <a href="{{ route('seller.products') }}" class="action-card">
            <div class="action-icon">📦</div>
            <h3>Kelola Produk</h3>
            <p style="color:#666;">Tambah & edit produk toko</p>
        </a>
        <a href="{{ route('seller.orders') }}" class="action-card">
            <div class="action-icon">📋</div>
            <h3>Pesanan Masuk</h3>
            <p style="color:#666;">Lihat pesanan pelanggan</p>
        </a>
        <a href="{{ route('seller.balance') }}" class="action-card">
            <div class="action-icon">💰</div>
            <h3>Saldo & Penarikan</h3>
            <p style="color:#666;">Kelola saldo toko</p>
        </a>
        <a href="{{ route('transaction.history') }}" class="action-card">
            <div class="action-icon">🛍️</div>
            <h3>Pesanan Saya</h3>
            <p style="color:#666;">Lihat riwayat belanja</p>
        </a>
        <a href="{{ route('profile') }}" class="action-card">
            <div class="action-icon">⚙️</div>
            <h3>Pengaturan</h3>
            <p style="color:#666;">Edit profile & info</p>
        </a>
    </div>
</div>

<!-- Products Section -->
<div class="products-section" id="products">
    <h2 class="section-title">🎯 Produk Terbaru</h2>
    <div class="products-grid">
        @for($i = 1; $i <= 3; $i++)
        <div class="product-card">
            <div class="product-image">🏅</div>
            <div class="product-info">
                <div class="product-category">⭐ Kategori {{ $i }}</div>
                <h3 class="product-name">Produk Sample {{ $i }}</h3>
                <div class="product-price">Rp 450.000</div>
                <div class="product-actions">
                    <a href="{{ route('product.detail', 1) }}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endfor
    </div>
    <div style="text-align:center; margin-top:2rem;">
        <a href="{{ route('home') }}#products" class="btn btn-primary">Lihat Semua Produk</a>
    </div>
</div>
@endsection