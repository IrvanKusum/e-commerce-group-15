@extends('layouts.app')

@section('title', 'My Orders - FlexSport')

@push('styles')
<style>
    .history-header {
        margin: 4rem 0 2rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding-bottom: 1rem;
    }

    .history-card {
        background: var(--darkl);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s;
    }

    .history-card:hover {
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
    }

    .trans-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .trans-id {
        font-family: 'Orbitron', sans-serif;
        font-weight: 700;
        color: var(--primary);
    }

    .trans-date {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .trans-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-pending { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
    .status-paid { background: rgba(16, 185, 129, 0.1); color: var(--success); }
    .status-shipped { background: rgba(79, 172, 254, 0.1); color: var(--secondary); }
    .status-cancelled { background: rgba(239, 68, 68, 0.1); color: var(--danger); }

    .trans-items {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .item-row {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .item-img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        background: #333;
        object-fit: cover;
    }

    .item-info h4 {
        font-size: 1rem;
        margin-bottom: 0.2rem;
    }

    .item-meta {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .trans-footer {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255,255,255,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="history-header">
        <h1>MY ORDER HISTORY</h1>
        <p>Track your gear purchases and order status.</p>
    </div>

    @forelse($transactions as $trans)
    <div class="history-card">
        <div class="trans-header">
            <div>
                <div class="trans-id">ORDER #{{ $trans->code ?? $trans->id }}</div>
                <div class="trans-date">{{ $trans->created_at->format('d M Y, H:i') }}</div>
            </div>
            <span class="trans-status status-{{ strtolower($trans->payment_status ?? 'pending') }}">
                {{ $trans->payment_status ?? 'PENDING' }}
            </span>
        </div>

        <div class="trans-items">
            @foreach($trans->transactionDetails as $detail)
            <div class="item-row">
                @php 
                    $img = $detail->product->productImages->first()->image ?? ''; 
                @endphp
                @if($img)
                <img src="{{ $img }}" class="item-img" alt="{{ $detail->product->name }}">
                @else
                <div class="item-img" style="display:flex;align-items:center;justify-content:center;">⚡</div>
                @endif
                
                <div class="item-info">
                    <h4>{{ $detail->product->name }}</h4>
                    <div class="item-meta">{{ $detail->qty }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="trans-footer">
            <div class="store-info">
                <span style="color:var(--text-muted)">Sold by:</span> 
                <strong>{{ $trans->store->name ?? 'Unknown Store' }}</strong>
            </div>
            <div class="total-price">
                Total: Rp {{ number_format($trans->grand_total, 0, ',', '.') }}
            </div>
        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 4rem; color: var(--text-muted);">
        <h3>No Orders Yet</h3>
        <p>You haven't bought any gear yet. Time to upgrade your inventory?</p>
        <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top:1rem;">START SHOPPING</a>
    </div>
    @endforelse

    <div style="height:4rem;"></div>
</div>
@endsection