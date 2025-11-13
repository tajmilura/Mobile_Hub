@extends('frontend.front_app')
@section('content')
    <main class="main">
        <!--Slider-->
        @if ($sliders->count())
            @include('frontend.partials.slider')
        @endif
        <!-- End .intro-slider-container -->
        <div class="container">
            <h2 class="title text-center mb-4">Explore Popular Categories</h2><!-- End .title text-center -->
                {{-- category show --}}
                @if ($categories->count())
                    <div class="cat-blocks-container">
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-6 col-sm-4 col-lg-2">
                            <a href="#" class="cat-block"> {{-- {{ route('category.show', $category->id) }} --}}
                                <figure>
                                    <span>
                                        <img src="{{ asset('storage/' . $category->category_image) }}"
                                            alt="{{ $category->category_name }}">
                                    </span>
                                </figure>
                                <h3 class="cat-block-title">{{ $category->category_name }}</h3>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End .cat-blocks-container -->
                @endif
        </div><!-- End .container -->

        <div class="mb-4"></div><!-- End .mb-4 -->
        <!--Banner-->
        @include('frontend.partials.banner')
        <!-- End .container -->

        <div class="mb-3"></div><!-- End .mb-5 -->

        <!--New Arraivals-->
        @include('frontend.partials.new_arrival')
        <!-- End .container -->

        <div class="mb-6"></div><!-- End .mb-6 -->

        <div class="container">
            <div class="cta cta-border mb-5"
                style="background-image: url({{ asset('assets/frontend') }}/assets/images/demos/demo-4/bg-1.jpg);">
                <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/camera.png" alt="camera"
                    class="cta-img">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="cta-content">
                            <div class="cta-text text-right text-white">
                                <p>Shop Today’s Deals <br><strong>Awesome Made Easy. HERO7 Black</strong></p>
                            </div><!-- End .cta-text -->
                            <a href="#" class="btn btn-primary btn-round"><span>Shop Now - $429.99</span><i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .cta-content -->
                    </div><!-- End .col-md-12 -->
                </div><!-- End .row -->
            </div><!-- End .cta -->
        </div><!-- End .container -->

        <div class="container">
            <div class="heading text-center mb-3">
                <h2 class="title">Deals & Outlet</h2><!-- End .title -->
                <p class="title-desc">Today’s deal and more</p><!-- End .title-desc -->
            </div><!-- End .heading -->

            <div class="row">
                <div class="col-lg-6 deal-col">
                    <div class="deal"
                        style="background-image: url('{{ asset('assets/frontend') }}/assets/images/demos/demo-4/deal/bg-1.jpg');">
                        <div class="deal-top">
                            <h2>Deal of the Day.</h2>
                            <h4>Limited quantities. </h4>
                        </div><!-- End .deal-top -->

                        <div class="deal-content">
                            <h3 class="product-title"><a href="product.html">Home Smart Speaker with Google
                                    Assistant</a></h3><!-- End .product-title -->

                            <div class="product-price">
                                <span class="new-price">$129.00</span>
                                <span class="old-price">Was $150.99</span>
                            </div><!-- End .product-price -->

                            <a href="product.html" class="btn btn-link"><span>Shop Now</span><i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .deal-content -->

                        <div class="deal-bottom">
                            <div class="deal-countdown daily-deal-countdown" data-until="+10h"></div>
                            <!-- End .deal-countdown -->
                        </div><!-- End .deal-bottom -->
                    </div><!-- End .deal -->
                </div><!-- End .col-lg-6 -->

                <div class="col-lg-6 deal-col">
                    <div class="deal"
                        style="background-image: url('{{ asset('assets/frontend') }}/assets/images/demos/demo-4/deal/bg-2.jpg');">
                        <div class="deal-top">
                            <h2>Your Exclusive Offers.</h2>
                            <h4>Sign in to see amazing deals.</h4>
                        </div><!-- End .deal-top -->

                        <div class="deal-content">
                            <h3 class="product-title"><a href="product.html">Certified Wireless Charging Pad for
                                    iPhone / Android</a></h3><!-- End .product-title -->

                            <div class="product-price">
                                <span class="new-price">$29.99</span>
                            </div><!-- End .product-price -->

                            <a href="login.html" class="btn btn-link"><span>Sign In and Save money</span><i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .deal-content -->

                        <div class="deal-bottom">
                            <div class="deal-countdown offer-countdown" data-until="+11d"></div>
                            <!-- End .deal-countdown -->
                        </div><!-- End .deal-bottom -->
                    </div><!-- End .deal -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->

            <div class="more-container text-center mt-1 mb-5">
                <a href="#" class="btn btn-outline-dark-2 btn-round btn-more"><span>Shop more Outlet
                        deals</span><i class="icon-long-arrow-right"></i></a>
            </div><!-- End .more-container -->
        </div><!-- End .container -->

        <div class="container">
            <hr class="mb-0">
            <div class="owl-carousel mt-5 mb-5 owl-simple" data-toggle="owl"
                data-owl-options='{
                        "nav": false,
                        "dots": false,
                        "margin": 30,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "420": {
                                "items":3
                            },
                            "600": {
                                "items":4
                            },
                            "900": {
                                "items":5
                            },
                            "1024": {
                                "items":6
                            }
                        }
                    }'>
                <a href="#" class="brand">
                    <img src="{{ asset('assets/frontend') }}/assets/images/brands/1.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('assets/frontend') }}/assets/images/brands/2.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('assets/frontend') }}/assets/images/brands/3.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('assets/frontend') }}/assets/images/brands/4.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('assets/frontend') }}/assets/images/brands/5.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('assets/frontend') }}/assets/images/brands/6.png" alt="Brand Name">
                </a>
            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
        <!---Tranding product-->
        @include('frontend.partials.trending')
        <!-- End .bg-light pt-5 pb-6 -->

        <div class="mb-5"></div><!-- End .mb-5 -->
        <!--Recommendation For You-->

        <div class="container for-you">
            <div class="heading heading-flex mb-3">
                <div class="heading-left">
                    <h2 class="title">Recommendation For You</h2><!-- End .title -->
                </div><!-- End .heading-left -->

                <div class="heading-right">
                    <a href="#" class="title-link">View All Recommendadion <i
                            class="icon-long-arrow-right"></i></a>
                </div><!-- End .heading-right -->
            </div><!-- End .heading -->

            <div class="products">
                <div class="row justify-content-center">
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-2">
                            <figure class="product-media">
                                <span class="product-label label-circle label-sale">Sale</span>
                                <a href="product.html">
                                    <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/products/product-10.jpg"
                                        alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add
                                            to cart</span></a>
                                    <a href="popup/quickView.html" class="btn-product btn-quickview"
                                        title="Quick view"><span>quick view</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Headphones</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Beats by Dr. Dre Wireless
                                        Headphones</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    <span class="new-price">$279.99</span>
                                    <span class="old-price">Was $349.99</span>
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 40%;"></div>
                                        <!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 4 Reviews )</span>
                                </div><!-- End .rating-container -->

                                <div class="product-nav product-nav-dots">
                                    <a href="#" class="active" style="background: #666666;"><span
                                            class="sr-only">Color name</span></a>
                                    <a href="#" style="background: #ff887f;"><span class="sr-only">Color
                                            name</span></a>
                                    <a href="#" style="background: #6699cc;"><span class="sr-only">Color
                                            name</span></a>
                                    <a href="#" style="background: #f3dbc1;"><span class="sr-only">Color
                                            name</span></a>
                                    <a href="#" style="background: #eaeaec;"><span class="sr-only">Color
                                            name</span></a>
                                </div><!-- End .product-nav -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-2">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/products/product-11.jpg"
                                        alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add
                                            to cart</span></a>
                                    <a href="popup/quickView.html" class="btn-product btn-quickview"
                                        title="Quick view"><span>quick view</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Cameras & Camcorders</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">GoPro - HERO7 Black HD Waterproof
                                        Action</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    $349.99
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 60%;"></div>
                                        <!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 2 Reviews )</span>
                                </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-2">
                            <figure class="product-media">
                                <span class="product-label label-circle label-new">New</span>
                                <a href="product.html">
                                    <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/products/product-12.jpg"
                                        alt="Product image" class="product-image">
                                    <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/products/product-12-2.jpg"
                                        alt="Product image" class="product-image-hover">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add
                                            to cart</span></a>
                                    <a href="popup/quickView.html" class="btn-product btn-quickview"
                                        title="Quick view"><span>quick view</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Smartwatches</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Apple - Apple Watch Series 3 with
                                        White Sport Band</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    $214.49
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 0%;"></div>
                                        <!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 0 Reviews )</span>
                                </div><!-- End .rating-container -->

                                <div class="product-nav product-nav-dots">
                                    <a href="#" class="active" style="background: #e2e2e2;"><span
                                            class="sr-only">Color name</span></a>
                                    <a href="#" style="background: #333333;"><span class="sr-only">Color
                                            name</span></a>
                                    <a href="#" style="background: #f2bc9e;"><span class="sr-only">Color
                                            name</span></a>
                                </div><!-- End .product-nav -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-2">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/products/product-13.jpg"
                                        alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add
                                            to cart</span></a>
                                    <a href="popup/quickView.html" class="btn-product btn-quickview"
                                        title="Quick view"><span>quick view</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Laptops</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Lenovo - 330-15IKBR 15.6"</a>
                                </h3><!-- End .product-title -->
                                <div class="product-price">
                                    <span class="out-price">$339.99</span>
                                    <span class="out-text">Out Of Stock</span>
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 60%;"></div>
                                        <!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 11 Reviews )</span>
                                </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-2">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/products/product-14.jpg"
                                        alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add
                                            to cart</span></a>
                                    <a href="popup/quickView.html" class="btn-product btn-quickview"
                                        title="Quick view"><span>quick view</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Digital Cameras</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Sony - Alpha a5100 Mirrorless
                                        Camera</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    $499.99
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 50%;"></div>
                                        <!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 11 Reviews )</span>
                                </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-2">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/products/product-15.jpg"
                                        alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add
                                            to cart</span></a>
                                    <a href="popup/quickView.html" class="btn-product btn-quickview"
                                        title="Quick view"><span>quick view</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Laptops</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Home Mini - Smart Speaker with
                                        Google Assistant</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    $49.00
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 60%;"></div>
                                        <!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 24 Reviews )</span>
                                </div><!-- End .rating-container -->

                                <div class="product-nav product-nav-dots">
                                    <a href="#" class="active" style="background: #ef837b;"><span
                                            class="sr-only">Color name</span></a>
                                    <a href="#" style="background: #333333;"><span class="sr-only">Color
                                            name</span></a>
                                    <a href="#" style="background: #e2e2e2;"><span class="sr-only">Color
                                            name</span></a>
                                </div><!-- End .product-nav -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-2">
                            <figure class="product-media">
                                <span class="product-label label-circle label-sale">Sale</span>
                                <a href="product.html">
                                    <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/products/product-16.jpg"
                                        alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add
                                            to cart</span></a>
                                    <a href="popup/quickView.html" class="btn-product btn-quickview"
                                        title="Quick view"><span>quick view</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Audio</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">WONDERBOOM Portable Bluetooth
                                        Speaker</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    <span class="new-price">$99.99</span>
                                    <span class="old-price">Was $129.99</span>
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 40%;"></div>
                                        <!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 4 Reviews )</span>
                                </div><!-- End .rating-container -->

                                <div class="product-nav product-nav-dots">
                                    <a href="#" class="active" style="background: #666666;"><span
                                            class="sr-only">Color name</span></a>
                                    <a href="#" style="background: #ff887f;"><span class="sr-only">Color
                                            name</span></a>
                                    <a href="#" style="background: #6699cc;"><span class="sr-only">Color
                                            name</span></a>
                                    <a href="#" style="background: #f3dbc1;"><span class="sr-only">Color
                                            name</span></a>
                                    <a href="#" style="background: #eaeaec;"><span class="sr-only">Color
                                            name</span></a>
                                </div><!-- End .product-nav -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-2">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/products/product-17.jpg"
                                        alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                                </div><!-- End .product-action -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add
                                            to cart</span></a>
                                    <a href="popup/quickView.html" class="btn-product btn-quickview"
                                        title="Quick view"><span>quick view</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Smart Home</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Google - Home Hub with Google
                                        Assistant</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    $149.00
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 60%;"></div>
                                        <!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 2 Reviews )</span>
                                </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .products -->
        </div><!-- End .container -->

        <div class="mb-4"></div><!-- End .mb-4 -->

        <div class="container">
            <hr class="mb-0">
        </div><!-- End .container -->

        <div class="icon-boxes-container bg-transparent">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="icon-box icon-box-side">
                            <span class="icon-box-icon text-dark">
                                <i class="icon-rocket"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Free Shipping</h3><!-- End .icon-box-title -->
                                <p>Orders $50 or more</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-sm-6 col-lg-3 -->

                    <div class="col-sm-6 col-lg-3">
                        <div class="icon-box icon-box-side">
                            <span class="icon-box-icon text-dark">
                                <i class="icon-rotate-left"></i>
                            </span>

                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Free Returns</h3><!-- End .icon-box-title -->
                                <p>Within 30 days</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-sm-6 col-lg-3 -->

                    <div class="col-sm-6 col-lg-3">
                        <div class="icon-box icon-box-side">
                            <span class="icon-box-icon text-dark">
                                <i class="icon-info-circle"></i>
                            </span>

                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Get 20% Off 1 Item</h3><!-- End .icon-box-title -->
                                <p>when you sign up</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-sm-6 col-lg-3 -->

                    <div class="col-sm-6 col-lg-3">
                        <div class="icon-box icon-box-side">
                            <span class="icon-box-icon text-dark">
                                <i class="icon-life-ring"></i>
                            </span>

                            <div class="icon-box-content">
                                <h3 class="icon-box-title">We Support</h3><!-- End .icon-box-title -->
                                <p>24/7 amazing services</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-sm-6 col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .icon-boxes-container -->
    </main>
@endsection
