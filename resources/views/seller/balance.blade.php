@extends('layouts.app')

@section('title', 'Saldo Toko - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/balance.css') }}">
@endpush



@section('content')
<div class="content">
    <a href="{{ route('seller.dashboard') }}" class="btn-back">
        ← Kembali
    </a>
    
    <div class="balance-card">
        <h1>💰 Saldo Toko Anda</h1>
        <div class="balance-amount">Rp {{ number_format($balance, 0, ',', '.') }}</div>
        <a href="{{ route('seller.withdrawal') }}" class="btn btn-primary">💸 Tarik Saldo</a>
    </div>

    <div class="card">
        <h2>📋 Riwayat Saldo</h2>
        @if(count($history) > 0)
        <table>
            <thead>
                <tr>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $h)
                <tr>
                    <td>
                        @if($h['type'] == 'income')
                            📈 Pemasukan
                        @else
                            📉 Penarikan
                        @endif
                    </td>
                    <td style="color:{{ $h['type'] == 'income' ? '#00C49A' : '#dc3545' }}; font-weight:700;">
                        {{ $h['type'] == 'income' ? '+' : '-' }} Rp {{ number_format($h['amount'], 0, ',', '.') }}
                    </td>
                    <td>{{ $h['remarks'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($h['created_at'])->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <p>Belum ada riwayat saldo</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Additional JavaScript if needed
</script>
@endpush