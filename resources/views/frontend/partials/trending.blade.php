<!--Tranding Products--->

<div class="bg-light pt-5 pb-6">
    <div class="container trending-products">
        <div class="heading heading-flex mb-3">
            <div class="heading-left">
                <h2 class="title">Featured Products</h2><!-- End .title -->
            </div><!-- End .heading-left -->
        </div><!-- End .heading -->

        <div class="row">
            {{-- <div class="col-xl-5col d-none d-xl-block">
                <div class="banner">
                    <a href="#">
                        <img src="{{ asset('assets/frontend') }}/assets/images/demos/demo-4/banners/banner-4.jpg"
                            alt="banner">
                    </a>
                </div><!-- End .banner -->
            </div><!-- End .col-xl-5col --> --}}

            <div class="col-xl">
                <div class="tab-content tab-content-carousel just-action-icons-sm">
                    <div class="tab-pane p-0 fade show active" id="trending-top-tab" role="tabpanel"
                        aria-labelledby="trending-top-link">
                        <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                            data-owl-options='{
                                            "nav": true,
                                            "dots": false,
                                            "margin": 20,
                                            "loop": false,
                                            "responsive": {
                                                "0": {
                                                    "items":2
                                                },
                                                "480": {
                                                    "items":2
                                                },
                                                "768": {
                                                    "items":3
                                                },
                                                "992": {
                                                    "items":4
                                                }
                                            }
                                        }'>
                        @include('frontend.partials.featured')

                        </div><!-- End .owl-carousel -->
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .col-xl-4-5col -->
        </div><!-- End .row -->
    </div><!-- End .container -->
</div>
