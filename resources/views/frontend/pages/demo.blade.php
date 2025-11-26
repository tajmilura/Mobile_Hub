@extends('frontend.front_app')
@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Demo Payment<span>Shop</span></h1>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white text-center">
                            <h4 class="mb-0">Demo Payment Gateway</h4>
                        </div>
                        <div class="card-body">
                            <div class="payment-info text-center mb-4">
                                <h5>Order #{{ $payment->order->order_number }}</h5>
                                <h3 class="text-success">${{ number_format($payment->amount, 2) }}</h3>
                                <p class="text-muted">Payment Method: {{ strtoupper($payment->payment_method) }}</p>
                            </div>

                            <form action="{{ route('payment.demo.process', $payment->id) }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="demo_mobile_number">Mobile Number *</label>
                                    <input type="text" class="form-control" id="demo_mobile_number" 
                                           name="demo_mobile_number" required 
                                           placeholder="01XXXXXXXXX" value="01{{ rand(100000000, 999999999) }}">
                                    <small class="form-text text-muted">Enter any 11-digit mobile number</small>
                                </div>

                                <div class="form-group">
                                    <label for="demo_transaction_id">Transaction ID *</label>
                                    <input type="text" class="form-control" id="demo_transaction_id" 
                                           name="demo_transaction_id" required 
                                           placeholder="Enter any transaction ID" 
                                           value="TXN{{ rand(100000, 999999) }}">
                                    <small class="form-text text-muted">Enter any transaction ID for demo</small>
                                </div>

                                <div class="alert alert-info">
                                    <h6><i class="icon-info-circle"></i> Demo Instructions</h6>
                                    <p class="mb-0">This is a demo payment system. You can enter any mobile number and transaction ID to simulate a successful payment.</p>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="icon-check-circle"></i> Complete Demo Payment
                                    </button>
                                    
                                    <a href="{{ route('payment.cancel', $payment->id) }}" 
                                       class="btn btn-outline-secondary btn-lg ml-2">
                                        <i class="icon-close"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection