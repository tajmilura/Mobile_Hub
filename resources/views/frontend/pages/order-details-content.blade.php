<!-- Order Status Header -->
<div class="order-status-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h4 class="mb-1">Order #{{ $order->order_number }}</h4>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('F d, Y \\a\\t h:i A') }}</p>
        </div>
        <div class="col-md-6 text-md-right">
            <div class="order-status-badges">
                <span class="badge badge-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} badge-lg p-2 mr-2">
                    {{ ucfirst($order->status) }}
                </span>
                <span class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} badge-lg p-2">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Order Progress Timeline -->
<div class="card progress-timeline-card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0"><i class="icon-truck"></i> Order Progress</h5>
    </div>
    <div class="card-body">
        <div class="order-progress">
            @php
                $steps = [
                    'pending' => ['icon' => 'icon-shopping-bag', 'title' => 'Order Placed', 'active' => true],
                    'confirmed' => ['icon' => 'icon-check-circle', 'title' => 'Confirmed', 'active' => in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered'])],
                    'processing' => ['icon' => 'icon-settings', 'title' => 'Processing', 'active' => in_array($order->status, ['processing', 'shipped', 'delivered'])],
                    'shipped' => ['icon' => 'icon-truck', 'title' => 'Shipped', 'active' => in_array($order->status, ['shipped', 'delivered'])],
                    'delivered' => ['icon' => 'icon-home', 'title' => 'Delivered', 'active' => $order->status === 'delivered']
                ];
            @endphp

            <div class="progress-steps">
                @foreach($steps as $status => $step)
                <div class="progress-step {{ $step['active'] ? 'active' : '' }}">
                    <div class="step-icon">
                        <i class="{{ $step['icon'] }}"></i>
                    </div>
                    <div class="step-content">
                        <h6 class="mb-1">{{ $step['title'] }}</h6>
                        @if($step['active'])
                            @if($status === 'pending')
                                <small class="text-success">{{ $order->created_at->format('M d, Y') }}</small>
                            @elseif($status === 'confirmed' && $order->confirmed_at)
                                <small class="text-success">{{ $order->confirmed_at->format('M d, Y') }}</small>
                            @elseif($status === 'processing' && $order->processing_at)
                                <small class="text-success">{{ $order->processing_at->format('M d, Y') }}</small>
                            @elseif($status === 'shipped' && $order->shipped_at)
                                <small class="text-success">{{ $order->shipped_at->format('M d, Y') }}</small>
                            @elseif($status === 'delivered' && $order->delivered_at)
                                <small class="text-success">{{ $order->delivered_at->format('M d, Y') }}</small>
                            @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Order Items -->
<div class="card order-items-card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Order Items ({{ $order->Items->count() }})</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->Items as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($item->product_image)
                                <img src="{{ asset('storage/' . $item->product_image) }}"
                                     alt="{{ $item->product_name }}"
                                     style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px; border-radius: 8px;">
                                @else
                                <div style="width: 60px; height: 60px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; margin-right: 15px; border-radius: 8px;">
                                    <i class="icon-image" style="color: #ccc; font-size: 24px;"></i>
                                </div>
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                    @if($item->product_sku)
                                    <p class="mb-1 small text-muted">SKU: {{ $item->product_sku }}</p>
                                    @endif
                                    @if($item->color || $item->size)
                                    <div class="product-variants">
                                        @if($item->color)
                                        <span class="badge badge-light mr-1">
                                            Color: {{ $item->color }}
                                        </span>
                                        @endif
                                        @if($item->size)
                                        <span class="badge badge-light">
                                            Size: {{ $item->size }}
                                        </span>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>${{ number_format($item->sale_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td><strong>${{ number_format($item->total, 2) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Summary -->
<div class="card order-summary-card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Order Summary</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="summary-item">
                    <h6>Billing Address</h6>
                    <p class="mb-1">{{ $order->billing_name }}</p>
                    <p class="mb-1">{{ $order->billing_email }}</p>
                    <p class="mb-1">{{ $order->billing_phone }}</p>
                    <p class="mb-1">{{ $order->billing_address }}</p>
                    <p class="mb-1">{{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zipcode }}</p>
                    <p class="mb-0">{{ $order->billing_country }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="summary-item">
                    <h6>Shipping Address</h6>
                    <p class="mb-1">{{ $order->shipping_name }}</p>
                    <p class="mb-1">{{ $order->shipping_phone }}</p>
                    <p class="mb-1">{{ $order->shipping_address }}</p>
                    <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}</p>
                    <p class="mb-0">{{ $order->shipping_country }}</p>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="summary-item">
                    <h6>Payment Information</h6>
                    <p class="mb-1"><strong>Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                    <p class="mb-1"><strong>Status:</strong>
                        <span class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    @if($order->paid_at)
                    <p class="mb-0"><strong>Paid On:</strong> {{ $order->paid_at->format('M d, Y') }}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="summary-item">
                    <h6>Shipping Information</h6>
                    <p class="mb-1"><strong>Method:</strong> {{ $order->shipping_method ?? 'Standard Delivery' }}</p>
                    @if($order->tracking_number)
                    <p class="mb-1"><strong>Tracking #:</strong> {{ $order->tracking_number }}</p>
                    @endif
                    <p class="mb-0"><strong>Estimated Delivery:</strong>
                        {{ $order->created_at->addDays(7)->format('F d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        @if($order->notes)
        <hr>
        <div class="summary-item">
            <h6>Order Notes</h6>
            <p class="text-muted">{{ $order->notes }}</p>
        </div>
        @endif
    </div>
</div>

<!-- Order Totals -->
<div class="card order-totals-card">
    <div class="card-header">
        <h5 class="card-title mb-0">Order Totals</h5>
    </div>
    <div class="card-body">
        <div class="totals-table">
            <div class="total-row d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>

            @if($order->discount > 0)
            <div class="total-row d-flex justify-content-between mb-2">
                <span>Discount:</span>
                <span class="text-danger">-${{ number_format($order->discount, 2) }}</span>
            </div>
            @endif

            <div class="total-row d-flex justify-content-between mb-2">
                <span>Shipping:</span>
                <span>
                    @if($order->shipping_charge == 0)
                        <span class="text-success">FREE</span>
                    @else
                        ${{ number_format($order->shipping_charge, 2) }}
                    @endif
                </span>
            </div>

            <div class="total-row d-flex justify-content-between mb-2">
                <span>Tax:</span>
                <span>${{ number_format($order->tax_amount, 2) }}</span>
            </div>

            <hr>

            <div class="total-row d-flex justify-content-between mb-0">
                <strong>Grand Total:</strong>
                <strong class="text-primary">${{ number_format($order->grand_total, 2) }}</strong>
            </div>
        </div>
    </div>
</div>
