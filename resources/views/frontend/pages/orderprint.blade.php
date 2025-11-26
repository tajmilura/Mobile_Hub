<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->order_number }} - Print</title>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12pt; }
            .page-break { page-break-before: always; }
            .container { max-width: 100% !important; }
        }
        @media screen {
            body { background: #f8f9fa; }
            .print-container { max-width: 210mm; margin: 20px auto; background: white; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .print-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e74c3c;
        }
        .store-info h1 {
            color: #e74c3c;
            margin: 0;
            font-size: 24px;
        }
        .store-info p {
            margin: 2px 0;
            color: #666;
        }
        .order-info {
            text-align: right;
        }
        .order-info h2 {
            color: #333;
            margin: 0 0 10px 0;
            font-size: 20px;
        }
        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .address-box {
            flex: 1;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            margin: 0 10px;
            border: 1px solid #dee2e6;
        }
        .address-box:first-child {
            margin-left: 0;
        }
        .address-box:last-child {
            margin-right: 0;
        }
        .address-box h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #34495e;
            color: white;
            font-weight: bold;
        }
        .totals-table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 15px;
            border-bottom: 1px solid #ddd;
        }
        .totals-table tr:last-child td {
            border-bottom: 2px solid #333;
            font-weight: bold;
            font-size: 14px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 11px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-paid { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cce7ff; color: #004085; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .mb-0 { margin-bottom: 0; }
        .mt-20 { margin-top: 20px; }
        .print-actions {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .print-btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        .print-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="print-container" style="padding: 30px; margin: auto; background: white;">
        <!-- Print Actions -->
        <div class="print-actions no-print">
            <button class="print-btn" onclick="window.print()">
                <i class="icon-printer"></i> Print
            </button>
            <button class="print-btn" onclick="window.close()">
                <i class="icon-close"></i> Close
            </button>
        </div>

        <!-- Header -->
        <div class="print-header">
            <div class="store-info">
                <h1>{{ getSetting('site_name', "Mobile") }}</h1>
                <p>Mirpur-11, Dhaka-1212, Bangladesh</p>
                <p>Email: info@mobilehub.tajmilur.net | Phone: +880 1312378607</p>
                <p>Website: www.mobilehub.tajmilur.net</p>
            </div>
            <div class="order-info">
                <h2>ORDER RECEIPT</h2>
                <p><strong>Order #:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                <p><strong>Status:</strong>
                    <span class="status-badge status-{{ $order->payment_status }}">
                        {{ strtoupper($order->status) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Billing & Shipping Address -->
        <div class="address-section">
            <div class="address-box">
                <h3>Bill To</h3>
                <p><strong>{{ $order->billing_name }}</strong></p>
                <p>{{ $order->billing_email }}</p>
                <p>{{ $order->billing_phone }}</p>
                <p>{{ $order->billing_address }}</p>
                <p>{{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_zipcode }}</p>
                <p>{{ $order->billing_country }}</p>
            </div>
            <div class="address-box">
                <h3>Ship To</h3>
                <p><strong>{{ $order->shipping_name }}</strong></p>
                <p>{{ $order->shipping_phone }}</p>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zipcode }}</p>
                <p>{{ $order->shipping_country }}</p>
            </div>
        </div>

        <!-- Order Items -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->Items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->color || $item->size)
                        <br>
                        <small>
                            @if($item->color) Color: {{ $item->color }} @endif
                            @if($item->size) | Size: {{ $item->size }} @endif
                        </small>
                        @endif
                        @if($item->product_sku)
                        <br><small>SKU: {{ $item->product_sku }}</small>
                        @endif
                    </td>
                    <td>${{ number_format($item->sale_price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->total, 2) }} TK </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Order Totals -->
        <table class="totals-table">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">{{ number_format($order->subtotal, 2) }} TK </td>
            </tr>
            @if($order->discount > 0)
            <tr>
                <td>Discount:</td>
                <td class="text-right">-{{ number_format($order->discount, 2) }}TK </td>
            </tr>
            @endif
            <tr>
                <td>Shipping:</td>
                <td class="text-right">
                    @if($order->shipping_charge == 0)
                        FREE
                    @else
                        {{ number_format($order->shipping_charge, 2) }} TK
                    @endif

                </td>
            </tr>
            <tr>
                <td>Tax:</td>
                <td class="text-right">{{ number_format($order->tax_amount, 2) }} TK </td>
            </tr>
            <tr>
                <td><strong>Grand Total:</strong></td>
                <td class="text-right"><strong>{{ number_format($order->grand_total, 2) }} TK </strong></td>
            </tr>
        </table>

        <!-- Payment & Shipping Information -->
        <div class="mt-20">
            <div class="address-section">
                <div class="address-box">
                    <h3>Payment Information</h3>
                    <p><strong>Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                    <p><strong>Status:</strong>
                        <span class="status-badge status-{{ $order->payment_status }}">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </p>
                    @if($order->paid_at)
                    <p><strong>Paid Date:</strong> {{ $order->paid_at->format('F d, Y h:i A') }}</p>
                    @endif
                </div>
                <div class="address-box">
                    <h3>Shipping Information</h3>
                    <p><strong>Method:</strong> {{ $order->shipping_method ?? 'Standard Delivery' }}</p>
                    @if($order->tracking_number)
                    <p><strong>Tracking #:</strong> {{ $order->tracking_number }}</p>
                    @endif
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                    <p><strong>Est. Delivery:</strong> {{ $order->created_at->addDays(7)->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Order Notes -->
        @if($order->notes)
        <div class="mt-20">
            <div class="address-box">
                <h3>Order Notes</h3>
                <p>{{ $order->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>If you have any questions about this order, please contact</p>
            <p>info@mobilehub.tajmilur.net | Phone: +880 1312378607</p>
            <p class="mb-0">This is a computer-generated receipt. No signature is required.</p>
            <p class="mb-0">Printed on: {{ now()->format('F d, Y \\a\\t h:i A') }}</p>
        </div>
    </div>

    <script>
        // Auto print when page loads (optional)
        window.onload = function() {
            // Uncomment the line below if you want auto-print
            // window.print();

            // Or show print dialog after 1 second
            setTimeout(function() {
                // window.print();
            }, 1000);
        };

        // Close window after print
        window.onafterprint = function() {
            // Optional: Close window after printing
            // window.close();
        };
    </script>
</body>
</html>
