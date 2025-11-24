<!--Header -->
<header class="header header-intro-clearance header-3">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <a href="tel:{{ getSetting('phone') ?? '+880 123 456 789' }}">
                    <i class="icon-phone"></i>
                    Call: {{ getSetting('phone') ?? '+880 123 456 789' }}
                </a>
            </div><!-- End .header-left -->

            <div class="header-right">
                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            {{-- Currency Dropdown --}}
                            <li>
                                <div class="header-dropdown">
                                    <a href="#">{{ getSetting('currency', 'USD') }}</a>
                                    <div class="header-menu">
                                        <ul>
                                            <li><a href="#">USD</a></li>
                                            <li><a href="#">EUR</a></li>
                                            <li><a href="#">BDT</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            {{-- Language Dropdown --}}
                            <li>
                                <div class="header-dropdown">
                                    <a href="#">{{ strtoupper(getSetting('language', 'EN')) }}</a>
                                    <div class="header-menu">
                                        <ul>
                                            <li><a href="#">English</a></li>
                                            <li><a href="#">French</a></li>
                                            <li><a href="#">Bangla</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            {{-- User Section --}}
                            @guest
                                <li>
                                    <a href="#signin-modal" data-toggle="modal">
                                        <i class="icon-user"></i> Sign in / Sign up
                                    </a>
                                </li>
                            @else
                                <li class="header-dropdown">
                                    <a href="#">
                                        <img src="{{ Auth::user()->profile_photo_url ?? asset('default-avatar.png') }}"
                                            alt="User" class="rounded-circle me-2" width="24" height="24">
                                        {{ Str::limit(Auth::user()->name, 12) }}
                                    </a>
                                    <div class="header-menu">
                                        <ul>
                                            <li><a href="{{ route('product.wishlist.index') }}">Wishlist</a></li>
                                            <li><a href="{{ route('product.cart.index') }}">My Cart</a></li>
                                            {{-- <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                                            <li><a href="{{ route('reviews.index') }}">My Reviews</a></li>
                                            <li><a href="{{ route('profile.show') }}">Profile</a></li> --}}
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        style="border:none; background:none;">
                                                        Logout
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </li>
                </ul>
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-top -->

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('storage/' . getSetting('site_logo')) }}" alt="Molla Logo" width="105"
                        height="25">
                </a>
            </div><!-- End .header-left -->

            <div class="header-center">
                <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                    <form action="#" method="get">
                        <div class="header-search-wrapper search-wrapper-wide">
                            <label for="q" class="sr-only">Search</label>
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                            <input type="search" class="form-control" name="q" id="q"
                                placeholder="Search product ..." required>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->
            </div>

            <div class="header-right">
                <div class="wishlist">
                    <a href="{{ route('product.wishlist.index') }}" title="Wishlist">
                        <div class="icon">
                            <i class="icon-heart-o"></i>
                            <span class="wishlist-count badge">
                                @auth
                                    {{ Auth::user()->wishlists->count() }}
                                @else
                                    0
                                @endauth
                            </span>
                        </div>
                        <p>Wishlist</p>
                    </a>
                </div><!-- End .wishlist -->
                <div class="dropdown cart-dropdown">
                    {{-- Cart Icon with Dropdown Toggle --}}
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-display="static">
                        <div class="icon">
                            <i class="icon-shopping-cart"></i>
                            <span class="cart-count">
                                @auth
                                    {{ Auth::user()->carts->count() }}
                                @else
                                    0
                                @endauth
                            </span>
                        </div>
                        <p>Cart</p>
                    </a>

                    {{-- Cart Dropdown Menu --}}
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-cart-products" id="header-cart-items">
                            @auth
                                @php
                                    $cartItems = Auth::user()->carts()->with('product')->latest()->take(3)->get();
                                    $subtotal = 0;
                                @endphp

                                @forelse($cartItems as $item)
                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="{{ route('product.details', $item->product_id) }}">
                                                    {{ Str::limit($item->product->name, 20) }}
                                                </a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">{{ $item->quantity }}</span>
                                                x ${{ number_format($item->product->price, 2) }}
                                            </span>

                                            @if ($item->color || $item->size)
                                                <div class="product-cart-attributes">
                                                    @if ($item->color)
                                                        <small>Color:
                                                            <span
                                                                style="display:inline-block; width:10px; height:10px; border-radius:50%; background:{{ $item->color }}; margin-left:2px;"></span>
                                                        </small>
                                                    @endif
                                                    @if ($item->size)
                                                        <small>Size: {{ $item->size }}</small>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <figure class="product-image-container">
                                            <a href="{{ route('product.details', $item->product_id) }}"
                                                class="product-image">
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            </a>
                                        </figure>
                                        <a href="#" class="btn-remove remove-header-cart" title="Remove Product"
                                            data-cart-id="{{ $item->id }}">
                                            <i class="icon-close"></i>
                                        </a>
                                    </div>
                                    @php
                                        $subtotal += $item->product->price * $item->quantity;
                                    @endphp
                                @empty
                                    <div class="empty-cart-message text-center py-3">
                                        <i class="icon-cart" style="font-size: 40px; color: #ccc;"></i>
                                        <p class="mt-2">Your cart is empty</p>
                                    </div>
                                @endforelse
                            @else
                                <div class="empty-cart-message text-center py-3">
                                    <i class="icon-cart" style="font-size: 40px; color: #ccc;"></i>
                                    <p class="mt-2">Please login to view cart</p>
                                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary mt-2">Login</a>
                                </div>
                            @endauth
                        </div>

                        @auth
                            @if ($cartItems->count() > 0)
                                <div class="dropdown-cart-total">
                                    <span>Subtotal</span>
                                    <span class="cart-total-price">${{ number_format($subtotal, 2) }}</span>
                                </div>

                                <div class="dropdown-cart-action">
                                    <a href="{{ route('product.cart.index') }}" class="btn btn-primary">View Cart</a>
                                    <a href="{{ route('checkout') }}"
                                        class="btn btn-outline-primary-2"><span>Checkout</span><i
                                            class="icon-long-arrow-right"></i></a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div><!-- End .cart-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->

    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="header-left">
                <div class="dropdown category-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
                        Browse Categories <i class="icon-angle-down"></i>
                    </a>

                    <div class="dropdown-menu">
                        <nav class="side-nav">
                            <ul class="menu-vertical sf-arrows">
                                <li class="item-lead"><a href="#">Daily offers</a></li>
                                <li class="item-lead"><a href="#">Gift Ideas</a></li>
                                <li><a href="#">Beds</a></li>
                                <li><a href="#">Lighting</a></li>
                            </ul><!-- End .menu-vertical -->
                        </nav><!-- End .side-nav -->
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .category-dropdown -->
            </div><!-- End .header-left -->

            <div class="header-center">
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="{{ url('/') }}" class="sf-with-ul">Home</a>
                        </li>
                        <li>
                            <a href="category.html" class="sf-with-ul">Shop</a>
                        </li>
                        <li>
                            <a href="{{ route('product.cart.index') }}" class="sf-with-ul">Cart</a>
                        </li>
                        <li>
                            <a href="{{ route('product.wishlist.index') }}" class="sf-with-ul">Wishlist</a>
                        </li>
                        <li>
                            <a href="#" class="sf-with-ul">Pages</a>
                            <ul>
                                <li><a href="about.html">About</a></li>
                                <li><a href="contact.html">Contact</a></li>
                                <li><a href="login.html">Login</a></li>
                                <li><a href="faq.html">FAQs</a></li>
                            </ul>
                        </li>
                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
            </div><!-- End .header-center -->

            <div class="header-right">
                <i class="la la-lightbulb-o"></i>
                <p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->
