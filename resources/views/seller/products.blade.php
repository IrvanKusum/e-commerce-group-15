@extends('layouts.seller')

@section('title', 'Products - Seller')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
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
        <span class="close" onclick="document.getElementById('addProductModal').style.display='none'">&times;</span>
        <h2 style="margin-bottom: 1.5rem; color: white;">Add New Product</h2>
        
        <form action="{{ route('seller.products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="product_category_id">Category</label>
                <select id="product_category_id" name="product_category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price (Rp)</label>
                <input type="number" id="price" name="price" min="0" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" min="0" required>
            </div>

            <div class="form-group">
                <label for="condition">Condition</label>
                <select id="condition" name="condition" required>
                    <option value="new">New</option>
                    <option value="used">Used</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image_url">Image URL (Optional)</label>
                <input type="url" id="image_url" name="image_url" placeholder="https://example.com/image.jpg">
                <small style="color: var(--text-muted); font-size: 0.85rem;">Enter direct link to product image</small>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Add Product</button>
        </form>
    </div>
</div>
@endsection