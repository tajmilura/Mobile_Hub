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

                                <div class="details-filter-row details-row-size">
                                    <label>Color:</label>
                                    @php
                                        $colors = is_array($product->colors)
                                            ? $product->colors
                                            : json_decode($product->colors, true);
                                        $colors = $colors ?? [];
                                    @endphp
                                    <div class="product-nav product-nav-thumbs">
                                        @foreach ($colors as $color)
                                            <a href="#" class="@if ($loop->first) active @endif">
                                                <span
                                                    style="background-color: {{ $color }}; display:block; width:20px; height:20px; border-radius:50%;"></span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qty" class="form-control" value="1"
                                            min="1" max="{{ $product->stock }}" step="1" data-decimals="0"
                                            required>
                                    </div>
                                </div>

                                <div class="product-details-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>

                                    <div class="details-action-wrapper">
                                        <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add to
                                                Wishlist</span></a>
                                        <a href="#" class="btn-product btn-compare" title="Compare"><span>Add to
                                                Compare</span></a>
                                    </div>
                                </div>

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <a href="#">{{ $product->category->name ?? '' }}</a>
                                    </div>

                                    <div class="social-icons social-icons-sm">
                                        <span class="social-label">Share:</span>
                                        <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                                class="icon-facebook-f"></i></a>
                                        <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                                class="icon-twitter"></i></a>
                                        <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                                class="icon-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-details-tab">
                    <ul class="nav nav-pills justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                                role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab"
                                role="tab" aria-controls="product-info-tab" aria-selected="false">Additional
                                information</a>
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
                            <div class="product-desc-content">
                                <h3 class="mb-3">Additional Information</h3>

                                <table class="table table-striped table-bordered">
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

                                        {{-- Dynamic Row Loop --}}
                                        @foreach ($attributes as $key => $label)
                                            @if (!empty($product->$key))
                                                <tr>
                                                    <th style="width: 200px; font-weight: 600;">{{ $label }}</th>
                                                    <td>{{ $product->$key }}</td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        {{-- Colors if exists --}}
                                        @php
                                            $colors = is_array($product->colors)
                                                ? $product->colors
                                                : json_decode($product->colors, true);
                                        @endphp

                                        @if (!empty($colors))
                                            <tr>
                                                <th style="font-weight: 600;">Available Colors</th>
                                                <td>
                                                    @foreach ($colors as $color)
                                                        <span
                                                            style="display:inline-block; width:18px; height:18px; border-radius:50%; background:{{ $color }}; margin-right:6px; border:1px solid #ccc;">
                                                        </span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
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
                                    We hope you’ll love every purchase, but if you ever need to return an item you can do so
                                    within a month of receipt. For full details of how to make a return, please view our <a
                                        href="#">Returns information</a></p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                            aria-labelledby="product-review-link">
                            <div class="reviews">
                                <h3>Reviews (2)</h3>
                                {{-- Existing static reviews --}}
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to
                                            wishlist</span></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div>
                            </figure>
                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">{{ $related->category->name ?? '' }}</a>
                                </div>
                                <h3 class="product-title"><a
                                        href="{{ route('product.details', $related->id) }}">{{ $related->name }}</a></h3>
                                <div class="product-price">${{ number_format($related->price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('product.trackView', $product->id) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            });
        });
    </script>
@endpush
