                            @foreach ($isFeaturedProducts as $product)
                                <div class="product product-2">
                                    <figure class="product-media">


                                        @if ($product->is_hot_deal)
                                            <span class="product-label label-circle label-top">Hot</span>
                                        @elseif($product->is_new_arrival)
                                            <span class="product-label label-circle label-top">New</span>
                                        @endif

                                        {{-- IMAGE --}}
                                        <a href="{{ route('product.details', $product->id) }}"> {{-- {{ route('product.details', $product->slug) }} --}}
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="product-image">
                                        </a>

                                        {{-- Wishlist --}}
                                        <div class="product-action-vertical">
                                            <a href="{{ route('product.wishlist.add', $product->id) }}" class="btn-product-icon btn-wishlist"
                                                title="Add to wishlist"></a>
                                        </div>

                                        {{-- Cart + Quick View --}}
                                        <div class="product-action">
                                            <a href="{{ route('product.cart.add', $product->id) }}" class="btn-product btn-cart" title="Add to cart">
                                                <span>Add to cart</span>
                                            </a>

                                            <a href="#" class="btn-product btn-quickview" title="Quick view">
                                                <span>Quick view</span>
                                            </a>
                                        </div>
                                    </figure>

                                    <div class="product-body">

                                        {{-- CATEGORY --}}
                                        <div class="product-cat">
                                            <a href="{{ route('product.category.products',$product->category_id) }}"> {{-- {{ route('category.products', $product->category->slug) }} --}}
                                                {{ $product->category->name }}
                                            </a>
                                        </div>

                                        {{-- TITLE --}}
                                        <h3 class="product-title">
                                            <a href="{{ route('product.details',$product->id) }}"> {{-- {{ route('product.details', $product->slug) }} --}}
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        {{-- PRICE (Discount Handling) --}}
                                        <div class="product-price">
                                            @if ($product->discount_price)
                                                <span class="new-price">{{ $product->discount_price }} ৳</span>
                                                <span class="old-price"><s>{{ $product->price }} ৳</s></span>
                                            @else
                                                <span class="new-price">{{ $product->price }} ৳</span>
                                            @endif
                                        </div>

                                        {{-- Rating --}}
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val"
                                                    style="width: {{ $product->rating_percent ?? 0 }}%;">
                                                </div>
                                            </div>
                                            <span class="ratings-text">({{ $product->reviews_count ?? 0 }}
                                                Reviews)</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
