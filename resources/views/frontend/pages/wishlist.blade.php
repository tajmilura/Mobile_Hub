@extends('frontend.front_app')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Wishlist<span>Shop</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">
                @if ($wishlistItems && $wishlistItems->count() > 0)
                    <table class="table table-wishlist table-mobile">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($wishlistItems as $item)
                                <tr id="wishlist-item-{{ $item->id }}">
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="{{ route('product.details', $item->product_id) }}">
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}" style="width: 80px; height: auto;">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a
                                                    href="{{ route('product.details', $item->product_id) }}">{{ $item->product->name }}</a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">${{ number_format($item->product->price, 2) }}</td>
                                    <td class="stock-col">
                                        @if ($item->product->stock > 0)
                                            <span class="in-stock">In stock</span>
                                            <small class="text-muted d-block">({{ $item->product->stock }}
                                                available)</small>
                                        @else
                                            <span class="out-of-stock">Out of stock</span>
                                        @endif
                                    </td>
                                    <td class="action-col">
                                        @if ($item->product->stock > 0)
                                            @if ($item->product->colors || $item->product->sizes)
                                                <div class="dropdown">
                                                    <button class="btn btn-block btn-outline-primary-2"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-list-alt"></i>Select Options
                                                    </button>

                                                    <div class="dropdown-menu">
                                                        @php
                                                            $colors = is_array($item->product->colors)
                                                                ? $item->product->colors
                                                                : json_decode($item->product->colors, true);
                                                            $colors = $colors ?? [];

                                                            $sizes = is_array($item->product->sizes)
                                                                ? $item->product->sizes
                                                                : json_decode($item->product->sizes, true);
                                                            $sizes = $sizes ?? [];
                                                        @endphp

                                                        @if (!empty($colors) || !empty($sizes))
                                                            @if (!empty($colors))
                                                                <h6 class="dropdown-header">Colors</h6>
                                                                @foreach ($colors as $color)
                                                                    <a class="dropdown-item add-to-cart-from-wishlist"
                                                                        href="#"
                                                                        data-product-id="{{ $item->product_id }}"
                                                                        data-color="{{ $color }}">
                                                                        <span
                                                                            style="display:inline-block; width:12px; height:12px; border-radius:50%; background:{{ $color }}; margin-right:8px;"></span>
                                                                        {{ $color }}
                                                                    </a>
                                                                @endforeach
                                                            @endif

                                                            @if (!empty($sizes))
                                                                <h6 class="dropdown-header">Sizes</h6>
                                                                @foreach ($sizes as $size)
                                                                    <a class="dropdown-item add-to-cart-from-wishlist"
                                                                        href="#"
                                                                        data-product-id="{{ $item->product_id }}"
                                                                        data-size="{{ $size }}">
                                                                        {{ $size }}
                                                                    </a>
                                                                @endforeach
                                                            @endif

                                                            <div class="dropdown-divider"></div>
                                                        @endif

                                                        <a class="dropdown-item add-to-cart-from-wishlist" href="#"
                                                            data-product-id="{{ $item->product_id }}">
                                                            Add to Cart (Default)
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <button
                                                    class="btn btn-block btn-outline-primary-2 add-to-cart-from-wishlist"
                                                    data-product-id="{{ $item->product_id }}">
                                                    <i class="icon-cart-plus"></i>Add to Cart
                                                </button>
                                            @endif
                                        @else
                                            <button class="btn btn-block btn-outline-primary-2 disabled">Out of
                                                Stock</button>
                                        @endif
                                    </td>
                                    <td class="remove-col">
                                        <button class="btn-remove remove-from-wishlist"
                                            data-wishlist-id="{{ $item->id }}">
                                            <i class="icon-close"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table><!-- End .table table-wishlist -->

                    <div class="wishlist-share">
                        <div class="social-icons social-icons-sm mb-2">
                            <label class="social-label">Share on:</label>
                            <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                    class="icon-facebook-f"></i></a>
                            <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                    class="icon-twitter"></i></a>
                            <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                    class="icon-instagram"></i></a>
                            <a href="#" class="social-icon" title="Youtube" target="_blank"><i
                                    class="icon-youtube"></i></a>
                            <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                    class="icon-pinterest"></i></a>
                        </div><!-- End .soial-icons -->
                    </div><!-- End .wishlist-share -->
                @else
                    <div class="empty-wishlist text-center py-5">
                        <i class="icon-heart-o" style="font-size: 80px; color: #ccc; margin-bottom: 20px;"></i>
                        <h2>Your wishlist is empty</h2>
                        <p class="mb-4">You haven't added any products to your wishlist yet.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
                    </div>
                @endif
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Remove item from wishlist
            $('.remove-from-wishlist').on('click', function(e) {
                e.preventDefault();
                let wishlistId = $(this).data('wishlist-id');
                let $this = $(this);

                if (confirm('Are you sure you want to remove this item from wishlist?')) {
                    $.ajax({
                        url: "{{ route('product.wishlist.remove') }}",
                        type: "POST",
                        data: {
                            id: wishlistId,
                            _token: "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            $this.prop('disabled', true).html('<i class="icon-loading"></i>');
                        },
                        success: function(response) {
                            toastr.success(response.message);

                            // Remove item from table
                            $('#wishlist-item-' + wishlistId).fadeOut(300, function() {
                                $(this).remove();

                                // Check if wishlist is empty
                                if ($('.table-wishlist tbody tr').length === 0) {
                                    location
                                .reload(); // Reload to show empty wishlist message
                                }
                            });

                            // Update header wishlist count
                            $('.wishlist-count').text(response.wishlist_count);
                        },
                        error: function(xhr) {
                            if (xhr.status === 401) {
                                window.location.href = "{{ route('login') }}";
                            } else {
                                toastr.error('Error removing item from wishlist');
                                $this.prop('disabled', false).html(
                                '<i class="icon-close"></i>');
                            }
                        }
                    });
                }
            });

            // Add to cart from wishlist
            $(document).on('click', '.add-to-cart-from-wishlist', function(e) {
                e.preventDefault();
                let productId = $(this).data('product-id');
                let color = $(this).data('color') || null;
                let size = $(this).data('size') || null;
                let $this = $(this);

                // If it's a dropdown item, close the dropdown
                if ($this.hasClass('dropdown-item')) {
                    $this.closest('.dropdown').find('.dropdown-toggle').dropdown('toggle');
                }

                $.ajax({
                    url: "{{ route('product.cart.add') }}",
                    type: "POST",
                    data: {
                        product_id: productId,
                        quantity: 1,
                        color: color,
                        size: size,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $this.prop('disabled', true);
                        if ($this.is('button')) {
                            $this.html('<i class="icon-loading"></i> Adding...');
                        }
                    },
                    success: function(response) {
                        toastr.success(response.message);

                        // Update header cart count
                        $('.cart-count').text(response.cart_count);

                        // Reset button state
                        if ($this.is('button')) {
                            $this.html('<i class="icon-cart-plus"></i> Added to Cart');
                            setTimeout(function() {
                                $this.html('<i class="icon-cart-plus"></i> Add to Cart')
                                    .prop('disabled', false);
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            window.location.href = "{{ route('login') }}";
                        } else {
                            let errorMessage = 'Error adding product to cart';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            toastr.error(errorMessage);
                        }

                        // Reset button state
                        if ($this.is('button')) {
                            $this.html('<i class="icon-cart-plus"></i> Add to Cart').prop(
                                'disabled', false);
                        }
                    },
                    complete: function() {
                        $this.prop('disabled', false);
                    }
                });
            });

            // Move all wishlist items to cart
            $(document).on('click', '.move-all-to-cart', function(e) {
                e.preventDefault();
                let $this = $(this);

                if (confirm('Are you sure you want to move all items to cart?')) {
                    $.ajax({
                        url: "{{ route('product.wishlist.move-all-to-cart') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            $this.prop('disabled', true).html(
                                '<i class="icon-loading"></i> Moving...');
                        },
                        success: function(response) {
                            toastr.success(response.message);

                            // Update counts
                            $('.cart-count').text(response.cart_count);
                            $('.wishlist-count').text(response.wishlist_count);

                            // Reload page to show empty wishlist
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        },
                        error: function(xhr) {
                            if (xhr.status === 401) {
                                window.location.href = "{{ route('login') }}";
                            } else {
                                toastr.error('Error moving items to cart');
                                $this.prop('disabled', false).html('Move All to Cart');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
