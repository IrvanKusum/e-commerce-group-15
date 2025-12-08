@extends('layouts.app')

@push('styles')
<style>
    /* Profile Page Dark Theme Overrides */
    .profile-card {
        background: rgba(255, 255, 255, 0.05); /* Glassmorphism */
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
    }
    
    .profile-card h2, .profile-card header h2 {
        color: white !important;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .profile-card p, .profile-card header p {
        color: #aaa !important;
    }
    
    .profile-card label {
        color: #ccc !important;
        font-weight: 500;
    }
    
    .profile-card input[type="text"],
    .profile-card input[type="email"],
    .profile-card input[type="password"] {
        background: rgba(0, 0, 0, 0.3) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        border-radius: 10px;
    }
    
    .profile-card input:focus {
        border-color: #00f2fe !important;
        ring: 2px solid #00f2fe !important;
        outline: none;
    }
    
    .profile-card button.inline-flex { /* Primary Button */
        background: linear-gradient(to right, #00f2fe, #4facfe) !important;
        color: black !important;
        font-weight: bold;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .profile-card button.text-red-600 { /* Delete Account Button */
        color: #ff4d4d !important;
    }
</style>
@endpush

@section('header')
    <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Profile') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="container" style="max-width: 80rem; margin: 0 auto; padding: 0 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <div class="profile-card">
                    <div style="max-width: 40rem;">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="profile-card">
                    <div style="max-width: 40rem;">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="profile-card">
                    <div style="max-width: 40rem;">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

