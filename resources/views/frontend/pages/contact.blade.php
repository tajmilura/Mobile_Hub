@extends('frontend.front_app')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Contact us 2<span>Pages</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact us 2</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="row justify-content-center">

                <div class="col-lg-10 offset-lg-1">
                    <div class="about-text text-center mt-3">
                        <h2 class="title text-center mb-2">Contact Us</h2><!-- End .title text-center mb-2 -->

                        <!-- Dynamic About Us Content -->
                        @if (getSetting('contact_us'))
                            <div class="about-content">
                                {!! getSetting('contact_us') !!}
                            </div>
                        @else
                            <p>Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit
                                nunc tortor eu nibh. Suspendisse potenti. Sed egestas, ante et vulputate volutpat, uctus
                                metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id,
                                est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis.</p>
                        @endif
                    </div><!-- End .about-text -->
                </div><!-- End .col-lg-10 offset-1 -->
            </div><!-- End .row -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
