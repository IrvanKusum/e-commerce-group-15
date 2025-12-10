@extends('layouts.seller')

@section('title', 'Penarikan Saldo - FlexSport')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    
    .container {
        padding: 3rem 2rem;
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }
    
    .card h1 {
        color: #003459;
        font-size: 2rem;
        margin-bottom: 2rem;
    }
    
    .balance-display {
        background: linear-gradient(135deg, #00C49A 0%, #00a882 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .balance-display p {
        font-size: 1rem;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }
    
    .balance-display h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
    }
    
    .alert-error {
        background: #f8d7da;
        color: #721c24;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #003459;
    }
    
    input, select {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #E1E5EA;
        border-radius: 8px;
        font-family: 'Sora', sans-serif;
        font-size: 1rem;
    }
    
    input:focus, select:focus {
        outline: none;
        border-color: #00C49A;
    }
    
    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Sora', sans-serif;
        transition: all 0.3s;
        width: 100%;
        font-size: 1rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #00C49A 0%, #00a882 100%);
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 196, 154, 0.4);
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }
    
    th, td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #E1E5EA;
    }
    
    th {
        background: #00C49A;
        color: white;
        font-weight: 700;
    }
    
    tr:hover {
        background: #f5f7fa;
    }
    
    .badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
    }
    
    .badge-pending {
        background: #ffc107;
        color: #000;
    }
    
    .badge-approved {
        background: #00C49A;
        color: white;
    }
    
    .badge-rejected {
        background: #dc3545;
        color: white;
    }
    
    small {
        display: block;
        margin-top: 0.3rem;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="card">
        <h1>💸 Tarik Saldo Toko</h1>
        
        <div class="balance-display">
            <p>Saldo Tersedia</p>
            <h2>Rp {{ number_format($balance, 0, ',', '.') }}</h2>
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

        <form method="POST" action="{{ route('seller.withdrawal.process') }}">
            @csrf
            
            <div class="form-group">
                <label for="amount">Jumlah Penarikan (Rp)</label>
                <input type="number" name="amount" id="amount" required min="50000" 
                       placeholder="Masukkan jumlah penarikan" value="{{ old('amount') }}">
                <small style="color:#666;">Minimal penarikan: Rp 50.000</small>
            </div>

            <div class="form-group">
                <label for="bank_name">Pilih Bank</label>
                <select name="bank_name" id="bank_name" required>
                    <option value="">-- Pilih Bank --</option>
                    <option value="BCA" {{ old('bank_name') == 'BCA' ? 'selected' : '' }}>BCA</option>
                    <option value="BRI" {{ old('bank_name') == 'BRI' ? 'selected' : '' }}>BRI</option>
                    <option value="BNI" {{ old('bank_name') == 'BNI' ? 'selected' : '' }}>BNI</option>
                    <option value="Mandiri" {{ old('bank_name') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                    <option value="CIMB Niaga" {{ old('bank_name') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                    <option value="BSI" {{ old('bank_name') == 'BSI' ? 'selected' : '' }}>BSI</option>
                </select>
            </div>

            <div class="form-group">
                <label for="account_name">Nama Pemilik Rekening</label>
                <input type="text" name="account_name" id="account_name" required 
                       placeholder="Contoh: Andi Pratama" value="{{ old('account_name') }}">
            </div>

            <div class="form-group">
                <label for="account_number">Nomor Rekening</label>
                <input type="text" name="account_number" id="account_number" required 
                       placeholder="Masukkan nomor rekening" value="{{ old('account_number') }}">
            </div>

            <button type="submit" class="btn btn-primary">💸 Ajukan Penarikan</button>
        </form>
    </div>

    <div class="card">
        <h1>📜 Riwayat Penarikan</h1>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Bank</th>
                    <th>Rekening</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $w)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($w['created_at'])->format('d M Y H:i') }}</td>
                        <td style="font-weight: 700; color: #00C49A;">Rp {{ number_format($w['amount'], 0, ',', '.') }}</td>
                        <td>{{ $w['bank_name'] }}</td>
                        <td>
                            <div style="font-weight: 600;">{{ $w['bank_account_name'] }}</div>
                            <small style="color: #666;">{{ $w['bank_account_number'] }}</small>
                        </td>
                        <td>
                            @if($w['status'] === 'pending')
                                <span class="badge badge-pending">⏳ Pending</span>
                            @elseif($w['status'] === 'approved')
                                <span class="badge badge-approved">✅ Disetujui</span>
                            @else
                                <span class="badge badge-rejected">❌ Ditolak</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:2rem; color:#666;">
                            Belum ada riwayat penarikan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validasi jumlah penarikan tidak melebihi saldo
    document.querySelector('form').addEventListener('submit', function(e) {
        const amount = parseInt(document.getElementById('amount').value);
        const balance = {{ $balance }};
        
        if (amount > balance) {
            e.preventDefault();
            alert('Jumlah penarikan tidak boleh melebihi saldo tersedia!');
            return false;
        }
        
        if (amount < 50000) {
            e.preventDefault();
            alert('Minimal penarikan adalah Rp 50.000!');
            return false;
        }
    });
</script>
@endpush