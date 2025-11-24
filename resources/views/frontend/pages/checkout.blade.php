@extends('frontend.front_app')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Checkout<span>Shop</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="checkout">
                <div class="container">
                    <!-- Quick Checkout Alert -->
                    @if (session('direct_checkout'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="icon-bolt"></i>
                            <strong>Quick Checkout:</strong> You are purchasing directly without adding to cart.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Coupon Section -->
                    <div class="checkout-discount">
                        <form action="#" id="coupon-form">
                            @csrf
                            <input type="text" class="form-control" id="checkout-discount-input" name="coupon_code"
                                placeholder="Enter coupon code" value="{{ $couponCode ?? '' }}"
                                {{ $appliedCoupon ? 'readonly' : '' }}>
                            <label for="checkout-discount-input" class="text-truncate">
                                Have a coupon? <span>Click here to enter your code</span>
                            </label>

                            @if ($appliedCoupon)
                                <div class="coupon-applied mt-2">
                                    <span class="text-success">
                                        <i class="icon-check-circle"></i>
                                        Coupon "{{ $couponCode }}" applied successfully!
                                        (-${{ number_format($discount, 2) }})
                                    </span>
                                    <button type="button" id="remove-coupon" class="btn btn-sm btn-outline-danger ml-2">
                                        Remove
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div><!-- End .checkout-discount -->

                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <h2 class="checkout-title">Billing Details</h2>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Full Name *</label>
                                        <input type="text" class="form-control" name="billing_name" required
                                            value="{{ auth()->user()->name ?? '' }}" placeholder="Enter your full name">
                                        @error('billing_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Email *</label>
                                        <input type="email" class="form-control" name="billing_email" required
                                            value="{{ auth()->user()->email ?? '' }}" placeholder="Enter your email">
                                        @error('billing_email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-6">
                                        <label>Phone *</label>
                                        <input type="tel" class="form-control" name="billing_phone" required
                                            value="{{ auth()->user()->phone ?? '' }}"
                                            placeholder="Enter your phone number">
                                        @error('billing_phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <label>City *</label>
                                        <select class="form-control" name="billing_city" required>
                                            <option value="">Select City</option>
                                            <option value="dhaka" {{ old('billing_city') == 'dhaka' ? 'selected' : '' }}>
                                                Dhaka</option>
                                            <option value="chittagong"
                                                {{ old('billing_city') == 'chittagong' ? 'selected' : '' }}>Chittagong
                                            </option>
                                            <option value="sylhet" {{ old('billing_city') == 'sylhet' ? 'selected' : '' }}>
                                                Sylhet</option>
                                            <option value="khulna" {{ old('billing_city') == 'khulna' ? 'selected' : '' }}>
                                                Khulna</option>
                                            <option value="rajshahi"
                                                {{ old('billing_city') == 'rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                                            <option value="barisal"
                                                {{ old('billing_city') == 'barisal' ? 'selected' : '' }}>Barisal</option>
                                            <option value="rangpur"
                                                {{ old('billing_city') == 'rangpur' ? 'selected' : '' }}>Rangpur</option>
                                        </select>
                                        @error('billing_city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label>Address *</label>
                                    <textarea class="form-control" name="billing_address" rows="3" required placeholder="Enter your full address">{{ old('billing_address') }}</textarea>
                                    @error('billing_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-6">
                                        <label>State *</label>
                                        <input type="text" class="form-control" name="billing_state" required
                                            value="{{ old('billing_state') }}" placeholder="Enter your state">
                                        @error('billing_state')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <label>ZIP Code *</label>
                                        <input type="text" class="form-control" name="billing_zipcode" required
                                            value="{{ old('billing_zipcode') }}" placeholder="Enter ZIP code">
                                        @error('billing_zipcode')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label>Country *</label>
                                    <input type="text" class="form-control" name="billing_country" value="Bangladesh"
                                        readonly style="background-color: #f8f9fa;">
                                </div>

                                <!-- Shipping Address Toggle -->
                                <div class="custom-control custom-checkbox mt-4">
                                    <input type="checkbox" class="custom-control-input" id="different-shipping"
                                        name="different_shipping">
                                    <label class="custom-control-label" for="different-shipping">
                                        Ship to a different address?
                                    </label>
                                </div>

                                <!-- Shipping Address (Hidden by Default) -->
                                <div id="shipping-address"
                                    style="display: none; margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
                                    <h5>Shipping Address</h5>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Shipping Name *</label>
                                            <input type="text" class="form-control" name="shipping_name"
                                                placeholder="Enter shipping name">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Shipping Phone *</label>
                                            <input type="tel" class="form-control" name="shipping_phone"
                                                placeholder="Enter shipping phone">
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Shipping Address *</label>
                                        <textarea class="form-control" name="shipping_address" rows="2" placeholder="Enter shipping address"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Shipping City *</label>
                                            <input type="text" class="form-control" name="shipping_city"
                                                placeholder="Enter shipping city">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Shipping ZIP Code *</label>
                                            <input type="text" class="form-control" name="shipping_zipcode"
                                                placeholder="Enter shipping ZIP code">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <label>Order notes (optional)</label>
                                    <textarea class="form-control" name="notes" rows="3"
                                        placeholder="Notes about your order, e.g. special notes for delivery">{{ old('notes') }}</textarea>
                                </div>
                            </div><!-- End .col-lg-8 -->

                            <aside class="col-lg-4">
                                <div class="summary">
                                    <h3 class="summary-title">Your Order</h3>

                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($cartItems as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <!-- Product Image -->
                                                            @if ($item->product && $item->product->image)
                                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                                    alt="{{ $item->product->name }}"
                                                                    style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px; border-radius: 8px;">
                                                            @else
                                                                <div
                                                                    style="width: 60px; height: 60px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; margin-right: 15px; border-radius: 8px;">
                                                                    <i class="icon-image"
                                                                        style="color: #ccc; font-size: 24px;"></i>
                                                                </div>
                                                            @endif

                                                            <!-- Product Details -->
                                                            <div class="product-info">
                                                                <!-- Product Name - FIXED -->
                                                                @if ($item->product)
                                                                    <h6 class="mb-1"
                                                                        style="font-weight: 600; color: #333; font-size: 14px;">
                                                                        {{ $item->product->name }}
                                                                    </h6>
                                                                @else
                                                                    <h6 class="mb-1 text-danger"
                                                                        style="font-weight: 600; font-size: 14px;">
                                                                        <i class="icon-alert-circle"></i> Product Not Found
                                                                    </h6>
                                                                @endif

                                                                <!-- Product Details -->
                                                                <div class="product-meta"
                                                                    style="font-size: 12px; color: #666;">
                                                                    <div class="mb-1">
                                                                        <strong>Qty:</strong> {{ $item->quantity }}
                                                                        @if ($item->product)
                                                                            ×
                                                                            ${{ number_format($item->product->price, 2) }}
                                                                        @endif
                                                                    </div>

                                                                    @if ($item->color)
                                                                        <div class="mb-1">
                                                                            <strong>Color:</strong>
                                                                            <span
                                                                                style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background: {{ $item->color }}; margin-left: 5px; vertical-align: middle; border: 1px solid #ddd;"></span>
                                                                            {{ $item->color }}
                                                                        </div>
                                                                    @endif

                                                                    @if ($item->size)
                                                                        <div class="mb-1">
                                                                            <strong>Size:</strong> {{ $item->size }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right" style="vertical-align: middle;">
                                                        @if ($item->product)
                                                            <strong style="font-size: 16px; color: #2b2b2b;">
                                                                ${{ number_format($item->price * $item->quantity, 2) }}
                                                            </strong>
                                                        @else
                                                            <span class="text-danger">$0.00</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <!-- Order Summary -->
                                            <tr class="summary-subtotal">
                                                <td><strong>Subtotal:</strong></td>
                                                <td class="text-right"><strong>${{ number_format($subtotal, 2) }}</strong>
                                                </td>
                                            </tr>

                                            @if ($appliedCoupon)
                                                <tr class="summary-discount">
                                                    <td>
                                                        <strong>Discount
                                                            @if ($discountType == 'percentage')
                                                                ({{ $couponCode }})
                                                            @else
                                                                (Coupon)
                                                            @endif:
                                                        </strong>
                                                    </td>
                                                    <td class="text-right text-danger">
                                                        <strong>-${{ number_format($discount, 2) }}</strong></td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <td><strong>Shipping:</strong></td>
                                                <td class="text-right">
                                                    @if ($shipping == 0)
                                                        <span class="text-success"><strong>FREE</strong></span>
                                                    @else
                                                        <strong>${{ number_format($shipping, 2) }}</strong>
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Tax (5%):</strong></td>
                                                <td class="text-right"><strong>${{ number_format($tax, 2) }}</strong></td>
                                            </tr>

                                            <tr class="summary-total">
                                                <td><strong style="font-size: 18px; color: #333;">Total:</strong></td>
                                                <td class="text-right"><strong
                                                        style="font-size: 18px; color: #e74c3c;">${{ number_format($total, 2) }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="payment-methods">
                                        <h5>Payment Method *</h5>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="cod" id="cod"
                                                {{ old('payment_method') == 'cod' ? 'checked' : 'checked' }}>
                                            <label class="form-check-label" for="cod">
                                                <i class="icon-money"></i> Cash on Delivery
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="card" id="card"
                                                {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="card">
                                                <i class="icon-credit-card"></i> Credit/Debit Card
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="bkash" id="bkash"
                                                {{ old('payment_method') == 'bkash' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bkash">
                                                <i class="icon-mobile"></i> bKash
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="bank" id="bank"
                                                {{ old('payment_method') == 'bank' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bank">
                                                <i class="icon-bank"></i> Bank Transfer
                                            </label>
                                        </div>
                                        @error('payment_method')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="custom-control custom-checkbox mt-3">
                                        <input type="checkbox" class="custom-control-input" id="terms"
                                            name="terms" required>
                                        <label class="custom-control-label" for="terms">
                                            I agree to the <a href="#" target="_blank">terms and conditions</a> *
                                        </label>
                                        @error('terms')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-order btn-block mt-4">
                                        <i class="icon-check-circle"></i>
                                        <span class="btn-text">Place Order</span>
                                    </button>

                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="icon-lock"></i> Your personal data will be used to process your order
                                            and support your experience.
                                        </small>
                                    </div>
                                </div><!-- End .summary -->
                            </aside><!-- End .col-lg-4 -->
                        </div><!-- End .row -->
                    </form>
                </div><!-- End .container -->
            </div><!-- End .checkout -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection

@push('styles')
    <style>
        .summary-discount {
            background-color: #f8f9fa;
        }

        .summary-discount td {
            color: #dc3545;
            font-weight: 600;
        }

        .coupon-applied {
            background: #d4edda;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
        }

        .checkout-discount {
            margin-bottom: 30px;
            position: relative;
        }

        .checkout-discount label {
            cursor: pointer;
        }

        .summary {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
        }

        .table-summary img {
            border-radius: 4px;
        }

        .btn-order {
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
        }

        .payment-methods {
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 15px;
        }

        .form-check-label {
            font-weight: 500;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Shipping Address Toggle
            $('#different-shipping').change(function() {
                if ($(this).is(':checked')) {
                    $('#shipping-address').slideDown(300);
                    // Copy billing address to shipping address
                    $('input[name="shipping_name"]').val($('input[name="billing_name"]').val());
                    $('input[name="shipping_phone"]').val($('input[name="billing_phone"]').val());
                    $('textarea[name="shipping_address"]').val($('textarea[name="billing_address"]').val());
                    $('input[name="shipping_city"]').val($('select[name="billing_city"]').val());
                    $('input[name="shipping_zipcode"]').val($('input[name="billing_zipcode"]').val());
                } else {
                    $('#shipping-address').slideUp(300);
                }
            });

            // Apply Coupon
            $('#coupon-form').on('submit', function(e) {
                e.preventDefault();
                let couponCode = $('#checkout-discount-input').val().trim();

                if (!couponCode) {
                    toastr.error('Please enter a coupon code');
                    return;
                }

                // Show loading
                $('#checkout-discount-input').prop('disabled', true);

                $.ajax({
                    url: "{{ route('checkout.apply-coupon') }}",
                    type: "POST",
                    data: {
                        coupon_code: couponCode,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            // Reload page to update totals
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response.message);
                            $('#checkout-discount-input').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Something went wrong!');
                        $('#checkout-discount-input').prop('disabled', false);
                    }
                });
            });

            // Remove Coupon
            $('#remove-coupon').on('click', function() {
                $.ajax({
                    url: "{{ route('checkout.remove-coupon') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 500);
                        }
                    }
                });
            });

            // Form validation
            $('#checkout-form').on('submit', function(e) {
                let paymentMethod = $('input[name="payment_method"]:checked').val();
                let termsAccepted = $('#terms').is(':checked');

                if (!paymentMethod) {
                    e.preventDefault();
                    toastr.error('Please select a payment method');
                    return false;
                }

                if (!termsAccepted) {
                    e.preventDefault();
                    toastr.error('Please accept the terms and conditions');
                    return false;
                }

                // Show loading
                $(this).find('button[type="submit"]').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Processing...');
            });

            // Auto calculate shipping on city change
            $('select[name="billing_city"]').change(function() {
                // You can implement real-time shipping calculation here
                let city = $(this).val();
                if (city) {
                    toastr.info('Shipping cost updated for ' + city);
                }
            });
        });
    </script>
@endpush
