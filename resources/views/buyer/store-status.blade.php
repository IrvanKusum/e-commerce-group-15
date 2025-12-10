@extends('layouts.app')

@section('title', 'Status Toko - FlexSport')

@push('styles')
<style>
    .status-container {
        max-width: 800px;
        margin: 4rem auto;
        padding: 0 2rem;
    }

    .status-card {
        background: rgba(28, 28, 30, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
    }

    .status-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
    }

    .pending { background: rgba(245, 158, 11, 0.2); }
    .verified { background: rgba(16, 185, 129, 0.2); }

    .dashboard-btn {
        display: inline-block;
        padding: 1rem 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        margin-top: 1.5rem;
        transition: transform 0.2s;
    }

    .dashboard-btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="status-container">
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success); padding: 1rem; border-radius: 12px; margin-bottom: 2rem; color: var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <div class="status-card">
        @if($existingStore->is_verified)
            <!-- Verified Store -->
            <div class="status-icon verified">✅</div>
            <h1 style="font-family: 'Orbitron', sans-serif; font-size: 2rem; margin-bottom: 0.5rem; color: white;">Toko Terverifikasi!</h1>
            <p style="color: var(--text-muted); margin-bottom: 1rem;">Selamat! Toko <strong style="color: var(--primary);">{{ $existingStore->name }}</strong> telah diverifikasi oleh admin.</p>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Anda sekarang dapat mulai berjualan dan mengelola produk Anda.</p>

            <a href="{{ route('seller.dashboard') }}" class="dashboard-btn">
                BUKA DASHBOARD SELLER
            </a>
        @else
            <!-- Pending Store -->
            <div class="status-icon pending">⏳</div>
            <h1 style="font-family: 'Orbitron', sans-serif; font-size: 2rem; margin-bottom: 0.5rem; color: white;">Menunggu Verifikasi</h1>
            <p style="color: var(--text-muted); margin-bottom: 1rem;">Toko <strong style="color: var(--primary);">{{ $existingStore->name }}</strong> sedang dalam proses verifikasi.</p>
            <p style="color: var(--text-muted);">Admin akan segera memverifikasi toko Anda. Harap tunggu beberapa saat.</p>

            <div style="margin-top: 2rem; background: rgba(255, 255, 255, 0.05); padding: 1.5rem; border-radius: 12px;">
                <h3 style="color: white; margin-bottom: 1rem;">Detail Toko</h3>
                <p style="color: var(--text-muted); margin: 0.5rem 0;"><strong>Nama:</strong> {{ $existingStore->name }}</p>
                <p style="color: var(--text-muted); margin: 0.5rem 0;"><strong>Kota:</strong> {{ $existingStore->city }}</p>
                <p style="color: var(--text-muted); margin: 0.5rem 0;"><strong>Telepon:</strong> {{ $existingStore->phone }}</p>
            </div>
        @endif

        <div style="margin-top: 2rem;">
            <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">← Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection
