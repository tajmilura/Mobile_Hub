@extends('admin.index')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-2 font-weight-bold" style="color: rgba(3, 152, 139, 0.622);">Order Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.all_order') }}">Orders</a></li>
                        <li class="breadcrumb-item active">#{{ $order->order_number }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Action Buttons -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="btn-group">
                        <a href="{{ route('order.all_order') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                        <a href="{{ route('order.edit', $order->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Order
                        </a>
                        <button class="btn btn-success" onclick="window.print()">
                            <i class="fas fa-print"></i> Print Invoice
                        </button>
                        @if($order->canBeCancelled())
                            <button class="btn btn-warning status-update" data-status="cancelled">
                                <i class="fas fa-times"></i> Cancel Order
                            </button>
                        @endif
                        @if($order->payment_status === 'paid' && $order->status !== 'refunded')
                            <button class="btn btn-danger status-update" data-status="refunded">
                                <i class="fas fa-undo"></i> Refund Order
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column - Order Details -->
                <div class="col-md-8">
                    <!-- Order Items -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order Items ({{ $order->items->count() }})</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <a href="{{ route('product.show', $item->product->id) }}" class="text-dark font-weight-bold">
                                                                                  <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                                             alt="{{ $item->product_name }}"
                                                             class="img-thumbnail mr-3"
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="img-thumbnail mr-3 d-flex align-items-center justify-content-center"
                                                             style="width: 60px; height: 60px; background: #f8f9fa;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="font-weight-bold">{{ $item->product_name }}</div>
                                                        @if($item->product)
                                                            <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                                        @endif
                                                        @if($item->variations)
                                                            <div class="text-muted small">
                                                                @foreach(json_decode($item->variations, true) as $key => $value)
                                                                    {{ $key }}: {{ $value }}@if(!$loop->last), @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                </a>

                                            </td>
                                            <td>৳{{ number_format($item->sale_price, 2) }}
                                                <div class="text-muted font-weight-bold">
                                                    <small>Original Price: ৳{{ number_format($item->product_price, 2) }}</small>
                                                </div>
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td class="font-weight-bold">৳{{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Order Timeline</h3>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="time-label">
                                    <span class="bg-success">{{ $order->created_at->format('M j, Y') }}</span>
                                </div>

                                <div>
                                    <i class="fas fa-shopping-cart bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $order->created_at->format('g:i A') }}</span>
                                        <h3 class="timeline-header">Order Placed</h3>
                                        <div class="timeline-body">
                                            Order #{{ $order->order_number }} was placed
                                        </div>
                                    </div>
                                </div>

                                @if($order->confirmed_at)
                                <div>
                                    <i class="fas fa-check bg-green"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $order->confirmed_at->format('M j, Y g:i A') }}</span>
                                        <h3 class="timeline-header">Order Confirmed</h3>
                                    </div>
                                </div>
                                @endif

                                @if($order->processing_at)
                                <div>
                                    <i class="fas fa-cog bg-orange"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $order->processing_at->format('M j, Y g:i A') }}</span>
                                        <h3 class="timeline-header">Order Processing</h3>
                                    </div>
                                </div>
                                @endif

                                @if($order->shipped_at)
                                <div>
                                    <i class="fas fa-shipping-fast bg-purple"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $order->shipped_at->format('M j, Y g:i A') }}</span>
                                        <h3 class="timeline-header">Order Shipped</h3>
                                        @if($order->tracking_number)
                                            <div class="timeline-body">
                                                Tracking Number: <strong>{{ $order->tracking_number }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($order->delivered_at)
                                <div>
                                    <i class="fas fa-box-open bg-green"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $order->delivered_at->format('M j, Y g:i A') }}</span>
                                        <h3 class="timeline-header">Order Delivered</h3>
                                    </div>
                                </div>
                                @endif

                                @if($order->cancelled_at)
                                <div>
                                    <i class="fas fa-times bg-red"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $order->cancelled_at->format('M j, Y g:i A') }}</span>
                                        <h3 class="timeline-header">Order Cancelled</h3>
                                    </div>
                                </div>
                                @endif

                                @if($order->refunded_at)
                                <div>
                                    <i class="fas fa-undo bg-dark"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $order->refunded_at->format('M j, Y g:i A') }}</span>
                                        <h3 class="timeline-header">Order Refunded</h3>
                                    </div>
                                </div>
                                @endif

                                <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="col-md-4">
                    <!-- Order Status Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order Status</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Current Status</label>
                                @php
                                    $statusColors = [
                                        'pending' => 'secondary',
                                        'confirmed' => 'info',
                                        'processing' => 'primary',
                                        'shipped' => 'warning',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                        'refunded' => 'dark'
                                    ];
                                @endphp
                                <div class="text-center">
                                    <span class="badge badge-{{ $statusColors[$order->status] }} badge-lg p-2" style="font-size: 1.1em;">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Payment Status</label>
                                @php
                                    $paymentStatusColors = [
                                        'pending' => 'warning',
                                        'paid' => 'success',
                                        'failed' => 'danger',
                                        'refunded' => 'info'
                                    ];
                                @endphp
                                <div class="text-center">
                                    <span class="badge badge-{{ $paymentStatusColors[$order->payment_status] }} badge-lg p-2" style="font-size: 1.1em;">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            @if($order->tracking_number)
                            <div class="form-group">
                                <label>Tracking Number</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $order->tracking_number }}" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="copyTrackingNumber()">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Quick Status Update -->
                            <div class="form-group">
                                <label>Update Status</label>
                                <select class="form-control" id="quickStatusUpdate">
                                    <option value="">Select Status</option>
                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    @if($order->canBeCancelled())
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Order Summary</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Subtotal:</th>
                                    <td class="text-right">৳{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if($order->discount > 0)
                                <tr>
                                    <th>Discount:</th>
                                    <td class="text-right text-danger">-৳{{ number_format($order->discount, 2) }}</td>
                                </tr>
                                @endif
                                @if($order->coupon_discount > 0)
                                <tr>
                                    <th>Coupon Discount:</th>
                                    <td class="text-right text-danger">-৳{{ number_format($order->coupon_discount, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Shipping Charge:</th>
                                    <td class="text-right">৳{{ number_format($order->shipping_charge, 2) }}</td>
                                </tr>
                                @if($order->tax_amount > 0)
                                <tr>
                                    <th>Tax:</th>
                                    <td class="text-right">৳{{ number_format($order->tax_amount, 2) }}</td>
                                </tr>
                                @endif
                                <tr class="font-weight-bold" style="border-top: 2px solid #dee2e6;">
                                    <th>Grand Total:</th>
                                    <td class="text-right text-success">৳{{ number_format($order->grand_total, 2) }}</td>
                                </tr>
                            </table>

                            @if($order->coupon)
                            <div class="alert alert-info mt-3">
                                <strong>Coupon Applied:</strong> {{ $order->coupon_code }}
                                <br>
                                <small>Type: {{ ucfirst($order->coupon_type) }} | Discount: ৳{{ number_format($order->coupon_discount, 2) }}</small>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Customer Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="customer-info">
                                <h6 class="font-weight-bold">Billing Address</h6>
                                <p class="mb-2">
                                    {{ $order->billing_name }}<br>
                                    {{ $order->billing_email }}<br>
                                    {{ $order->billing_phone }}<br>
                                    {{ $order->billing_address }}<br>
                                    {{ $order->billing_city }}, {{ $order->billing_state }}<br>
                                    {{ $order->billing_country }} - {{ $order->billing_zipcode }}
                                </p>

                                <h6 class="font-weight-bold mt-3">Shipping Address</h6>
                                <p class="mb-0">
                                    {{ $order->shipping_name }}<br>
                                    {{ $order->shipping_email }}<br>
                                    {{ $order->shipping_phone }}<br>
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
                                    {{ $order->shipping_country }} - {{ $order->shipping_zipcode }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Payment Information</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Payment Method:</th>
                                    <td class="text-right">{{ ucfirst($order->payment_method) }}</td>
                                </tr>
                                @if($order->transaction_id)
                                <tr>
                                    <th>Transaction ID:</th>
                                    <td class="text-right">
                                        <code>{{ $order->transaction_id }}</code>
                                    </td>
                                </tr>
                                @endif
                                @if($order->paid_at)
                                <tr>
                                    <th>Paid At:</th>
                                    <td class="text-right">{{ $order->paid_at->format('M j, Y g:i A') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .badge-lg {
        font-size: 1.1em;
        padding: 8px 12px;
    }
    .timeline {
        position: relative;
        margin: 0 0 30px 0;
        padding: 0;
        list-style: none;
    }
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #ddd;
        left: 31px;
        margin: 0;
        border-radius: 2px;
    }
    .timeline > li {
        position: relative;
        margin-right: 10px;
        margin-bottom: 15px;
    }
    .timeline > li:before, .timeline > li:after {
        content: " ";
        display: table;
    }
    .timeline > li:after {
        clear: both;
    }
    .timeline > li > .timeline-item {
        margin-top: 0;
        background: #fff;
        color: #444;
        margin-left: 60px;
        margin-right: 15px;
        padding: 0;
        position: relative;
        border-radius: 3px;
    }
    .timeline > li > .fa, .timeline > li > .glyphicon, .timeline > li > .ion {
        width: 30px;
        height: 30px;
        font-size: 15px;
        line-height: 30px;
        position: absolute;
        color: #666;
        background: #d2d6de;
        border-radius: 50%;
        text-align: center;
        left: 18px;
        top: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    function copyTrackingNumber() {
        const trackingNumber = "{{ $order->tracking_number }}";
        navigator.clipboard.writeText(trackingNumber).then(function() {
            toastr.success('Tracking number copied to clipboard');
        }, function() {
            toastr.error('Failed to copy tracking number');
        });
    }

    // Quick status update
    $('#quickStatusUpdate').on('change', function() {
        const newStatus = $(this).val();
        if (!newStatus) return;

        Swal.fire({
            title: 'Update Order Status?',
            text: `Are you sure you want to update this order to ${newStatus}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("order.updateStatus", $order->id) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Order status updated successfully');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to update order status');
                    $('#quickStatusUpdate').val('{{ $order->status }}');
                    }
                });
            } else {
                // Reset to current status if cancelled
                $('#quickStatusUpdate').val('{{ $order->status }}');
            }
        });
    });

    // Status update buttons
    $('.status-update').on('click', function() {
        const newStatus = $(this).data('status');

        Swal.fire({
            title: 'Update Order Status?',
            text: `Are you sure you want to mark this order as ${newStatus}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("order.updateStatus", $order->id) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Order status updated successfully');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to update order status');
                    }
                });
            }
        });
    });
</script>
@endpush
