@extends('frontend.front_app')

@section('title', 'Dashboard')

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Dashboard<span>Account</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('frontend.partials.profile-sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Welcome Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                                         alt="{{ Auth::user()->name }}"
                                         class="rounded-circle" width="80" height="80">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="fw-bold text-dark mb-1">Welcome back, {{ Auth::user()->name }}!</h3>
                                    <p class="text-muted mb-0">Here's what's happening with your account today.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm text-center">
                                <div class="card-body py-4">
                                    <div class="stats-icon bg-primary mb-3">
                                        <i class="fas fa-shopping-bag text-white"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark">5</h4>
                                    <p class="text-muted mb-0">Total Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm text-center">
                                <div class="card-body py-4">
                                    <div class="stats-icon bg-success mb-3">
                                        <i class="fas fa-heart text-white"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark">12</h4>
                                    <p class="text-muted mb-0">Wishlist Items</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm text-center">
                                <div class="card-body py-4">
                                    <div class="stats-icon bg-info mb-3">
                                        <i class="fas fa-map-marker-alt text-white"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark">2</h4>
                                    <p class="text-muted mb-0">Saved Addresses</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold text-dark">
                                <i class="fas fa-clock me-2"></i>Recent Orders
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-bag text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No recent orders</h5>
                                <p class="text-muted">You haven't placed any orders yet.</p>
                                <a href="{{ url('/') }}" class="btn btn-primary">Start Shopping</a>
                            </div>
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
.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 24px;
}
</style>
@endpush
