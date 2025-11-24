@extends('frontend.front_app')
@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="cart">
            <div class="container">
                @if($cartItems && $cartItems->count() > 0)
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($cartItems as $item)
                                <tr id="cart-item-{{ $item->id }}">
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="{{ route('product.details', $item->product_id) }}">
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 80px; height: auto;">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="{{ route('product.details', $item->product_id) }}">{{ $item->product->name }}</a>
                                            </h3><!-- End .product-title -->

                                            @if($item->color || $item->size)
                                            <div class="product-cart-details">
                                                @if($item->color)
                                                <strong>Color:</strong>
                                                <span style="display:inline-block; width:12px; height:12px; border-radius:50%; background:{{ $item->color }}; margin-left:5px;"></span>
                                                {{ $item->color }}
                                                @endif

                                                @if($item->size)
                                                <strong class="ml-2">Size:</strong> {{ $item->size }}
                                                @endif
                                            </div>
                                            @endif
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">${{ number_format($item->product->price, 2) }}</td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity">
                                            <input type="number" class="form-control quantity-input"
                                                   value="{{ $item->quantity }}"
                                                   min="1"
                                                   max="{{ $item->product->stock }}"
                                                   step="1"
                                                   data-decimals="0"
                                                   required
                                                   data-cart-id="{{ $item->id }}"
                                                   data-product-id="{{ $item->product_id }}">
                                        </div><!-- End .cart-product-quantity -->
                                    </td>
                                    <td class="total-col" id="item-total-{{ $item->id }}">
                                        ${{ number_format($item->product->price * $item->quantity, 2) }}
                                    </td>
                                    <td class="remove-col">
                                        <button class="btn-remove remove-from-cart" data-cart-id="{{ $item->id }}">
                                            <i class="icon-close"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table><!-- End .table table-cart -->

                        <div class="cart-bottom">
                            <div class="cart-discount">
                                <form id="coupon-form">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="coupon-code"
                                               placeholder="Enter coupon code" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary-2" type="submit" id="apply-coupon-btn">
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div id="coupon-message" class="mt-2"></div>

                                @if(session('applied_coupon'))
                                <div class="applied-coupon mt-2">
                                    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                                        <strong>Coupon Applied!</strong>
                                        {{ session('applied_coupon')['code'] }} -
                                        ${{ number_format(session('applied_coupon')['discount'], 2) }} off
                                        <button type="button" class="close py-1" id="remove-coupon-btn">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div><!-- End .cart-discount -->

                            <button class="btn btn-outline-dark-2 clear-cart">
                                <span>CLEAR CART</span>
                                <i class="icon-refresh"></i>
                            </button>
                        </div><!-- End .cart-bottom -->
                    </div><!-- End .col-lg-9 -->

                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td id="cart-subtotal">${{ number_format($subtotal, 2) }}</td>
                                    </tr><!-- End .summary-subtotal -->

                                    @if(isset($discount) && $discount > 0)
                                    <tr class="summary-discount">
                                        <td>Discount:</td>
                                        <td id="cart-discount">-${{ number_format($discount, 2) }}</td>
                                    </tr><!-- End .summary-discount -->
                                    @endif

                                    <tr class="summary-shipping">
                                        <td>Shipping:</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr class="summary-shipping-row">
                                        <td>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="free-shipping" name="shipping" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="free-shipping">Free Shipping</label>
                                            </div><!-- End .custom-control -->
                                        </td>
                                        <td>$0.00</td>
                                    </tr><!-- End .summary-shipping-row -->

                                    <tr class="summary-shipping-row">
                                        <td>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="standart-shipping" name="shipping" class="custom-control-input">
                                                <label class="custom-control-label" for="standart-shipping">Standard:</label>
                                            </div><!-- End .custom-control -->
                                        </td>
                                        <td>$10.00</td>
                                    </tr><!-- End .summary-shipping-row -->

                                    <tr class="summary-shipping-row">
                                        <td>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="express-shipping" name="shipping" class="custom-control-input">
                                                <label class="custom-control-label" for="express-shipping">Express:</label>
                                            </div><!-- End .custom-control -->
                                        </td>
                                        <td>$20.00</td>
                                    </tr><!-- End .summary-shipping-row -->

                                    <tr class="summary-shipping-estimate">
                                        <td>Estimate for Your Country<br> <a href="dashboard.html">Change address</a></td>
                                        <td>&nbsp;</td>
                                    </tr><!-- End .summary-shipping-estimate -->

                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td id="cart-total">${{ number_format($total, 2) }}</td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <a href="{{ route('checkout') }}" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                        </div><!-- End .summary -->

                        <a href="{{ url('/') }}" class="btn btn-outline-dark-2 btn-block mb-3">
                            <span>CONTINUE SHOPPING</span>
                            <i class="icon-refresh"></i>
                        </a>
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="empty-cart text-center py-5">
                            <i class="icon-cart" style="font-size: 80px; color: #ccc; margin-bottom: 20px;"></i>
                            <h2>Your cart is empty</h2>
                            <p class="mb-4">You have no items in your shopping cart.</p>
                            <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
                @endif
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Quantity update with debounce
    let quantityTimeout;

    $('.quantity-input').on('change', function() {
        clearTimeout(quantityTimeout);

        let cartId = $(this).data('cart-id');
        let productId = $(this).data('product-id');
        let quantity = $(this).val();
        let maxStock = $(this).attr('max');
        let $this = $(this);

        // Validate quantity
        if (quantity < 1) {
            $this.val(1);
            quantity = 1;
        }

        if (quantity > maxStock) {
            toastr.error('Quantity exceeds available stock! Maximum: ' + maxStock);
            $this.val(maxStock);
            quantity = maxStock;
            return;
        }

        quantityTimeout = setTimeout(function() {
            updateCartQuantity(cartId, quantity, $this);
        }, 500);
    });

    // Function to update cart quantity
    function updateCartQuantity(cartId, quantity, $input) {
        $.ajax({
            url: "{{ route('product.cart.update') }}",
            type: "POST",
            data: {
                id: cartId,
                quantity: quantity,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $input.prop('disabled', true);
            },
            success: function(response) {
                toastr.success(response.message);

                // Update individual item total
                let itemPrice = parseFloat($('#cart-item-' + cartId + ' .price-col').text().replace('$', ''));
                let itemTotal = itemPrice * quantity;
                $('#item-total-' + cartId).text('$' + itemTotal.toFixed(2));

                // Update cart totals
                $('#cart-subtotal').text('$' + response.subtotal);
                $('#cart-total').text('$' + response.total);

                // Update header cart count
                $('.cart-count').text(response.cart_count);
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = "{{ route('login') }}?redirect_back=" + encodeURIComponent(window.location.href);
                } else {
                    let errorMessage = 'Error updating cart';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    toastr.error(errorMessage);

                    // Reset input to original value
                    let originalQuantity = $input.data('original-value') || 1;
                    $input.val(originalQuantity);
                }
            },
            complete: function() {
                $input.prop('disabled', false);
            }
        });
    }

    // Store original quantity on focus
    $('.quantity-input').on('focus', function() {
        $(this).data('original-value', $(this).val());
    });

    // Remove item from cart
    $(document).on('click', '.remove-from-cart', function(e) {
        e.preventDefault();
        let cartId = $(this).data('cart-id');
        let $this = $(this);

        if (confirm('Are you sure you want to remove this item from cart?')) {
            $.ajax({
                url: "{{ route('product.cart.remove') }}",
                type: "POST",
                data: {
                    id: cartId,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $this.prop('disabled', true).html('<i class="icon-loading"></i>');
                },
                success: function(response) {
                    toastr.success(response.message);

                    // Remove item from table
                    $('#cart-item-' + cartId).fadeOut(300, function() {
                        $(this).remove();

                        // Check if cart is empty
                        if ($('.table-cart tbody tr').length === 0) {
                            location.reload(); // Reload to show empty cart message
                        } else {
                            // Update totals
                            $('#cart-subtotal').text('$' + response.subtotal);
                            $('#cart-total').text('$' + response.total);
                        }
                    });

                    // Update header cart count
                    $('.cart-count').text(response.cart_count);
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                    } else {
                        toastr.error('Error removing item from cart');
                        $this.prop('disabled', false).html('<i class="icon-close"></i>');
                    }
                }
            });
        }
    });

    // Clear entire cart
    $('.clear-cart').on('click', function() {
        if (confirm('Are you sure you want to clear your entire cart?')) {
            $.ajax({
                url: "{{ route('product.cart.clear') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $('.clear-cart').prop('disabled', true).html('<i class="icon-loading"></i> Clearing...');
                },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload(); // Reload to show empty cart
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                    } else {
                        toastr.error('Error clearing cart');
                        $('.clear-cart').prop('disabled', false).html('<span>CLEAR CART</span><i class="icon-refresh"></i>');
                    }
                }
            });
        }
    });

    // Shipping option change
    $('input[name="shipping"]').on('change', function() {
        let shippingCost = 0;

        if ($(this).attr('id') === 'standart-shipping') {
            shippingCost = 10.00;
        } else if ($(this).attr('id') === 'express-shipping') {
            shippingCost = 20.00;
        }

        // Update totals
        let subtotal = parseFloat($('#cart-subtotal').text().replace('$', ''));
        let discount = {{ $discount ?? 0 }};
        let newTotal = subtotal + shippingCost - discount;

        $('.summary-total td:last').text('$' + newTotal.toFixed(2));
    });

    // Coupon functionality
    $('#coupon-form').on('submit', function(e) {
        e.preventDefault();

        let couponCode = $('#coupon-code').val();
        let $btn = $('#apply-coupon-btn');
        let originalHtml = $btn.html();

        $btn.prop('disabled', true).html('<i class="icon-loading"></i>');

        $.ajax({
            url: "{{ route('coupon.apply') }}",
            type: "POST",
            data: {
                code: couponCode,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    location.reload(); // Reload to update totals
                } else {
                    $('#coupon-message').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to apply coupon.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#coupon-message').html('<div class="alert alert-danger">' + errorMessage + '</div>');
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    });

    // Remove coupon
    $(document).on('click', '#remove-coupon-btn', function() {
        $.ajax({
            url: "{{ route('coupon.remove') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    location.reload();
                }
            }
        });
    });

    // Coupon code check on input change
    $('#coupon-code').on('input', function() {
        $('#coupon-message').html('');
    });
});
</script>
@endpush
