@extends('frontend.front_app')

@section('title', 'User Profile')

@section('content')
<main class="main">
    <!-- Page Header -->
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">My Profile<span>Account</span></h1>
        </div>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <!-- Sidebar Menu -->
                <div class="col-lg-3">
                    <div class="profile-sidebar">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body text-center p-4">
                                <div class="profile-avatar mb-3">
                                    <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                                         alt="{{ Auth::user()->name }}"
                                         class="rounded-circle" width="80" height="80">
                                </div>
                                <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                                <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                                <div class="badge bg-success">Verified Account</div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action active">
                                        <i class="fas fa-user me-2"></i>Profile Information
                                    </a>
                                    <a href="{{ route('order.history') }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-shopping-bag me-2"></i>Order History
                                    </a>
                                    {{-- <a href="{{ route('address.index') }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-address-book me-2"></i>Address Book
                                    </a> --}}
                                    {{-- <a href="{{ route('wishlist') }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-heart me-2"></i>Wishlist
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Profile Information Form -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="card-title mb-0 fw-bold">
                                <i class="fas fa-user-edit me-2"></i>Profile Information
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Update Password Form -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark py-3">
                            <h4 class="card-title mb-0 fw-bold">
                                <i class="fas fa-lock me-2"></i>Update Password
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Delete Account Form -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-danger text-white py-3">
                            <h4 class="card-title mb-0 fw-bold">
                                <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
.profile-sidebar .list-group-item {
    border: none;
    padding: 15px 20px;
    font-weight: 500;
    color: #495057;
    transition: all 0.3s ease;
}

.profile-sidebar .list-group-item:hover {
    background-color: #f8f9fa;
    color: #007bff;
}

.profile-sidebar .list-group-item.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.profile-avatar img {
    border: 3px solid #e9ecef;
    object-fit: cover;
}

.card-header {
    border-radius: 8px 8px 0 0 !important;
}

/* Form Styling */
.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
}

.btn {
    border-radius: 8px;
    padding: 12px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .profile-sidebar {
        margin-bottom: 30px;
    }

    .card-body {
        padding: 20px;
    }
}
</style>
@endpush
