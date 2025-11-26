@extends('frontend.front_app')
@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Complete Payment<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
                <li class="breadcrumb-item"><a href="{{ route('checkout') }}">Checkout</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="payment-card">
                        <div class="payment-header text-center mb-4">
                            <h2>Complete Your Payment</h2>
                            <p class="text-muted">Order #{{ $payment->order->order_number }}</p>
                        </div>

                        <div class="payment-details mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <strong>Payment Method:</strong>
                                        <span class="text-capitalize">{{ $payment->payment_method }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <strong>Amount to Pay:</strong>
                                        <span class="text-success">${{ number_format($payment->amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Specific Instructions -->
                        <div class="payment-instructions">
                            @if($payment->payment_method === 'bkash')
                                <div class="bkash-instructions">
                                    <h5>Pay with bKash</h5>
                                    <ol>
                                        <li>Go to your bKash Mobile Menu by dialing *247#</li>
                                        <li>Choose "Send Money"</li>
                                        <li>Enter our bKash Account: <strong>017XXXXXXXX</strong></li>
                                        <li>Enter amount: <strong>${{ number_format($payment->amount, 2) }}</strong></li>
                                        <li>Enter reference: <strong>{{ $payment->order->order_number }}</strong></li>
                                        <li>Enter your bKash PIN to confirm</li>
                                        <li>Take a screenshot of the payment confirmation</li>
                                    </ol>
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> After payment, your order will be automatically confirmed.
                                    </div>
                                </div>

                            @elseif($payment->payment_method === 'nagad')
                                <div class="nagad-instructions">
                                    <h5>Pay with Nagad</h5>
                                    <!-- Similar instructions for Nagad -->
                                </div>

                            @elseif($payment->payment_method === 'card')
                                <div class="card-instructions">
                                    <h5>Pay with Credit/Debit Card</h5>
                                    <!-- Card payment form -->
                                    <div id="card-payment-form">
                                        <!-- This would integrate with Stripe or other payment gateway -->
                                        <p>Card payment integration would go here</p>
                                    </div>
                                </div>

                            @elseif($payment->payment_method === 'bank')
                                <div class="bank-instructions">
                                    <h5>Bank Transfer Details</h5>
                                    <!-- Bank transfer details -->
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="payment-actions text-center mt-5">
                            @if(in_array($payment->payment_method, ['bkash', 'nagad', 'rocket']))
                                <button type="button" class="btn btn-success btn-lg" id="confirm-payment">
                                    <i class="icon-check-circle"></i> I Have Completed Payment
                                </button>

                                <a href="{{ route('payment.cancel', $payment->id) }}"
                                   class="btn btn-outline-secondary btn-lg ml-3">
                                    <i class="icon-close"></i> Cancel Payment
                                </a>
                            @endif

                            <div class="mt-3">
                                <a href="{{ route('order.confirmation', $payment->order_id) }}"
                                   class="btn btn-outline-primary">
                                    <i class="icon-shopping-bag"></i> View Order Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle payment confirmation
    $('#confirm-payment').on('click', function() {
        if (confirm('Have you really completed the payment?')) {
            // Redirect to success page
            window.location.href = "{{ route('payment.success', $payment->id) }}";
        }
    });

    // Auto-redirect for demo (remove in production)
    setTimeout(function() {
        // window.location.href = "{{ route('payment.success', $payment->id) }}";
    }, 30000); // 30 seconds for demo
});
</script>
@endpush
