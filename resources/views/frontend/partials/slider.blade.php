<!--Slider -->
<div class="intro-slider-container mb-5">
    <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
        data-owl-options='{
                        "dots": true,
                        "nav": false,
                        "responsive": {
                            "1200": {
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>
    @foreach($sliders as $slider)
        <div class="intro-slide" style="background-image: url({{ asset('storage/' . $slider->image_path) }});">
            <div class="container intro-content">
                <div class="row justify-content-end">
                    <div class="col-auto col-sm-7 col-md-6 col-lg-5">
                        @if($slider->subtitle)
                        <h3 class="intro-subtitle text-third">{{ $slider->subtitle }}</h3>
                        @endif

                        @if($slider->title)
                        <h1 class="intro-title">{!! nl2br(e($slider->title)) !!}</h1>
                        @endif

                        @if($slider->price)
                        <div class="intro-price">
                            @if($slider->highlight_text)
                                <sup>{{ $slider->highlight_text }}</sup>
                            @endif
                            <span class="text-third">${{ $slider->price }}</span>
                        </div>
                        @endif

                        @if($slider->link)
                        <a href="{{ $slider->link }}" class="btn btn-primary btn-round">
                            <span>Shop More</span>
                            <i class="icon-long-arrow-right"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    </div><!-- End .intro-slider owl-carousel owl-simple -->

    <span class="slider-loader"></span><!-- End .slider-loader -->
</div>
