<!--Banner-->

@if ($banners->count())
    <div class="container">
        <div class="row justify-content-center">

            @foreach ($banners as $banner)
                <div class="col-md-6 col-lg-4">
                    <div class="banner banner-overlay banner-overlay-light">
                        <a href="{{ $banner->link ?? '#' }}">
                            <img src="{{ asset('storage/' . $banner->image_path) }}" alt="Banner Image">
                        </a>

                        <div class="banner-content">

                            @if ($banner->subtitle)
                                <h4 class="banner-subtitle">
                                    <a href="{{ $banner->link ?? '#' }}">
                                        {{ $banner->subtitle }}
                                    </a>
                                </h4>
                            @endif

                            @if ($banner->title)
                                <h3 class="banner-title">
                                    <a href="{{ $banner->link ?? '#' }}">
                                        {!! nl2br(e($banner->title)) !!}
                                    </a>
                                </h3>
                            @endif

                            <a href="{{ $banner->link ?? '#' }}" class="banner-link">
                                Shop Now <i class="icon-long-arrow-right"></i>
                            </a>

                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col -->
            @endforeach

        </div><!-- End .row -->
    </div><!-- End .container -->
@endif
