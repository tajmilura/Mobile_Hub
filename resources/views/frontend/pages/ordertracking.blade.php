@extends('frontend.front_app')
@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Track Your Order<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('order.history') }}">Order History</a></li>
                <li class="breadcrumb-item active" aria-current="page">Track Order</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if(isset($order))
            <div class="row">
                <div class="col-lg-8">
                    <!-- Order Status Timeline -->
                    <div class="card tracking-timeline-card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold text-dark">
                                <i class="fas fa-truck me-2 text-primary"></i>
                                Order Tracking - #{{ $order->order_number }}
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="tracking-timeline">
                                @php
                                    $statuses = [
                                        'pending' => [
                                            'icon' => 'fas fa-shopping-cart',
                                            'title' => 'Order Placed',
                                            'description' => 'Your order has been received',
                                            'date_field' => 'created_at'
                                        ],
                                        'confirmed' => [
                                            'icon' => 'fas fa-check-circle',
                                            'title' => 'Order Confirmed',
                                            'description' => 'Your order has been confirmed',
                                            'date_field' => 'confirmed_at'
                                        ],
                                        'processing' => [
                                            'icon' => 'fas fa-cog',
                                            'title' => 'Processing',
                                            'description' => 'Your order is being processed',
                                            'date_field' => 'processing_at'
                                        ],
                                        'shipped' => [
                                            'icon' => 'fas fa-shipping-fast',
                                            'title' => 'Shipped',
                                            'description' => 'Your order has been shipped',
                                            'date_field' => 'shipped_at'
                                        ],
                                        'delivered' => [
                                            'icon' => 'fas fa-home',
                                            'title' => 'Delivered',
                                            'description' => 'Your order has been delivered',
                                            'date_field' => 'delivered_at'
                                        ]
                                    ];

                                    $statusKeys = array_keys($statuses);
                                    $currentStatusIndex = array_search($order->status, $statusKeys);
                                @endphp

                                @foreach($statuses as $status => $details)
                                    @php
                                        $isCompleted = array_search($status, $statusKeys) <= $currentStatusIndex;
                                        $isCurrent = $order->status === $status;
                                        $hasDate = $isCompleted && $order->{$details['date_field']};

                                        // Color logic
                                        if($isCompleted) {
                                            $colorClass = 'completed';
                                            $iconColor = 'success';
                                        } else {
                                            $colorClass = 'pending';
                                            $iconColor = 'secondary';
                                        }

                                        if($isCurrent && !$isCompleted) {
                                            $colorClass = 'current';
                                            $iconColor = 'warning';
                                        }
                                    @endphp

                                    <div class="timeline-item {{ $colorClass }}">
                                        <div class="timeline-icon bg-{{ $iconColor }}">
                                            <i class="{{ $details['icon'] }}"></i>
                                        </div>
                                        <div class="timeline-content border-{{ $iconColor }}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">{{ $details['title'] }}</h6>
                                                    <p class="mb-1 text-muted small">{{ $details['description'] }}</p>
                                                </div>
                                                @if($hasDate)
                                                    <small class="text-{{ $iconColor }} fw-medium">
                                                        <i class="fas fa-check me-1"></i>
                                                        {{ $order->{$details['date_field']}->format('M d, Y h:i A') }}
                                                    </small>
                                                @endif
                                            </div>

                                            @if($isCurrent && !$isCompleted)
                                                <small class="text-warning fw-medium">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Currently at this stage
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Progress Bar -->
                            <div class="progress-tracker mt-4">
                                <div class="progress" style="height: 8px;">
                                    @php
                                        $progressPercentage = (($currentStatusIndex + 1) / count($statuses)) * 100;
                                    @endphp
                                    <div class="progress-bar bg-success"
                                         role="progressbar"
                                         style="width: {{ $progressPercentage }}%"
                                         aria-valuenow="{{ $progressPercentage }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted">Order Placed</small>
                                    <small class="text-muted">{{ number_format($progressPercentage, 0) }}% Complete</small>
                                    <small class="text-muted">Delivered</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="card shipping-info-card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold text-dark">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                Shipping Information
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <h6 class="fw-semibold mb-3 text-dark">Shipping Address</h6>
                                    <div class="shipping-details">
                                        <p class="mb-2 fw-medium">{{ $order->shipping_name }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->shipping_address }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}</p>
                                        <p class="mb-2 text-muted small">{{ $order->shipping_country }}</p>
                                        <p class="mb-0 text-muted small">
                                            <i class="fas fa-phone me-1"></i> {{ $order->shipping_phone }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-3 text-dark">Delivery Information</h6>
                                    <div class="delivery-details">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted small">Estimated Delivery:</span>
                                            <span class="fw-medium small">{{ $order->created_at->addDays(7)->format('F d, Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted small">Shipping Method:</span>
                                            <span class="fw-medium small">Standard Delivery</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted small">Tracking Number:</span>
                                            <span class="fw-medium small {{ $order->tracking_number ? 'text-primary' : 'text-muted' }}">
                                                {{ $order->tracking_number ?: 'Not assigned yet' }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">Carrier:</span>
                                            <span class="fw-medium small">{{ $order->shipping_method ?? 'Standard Courier' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card order-summary-card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold text-dark">Order Summary</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="order-meta mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted small">Order Number:</span>
                                    <span class="fw-semibold small">{{ $order->order_number }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted small">Order Date:</span>
                                    <span class="fw-semibold small">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted small">Order Status:</span>
                                    <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} px-2 py-1 small">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Payment Status:</span>
                                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} px-2 py-1 small">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="order-items-preview mb-4">
                                <h6 class="fw-semibold mb-3 text-dark">Order Items ({{ $order->Items->count() }})</h6>
                                @foreach($order->Items->take(3) as $item)
                                <div class="order-item-preview d-flex align-items-center mb-3 p-2 bg-light rounded">
                                    @if($item->product_image)
                                    <img src="{{ asset('storage/' . $item->product_image) }}"
                                         alt="{{ $item->product_name }}"
                                         class="product-image-xs me-3 rounded">
                                    @else
                                    <div class="product-image-placeholder-xs me-3 rounded d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image text-muted small"></i>
                                    </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <p class="mb-1 small fw-medium text-dark">{{ Str::limit($item->product_name, 25) }}</p>
                                        <p class="mb-0 small text-muted">Qty: {{ $item->quantity }} × ${{ number_format($item->sale_price, 2) }}</p>
                                    </div>
                                </div>
                                @endforeach

                                @if($order->Items->count() > 3)
                                <p class="text-center small text-muted mt-2 mb-0">
                                    +{{ $order->Items->count() - 3 }} more items
                                </p>
                                @endif
                            </div>

                            <hr class="my-4">

                            <div class="order-total text-center">
                                <h4 class="text-primary fw-bold mb-1">${{ number_format($order->grand_total, 2) }}</h4>
                                <p class="small text-muted mb-0">Total Amount</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons mb-4">
                        <div class="d-grid gap-3">
                            <a href="{{ route('order.details', $order->id) }}" class="btn btn-outline-primary py-3 fw-semibold">
                                <i class="fas fa-eye me-2"></i> View Order Details
                            </a>
                            <a href="{{ route('order.print', $order->id) }}" class="btn btn-outline-secondary py-3 fw-semibold" target="_blank">
                                <i class="fas fa-print me-2"></i> Print Order
                            </a>
                            <a href="{{ route('order.invoice', $order->id) }}" class="btn btn-outline-info py-3 fw-semibold">
                                <i class="fas fa-download me-2"></i> Download Invoice
                            </a>
                            @if(in_array($order->status, ['pending', 'confirmed']))
                            <button type="button" class="btn btn-outline-danger py-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                <i class="fas fa-times me-2"></i> Cancel Order
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Support Card -->
                    <div class="card support-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="support-icon mb-3">
                                <i class="fas fa-headset text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="fw-semibold mb-3 text-dark">Need Help?</h6>
                            <p class="small text-muted mb-3">Our support team is here to help</p>
                            <div class="support-details">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-envelope text-muted me-2 small"></i>
                                    <span class="small">support@yourstore.com</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-phone text-muted me-2 small"></i>
                                    <span class="small">+880 1XXX-XXXXXX</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-clock text-muted me-2 small"></i>
                                    <span class="small">9AM - 6PM (Sat - Thu)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</main>

<!-- Cancel Order Modal -->
@if(isset($order) && in_array($order->status, ['pending', 'confirmed']))
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
/* Timeline Styling */
.tracking-timeline {
    position: relative;
    padding-left: 40px;
}

.tracking-timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #28a745 0%, #28a745 100%);
    z-index: 1;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-icon {
    position: absolute;
    left: -40px;
    top: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: 3px solid white;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

/* Completed Status - Green */
.timeline-item.completed .timeline-icon {
    background: #28a745 !important;
    animation: pulse-green 2s infinite;
}

.timeline-item.completed .timeline-content {
    border-color: #28a745 !important;
    background: linear-gradient(135deg, #f8fff9 0%, #ffffff 100%);
    box-shadow: 0 2px 12px rgba(40, 167, 69, 0.15);
}

/* Current Status - Blue */
.timeline-item.current .timeline-icon {
    background: #007bff !important;
    animation: pulse-blue 2s infinite;
}

.timeline-item.current .timeline-content {
    border-color: #007bff !important;
    background: linear-gradient(135deg, #f0f8ff 0%, #ffffff 100%);
    box-shadow: 0 2px 12px rgba(0, 123, 255, 0.15);
}

/* Pending Status - Gray */
.timeline-item.pending .timeline-icon {
    background: #6c757d !important;
}

.timeline-item.pending .timeline-content {
    border-color: #dee2e6 !important;
    background: #f8f9fa;
    opacity: 0.7;
}

.timeline-content {
    padding: 20px;
    border-radius: 10px;
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
}

/* Animation for completed stages */
@keyframes pulse-green {
    0% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
        transform: scale(1);
    }
}

@keyframes pulse-blue {
    0% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
        transform: scale(1);
    }
}

/* Progress Bar */
.progress-tracker {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #e9ecef;
}

.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    border-radius: 10px;
    transition: width 0.6s ease;
}

/* Product Images */
.product-image-xs {
    width: 45px !important;
    height: 45px !important;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

/* Responsive Design */
@media (max-width: 768px) {
    .tracking-timeline {
        padding-left: 30px;
    }

    .tracking-timeline::before {
        left: 15px;
    }

    .timeline-icon {
        left: -30px;
        width: 30px;
        height: 30px;
    }
}

/* Status Legend */
.status-legend {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.status-legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.status-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.status-completed { background: #28a745; }
.status-current { background: #007bff; }
.status-pending { background: #6c757d; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Timeline animation
    $('.timeline-item').each(function(index) {
        $(this).delay(200 * index).fadeIn(400);
    });

    // Progress bar animation
    $('.progress-bar').each(function() {
        $(this).css('width', '0%');
        setTimeout(() => {
            $(this).css('width', $(this).attr('style').split('width:')[1].split('%')[0] + '%');
        }, 500);
    });
});
</script>
@endpush
