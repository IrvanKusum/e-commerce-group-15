@extends('layouts.seller')

@section('title', 'Products - Seller')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
<style>
    .modal {
        backdrop-filter: blur(10px);
    }
    
    .modal-content {
        max-width: 700px;
        animation: slideDown 0.3s ease;
    }
    
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-50px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .image-preview {
        width: 100%;
        height: 200px;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 0.5rem;
        overflow: hidden;
    }
    
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .upload-area {
        border: 2px dashed rgba(255, 69, 0, 0.5);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .upload-area:hover {
        border-color: var(--primary);
        background: rgba(255, 69, 0, 0.05);
    }
    
    .upload-area input[type="file"] {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="header">
    <div>
        <h1 style="margin: 0; font-size: 2rem;">📦 Your Products</h1>
        <p style="margin: 0.5rem 0 0 0; color: var(--text-muted);">Manage your store inventory</p>
    </div>
    <button onclick="document.getElementById('addProductModal').style.display='block'" class="btn btn-primary">
        + Add Product
    </button>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-error">
    <ul style="margin: 0; padding-left: 1.5rem;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if($products->count() > 0)
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
    @foreach($products as $product)
    <div style="background: var(--darkl); border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05);">
        <div style="height: 200px; background: #222; display: flex; align-items: center; justify-content: center;">
            @if($product->productImages->first())
            <img src="{{ $product->productImages->first()->image }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
            <span style="font-size: 3rem;">📦</span>
            @endif
        </div>
        <div style="padding: 1rem;">
            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem;">{{ $product->name }}</h3>
            <div style="color: var(--primary); font-weight: bold; font-size: 1.2rem; margin-bottom: 0.5rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div style="display: flex; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
                <span>Stock: {{ $product->stock }}</span>
                <span>•</span>
                <span>{{ $product->weight }}g</span>
                <span>•</span>
                <span>{{ ucfirst($product->condition) }}</span>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('product.detail', $product->id) }}" class="btn" style="flex: 1; background: rgba(255,69,0,0.1); color: var(--primary); padding: 0.5rem; border-radius: 6px; text-decoration: none; text-align: center; font-size: 0.9rem;">View</a>
                <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width: 100%; padding: 0.5rem; font-size: 0.9rem;" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div style="text-align: center; padding: 4rem; background: var(--darkl); border-radius: 16px;">
    <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
    <h3 style="margin: 0 0 0.5rem 0;">No Products Yet</h3>
    <p style="margin: 0 0 1.5rem 0; color: var(--text-muted);">Start adding products to your store</p>
    <button onclick="document.getElementById('addProductModal').style.display='block'" class="btn btn-primary">
        + Add Product
    </button>
</div>
@endif

<!-- Add Product Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="margin: 0; color: white; font-family: 'Orbitron', sans-serif;">Add New Product</h2>
            <span class="close" onclick="document.getElementById('addProductModal').style.display='none'">&times;</span>
        </div>
        
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name">Product Name *</label>
                <input type="text" id="name" name="name" required placeholder="e.g. Nike Air Max Pro">
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="product_category_id">Category *</label>
                    <select id="product_category_id" name="product_category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (Rp) *</label>
                    <input type="number" id="price" name="price" min="0" required placeholder="100000">
                </div>

                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" id="stock" name="stock" min="0" required placeholder="10">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="weight">Weight (grams) *</label>
                    <input type="number" id="weight" name="weight" min="1" required placeholder="1000">
                </div>

                <div class="form-group">
                    <label for="condition">Condition *</label>
                    <select id="condition" name="condition" required>
                        <option value="new">New</option>
                        <option value="used">Used</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <div class="upload-area" onclick="document.getElementById('imageInput').click()">
                    <input type="file" id="imageInput" name="image" accept="image/*" onchange="previewImage(event)">
                    <div id="uploadText">
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📸</div>
                        <div style="color: white; font-weight: 600; margin-bottom: 0.25rem;">Click to upload image</div>
                        <div style="color: var(--text-muted); font-size: 0.85rem;">PNG, JPG, GIF up to 2MB</div>
                    </div>
                </div>
                <div class="image-preview" id="imagePreview" style="display: none;">
                    <img id="previewImg" src="" alt="Preview">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe your product..." rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem;">
                Add Product
            </button>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').style.display = 'flex';
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('uploadText').style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('addProductModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection