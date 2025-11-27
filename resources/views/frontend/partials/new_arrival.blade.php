<div class="container new-arrivals">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">New Arrivals</h2>
        </div>

        <div class="heading-right">
            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="new-all-link" data-toggle="tab" href="#new-all-tab"
                       role="tab" aria-controls="new-all-tab" aria-selected="true">All</a>
                </li>
                @foreach($categories as $category)
                <li class="nav-item">
                    <a class="nav-link" id="new-{{ $category->id }}-link" data-toggle="tab"
                       href="#new-{{ $category->id }}-tab" role="tab"
                       aria-controls="new-{{ $category->id }}-tab" aria-selected="false">
                        {{ $category->category_name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
<div class="tab-content tab-content-carousel just-action-icons-sm">
    <!-- All Products -->
    <div class="tab-pane p-0 fade show active" id="new-all-tab" role="tabpanel">
        <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
             data-owl-options='{
                 "nav": true,
                 "dots": true,
                 "margin": 20,
                 "loop": false,
                 "responsive": {
                     "0": { "items":2 },
                     "480": { "items":2 },
                     "768": { "items":3 },
                     "992": { "items":4 },
                     "1200": { "items":5 }
                 }
             }'>
            @foreach($newArrivals as $product)
                @include('frontend.partials.new_arraival_product_card', ['product' => $product])
            @endforeach
        </div>
    </div>

    <!-- Category-wise Products -->
    @foreach($categories as $category)
    <div class="tab-pane p-0 fade" id="new-{{ $category->id }}-tab" role="tabpanel">
        <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
             data-owl-options='{
                 "nav": true,
                 "dots": true,
                 "margin": 20,
                 "loop": false,
                 "responsive": {
                     "0": { "items":2 },
                     "480": { "items":2 },
                     "768": { "items":3 },
                     "992": { "items":4 },
                     "1200": { "items":5 }
                 }
             }'>
            @foreach($newArrivals->where('category_id', $category->id) as $product)
                @include('frontend.partials.new_arraival_product_card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endforeach
</div>
</div>

