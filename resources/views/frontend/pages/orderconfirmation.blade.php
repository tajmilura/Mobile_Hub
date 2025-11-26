@extends('frontend.front_app')
@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Order Confirmation<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product.cart.index') }}">Cart</a></li>
                <li class="breadcrumb-item"><a href="{{ route('checkout') }}">Checkout</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Confirmation</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <!-- Success Alert -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="icon-check-circle mr-2" style="font-size: 20px;"></i>
                    <span class="font-weight-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Order Confirmation Message -->
            <div class="confirmation-message text-center mb-5">
                <div class="confirmation-icon mb-3">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h2 class="text-success mb-3">Order Confirmed Successfully!</h2>
                <p class="text-muted lead">Thank you for your purchase. Your order has been received and is being processed.</p>
            </div>

            <div class="row">
                <!-- Left Column - Order Details -->
                <div class="col-lg-8">
                    <!-- Order Status Banner -->
                    <div class="order-status-banner mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        @if($order->payment_status === 'paid')
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon success mr-3">
                                                <i class="icon-check-circle"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-1 text-success">Payment Confirmed!</h3>
                                                <p class="text-muted mb-0">Thank you for your order. We're preparing your items.</p>
                                            </div>
                                        </div>
                                        @elseif($order->payment_method === 'cod' && $order->payment_status === 'pending')
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon info mr-3">
                                                <i class="icon-shopping-bag"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-1 text-info">Order Confirmed!</h3>
                                                <p class="text-muted mb-0">Pay <strong class="text-dark">${{ number_format($order->grand_total, 2) }}</strong> when you receive your order.</p>
                                            </div>
                                        </div>
                                        @elseif($order->status === 'pending')
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon warning mr-3">
                                                <i class="icon-clock"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-1 text-warning">Pending Payment</h3>
                                                <p class="text-muted mb-0">Waiting for payment confirmation.</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-md-right">
                                        <div class="order-badge">
                                            <span class="badge badge-{{ $order->status === 'confirmed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }} badge-lg px-3 py-2">
                                                {{ strtoupper($order->status) }}
                                            </span>
                                        </div>
                                        <p class="text-muted mt-2 mb-0">Order #{{ $order->order_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Section -->
                    <div class="card order-items-section mb-4">
                        <div class="card-header bg-white border-bottom-0 py-3">
                            <h5 class="card-title mb-0 font-weight-bold text-dark">
                                <i class="icon-bag mr-2 text-primary"></i>
                                Order Items ({{ $order->Items->count() }})
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 py-3 px-4 font-weight-medium text-dark">Product</th>
                                            <th class="border-0 py-3 px-4 font-weight-medium text-dark text-center">Price</th>
                                            <th class="border-0 py-3 px-4 font-weight-medium text-dark text-center">Qty</th>
                                            <th class="border-0 py-3 px-4 font-weight-medium text-dark text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->Items as $item)
                                        <tr class="order-item-row">
                                            <td class="py-3 px-4 border-bottom">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product_image)
                                                    <img src="{{ asset('storage/' . $item->product_image) }}"
                                                         alt="{{ $item->product_name }}"
                                                         class="product-image-xs mr-3 rounded">
                                                    @else
                                                    <div class="product-image-placeholder-xs mr-3 rounded d-flex align-items-center justify-content-center">
                                                        <i class="icon-image text-muted"></i>
                                                    </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 font-weight-medium text-dark">{{ $item->product_name }}</h6>
                                                        <div class="product-variants">
                                                            @if($item->color)
                                                            <span class="badge badge-light mr-1">
                                                                <i class="icon-palette mr-1"></i>{{ $item->color }}
                                                            </span>
                                                            @endif
                                                            @if($item->size)
                                                            <span class="badge badge-light">
                                                                <i class="icon-ruler mr-1"></i>{{ $item->size }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 border-bottom text-center text-dark font-weight-medium">
                                                ${{ number_format($item->sale_price, 2) }}
                                            </td>
                                            <td class="py-3 px-4 border-bottom text-center text-dark font-weight-medium">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="py-3 px-4 border-bottom text-right text-dark font-weight-bold">
                                                ${{ number_format($item->total, 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card address-card h-100">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h6 class="card-title mb-0 font-weight-bold text-dark">
                                        <i class="icon-location-pin mr-2 text-primary"></i>
                                        Billing Address
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="address-content">
                                        <p class="mb-2 font-weight-medium text-dark">{{ $order->billing_name }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->billing_email }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->billing_phone }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->billing_address }}</p>
                                        <p class="mb-0 text-muted small">{{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_zipcode }}</p>
                                        <p class="mb-0 text-muted small">{{ $order->billing_country }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card address-card h-100">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h6 class="card-title mb-0 font-weight-bold text-dark">
                                        <i class="icon-truck mr-2 text-primary"></i>
                                        Shipping Address
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="address-content">
                                        <p class="mb-2 font-weight-medium text-dark">{{ $order->shipping_name }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->shipping_phone }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->shipping_address }}</p>
                                        <p class="mb-0 text-muted small">{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zipcode }}</p>
                                        <p class="mb-0 text-muted small">{{ $order->shipping_country }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary & Actions -->
                <div class="col-lg-4">
                    <div class="sticky-sidebar-wrapper">
                        <!-- Action Buttons - Moved to Top -->
                        <div class="action-buttons mb-4">
                            <div class="confirmation-text mb-3 text-center">
                                <h5 class="text-success mb-2">Order Confirmed Successfully!</h5>
                                <p class="text-muted small mb-0">Your order #{{ $order->order_number }} has been placed</p>
                            </div>
                            <div class="d-grid gap-3">
                                <a href="{{ route('order.tracking', $order->id) }}" class="btn btn-primary btn-lg shadow-sm">
                                    <i class="icon-truck mr-2"></i> Track Your Order
                                </a>
                                <a href="{{ route('order.details', $order->id) }}" class="btn btn-outline-primary btn-lg">
                                    <i class="icon-file-text mr-2"></i> View Order Details
                                </a>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">
                                            <i class="icon-shopping-bag mr-1"></i> Shop More
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('order.history') }}" class="btn btn-outline-info w-100">
                                            <i class="icon-list mr-1"></i> History
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="card order-summary-card">
                            <div class="card-header bg-primary text-white py-3">
                                <h5 class="card-title mb-0 font-weight-bold">
                                    <i class="icon-file-text mr-2"></i>
                                    Order Summary
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Order Meta -->
                                <div class="order-meta mb-4">
                                    <div class="meta-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Order Number</span>
                                        <span class="font-weight-medium text-dark">{{ $order->order_number }}</span>
                                    </div>
                                    <div class="meta-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Order Date</span>
                                        <span class="font-weight-medium text-dark">{{ $order->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="meta-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Payment Method</span>
                                        <span class="font-weight-medium text-dark text-capitalize">{{ $order->payment_method }}</span>
                                    </div>
                                    <div class="meta-item d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Payment Status</span>
                                        <span class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} px-2 py-1">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Order Totals -->
                                <div class="order-totals">
                                    <div class="total-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Subtotal</span>
                                        <span class="font-weight-medium text-dark">${{ number_format($order->subtotal, 2) }}</span>
                                    </div>

                                    @if($order->discount > 0)
                                    <div class="total-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Discount</span>
                                        <span class="font-weight-medium text-danger">-${{ number_format($order->discount, 2) }}</span>
                                    </div>
                                    @endif

                                    <div class="total-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Shipping</span>
                                        <span class="font-weight-medium text-dark">
                                            @if($order->shipping_charge == 0)
                                                <span class="text-success">FREE</span>
                                            @else
                                                ${{ number_format($order->shipping_charge, 2) }}
                                            @endif
                                        </span>
                                    </div>

                                    <div class="total-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Tax</span>
                                        <span class="font-weight-medium text-dark">${{ number_format($order->tax_amount, 2) }}</span>
                                    </div>

                                    <hr class="my-3">

                                    <div class="total-item d-flex justify-content-between align-items-center mb-0">
                                        <strong class="text-dark">Grand Total</strong>
                                        <strong class="text-primary h5 mb-0">${{ number_format($order->grand_total, 2) }}</strong>
                                    </div>
                                </div>

                                @if($order->notes)
                                <div class="order-notes mt-4 pt-3 border-top">
                                    <h6 class="font-weight-bold text-dark mb-2">Order Notes</h6>
                                    <p class="text-muted small mb-0">{{ $order->notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Support Information -->
                        <div class="support-info mt-4">
                            <div class="card border-0 bg-light">
                                <div class="card-body text-center py-4">
                                    <div class="support-icon mb-3">
                                        <i class="icon-headphones text-primary" style="font-size: 40px;"></i>
                                    </div>
                                    <h6 class="font-weight-bold text-dark mb-3">Need Help With Your Order?</h6>
                                    <div class="support-details">
                                        <p class="mb-2 small text-muted">
                                            <i class="icon-envelope mr-2"></i>support@yourstore.com
                                        </p>
                                        <p class="mb-2 small text-muted">
                                            <i class="icon-phone mr-2"></i>+880 1XXX-XXXXXX
                                        </p>
                                        <p class="mb-0 small text-muted">
                                            <i class="icon-clock mr-2"></i>9AM - 6PM (Sat - Thu)
                                        </p>
                                    </div>
                                </div>
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
/* Order Status Banner */
.order-status-banner .status-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.order-status-banner .status-icon.success {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.order-status-banner .status-icon.info {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
}

.order-status-banner .status-icon.warning {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

/* Product Images - EXTRA SMALL SIZE (15px x 15px) */
.product-image-xs {
    width: 15px !important;
    height: 15px !important;
    object-fit: cover;
    border: 1px solid #e9ecef;
    border-radius: 3px;
}

.product-image-placeholder-xs {
    width: 15px !important;
    height: 15px !important;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 3px;
    font-size: 8px !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

.order-item-row:hover {
    background-color: #f8f9ff !important;
}

/* Cards */
.order-items-section,
.address-card,
.order-summary-card {
    border: none;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    overflow: hidden;
}

.order-summary-card .card-header {
    border-radius: 12px 12px 0 0 !important;
}

/* Sticky Sidebar - FIXED */
.sticky-sidebar-wrapper {
    position: sticky;
    top: 20px;
    z-index: 10;
}

/* Badges */
.badge-lg {
    font-size: 13px;
    padding: 8px 16px;
    border-radius: 20px;
}

/* Action Buttons - Improved */
.action-buttons {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
}

.confirmation-text {
    padding-bottom: 15px;
    border-bottom: 2px dashed #e9ecef;
    margin-bottom: 20px;
}

.action-buttons .btn {
    border-radius: 10px;
    padding: 14px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.action-buttons .btn-primary {
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    border-color: #4e54c8;
}

.action-buttons .btn-outline-primary {
    border-color: #4e54c8;
    color: #4e54c8;
}

.action-buttons .btn-outline-primary:hover {
    background: #4e54c8;
    color: white;
}

/* Support Section */
.support-info .card {
    border-radius: 12px;
}

.support-icon {
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Table improvements */
.table th {
    border-top: none;
    font-weight: 600;
    font-size: 14px;
}

.table td {
    vertical-align: middle;
    font-size: 14px;
}

/* Confirmation Message */
.confirmation-message {
    background: linear-gradient(135deg, #f8f9ff, #e9ecef);
    padding: 40px;
    border-radius: 15px;
    border-left: 5px solid #28a745;
}

/* Product variants badges */
.product-variants .badge {
    font-size: 10px;
    padding: 4px 8px;
}

/* Responsive Design */
@media (max-width: 991px) {
    .sticky-sidebar-wrapper {
        position: static;
    }

    .product-image-xs {
        width: 12px !important;
        height: 12px !important;
    }

    .product-image-placeholder-xs {
        width: 12px !important;
        height: 12px !important;
        font-size: 6px !important;
    }
}

@media (max-width: 768px) {
    .order-status-banner .d-flex {
        flex-direction: column;
        text-align: center;
    }

    .order-status-banner .status-icon {
        margin: 0 auto 15px auto;
    }

    .confirmation-message {
        padding: 25px;
    }

    .action-buttons {
        padding: 20px;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.order-status-banner,
.order-items-section,
.order-summary-card,
.confirmation-message,
.action-buttons {
    animation: fadeInUp 0.6s ease-out;
}

/* Order item row animation */
.order-item-row {
    transition: all 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Add smooth animations
    $('.order-item-row').each(function(index) {
        $(this).delay(100 * index).fadeIn(300);
    });

    // Print functionality
    $('.btn-print').on('click', function() {
        window.print();
    });

    // Sticky sidebar behavior
    $(window).scroll(function() {
        var stickySidebar = $('.sticky-sidebar-wrapper');
        var sidebarOffset = stickySidebar.offset().top;
        var scrollTop = $(window).scrollTop();

        if (scrollTop >= sidebarOffset) {
            stickySidebar.addClass('sticky-active');
        } else {
            stickySidebar.removeClass('sticky-active');
        }
    });
});
</script>
@endpush
