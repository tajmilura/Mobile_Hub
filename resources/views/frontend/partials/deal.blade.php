@if($hotDeals->count() > 0)
<div class="container">
    <div class="heading text-center mb-3">
        <h2 class="title">Deals & Outlet</h2>
        <p class="title-desc">Today’s deal and more</p>
    </div>

    <div class="row">
        @foreach($hotDeals as $deal)
        <div class="col-lg-6 deal-col">
            <div class="deal"
                 style="background-image: url('{{ asset('storage/' . $deal->image) }}');">
                <div class="deal-top">
                    <h2>{{ $deal->name }}</h2>
                    @if($deal->discount_price)
                        <h4>Save ${{ number_format($deal->price - $deal->discount_price, 2) }}</h4>
                    @endif
                </div>

                <div class="deal-content">
                    <h3 class="product-title">
                        <a href="#">{{ $deal->name }}</a> {{-- {{ route('product.show', $deal->id) }} --}}
                    </h3>

                    <div class="product-price">
                        @if($deal->discount_price)
                            <span class="new-price">${{ $deal->discount_price }}</span>
                            <span class="old-price">Was ${{ $deal->price }}</span>
                        @else
                            <span class="new-price">${{ $deal->price }}</span>
                        @endif
                    </div>

                    <a href="#" class="btn btn-link"> 
                        <span>Shop Now</span>
                        <i class="icon-long-arrow-right"></i>
                    </a> {{-- {{ route('product.show', $deal->id) }} --}}
                </div>

                @if($deal->discount_end)
                <div class="deal-bottom">
                    <div class="deal-countdown daily-deal-countdown" 
                         data-until="{{ \Carbon\Carbon::parse($deal->discount_end)->toIso8601String() }}">
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    {{--b {{ route('products.hotDeals') }} --}}

    <div class="more-container text-center mt-1 mb-5">
        <a href="#" class="btn btn-outline-dark-2 btn-round btn-more">
            <span>Shop more Outlet deals</span>
            <i class="icon-long-arrow-right"></i>
        </a> 
    </div>
</div>
@endif
