        <footer class="footer">
            <div class="cta bg-image bg-dark pt-4 pb-5 mb-0"
                style="background-image: url({{ asset('assets/frontend') }}/assets/images/demos/demo-4/bg-5.jpg);">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-10 col-md-8 col-lg-6">
                            <div class="cta-heading text-center">
                                <h3 class="cta-title text-white">Get The Latest Deals</h3><!-- End .cta-title -->
                                <p class="cta-desc text-white">and receive <span class="font-weight-normal">$20
                                        coupon</span> for first shopping</p><!-- End .cta-desc -->
                            </div><!-- End .text-center -->

                            <form method="POST" action="{{ route('newsletter.subscribe') }}">
                                @csrf
                                <div class="input-group input-group-round">
                                    <input type="email" name="email"
                                        class="form-control form-control-white @error('email') is-invalid @enderror"
                                        placeholder="Enter your Email Address" aria-label="Email Address" required
                                        value="{{ old('email') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <span>Subscribe</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @if (session('newsletter_success'))
                                    <div class="alert alert-success mt-2">{{ session('newsletter_success') }}</div>
                                @endif
                            </form>
                        </div><!-- End .col-sm-10 col-md-8 col-lg-6 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cta -->
            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="widget widget-about">
                                <img src="{{ asset('storage/' . getSetting('site_logo')) }}" class="footer-logo"
                                    alt="Footer Logo" width="105" height="25">
                                <p>Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate
                                    magna eros eu erat. </p>

                                <div class="widget-call">
                                    <i class="icon-phone"></i>
                                    Got Question? Call us 24/7
                                    <a href="tel:#"></a>{{ getSetting('phone', 'Mobile Hub') }}
                                </div><!-- End .widget-call -->
                            </div><!-- End .widget about-widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="{{ route('about') }}">About
                                            {{ getSetting('site_name', 'Mobile Hub') }}</a></li>
                                    <li><a href="#">Our Services</a></li>
                                    <li><a href="#">How to shop on {{ getSetting('site_name', 'Mobile Hub') }}</a>
                                    </li>
                                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                                    <li><a href="{{ route('contact') }}">Contact us</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="#">Payment Methods</a></li>
                                    <li><a href="#">Money-back guarantee!</a></li>
                                    <li><a href="#">Returns</a></li>
                                    <li><a href="#">Shipping</a></li>
                                    <li><a href="#">Terms and conditions</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="{{ route('login') }}">Sign In</a></li>
                                    <li><a href="{{ route('product.cart.index') }}">View Cart</a></li>
                                    <li><a href="{{ route('product.wishlist.index') }}">My Wishlist</a></li>
                                    <li><a href="#">Track My Order</a></li>
                                    <li><a href="{{ route('contact') }}">Help</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="footer-bottom">
                <div class="container">
                    ' <strong>Copyright &copy; {{ date('Y') }} <a
                            href="#">{{ getSetting('site_name', 'Mobile Hub') }}</a>.</strong>'
                    All rights reserved.
                    <div class="float-right d-none d-sm-inline-block">
                        <b>Version</b> 1.0
                    </div>
                    <!-- End .footer-copyright -->
                    <figure class="footer-payments">
                        <img src="{{ asset('assets/frontend') }}/assets/images/payments.png" alt="Payment methods"
                            width="272" height="20">
                    </figure><!-- End .footer-payments -->
                </div><!-- End .container -->
            </div><!-- End .footer-bottom -->
        </footer>
