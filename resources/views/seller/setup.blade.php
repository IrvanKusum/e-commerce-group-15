@extends('layouts.app')

@section('title', 'Setup Toko - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/seller-setup.css') }}">
@endpush

@section('content')
<div class="setup-container">
    <h1>🏪 Setup Toko Anda</h1>
    <p class="subtitle">Lengkapi informasi toko untuk mulai berjualan</p>
    
    @if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif
    
    @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    
    <form method="POST" action="{{ route('seller.setup.store') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Logo Upload -->
        <div class="form-group">
            <label>📸 Logo Toko</label>
            <div class="logo-upload" onclick="document.getElementById('logo-input').click()">
                <input type="file" id="logo-input" name="logo" accept="image/*" onchange="previewLogo(event)">
                <div class="upload-icon">🖼️</div>
                <p><strong>Klik untuk upload logo toko</strong></p>
                <p style="font-size:0.85rem; color:#666; margin-top:0.5rem;">Format: JPG, PNG, GIF (Max 2MB)</p>
                <img id="logo-preview" class="logo-preview" style="display:none;">
            </div>
        </div>
        
        <div class="form-group">
            <label for="store_name">🏪 Nama Toko</label>
            <input type="text" id="store_name" name="store_name" placeholder="Contoh: Sport Gear Pro" required>
        </div>
        
        <div class="form-group">
            <label for="about">📝 Tentang Toko</label>
            <textarea id="about" name="about" placeholder="Deskripsikan toko Anda..." required></textarea>
        </div>
        
        <div class="form-group">
            <label for="phone">📞 Nomor Telepon</label>
            <input type="tel" id="phone" name="phone" placeholder="08123456789" required>
        </div>
        
        <div class="form-group">
            <label for="city">🏙️ Kota</label>
            <input type="text" id="city" name="city" placeholder="Jakarta" required>
        </div>
        
        <div class="form-group">
            <label for="address">📍 Alamat Lengkap</label>
            <textarea id="address" name="address" placeholder="Jl. Sudirman No. 123..." required></textarea>
        </div>
        
        <div class="form-group">
            <label for="postal_code">📮 Kode Pos</label>
            <input type="text" id="postal_code" name="postal_code" placeholder="12345" required>
        </div>
        
        <button type="submit" class="btn btn-primary">🚀 Buat Toko</button>
    </form>
    
    <a href="{{ route('seller.dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
</div>

@push('scripts')
<script>
function previewLogo(event) {
    const preview = document.getElementById('logo-preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection