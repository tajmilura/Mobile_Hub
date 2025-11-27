<div class="container for-you">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">Recommendation For You</h2>
        </div>

        <div class="heading-right">
            <a href="#" class="title-link">
                View All Recommendation <i class="icon-long-arrow-right"></i>
            </a> {{-- {{ route('products.recommended') }} --}}
        </div>
    </div>

    <div class="products">
        <div class="row justify-content-center">

            @foreach($recommendedProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product product-2">

                        <figure class="product-media">

                            @if($product->discount_price)
                                <span class="product-label label-circle label-sale">Sale</span>
                            @endif

                            <a href="{{ route('product.details', $product->id) }}">
                                <img src="{{ asset('storage/'. $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="product-image">
                            </a>

                            <div class="product-action-vertical">
                                <a href="{{ route('product.wishlist.add',$product->id) }}" data-id="{{ $product->id }}"
                                   class="btn-product-icon btn-wishlist add-to-wishlist"
                                   title="Add to wishlist"></a>
                            </div>

                            <div class="product-action">
                                <a href="{{ route('product.cart.add',$product->id) }}" data-id="{{ $product->id }}"
                                   class="btn-product btn-cart add-to-cart">
                                   <span>add to cart</span>
                                </a>

                                <a href="#" data-id="{{ $product->id }}"
                                   class="btn-product btn-quickview quick-view">
                                   <span>quick view</span>
                                </a>
                            </div>
                        </figure>

                        <div class="product-body">

                            <div class="product-cat">
                                <a href="#">{{ $product->category->name }}</a>
                            </div>

                            <h3 class="product-title">
                                <a href="{{ route('product.details', $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="product-price">
                                @if($product->discount_price)
                                    <span class="new-price">৳{{ $product->discount_price }}</span>
                                    <span class="old-price">Was ৳{{ $product->selling_price }}</span>
                                @else
                                    ৳{{ $product->selling_price }}
                                @endif
                            </div>

                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val"
                                         style="width: {{ $product->rating_percent }}%;">
                                    </div>
                                </div>
                                <span class="ratings-text">({{ $product->reviews_count }} Reviews)</span>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
