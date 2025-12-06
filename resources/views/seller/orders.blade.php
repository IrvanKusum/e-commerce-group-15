@extends('layouts.app')

@section('title', 'Kelola Pesanan - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="page-header">
        <h1>📋 Kelola Pesanan</h1>
        <p>Toko: <strong>Sport Gear Pro</strong></p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
    @endif

    @if(count($orders) > 0)
        @foreach($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <span class="order-code">📦 {{ $order['code'] }}</span>
                <span class="badge badge-{{ $order['payment_status'] }}">
                    @if($order['payment_status'] === 'paid')
                        ✅ LUNAS
                    @else
                        ⏳ BELUM BAYAR
                    @endif
                </span>
            </div>
            
            <div class="order-info">
                <div class="info-item">
                    <div class="info-label">👤 Pembeli</div>
                    <div class="info-value">{{ $order['buyer_name'] }}</div>
                    <div style="font-size: 0.85rem; color: #666; margin-top: 0.3rem;">
                        {{ $order['buyer_email'] }}
                    </div>
                    @if(isset($order['phone_number']) && $order['phone_number'])
                    <div style="font-size: 0.85rem; color: #666;">
                        📞 {{ $order['phone_number'] }}
                    </div>
                    @endif
                </div>
                
                <div class="info-item">
                    <div class="info-label">📍 Alamat Pengiriman</div>
                    <div class="info-value">{{ $order['city'] }}</div>
                    <div style="font-size: 0.85rem; color: #666; margin-top: 0.3rem;">
                        {{ $order['address'] }}
                    </div>
                    <div style="font-size: 0.85rem; color: #666;">
                        Kode Pos: {{ $order['postal_code'] }}
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">🚚 Pengiriman</div>
                    <div class="info-value">{{ $order['shipping'] }}</div>
                    <div style="font-size: 0.85rem; color: #666; margin-top: 0.3rem;">
                        {{ ucfirst($order['shipping_type']) }}
                    </div>
                    <div style="font-size: 0.85rem; color: #666;">
                        Ongkir: Rp {{ number_format($order['shipping_cost'], 0, ',', '.') }}
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">💰 Total Pesanan</div>
                    <div class="info-value" style="color: #00C49A; font-size: 1.3rem;">
                        Rp {{ number_format($order['grand_total'], 0, ',', '.') }}
                    </div>
                    <div style="font-size: 0.85rem; color: #666; margin-top: 0.3rem;">
                        Subtotal: Rp {{ number_format($order['order_total'], 0, ',', '.') }}
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">📅 Tanggal Pesanan</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}</div>
                    <div style="font-size: 0.85rem; color: #666; margin-top: 0.3rem;">
                        {{ \Carbon\Carbon::parse($order['created_at'])->format('H:i') }} WIB
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">🔖 Nomor Resi</div>
                    <div class="info-value">
                        @if(isset($order['tracking_number']) && $order['tracking_number'])
                            {{ $order['tracking_number'] }}
                        @else
                            ❌ Belum ada
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="order-actions">
                @if($order['payment_status'] === 'unpaid')
                <form method="POST" action="#" style="display: inline;">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{ $order['id'] }}">
                    <button type="submit" name="confirm_payment" class="btn btn-success" 
                            onclick="return confirm('Konfirmasi pembayaran untuk pesanan ini?')">
                        ✅ Konfirmasi Pembayaran
                    </button>
                </form>
                @endif
                
                @if($order['payment_status'] === 'paid')
                <form method="POST" action="#" class="tracking-form">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{ $order['id'] }}">
                    <input type="text" name="tracking_number" placeholder="Masukkan nomor resi..." 
                           value="{{ $order['tracking_number'] ?? '' }}" required>
                    <button type="submit" name="update_tracking" class="btn btn-primary">
                        🚚 {{ isset($order['tracking_number']) && $order['tracking_number'] ? 'Update' : 'Tambah' }} Resi
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    @else
    <div class="empty-state">
        <h3>😔 Belum ada pesanan masuk</h3>
        <p>Pesanan dari pembeli akan muncul di sini</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Additional JavaScript if needed
</script>
@endpush