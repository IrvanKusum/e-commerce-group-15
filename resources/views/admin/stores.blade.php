@extends('layouts.admin')

@section('title', 'Manage Stores - FlexSport Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="container">
        <div class="page-header">
            <h1>MANAGE STORES</h1>
            <p>Verify and manage seller accounts.</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="card">
            @if(count($stores) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Store Name</th>
                        <th>Owner</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stores as $store)
                    <tr>
                        <td><strong>{{ $store->name }}</strong></td>
                        <td>{{ $store->user->name ?? 'N/A' }}</td>
                        <td>{{ $store->user->email ?? 'N/A' }}</td>
                        <td>{{ $store->city }}</td>
                        <td>
                            @if($store->is_verified)
                                <span class="badge badge-verified">VERIFIED</span>
                            @else
                                <span class="badge badge-pending">PENDING</span>
                            @endif
                        </td>
                        <td>
                            @if(!$store->is_verified)
                            <div class="action-buttons">
                                <form method="POST" action="{{ route('admin.stores.verify') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-approve" 
                                            onclick="return confirm('Approve this store?')">
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.stores.verify') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-reject"
                                            onclick="return confirm('Reject and delete this store?')">
                                        Reject
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-muted">No Actions</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <h3>No Registered Stores</h3>
                <p>New store registrations will appear here.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection