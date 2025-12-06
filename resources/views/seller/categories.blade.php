@extends('layouts.app')

@section('title', 'Kelola Kategori - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/seller-all.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="page-header">
        <h1>📂 Kelola Kategori Produk</h1>
        <p>Toko: <strong>Sport Gear Pro</strong></p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="card">
        <button onclick="openAddModal()" class="btn btn-primary">➕ Tambah Kategori Baru</button>
    </div>

    <div class="card">
        <h2>Daftar Kategori</h2>
        @if(count($categories) > 0)
        <div class="category-grid">
            @foreach($categories as $cat)
            <div class="category-card">
                <div class="category-name">📁 {{ $cat['name'] }}</div>
                <div class="category-tagline">{{ $cat['tagline'] ?? '-' }}</div>
                <div class="category-description">{{ $cat['description'] }}</div>
                <div class="product-count">📦 {{ $cat['product_count'] }} Produk</div>
                <div>
                    <button onclick="openEditModal({{ $cat['id'] }}, '{{ addslashes($cat['name']) }}', '{{ addslashes($cat['tagline'] ?? '') }}', '{{ addslashes($cat['description']) }}')" 
                            class="btn btn-edit">✏️ Edit</button>
                    @if($cat['product_count'] == 0)
                    <form method="POST" action="{{ route('seller.categories.destroy', $cat['id']) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus kategori ini?')">🗑️ Hapus</button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p style="text-align:center; grid-column:1/-1; padding:2rem; color:#666;">Belum ada kategori</p>
        @endif
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddModal()">&times;</span>
        <h2 style="margin-bottom:2rem; color:#003459;">➕ Tambah Kategori Baru</h2>
        <form method="POST" action="{{ route('seller.categories.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" required placeholder="Contoh: Sepatu Olahraga">
            </div>
            <div class="form-group">
                <label>Tagline</label>
                <input type="text" name="tagline" placeholder="Tagline singkat kategori">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" required placeholder="Deskripsi kategori..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">💾 Simpan Kategori</button>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2 style="margin-bottom:2rem; color:#003459;">✏️ Edit Kategori</h2>
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="category_id" id="edit_category_id">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" id="edit_name" required>
            </div>
            <div class="form-group">
                <label>Tagline</label>
                <input type="text" name="tagline" id="edit_tagline">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" id="edit_description" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">💾 Update Kategori</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openAddModal() { 
    document.getElementById('addModal').style.display = 'block'; 
}

function closeAddModal() { 
    document.getElementById('addModal').style.display = 'none'; 
}

function openEditModal(id, name, tagline, description) {
    document.getElementById('edit_category_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_tagline').value = tagline;
    document.getElementById('edit_description').value = description;
    
    const form = document.getElementById('editForm');
    form.action = "{{ route('seller.categories.update', ':id') }}".replace(':id', id);
    
    document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() { 
    document.getElementById('editModal').style.display = 'none'; 
}

window.onclick = function(e) {
    if (e.target.classList.contains('modal')) {
        closeAddModal();
        closeEditModal();
    }
}
</script>
@endpush
@endsection