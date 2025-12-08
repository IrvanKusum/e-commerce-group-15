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
        border-color: #f97316 !important;
        ring: 2px solid #f97316 !important;
        outline: none;
    }
    
    .profile-card button.inline-flex { /* Primary Button */
        background: linear-gradient(to right, #f97316, #ef4444) !important;
        color: white !important;
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
        <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 2rem;">
            
            <!-- Profile Header -->
            <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 1.5rem;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: bold; color: white; box-shadow: 0 0 20px rgba(249, 115, 22, 0.4);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h1 style="font-size: 2rem; font-weight: 800; color: white; margin-bottom: 0.2rem;">{{ Auth::user()->name }}</h1>
                    <p style="color: var(--text-muted); font-size: 1rem;">Manage your account settings and preferences.</p>
                </div>
            </div>

            <!-- Profile Dashboard Grid -->
            <div style="display: grid; grid-template-columns: 2fr 1.5fr; gap: 2rem;">
                
                <!-- Left Column: Main Settings -->
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <!-- Update Profile Info -->
                    <div class="profile-card">
                        <header style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
                            <h2 style="font-size: 1.25rem; font-weight: 700; color: white; display: flex; align-items: center; gap: 0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                Profile Information
                            </h2>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">Update your account's profile information and email address.</p>
                        </header>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Update Password -->
                    <div class="profile-card">
                        <header style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
                             <h2 style="font-size: 1.25rem; font-weight: 700; color: white; display: flex; align-items: center; gap: 0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                Update Password
                            </h2>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">Ensure your account is using a long, random password to stay secure.</p>
                        </header>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Right Column: Danger Zone & Status -->
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    
                    <!-- Account Status Card (Optional decoration/info) -->
                    <div class="profile-card" style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.9));">
                        <h3 style="color: white; font-weight: 700; margin-bottom: 1rem;">Account Status</h3>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></span>
                            <span style="color: white; font-weight: 600;">Active Member</span>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.85rem;">Member since {{ Auth::user()->created_at->format('M d, Y') }}</p>
                    </div>

                    <!-- Delete Account -->
                    <div class="profile-card" style="border-color: rgba(239, 68, 68, 0.3);">
                        <header style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(239, 68, 68, 0.2); padding-bottom: 1rem;">
                             <h2 style="font-size: 1.25rem; font-weight: 700; color: #ef4444; display: flex; align-items: center; gap: 0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                Delete Account
                            </h2>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                        </header>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Responsive Adjustments -->
    <style>
        @media (max-width: 1024px) {
            .container > div[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection

