<div class="product product-2">
    <figure class="product-media">
        @if($product->is_hot_deal)
        <span class="product-label label-circle label-top">Hot</span>
        @elseif($product->is_new_arrival)
        <span class="product-label label-circle label-top">New</span>
        @endif
        <a href="{{ route('product.details', $product->id) }}"> {{-- {{ route('product', $product->id) }} --}}
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
        </a>
        <div class="product-action-vertical">
            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
        </div>
        <div class="product-action">
            <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
            <a href="popup/quickView.html" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
        </div>
    </figure>
    <div class="product-body">
        <div class="product-cat"><a href="#">{{ $product->category->category_name }}</a></div>
        <h3 class="product-title"><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h3> {{--{{ route('product.show', $product->id) }}--}}
        <div class="product-price">${{ number_format($product->price, 2) }}</div>
    </div>
</div>
