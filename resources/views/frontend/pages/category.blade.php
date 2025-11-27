@extends('frontend.front_app')
@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container d-flex align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->category_name }}</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">

                <div class="products">
                    <div class="row justify-content-center">

                        @foreach ($products as $product)
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="product product-2">

                                    <figure class="product-media">

                                        @if ($product->discount_price)
                                            <span class="product-label label-circle label-sale">Sale</span>
                                        @endif

                                        <a href="{{ route('product.details', $product->id) }}">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="product-image">
                                        </a>

                                        <div class="product-action-vertical">
                                            <a href="#" data-id="{{ $product->id }}"
                                                class="btn-product-icon btn-wishlist add-to-wishlist"
                                                title="Add to wishlist"></a>
                                        </div>

                                        <div class="product-action">
                                            <a href="{{ route('product.cart.add', $product->id) }}" data-id="{{ $product->id }}"
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
                                            @if ($product->discount_price)
                                                <span class="new-price">৳{{ $product->discount_price }}</span>
                                                <span class="old-price">Was ৳{{ $product->selling_price }}</span>
                                            @else
                                                ৳{{ $product->selling_price }}
                                            @endif
                                        </div>

                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val" style="width: {{ $product->rating_percent }}%;">
                                                </div>
                                            </div>
                                            <span class="ratings-text">({{ $product->reviews_count }} Reviews)</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                    <div class="row mt-4">
                        <div class="col-12">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    {{-- Previous Page Link --}}
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-hidden="true">&laquo;</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev" aria-label="Previous">
                                                &laquo;
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next" aria-label="Next">
                                                &raquo;
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-hidden="true">&raquo;</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                    @endif
                    <!-- End Pagination -->

                </div>
            </div>
        </div>
    </main>
@endsection
