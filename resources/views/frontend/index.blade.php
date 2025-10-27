@extends('frontend.front_app')
@section('content')

       <main class="main">
            @include('frontend.partials.slider')
            <!-- End .intro-section -->

            @include('frontend.partials.featured')
            <!-- End featured .container -->

            <div class="mb-7 mb-lg-11"></div><!-- End .mb-7 -->

            <div class="container">
                <div class="cta cta-border cta-border-image mb-5 mb-lg-7"
                    style="background-image: url({{ asset('assets/frontend') }}/assets/images/demos/demo-3/bg-1.jpg);">
                    <div class="cta-border-wrapper bg-white">
                        <div class="row justify-content-center">
                            <div class="col-md-11 col-xl-11">
                                <div class="cta-content">
                                    <div class="cta-heading">
                                        <h3 class="cta-title text-right"><span class="text-primary">New Deals</span>
                                            <br>Start Daily at 12pm e.t.
                                        </h3><!-- End .cta-title -->
                                    </div><!-- End .cta-heading -->

                                    <div class="cta-text">
                                        <p>Get <span class="text-dark font-weight-normal">FREE SHIPPING* & 5%
                                                rewards</span> on <br>every order with Molla Theme rewards program</p>
                                    </div><!-- End .cta-text -->
                                    <a href="#" class="btn btn-primary btn-round"><span>Add to Cart for
                                            $50.00/yr</span><i class="icon-long-arrow-right"></i></a>
                                </div><!-- End .cta-content -->
                            </div><!-- End .col-xl-7 -->
                        </div><!-- End .row -->
                    </div><!-- End .bg-white -->
                </div><!-- End .cta -->
            </div><!-- End .container -->

            @include('frontend.partials.deal')
            <!-- End .deal-container -->

            <div class="container">
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

            <div class="container">
                <hr class="mt-3 mb-6">
            </div><!-- End .container -->

            @include('frontend.partials.trending')
            <!-- End .container -->

            <div class="container">
                <hr class="mt-5 mb-6">
            </div><!-- End .container -->
            @include('frontend.partials.top_selling')
            <!-- Top End .container -->

            <div class="container">
                <hr class="mt-5 mb-0">
            </div><!-- End .container -->

            <div class="icon-boxes-container mt-2 mb-2 bg-transparent">
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

            <div class="container">
                <div class="cta cta-separator cta-border-image cta-half mb-0"
                    style="background-image: url({{ asset('assets/frontend') }}/assets/images/demos/demo-3/bg-2.jpg);">
                    <div class="cta-border-wrapper bg-white">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="cta-wrapper cta-text text-center">
                                    <h3 class="cta-title">Shop Social</h3><!-- End .cta-title -->
                                    <p class="cta-desc">Donec nec justo eget felis facilisis fermentum. Aliquam
                                        porttitor mauris sit amet orci. </p><!-- End .cta-desc -->

                                    <div class="social-icons social-icons-colored justify-content-center">
                                        <a href="#" class="social-icon social-facebook" title="Facebook"
                                            target="_blank"><i class="icon-facebook-f"></i></a>
                                        <a href="#" class="social-icon social-twitter" title="Twitter"
                                            target="_blank"><i class="icon-twitter"></i></a>
                                        <a href="#" class="social-icon social-instagram" title="Instagram"
                                            target="_blank"><i class="icon-instagram"></i></a>
                                        <a href="#" class="social-icon social-youtube" title="Youtube"
                                            target="_blank"><i class="icon-youtube"></i></a>
                                        <a href="#" class="social-icon social-pinterest" title="Pinterest"
                                            target="_blank"><i class="icon-pinterest"></i></a>
                                    </div><!-- End .soial-icons -->
                                </div><!-- End .cta-wrapper -->
                            </div><!-- End .col-lg-6 -->

                            <div class="col-lg-6">
                                <div class="cta-wrapper text-center">
                                    <h3 class="cta-title">Get the Latest Deals</h3><!-- End .cta-title -->
                                    <p class="cta-desc">and <br>receive <span class="text-primary">$20 coupon</span>
                                        for first shopping</p><!-- End .cta-desc -->

                                    <form action="#">
                                        <div class="input-group">
                                            <input type="email" class="form-control"
                                                placeholder="Enter your Email Address" aria-label="Email Adress"
                                                required>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-rounded" type="submit"><i
                                                        class="icon-long-arrow-right"></i></button>
                                            </div><!-- .End .input-group-append -->
                                        </div><!-- .End .input-group -->
                                    </form>
                                </div><!-- End .cta-wrapper -->
                            </div><!-- End .col-lg-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .bg-white -->
                </div><!-- End .cta -->
            </div><!-- End .container -->
        </main><!-- End .main -->

@endsection
