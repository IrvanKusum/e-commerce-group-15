@extends('layouts.app')

@section('title', 'Kelola Gambar Produk - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/seller-all.css') }}">
@endpush

@section('content')
<div class="content">
    <a href="{{ route('seller.products') }}" class="btn btn-back">← Kembali ke Produk</a>
    
    <div class="page-header">
        <h1>🖼️ Kelola Gambar Produk</h1>
        <p>Produk: <strong>{{ $product['name'] }}</strong></p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="card">
        <h2>📤 Upload Gambar Baru</h2>
        <form method="POST" action="{{ route('seller.product.images.store', $product['id']) }}" enctype="multipart/form-data">
            @csrf
            <div class="upload-area" onclick="document.getElementById('image-input').click()">
                <input type="file" id="image-input" name="image" accept="image/*" onchange="previewImage(event)">
                <div class="upload-icon">🖼️</div>
                <p><strong>Klik untuk upload gambar</strong></p>
                <p style="font-size:0.85rem; color:#666; margin-top:0.5rem;">Format: JPG, PNG, GIF (Max 5MB)</p>
                <img id="image-preview" style="max-width: 300px; margin-top: 1rem; border-radius: 10px; display: none;">
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_thumbnail">
                    Jadikan sebagai gambar utama (thumbnail)
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">📤 Upload Gambar</button>
        </form>
    </div>

    <div class="card">
        <h2>🖼️ Galeri Gambar</h2>
        @if(count($images) > 0)
        <div class="images-grid">
            @foreach($images as $img)
            <div class="image-card">
                @if($img['is_thumbnail'])
                <div class="thumbnail-badge">⭐ UTAMA</div>
                @endif
                <img src="{{ asset($img['image']) }}" alt="Product Image" class="image-preview">
                <div class="image-info">
                    <div class="image-actions">
                        @if(!$img['is_thumbnail'])
                        <form method="POST" action="{{ route('seller.product.images.thumbnail', [$product['id'], $img['id']]) }}" style="flex:1;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm" style="width:100%;">
                                ⭐ Jadikan Utama
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('seller.product.images.destroy', [$product['id'], $img['id']]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Hapus gambar ini?')">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p style="text-align:center; padding:3rem; color:#666;">Belum ada gambar. Upload gambar pertama untuk produk ini!</p>
        @endif
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const preview = document.getElementById('image-preview');
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