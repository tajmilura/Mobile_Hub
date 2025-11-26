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
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .address-box {
            flex: 1;
            padding: 15px;
            border: 1px solid #ddd;
            margin: 0 10px;
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
            background-color: #f8f9fa;
        }
        .totals {
            width: 300px;
            margin-left: auto;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button class="print-btn no-print" onclick="window.print()">🖨️ Print</button>

    <!-- Header -->
    <div class="header">
        <h1>ORDER CONFIRMATION</h1>
        <h2>#{{ $order->order_number }}</h2>
        <p>Order Date: {{ $order->created_at->format('F d, Y') }}</p>
    </div>

    <!-- Order Status -->
    <div class="order-info">
        <div>
            <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
            <strong>Payment:</strong> {{ ucfirst($order->payment_status) }}
        </div>
        <div>
            <strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}<br>
            <strong>Order Total:</strong> ${{ number_format($order->grand_total, 2) }}
        </div>
    </div>

    <!-- Addresses -->
    <div class="address-section">
        <div class="address-box">
            <h3>Billing Address</h3>
            <p>{{ $order->billing_name }}<br>
            {{ $order->billing_email }}<br>
            {{ $order->billing_phone }}<br>
            {{ $order->billing_address }}<br>
            {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zipcode }}<br>
            {{ $order->billing_country }}</p>
        </div>
        <div class="address-box">
            <h3>Shipping Address</h3>
            <p>{{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address }}<br>
            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}<br>
            {{ $order->shipping_country }}</p>
        </div>
    </div>

    <!-- Order Items -->
    <h3>Order Items</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->Items as $item)
            <tr>
                <td>
                    <strong>{{ $item->product_name }}</strong>
                    @if($item->color || $item->size)
                    <br><small>
                        @if($item->color) Color: {{ $item->color }} @endif
                        @if($item->size) | Size: {{ $item->size }} @endif
                    </small>
                    @endif
                </td>
                <td>${{ number_format($item->sale_price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Order Totals -->
    <table class="totals">
        <tr>
            <td>Subtotal:</td>
            <td>${{ number_format($order->subtotal, 2) }}</td>
        </tr>
        @if($order->discount > 0)
        <tr>
            <td>Discount:</td>
            <td>-${{ number_format($order->discount, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td>Shipping:</td>
            <td>
                @if($order->shipping_charge == 0)
                    FREE
                @else
                    ${{ number_format($order->shipping_charge, 2) }}
                @endif
            </td>
        </tr>
        <tr>
            <td>Tax:</td>
            <td>${{ number_format($order->tax_amount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Grand Total:</strong></td>
            <td><strong>${{ number_format($order->grand_total, 2) }}</strong></td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your order! For any questions, contact us at support@yourstore.com</p>
        <p>Printed on: {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            // Uncomment the line below if you want auto-print
            // window.print();
        };
    </script>
</body>
</html>