@extends('frontend.front_app')
@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container d-flex align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>

                <nav class="product-pager ml-auto" aria-label="Product">
                    <a class="product-pager-link product-pager-prev" href="#" aria-label="Previous" tabindex="-1">
                        <i class="icon-angle-left"></i>
                        <span>Prev</span>
                    </a>

                    <a class="product-pager-link product-pager-next" href="#" aria-label="Next" tabindex="-1">
                        <span>Next</span>
                        <i class="icon-angle-right"></i>
                    </a>
                </nav>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="product-details-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery product-gallery-vertical">
                                <div class="row">
                                    <figure class="product-main-image">
                                        <img id="product-zoom" src="{{ asset('storage/' . $product->image) }}"
                                            data-zoom-image="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}">
                                        <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                            <i class="icon-arrows"></i>
                                        </a>
                                    </figure>

                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        @foreach ($product->images ?? [] as $img)
                                            <a class="product-gallery-item @if ($loop->first) active @endif"
                                                href="#" data-image="{{ asset('storage/' . $img->image_path) }}"
                                                data-zoom-image="{{ asset('storage/' . $img->image_path) }}">
                                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="product image">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="product-details">
                                <h1 class="product-title">{{ $product->name }}</h1>

                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div>
                                    </div>
                                    <a class="ratings-text" href="#product-review-link">( 2 Reviews )</a>
                                </div>

                                <div class="product-price">
                                    ${{ number_format($product->price, 2) }}
                                    @if ($product->discount_price)
                                        <span class="old-price">${{ number_format($product->discount_price, 2) }}</span>
                                    @endif
                                </div>

                                <div class="product-content">
                                    <p>{{ $product->description }}</p>
                                </div>

                                @php
                                    $colors = is_array($product->colors)
                                        ? $product->colors
                                        : json_decode($product->colors, true);
                                    $colors = $colors ?? [];
                                    $sizes = is_array($product->sizes)
                                        ? $product->sizes
                                        : json_decode($product->sizes, true);
                                    $sizes = $sizes ?? [];
                                @endphp

                                @if(!empty($colors))
                                <div class="details-filter-row details-row-size">
                                    <label>Color:</label>
                                    <div class="product-nav product-nav-thumbs">
                                        @foreach ($colors as $color)
                                            <a href="#" class="color-option @if ($loop->first) active @endif"
                                               data-color="{{ $color }}">
                                                <span style="background-color: {{ $color }}; display:block; width:20px; height:20px; border-radius:50%;"></span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(!empty($sizes))
                                <div class="details-filter-row details-row-size">
                                    <label>Size:</label>
                                    <div class="product-nav product-nav-thumbs">
                                        @foreach ($sizes as $size)
                                            <a href="#" class="size-option @if ($loop->first) active @endif"
                                               data-size="{{ $size }}">
                                                {{ $size }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qty" class="form-control" value="1"
                                            min="1" max="{{ $product->stock }}" step="1" data-decimals="0"
                                            required>
                                    </div>
                                </div>

                                <div class="product-details-action">
                                    <!-- Add to Cart Button -->
                                    <a href="#" data-id="{{ $product->id }}"
                                        class="btn-product btn-cart addToCart">
                                        <span>add to cart</span>
                                    </a>
                                     <a href="{{ route('checkout', $product->id) }}" data-id="{{ $product->id }}"
                                        class="btn-product btn-cart ml-3 addToCart">
                                        <span>Buy Now</span>
                                    </a>


                                    <div class="details-action-wrapper">
                                        <a href="#" class="btn-product btn-wishlist addToWishlist"
                                            data-id="{{ $product->id }}" title="Wishlist">
                                            <span>Add to Wishlist</span>
                                        </a>
                                        {{-- <a href="#" class="btn-product btn-compare" title="Compare">
                                            <span>Add to Compare</span>
                                        </a> --}}
                                    </div>
                                </div>

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <a href="#">{{ $product->category->name ?? 'N/A' }}</a>
                                    </div>

                                    <div class="social-icons social-icons-sm">
                                        <span class="social-label">Share:</span>
                                        <a href="#" class="social-icon" title="Facebook" target="_blank">
                                            <i class="icon-facebook-f"></i>
                                        </a>
                                        <a href="#" class="social-icon" title="Twitter" target="_blank">
                                            <i class="icon-twitter"></i>
                                        </a>
                                        <a href="#" class="social-icon" title="Instagram" target="_blank">
                                            <i class="icon-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-details-tab">
                    <ul class="nav nav-pills justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab"
                                role="tab" aria-controls="product-info-tab" aria-selected="true">Additional information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                                role="tab" aria-controls="product-desc-tab" aria-selected="false">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-shipping-link" data-toggle="tab"
                                href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab"
                                aria-selected="false">Shipping & Returns</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab"
                                role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-info-tab" role="tabpanel"
                            aria-labelledby="product-info-link">
                            <div class="product-info-content">
                                <h3 class="mb-4">Additional Information</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped additional-info-table">
                                        <tbody>
                                            @php
                                                $attributes = [
                                                    'ram' => 'RAM',
                                                    'storage' => 'Storage',
                                                    'processor' => 'Processor',
                                                    'os' => 'Operating System',
                                                    'battery' => 'Battery',
                                                    'charging' => 'Charging',
                                                    'display' => 'Display',
                                                    'resolution' => 'Resolution',
                                                    'camera' => 'Rear Camera',
                                                    'front_camera' => 'Front Camera',
                                                    'network' => 'Network',
                                                    'sim' => 'SIM',
                                                    'build' => 'Build Material',
                                                    'weight' => 'Weight',
                                                    'dimensions' => 'Dimensions',
                                                    'fingerprint' => 'Fingerprint Sensor',
                                                    'water_resistance' => 'Water Resistance',
                                                    'bluetooth' => 'Bluetooth',
                                                    'wifi' => 'WiFi',
                                                    'usb' => 'USB',
                                                    'audio' => 'Audio',
                                                    'sensors' => 'Sensors',
                                                    'release_date' => 'Release Date',
                                                    'warranty' => 'Warranty',
                                                    'sku' => 'SKU',
                                                    'barcode' => 'Barcode',
                                                ];
                                            @endphp

                                            @foreach ($attributes as $key => $label)
                                                @if (!empty($product->$key))
                                                    <tr>
                                                        <th class="attribute-label">{{ $label }}</th>
                                                        <td class="attribute-value">{{ $product->$key }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            @if (!empty($colors))
                                                <tr>
                                                    <th class="attribute-label">Available Colors</th>
                                                    <td class="attribute-value">
                                                        <div class="color-options-display">
                                                            @foreach ($colors as $color)
                                                                <span class="color-dot" style="background-color: {{ $color }};" title="{{ $color }}"></span>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (!empty($sizes))
                                                <tr>
                                                    <th class="attribute-label">Available Sizes</th>
                                                    <td class="attribute-value">
                                                        <div class="size-options-display">
                                                            @foreach ($sizes as $size)
                                                                <span class="size-badge">{{ $size }}</span>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="product-desc-tab" role="tabpanel"
                            aria-labelledby="product-desc-link">
                            <div class="product-desc-content">
                                <h3>Product Information</h3>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                            aria-labelledby="product-shipping-link">
                            <div class="product-desc-content">
                                <h3>Delivery & returns</h3>
                                <p>We deliver to over 100 countries around the world. For full details of the delivery
                                    options we offer, please view our <a href="#">Delivery information</a><br>
                                    We hope you'll love every purchase, but if you ever need to return an item you can do so
                                    within a month of receipt. For full details of how to make a return, please view our <a
                                        href="#">Returns information</a></p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                            aria-labelledby="product-review-link">
                            <div class="reviews">
                                <h3>Reviews (2)</h3>
                                <!-- Reviews content here -->
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <h2 class="title text-center mb-4">You May Also Like</h2>

                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                        "nav": false,
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {"items":1},
                            "480": {"items":2},
                            "768": {"items":3},
                            "992": {"items":4},
                            "1200": {"items":4,"nav": true,"dots": false}
                        }
                    }'>
                    @foreach ($relatedProducts as $related)
                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <a href="{{ route('product.details', $related->id) }}">
                                    <img src="{{ asset('storage/' . $related->image) }}" alt="Product image"
                                        class="product-image">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable addToWishlist" data-id="{{ $related->id }}">
                                        <span>add to wishlist</span>
                                    </a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart addToCart" data-id="{{ $related->id }}">
                                        <span>add to cart</span>
                                    </a>
                                </div>
                            </figure>
                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">{{ $related->category->name ?? 'N/A' }}</a>
                                </div>
                                <h3 class="product-title">
                                    <a href="{{ route('product.details', $related->id) }}">{{ $related->name }}</a>
                                </h3>
                                <div class="product-price">${{ number_format($related->price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@push('styles')
<style>
    /* Additional Information Table Styling */
    .additional-info-table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 0;
    }

    .additional-info-table th.attribute-label {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
        width: 220px;
        padding: 16px 20px;
        border-right: 2px solid #dee2e6;
        font-size: 15px;
    }

    .additional-info-table td.attribute-value {
        padding: 16px 20px;
        background-color: #fff;
        color: #6c757d;
        font-size: 15px;
        line-height: 1.5;
    }

    .additional-info-table tr:hover td {
        background-color: #f8f9fa;
    }

    /* Color and Size Display Styling */
    .color-options-display {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .color-dot {
        display: inline-block;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .color-dot:hover {
        transform: scale(1.1);
    }

    .size-options-display {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .size-badge {
        display: inline-block;
        padding: 6px 12px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #495057;
        transition: all 0.2s ease;
    }

    .size-badge:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    /* Buy Now Button Styling */
    .btn-buy-now {
        background: linear-gradient(135deg, #28a745, #20c997);
        border-color: #28a745;
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
    }

    .btn-buy-now:hover {
        background: linear-gradient(135deg, #218838, #1e9e8a);
        border-color: #1e7e34;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-buy-now i {
        margin-right: 8px;
    }

    /* Product Details Action Area */
    .product-details-action {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin: 20px 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .additional-info-table th.attribute-label {
            width: 150px;
            padding: 12px 15px;
            font-size: 14px;
        }

        .additional-info-table td.attribute-value {
            padding: 12px 15px;
            font-size: 14px;
        }

        .product-details-action {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-buy-now, .btn-cart {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    /* Tab Content Styling */
    .product-info-content {
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .product-desc-content {
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        line-height: 1.7;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function(){
    let selectedColor = '';
    let selectedSize = '';

    // Color selection
    $('.color-option').click(function(e) {
        e.preventDefault();
        $('.color-option').removeClass('active');
        $(this).addClass('active');
        selectedColor = $(this).data('color');
        $('#buy_now_color').val(selectedColor);
    });

    // Size selection
    $('.size-option').click(function(e) {
        e.preventDefault();
        $('.size-option').removeClass('active');
        $(this).addClass('active');
        selectedSize = $(this).data('size');
        $('#buy_now_size').val(selectedSize);
    });

    // Quantity change for Buy Now
    $('#qty').on('change input', function() {
        $('#buy_now_quantity').val($(this).val());
    });

    // Set default selections
    if ($('.color-option').length > 0) {
        selectedColor = $('.color-option.active').data('color');
        $('#buy_now_color').val(selectedColor);
    }
    if ($('.size-option').length > 0) {
        selectedSize = $('.size-option.active').data('size');
        $('#buy_now_size').val(selectedSize);
    }

    // Add to Cart
    $('.addToCart').click(function(e) {
        e.preventDefault();
        let productId = $(this).data('id');
        let quantity = $('#qty').val() || 1;

        // Check stock
        let maxStock = $('#qty').attr('max');
        if (parseInt(quantity) > parseInt(maxStock)) {
            toastr.error('Quantity exceeds available stock!');
            return;
        }

        $.ajax({
            url: "{{ route('product.cart.add') }}",
            type: "POST",
            data: {
                product_id: productId,
                quantity: quantity,
                color: selectedColor,
                size: selectedSize,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                toastr.success(response.message);
                // Update cart count in header if needed
                if (response.cart_count !== undefined) {
                    $('.cart-count').text(response.cart_count);
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = "{{ route('login') }}?redirect_back=" + encodeURIComponent(window.location.href);
                } else {
                    let errorMessage = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    toastr.error(errorMessage);
                    console.error('Cart Add Error:', xhr.responseText);
                }
            }
        });
    });

    // Add to Wishlist
    $('.addToWishlist').click(function(e) {
        e.preventDefault();
        let productId = $(this).data('id');

        $.ajax({
            url: "{{ route('product.wishlist.add') }}",
            type: "POST",
            data: {
                product_id: productId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                toastr.success(response.message);
                // Update wishlist count in header if needed
                if (response.wishlist_count !== undefined) {
                    $('.wishlist-count').text(response.wishlist_count);
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = "{{ route('login') }}?redirect_back=" + encodeURIComponent(window.location.href);
                } else {
                    let errorMessage = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    toastr.error(errorMessage);
                    console.error('Wishlist Add Error:', xhr.responseText);
                }
            }
        });
    });

    // Buy Now form validation {{ route('checkout') }}
    $('form[action="#"]').on('submit', function(e) {
        let quantity = $('#qty').val() || 1;
        let maxStock = $('#qty').attr('max');

        if (parseInt(quantity) > parseInt(maxStock)) {
            e.preventDefault();
            toastr.error('Quantity exceeds available stock!');
            return false;
        }

        // Show loading state
        $(this).find('.btn-buy-now').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    });
});
</script>
@endpush
