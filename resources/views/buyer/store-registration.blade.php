@extends('layouts.app')

@section('title', 'Daftar Toko - FlexSport')

@push('styles')
<style>
    .registration-container {
        max-width: 800px;
        margin: 4rem auto;
        padding: 0 2rem;
    }

    .registration-card {
        background: rgba(28, 28, 30, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 3rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        color: #fff;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 1rem;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: white;
        font-family: 'Sora', sans-serif;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
    }

    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .submit-btn {
        width: 100%;
        padding: 1.2rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: transform 0.2s;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="registration-container">
    <div class="registration-card">
        <h1 style="font-family: 'Orbitron', sans-serif; font-size: 2rem; margin-bottom: 0.5rem; color: white;">🏪 Daftar Toko Baru</h1>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Mulai jual produk olahraga Anda di FlexSport</p>

        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.5rem; color: var(--danger);">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('store.register.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Toko *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Sport Pro Store">
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Toko *</label>
                <textarea id="description" name="description" required placeholder="Ceritakan tentang toko Anda...">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="address">Alamat Lengkap *</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" required placeholder="Jl. Contoh No. 123">
            </div>

            <div class="form-group">
                <label for="city">Kota *</label>
                <input type="text" id="city" name="city" value="{{ old('city') }}" required placeholder="Jakarta">
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon *</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="08123456789">
            </div>

            <div style="background: rgba(245, 158, 11, 0.1); border: 1px solid var(--warning); padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <p style="color: var(--warning); margin: 0; font-size: 0.9rem;">
                    ⚠️ <strong>Catatan:</strong> Toko Anda akan diverifikasi oleh admin terlebih dahulu sebelum dapat mulai berjualan.
                </p>
            </div>

            <button type="submit" class="submit-btn">Daftar Toko Sekarang</button>
        </form>
    </div>
</div>
@endsection
