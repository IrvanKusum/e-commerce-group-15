@extends('layouts.seller')

@section('title', 'Manage Product Images - Seller')

@section('content')
<div class="header">
    <div>
        <h1 style="margin: 0; font-size: 2rem;">🖼️ Manage Images</h1>
        <p style="margin: 0.5rem 0 0 0; color: var(--text-muted);">Product: <strong style="color: white;">{{ $product->name }}</strong></p>
    </div>
    <a href="{{ route('seller.products') }}" class="btn btn-outline-primary" style="padding: 0.75rem 1.5rem;">
        ← Back to Products
    </a>
</div>

@if(session('success'))
<div style="background: rgba(34, 197, 94, 0.2); border: 1px solid #22c55e; color: #22c55e; padding: 1rem; border-radius: 12px; margin-bottom: 2rem;">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 1rem; border-radius: 12px; margin-bottom: 2rem;">
    {{ session('error') }}
</div>
@endif

<!-- Upload Section -->
<div class="card" style="margin-bottom: 2rem;">
    <h2 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem;">📤 Upload New Image</h2>
    <form method="POST" action="{{ route('seller.product.images.store', $product->id) }}" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; width: 100%; border: 2px dashed rgba(255,255,255,0.1); border-radius: 12px; padding: 3rem; text-align: center; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.backgroundColor='rgba(255,255,255,0.02)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.backgroundColor='transparent'">
                <input type="file" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                <div style="font-size: 3rem; margin-bottom: 1rem;">☁️</div>
                <h3 style="margin: 0 0 0.5rem 0; color: white;">Click to Upload Image</h3>
                <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">JPG, PNG, GIF (Max 2MB)</p>
                <img id="image-preview" style="max-width: 200px; max-height: 200px; margin-top: 1.5rem; border-radius: 8px; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
            </label>
        </div>
        
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label style="display: flex; align-items: center; gap: 0.75rem; color: white; cursor: pointer;">
                <input type="checkbox" name="is_thumbnail" style="width: 1.25rem; height: 1.25rem; accent-color: var(--primary);">
                Set as Main Thumbnail
            </label>
            <button type="submit" class="btn btn-primary">
                📤 Upload Image
            </button>
        </div>
    </form>
</div>

<!-- Gallery Section -->
<div class="card">
    <h2 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem;">🖼️ Image Gallery</h2>
    
    @if(count($images) > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem;">
        @foreach($images as $img)
        <div style="background: rgba(0,0,0,0.2); border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); transition: transform 0.2s; position: relative;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            @if($img->is_thumbnail)
            <div style="position: absolute; top: 0.75rem; left: 0.75rem; background: var(--primary); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10;">
                ⭐ MAIN IMAGE
            </div>
            @endif
            
            <div style="height: 200px; background: #222; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <img src="{{ asset($img->image) }}" alt="Product Image" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            <div style="padding: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
                @if(!$img->is_thumbnail)
                <form method="POST" action="{{ route('seller.product.images.thumbnail', [$product->id, $img->id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary" style="width: 100%; padding: 0.5rem; font-size: 0.85rem;">
                        Set as Main
                    </button>
                </form>
                @else
                <button disabled class="btn" style="width: 100%; padding: 0.5rem; font-size: 0.85rem; background: rgba(255,255,255,0.1); color: var(--text-muted); cursor: not-allowed;">
                    Currently Main
                </button>
                @endif
                
                <form method="POST" action="{{ route('seller.product.images.destroy', [$product->id, $img->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width: 100%; padding: 0.5rem; font-size: 0.85rem;" onclick="return confirm('Delete this image?')">
                        Delete Image
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div style="text-align: center; padding: 4rem; color: var(--text-muted);">
        <div style="font-size: 4rem; margin-bottom: 1rem;">🖼️</div>
        <h3>No Images Yet</h3>
        <p>Upload the first image for this product to start selling!</p>
    </div>
    @endif
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