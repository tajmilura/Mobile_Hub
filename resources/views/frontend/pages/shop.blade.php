@extends('frontend.front_app')

@section('title', 'Shop - All Products')

@section('content')
<main class="main">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3">
                    <div class="sidebar sidebar-shop">
                        <!-- Search Filter -->
                        <div class="widget">
                            <h3 class="widget-title">Search</h3>
                            <div class="widget-body">
                                <form action="{{ route('shop') }}" method="GET">
                                    @if(request('sort'))
                                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                                    @endif
                                    @if(request('category'))
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                    @endif
                                    @if(request('brand'))
                                        <input type="hidden" name="brand" value="{{ request('brand') }}">
                                    @endif
                                    @if(request('min_price'))
                                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                    @endif
                                    @if(request('max_price'))
                                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                    @endif
                                    
                                    <div class="form-group">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Search products..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">Search</button>
                                </form>
                            </div>
                        </div>

                        <!-- Categories Filter -->
                        <div class="widget widget-categories">
                            <h3 class="widget-title">Categories</h3>
                            <div class="widget-body">
                                <form action="{{ route('shop') }}" method="GET" id="category-form">
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if(request('sort'))
                                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                                    @endif
                                    @if(request('brand'))
                                        <input type="hidden" name="brand" value="{{ request('brand') }}">
                                    @endif
                                    @if(request('min_price'))
                                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                    @endif
                                    @if(request('max_price'))
                                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                    @endif
                                    
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input category-filter" 
                                                       id="category-all" 
                                                       name="category" 
                                                       value=""
                                                       {{ !request('category') ? 'checked' : '' }}
                                                       onchange="document.getElementById('category-form').submit()">
                                                <label class="custom-control-label" for="category-all">
                                                    All Categories
                                                </label>
                                            </div>
                                        </li>
                                        @foreach($categories as $category)
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input category-filter" 
                                                       id="category-{{ $category->id }}" 
                                                       name="category" 
                                                       value="{{ $category->id }}"
                                                       {{ request('category') == $category->id ? 'checked' : '' }}
                                                       onchange="document.getElementById('category-form').submit()">
                                                <label class="custom-control-label" for="category-{{ $category->id }}">
                                                    {{ $category->category_name }}
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </form>
                            </div>
                        </div>

                        <!-- Brands Filter -->
                        <div class="widget widget-categories">
                            <h3 class="widget-title">Brands</h3>
                            <div class="widget-body">
                                <form action="{{ route('shop') }}" method="GET" id="brand-form">
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if(request('sort'))
                                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                                    @endif
                                    @if(request('category'))
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                    @endif
                                    @if(request('min_price'))
                                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                    @endif
                                    @if(request('max_price'))
                                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                    @endif
                                    
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input brand-filter" 
                                                       id="brand-all" 
                                                       name="brand" 
                                                       value=""
                                                       {{ !request('brand') ? 'checked' : '' }}
                                                       onchange="document.getElementById('brand-form').submit()">
                                                <label class="custom-control-label" for="brand-all">
                                                    All Brands
                                                </label>
                                            </div>
                                        </li>
                                        @foreach($brands as $brand)
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input brand-filter" 
                                                       id="brand-{{ $brand->id }}" 
                                                       name="brand" 
                                                       value="{{ $brand->id }}"
                                                       {{ request('brand') == $brand->id ? 'checked' : '' }}
                                                       onchange="document.getElementById('brand-form').submit()">
                                                <label class="custom-control-label" for="brand-{{ $brand->id }}">
                                                    {{ $brand->name }}
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </form>
                            </div>
                        </div>

                        <!-- Clear All Filters -->
                        @if(request('search') || request('category') || request('brand') || request('min_price') || request('max_price'))
                        <div class="widget">
                            <div class="widget-body">
                                <a href="{{ route('shop') }}" class="btn btn-outline-danger btn-sm btn-block">
                                    Clear All Filters
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Products Section -->
                <div class="col-lg-9">
                    <!-- Page Header -->
                    <div class="page-header mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="page-title">
                                    @if(request('search'))
                                        Search: "{{ request('search') }}"
                                    @else
                                        All Products
                                    @endif
                                </h1>
                                <p class="page-subtitle">
                                    Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} products
                                </p>
                            </div>
                            <div class="col-md-6">
                                <!-- Sorting Options -->
                                <div class="sorting-options text-right">
                                    <form action="{{ route('shop') }}" method="GET" id="sort-form">
                                        @if(request('search'))
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                        @endif
                                        @if(request('category'))
                                            <input type="hidden" name="category" value="{{ request('category') }}">
                                        @endif
                                        @if(request('brand'))
                                            <input type="hidden" name="brand" value="{{ request('brand') }}">
                                        @endif
                                        @if(request('min_price'))
                                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                        @endif
                                        @if(request('max_price'))
                                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                        @endif
                                        
                                        <select name="sort" id="sort" class="form-control form-control-sm d-inline-block w-auto" onchange="document.getElementById('sort-form').submit()">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="products">
                        <div class="row justify-content-center">
                            @forelse ($products as $product)
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
                                                <a href="#">{{ $product->category->category_name }}</a>
                                            </div>

                                            <h3 class="product-title">
                                                <a href="{{ route('product.details', $product->id) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>

                                            <div class="product-price">
                                                @if($product->discount_price)
                                                    <span class="new-price">৳{{ number_format($product->discount_price) }}</span>
                                                    <span class="old-price">Was ৳{{ number_format($product->price) }}</span>
                                                @else
                                                    ৳{{ number_format($product->price) }}
                                                @endif
                                            </div>

                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val"
                                                         style="width: {{ $product->rating_percent ?? 80 }}%;">
                                                    </div>
                                                </div>
                                                <span class="ratings-text">({{ $product->reviews_count ?? 0 }} Reviews)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info text-center py-5">
                                        <h4>No products found!</h4>
                                        <p>There are no products matching your search criteria.</p>
                                        <a href="{{ route('shop') }}" class="btn btn-primary">View All Products</a>
                                    </div>
                                </div>
                            @endforelse
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection