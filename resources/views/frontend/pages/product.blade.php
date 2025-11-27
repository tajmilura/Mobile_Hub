@extends('frontend.front_app')
@section('content')
    @push('styles')
        <style>
            .product-video-section {
                max-width: 1200px;
                margin: 0 auto;
            }

            .section-title {
                color: #2c3e50;
                font-weight: 700;
                font-size: 2rem;
                border-bottom: 3px solid #3498db;
                display: inline-block;
                padding-bottom: 0.5rem;
            }

            .video-item .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 15px;
                overflow: hidden;
            }

            .video-item .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            }

            .card-header {
                border-radius: 0 !important;
                padding: 1rem 1.5rem;
            }

            .local-video-container {
                background: #000;
            }

            .product-video {
                border-radius: 0;
                max-height: 400px;
            }

            .embed-video-container {
                position: relative;
                width: 100%;
                height: 0;
                padding-bottom: 56.25%;
                background: #000;
            }

            .embed-video-container iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border: 0;
            }

            .video-title {
                font-size: 0.95rem;
                line-height: 1.4;
            }

            .no-video-placeholder .card {
                border-radius: 15px;
                transition: all 0.3s ease;
            }

            .no-video-placeholder .card:hover {
                background: #f8f9fa !important;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .section-title {
                    font-size: 1.5rem;
                }

                .video-item {
                    margin-bottom: 1.5rem;
                }

                .card-header h5 {
                    font-size: 1rem;
                }
            }

            /* Animation */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .video-item {
                animation: fadeIn 0.6s ease-out;
            }
        </style>
        <style>
            .additional-info-table {
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid #e3f2fd;
            }

            .additional-info-table thead {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                border: none;
            }

            .additional-info-table th {
                border: none;
                font-size: 15px;
                letter-spacing: 0.5px;
            }

            .additional-info-table tbody tr {
                transition: all 0.3s ease;
                border-left: 3px solid transparent;
            }

            .additional-info-table tbody tr:hover {
                background-color: #f8f9ff;
                border-left: 3px solid #007bff;
                transform: translateX(2px);
            }

            .additional-info-table tbody td {
                border-color: #f1f3f4;
                vertical-align: middle;
            }

            .spec-row:nth-child(even) {
                background-color: #fafbfc;
            }

            .spec-row:nth-child(odd) {
                background-color: #ffffff;
            }

            /* Color Display Styles */
            .color-options-display .color-option {
                padding: 4px 8px;
                border-radius: 20px;
                background: white;
                border: 1px solid #e9ecef;
                transition: all 0.3s ease;
            }

            .color-options-display .color-option:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .color-dot {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                display: inline-block;
                border: 2px solid white;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                transition: transform 0.3s ease;
            }

            .color-dot:hover {
                transform: scale(1.2);
            }

            /* Size Display Styles */
            .size-badge {
                font-weight: 600;
                font-size: 13px;
                border: 2px solid #007bff !important;
                background: white;
                color: #007bff;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .size-badge:hover {
                background: #007bff;
                color: white;
                transform: translateY(-2px);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .additional-info-table {
                    font-size: 14px;
                }

                .additional-info-table th,
                .additional-info-table td {
                    padding: 12px 8px;
                }

                .color-options-display .color-option {
                    margin-bottom: 5px;
                }
            }
        </style>
        @push('styles')
            <style>
                .btn-product {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    padding: 12px 24px;
                    border: 2px solid #007bff;
                    border-radius: 8px;
                    text-decoration: none;
                    font-weight: 600;
                    font-size: 14px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    transition: all 0.3s ease;
                    min-width: 140px;
                    position: relative;
                    overflow: hidden;
                }

                .btn-cart {
                    background-color: #ffffff;
                    color: #007bff !important;
                    border-color: #007bff;
                }

                .btn-cart:hover {
                    background-color: #007bff;
                    color: #ffffff !important;
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
                }

                .btn-cart.bg-primary {
                    background-color: #007bff !important;
                    color: #ffffff !important;
                    border-color: #007bff;
                }

                .btn-cart.bg-primary:hover {
                    background-color: #0056b3 !important;
                    border-color: #0056b3;
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
                }

                .button-text {
                    color: inherit !important;
                    font-weight: 600;
                    z-index: 2;
                    position: relative;
                }

                /* Ensure text is always visible */
                .btn-product span {
                    color: inherit !important;
                    opacity: 1 !important;
                    visibility: visible !important;
                }

                /* Mobile responsive */
                @media (max-width: 768px) {
                    .product-action-buttons {
                        flex-direction: column;
                        gap: 12px;
                    }

                    .btn-product {
                        min-width: 100%;
                        margin-left: 0 !important;
                    }
                }
            </style>
        @endpush
    @endpush
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
                                    {{ number_format($product->price, 2) }} TK
                                    @if ($product->discount_price)
                                        <span class="old-price m-2">
                                            {{ number_format($product->discount_price, 2) }}TK</span>
                                    @endif
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

                                @if (!empty($colors))
                                    <div class="details-filter-row details-row-size">
                                        <label>Color:</label>
                                        <div class="product-nav product-nav-thumbs">
                                            @foreach ($colors as $color)
                                                <a href="#"
                                                    class="color-option @if ($loop->first) active @endif"
                                                    data-color="{{ $color }}">
                                                    <span
                                                        style="background-color: {{ $color }}; display:block; width:20px; height:20px; border-radius:50%;"></span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($sizes))
                                    <div class="details-filter-row details-row-size">
                                        <label>Size:</label>
                                        <div class="product-nav product-nav-thumbs">
                                            @foreach ($sizes as $size)
                                                <a href="#"
                                                    class="size-option @if ($loop->first) active @endif"
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
                                    <button type="button" data-id="{{ $product->id }}"
                                        class="btn btn-outline-primary btn-lg addToCart fw-semibold mr-2">
                                        <i class="fas fa-cart-plus me-2"></i>
                                        ADD TO CART
                                    </button>

                                    <a href="{{ route('checkout', $product->id) }}"
                                        class="btn btn-danger btn-lg fw-semibold text-white">
                                        <i class="fas fa-bolt me-2"></i>
                                        BUY NOW
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
                            <a class="nav-link active" id="product-info-link" data-toggle="tab" href="#product-info-tab"
                                role="tab" aria-controls="product-info-tab" aria-selected="true">Additional
                                information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
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
                                <h3 class="mb-4 text-dark font-weight-bold">Product Specifications</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover additional-info-table shadow-sm">
                                        <thead class="bg-danger text-white">
                                            <tr>
                                                <th class="py-3 px-4 text-uppercase font-weight-bold" style="width: 35%;">
                                                    Specification</th>
                                                <th class="py-3 px-4 text-uppercase font-weight-bold" style="width: 65%;">
                                                    Details</th>
                                            </tr>
                                        </thead>
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
                                                    <tr class="spec-row">
                                                        <td class="py-3 px-4 font-weight-bold text-dark bg-light">
                                                            <i class="fas fa-angle-right text-primary mr-2"></i>
                                                            {{ $label }}
                                                        </td>
                                                        <td class="py-3 px-4 text-dark">
                                                            {{ $product->$key }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            @if (!empty($colors))
                                                <tr class="spec-row">
                                                    <td class="py-3 px-4 font-weight-bold text-dark bg-light">
                                                        <i class="fas fa-palette text-primary mr-2"></i>
                                                        Available Colors
                                                    </td>
                                                    <td class="py-3 px-4">
                                                        <div class="color-options-display d-flex flex-wrap gap-2">
                                                            @foreach ($colors as $color)
                                                                <div class="color-option d-flex align-items-center">
                                                                    <span class="color-dot shadow-sm"
                                                                        style="background-color: {{ $color }};"
                                                                        title="{{ $color }}"></span>
                                                                    <small
                                                                        class="ml-1 text-muted d-none d-sm-inline">{{ $color }}</small>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (!empty($sizes))
                                                <tr class="spec-row">
                                                    <td class="py-3 px-4 font-weight-bold text-dark bg-light">
                                                        <i class="fas fa-ruler text-primary mr-2"></i>
                                                        Available Sizes
                                                    </td>
                                                    <td class="py-3 px-4">
                                                        <div class="size-options-display d-flex flex-wrap gap-2">
                                                            @foreach ($sizes as $size)
                                                                <span
                                                                    class="size-badge badge badge-outline-primary py-2 px-3 border">
                                                                    {{ $size }}
                                                                </span>
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
                                <p> {!! html_entity_decode($product->description) !!}</p>
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

                    {{-- Video Part --}}
                    <div class="product-video-section text-center py-4">
                        <h3 class="section-title mb-4">📹 Product Videos</h3>

                        @if ($product->video)
                            <div class="videos-container row justify-content-center g-4">
                                <!-- Local Video Check -->
                                @if ($product->video->video_path)
                                    <div class="video-item col-lg-6 col-md-8">
                                        <div class="card shadow-sm border-0 h-100">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="card-title mb-0">
                                                    <i class="fas fa-play-circle m-2"></i>Product Video
                                                </h5>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="local-video-container">
                                                    <video controls class="product-video w-100">
                                                        <source
                                                            src="{{ asset('storage/' . $product->video->video_path) }}"
                                                            type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                                @if ($product->video->title)
                                                    <div class="p-3">
                                                        <p class="video-title fw-semibold text-muted mb-0">
                                                            <i
                                                                class="fas fa-heading me-2"></i>{{ $product->video->title }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Embed Video Check -->
                                @if ($product->video->embed_link)
                                    <div class="video-item col-lg-6 col-md-8">
                                        <div class="card shadow-sm border-0 h-100">
                                            <div class="card-header bg-success text-white">
                                                <h5 class="card-title mb-0">
                                                    <i class="fab fa-youtube m-2"></i>Video From Youtube
                                                </h5>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="embed-video-container">
                                                    {!! $product->video->embed_link !!}
                                                </div>
                                                @if ($product->video->title && !$product->video->video_path)
                                                    <div class="p-3">
                                                        <p class="video-title fw-semibold text-muted mb-0">
                                                            <i
                                                                class="fas fa-heading me-2"></i>{{ $product->video->title }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="no-video-placeholder">
                                <div class="card border-0 bg-light">
                                    <div class="card-body py-5">
                                        <i class="fas fa-video-slash fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No Video Available</h5>
                                        <p class="text-muted mb-0">This product doesn't have any videos yet.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if (isset($relatedProducts) && $relatedProducts->count() > 0)
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
                                        <a href="#"
                                            class="btn-product-icon btn-wishlist btn-expandable addToWishlist"
                                            data-id="{{ $related->id }}">
                                            <span>add to wishlist</span>
                                        </a>
                                    </div>
                                    <div class="product-action">
                                        <a href="#" class="btn-product btn-cart addToCart"
                                            data-id="{{ $related->id }}">
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

            .btn-buy-now,
            .btn-cart {
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
        $(document).ready(function() {
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
                            window.location.href = "{{ route('login') }}?redirect_back=" +
                                encodeURIComponent(window.location.href);
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
                            window.location.href = "{{ route('login') }}?redirect_back=" +
                                encodeURIComponent(window.location.href);
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
                $(this).find('.btn-buy-now').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Processing...');
            });
        });
    </script>
@endpush
