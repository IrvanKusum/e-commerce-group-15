@extends('layouts.seller')

@section('title', 'Balance - Seller')

@section('content')
<div class="header">
    <div>
        <h1 style="margin: 0; font-size: 2rem;">💰 Store Balance</h1>
        <p style="margin: 0.5rem 0 0 0; color: var(--text-muted);">Manage your earnings</p>
    </div>
</div>

<div style="background: var(--darkl); padding: 3rem; border-radius: 16px; text-align: center; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 2rem;">
    <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">Total Balance</div>
    <div style="font-size: 3rem; font-weight: bold; color: var(--primary); margin-bottom: 1.5rem;">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</div>
    <a href="{{ route('seller.withdrawal') }}" style="background: var(--primary); color: black; border: none; padding: 1rem 2rem; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none;" class="btn btn-primary">Withdraw Funds</a>
</div>

<div style="background: var(--darkl); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
    <h2 style="margin: 0 0 1.5rem 0;">Transaction History</h2>
    <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
        <p>No transaction history yet</p>
    </div>
</div>
@endsection