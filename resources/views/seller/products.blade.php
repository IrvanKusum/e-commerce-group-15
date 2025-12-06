@extends('layouts.app')

@section('title', 'Kelola Produk - FlexSport')


@push('styles')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="page-header">
        <h1>📦 Kelola Produk</h1>
        <p>Toko: <strong>Sport Gear Pro</strong></p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{!! session('success') !!}</div>
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

    <div class="card">
        <div class="action-buttons">
            <button onclick="openModal()" class="btn btn-primary">➕ Tambah Produk Baru</button>
            <a href="{{ route('seller.categories') }}" class="btn btn-secondary">📂 Kelola Kategori</a>
        </div>
    </div>

    <div class="card">
        <h2>Daftar Produk</h2>
        @if(count($products) > 0)
        <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card">
                <div class="product-image" style="position:relative;">
                    @if(isset($product['thumbnail']))
                        <img src="{{ $product['thumbnail'] }}" style="width:100%; height:100%; object-fit:cover;" alt="{{ $product['name'] }}">
                    @else
                        🏅
                    @endif
                    @if(isset($product['image_count']) && $product['image_count'] > 0)
                        <div class="image-badge">📷 {{ $product['image_count'] }}</div>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-category">⭐ {{ $product['category'] ?? '-' }}</div>
                    <div class="product-name">{{ $product['name'] }}</div>
                    <div class="product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</div>
                    <div class="product-stock">
                        @if($product['condition'] == 'new')
                            ✨ Baru
                        @else
                            ♻️ Bekas
                        @endif
                        • Stock: {{ $product['stock'] }}
                    </div>
                    <div class="product-actions">
                        <a href="{{ route('product.detail', $product['id']) }}" class="btn btn-info btn-sm" target="_blank">👁️ Lihat</a>
                        <a href="{{ route('seller.product.images', $product['id']) }}" class="btn btn-warning btn-sm">🖼️ Gambar</a>
                        <form method="POST" action="#" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">🗑️ Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <p>Belum ada produk. Tambahkan produk pertama Anda!</p>
        </div>
        @endif
    </div>
</div>

<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 style="margin-bottom:2rem; color:#003459;">➕ Tambah Produk Baru</h2>
        <form method="POST" action="#">
            @csrf
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" required placeholder="Contoh: Sepatu Futsal Nike" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category['id'] }}" {{ old('category_id') == $category['id'] ? 'selected' : '' }}>
                        {{ $category['name'] }}
                    </option>
                    @endforeach
                </select>
                <small style="color:#666; font-size:0.85rem;">
                    Belum ada kategori? 
                    <a href="{{ route('seller.categories') }}" style="color:#0077C8; font-weight:600;">Buat kategori dulu →</a>
                </small>
            </div>
            <div class="form-group">
                <label>Kondisi</label>
                <select name="condition" required>
                    <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>✨ Baru</option>
                    <option value="second" {{ old('condition') == 'second' ? 'selected' : '' }}>♻️ Bekas</option>
                </select>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="price" required placeholder="150000" value="{{ old('price') }}">
            </div>
            <div class="form-group">
                <label>Berat (gram)</label>
                <input type="number" name="weight" required placeholder="500" value="{{ old('weight') }}">
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stock" required placeholder="10" value="{{ old('stock') }}">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" rows="4" required placeholder="Deskripsi produk lengkap...">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">💾 Simpan Produk</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal() { 
        document.getElementById('addModal').style.display = 'block'; 
    }
    
    function closeModal() { 
        document.getElementById('addModal').style.display = 'none'; 
    }
    
    window.onclick = function(e) { 
        if (e.target.classList.contains('modal')) {
            closeModal(); 
        }
    }

    // Auto open modal if there are validation errors
    @if($errors->any())
        openModal();
    @endif
</script>
@endpush