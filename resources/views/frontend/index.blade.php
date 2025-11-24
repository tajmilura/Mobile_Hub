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
        @if ($longBanner)
            <div class="container">
                <div class="cta cta-border mb-5"
                    style="background-image: url({{ asset('storage/' . $longBanner->image_path) }});">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="cta-content">
                                <div class="cta-text text-right text-white">
                                    <p>{!! $longBanner->subtitle !!} <br><strong>{!! $longBanner->highlight_text !!}</strong></p>
                                </div>
                                <a href="{{ $longBanner->link ?? '#' }}" class="btn btn-primary btn-round">
                                    <span>{{ $longBanner->title }} - ${{ number_format($longBanner->price, 2) }}</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- End .container -->

        <!-- Todays deal -->

        @include('frontend.partials.deal') <!-- End .container -->

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
        @if($isFeaturedProducts->count() > 0)
        @include('frontend.partials.trending')
        @endif
        <!-- End .bg-light pt-5 pb-6 -->

        <div class="mb-5"></div><!-- End .mb-5 -->
        <!--Recommendation For You-->

        @include('frontend.partials.recommendation')

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
