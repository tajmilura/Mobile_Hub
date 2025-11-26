@extends('frontend.front_app')
@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Order Details<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('order.history') }}">Order History</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Details</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <!-- Success Alert -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle mr-2" style="font-size: 20px;"></i>
                    <span class="font-weight-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

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
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-1 text-success">Payment Confirmed!</h3>
                                                <p class="text-muted mb-0">Thank you for your order. We're preparing your items.</p>
                                            </div>
                                        </div>
                                        @elseif($order->payment_method === 'cod' && $order->payment_status === 'pending')
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon info mr-3">
                                                <i class="fas fa-shopping-bag"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-1 text-info">Order Confirmed!</h3>
                                                <p class="text-muted mb-0">Pay <strong class="text-dark">${{ number_format($order->grand_total, 2) }}</strong> when you receive your order.</p>
                                            </div>
                                        </div>
                                        @elseif($order->status === 'pending')
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon warning mr-3">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-1 text-warning">Pending Payment</h3>
                                                <p class="text-muted mb-0">Waiting for payment confirmation.</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <div class="order-badge">
                                            <span class="badge bg-{{ $order->status === 'confirmed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }} badge-lg px-3 py-2">
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
                            <h5 class="card-title mb-0 fw-bold text-dark">
                                <i class="fas fa-box-open me-2 text-primary"></i>
                                Order Items ({{ $order->Items->count() }})
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 py-3 px-4 fw-semibold text-dark">Product</th>
                                            <th class="border-0 py-3 px-4 fw-semibold text-dark text-center">Price</th>
                                            <th class="border-0 py-3 px-4 fw-semibold text-dark text-center">Qty</th>
                                            <th class="border-0 py-3 px-4 fw-semibold text-dark text-end">Total</th>
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
                                                         class="product-image-xs me-3 rounded">
                                                    @else
                                                    <div class="product-image-placeholder-xs me-3 rounded d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-semibold text-dark">{{ $item->product_name }}</h6>
                                                        <div class="product-variants">
                                                            @if($item->color)
                                                            <span class="badge bg-light text-dark me-1">
                                                                <i class="fas fa-palette me-1"></i>{{ $item->color }}
                                                            </span>
                                                            @endif
                                                            @if($item->size)
                                                            <span class="badge bg-light text-dark">
                                                                <i class="fas fa-ruler me-1"></i>{{ $item->size }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 border-bottom text-center fw-semibold text-dark">
                                                ${{ number_format($item->sale_price, 2) }}
                                            </td>
                                            <td class="py-3 px-4 border-bottom text-center fw-semibold text-dark">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="py-3 px-4 border-bottom text-end fw-bold text-dark">
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
                        <div class="col-md-6 mb-3">
                            <div class="card address-card h-100">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h6 class="card-title mb-0 fw-bold text-dark">
                                        <i class="fas fa-location-dot me-2 text-primary"></i>
                                        Billing Address
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="address-content">
                                        <p class="mb-2 fw-semibold text-dark">{{ $order->billing_name }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->billing_email }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->billing_phone }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->billing_address }}</p>
                                        <p class="mb-0 text-muted small">{{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_zipcode }}</p>
                                        <p class="mb-0 text-muted small">{{ $order->billing_country }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card address-card h-100">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h6 class="card-title mb-0 fw-bold text-dark">
                                        <i class="fas fa-truck me-2 text-primary"></i>
                                        Shipping Address
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="address-content">
                                        <p class="mb-2 fw-semibold text-dark">{{ $order->shipping_name }}</p>
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
                        <!-- Order Summary -->
                        <div class="card order-summary-card mb-4">
                            <div class="card-header bg-primary text-white py-3">
                                <h5 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-file-invoice me-2"></i>
                                    Order Summary
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Order Meta -->
                                <div class="order-meta mb-4">
                                    <div class="meta-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Order Number</span>
                                        <span class="fw-semibold text-dark">{{ $order->order_number }}</span>
                                    </div>
                                    <div class="meta-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Order Date</span>
                                        <span class="fw-semibold text-dark">{{ $order->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="meta-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Payment Method</span>
                                        <span class="fw-semibold text-dark text-capitalize">{{ $order->payment_method }}</span>
                                    </div>
                                    <div class="meta-item d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Payment Status</span>
                                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} px-2 py-1">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Order Totals -->
                                <div class="order-totals">
                                    <div class="total-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Subtotal</span>
                                        <span class="fw-semibold text-dark">${{ number_format($order->subtotal, 2) }}</span>
                                    </div>

                                    @if($order->discount > 0)
                                    <div class="total-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Discount</span>
                                        <span class="fw-semibold text-danger">-${{ number_format($order->discount, 2) }}</span>
                                    </div>
                                    @endif

                                    <div class="total-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Shipping</span>
                                        <span class="fw-semibold text-dark">
                                            @if($order->shipping_charge == 0)
                                                <span class="text-success">FREE</span>
                                            @else
                                                ${{ number_format($order->shipping_charge, 2) }}
                                            @endif
                                        </span>
                                    </div>

                                    <div class="total-item d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Tax</span>
                                        <span class="fw-semibold text-dark">${{ number_format($order->tax_amount, 2) }}</span>
                                    </div>

                                    <hr class="my-3">

                                    <div class="total-item d-flex justify-content-between align-items-center mb-0">
                                        <strong class="text-dark">Grand Total</strong>
                                        <strong class="text-primary h5 mb-0">${{ number_format($order->grand_total, 2) }}</strong>
                                    </div>
                                </div>

                                @if($order->notes)
                                <div class="order-notes mt-4 pt-3 border-top">
                                    <h6 class="fw-bold text-dark mb-2">Order Notes</h6>
                                    <p class="text-muted small mb-0">{{ $order->notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="card order-actions-card mb-4">
                            <div class="card-header bg-white border-bottom py-3">
                                <h5 class="card-title mb-0 fw-bold text-dark">
                                    <i class="fas fa-cogs me-2 text-primary"></i>
                                    Order Actions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-3">
                                    <a href="{{ route('order.print', $order->id) }}" class="btn btn-outline-primary py-3 fw-semibold" target="_blank">
                                        <i class="fas fa-print me-2"></i> Print Order
                                    </a>
                                    <a href="{{ route('order.invoice', $order->id) }}" class="btn btn-outline-info py-3 fw-semibold">
                                        <i class="fas fa-download me-2"></i> Download Invoice (PDF)
                                    </a>
                                    <a href="{{ route('order.invoice.view', $order->id) }}" class="btn btn-outline-secondary py-3 fw-semibold">
                                        <i class="fas fa-eye me-2"></i> View Invoice
                                    </a>
                                    <a href="{{ route('order.tracking', $order->id) }}" class="btn btn-outline-success py-3 fw-semibold">
                                        <i class="fas fa-truck me-2"></i> Track Order
                                    </a>
                                    @if(in_array($order->status, ['pending', 'confirmed']))
                                    <button type="button" class="btn btn-outline-danger py-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                        <i class="fas fa-times me-2"></i> Cancel Order
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Support Information -->
                        <div class="support-info">
                            <div class="card border-0 bg-light">
                                <div class="card-body text-center py-4">
                                    <div class="support-icon mb-3">
                                        <i class="fas fa-headset text-primary" style="font-size: 40px;"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-3">Need Help With Your Order?</h6>
                                    <div class="support-details">
                                        <p class="mb-2 small text-muted">
                                            <i class="fas fa-envelope me-2"></i>support@yourstore.com
                                        </p>
                                        <p class="mb-2 small text-muted">
                                            <i class="fas fa-phone me-2"></i>+880 1XXX-XXXXXX
                                        </p>
                                        <p class="mb-0 small text-muted">
                                            <i class="fas fa-clock me-2"></i>9AM - 6PM (Sat - Thu)
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

<!-- Cancel Order Modal -->
@if(in_array($order->status, ['pending', 'confirmed']))
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                @csrf
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold text-dark">Cancel Order #{{ $order->order_number }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-3">Are you sure you want to cancel this order?</p>
                    <div class="mb-3">
                        <label for="cancellation_reason" class="form-label fw-semibold">Reason for Cancellation</label>
                        <textarea class="form-control" id="cancellation_reason" name="cancellation_reason"
                                  rows="3" required placeholder="Please tell us why you want to cancel this order"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top py-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Order</button>
                    <button type="submit" class="btn btn-danger">Cancel Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
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

/* Product Images - Small Size */
.product-image-xs {
    width: 45px !important;
    height: 45px !important;
    object-fit: cover;
    border: 1px solid #e9ecef;
    border-radius: 6px;
}

.product-image-placeholder-xs {
    width: 45px !important;
    height: 45px !important;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.order-item-row:hover {
    background-color: #f8f9ff !important;
}

/* Cards */
.order-items-section,
.address-card,
.order-summary-card,
.order-actions-card {
    border: none;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    overflow: hidden;
}

.order-summary-card .card-header {
    border-radius: 12px 12px 0 0 !important;
}

/* Sticky Sidebar */
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

/* Action Buttons */
.order-actions-card .btn {
    border-radius: 8px;
    border-width: 2px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.order-actions-card .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

/* Responsive Design */
@media (max-width: 991px) {
    .sticky-sidebar-wrapper {
        position: static;
    }

    .product-image-xs {
        width: 40px !important;
        height: 40px !important;
    }

    .product-image-placeholder-xs {
        width: 40px !important;
        height: 40px !important;
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

    .product-image-xs {
        width: 35px !important;
        height: 35px !important;
    }

    .product-image-placeholder-xs {
        width: 35px !important;
        height: 35px !important;
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
.order-actions-card {
    animation: fadeInUp 0.6s ease-out;
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
