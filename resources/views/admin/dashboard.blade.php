@extends('admin.index')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat boxes) -->
        <div class="row">
            <!-- Total Products -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalProducts }}</h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <a href="{{ route('product.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalCategories }}</h3>
                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <a href="{{ route('category.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Total Brands -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalBrands }}</h3>
                        <p>Brands</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <a href="{{ route('brand.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('order.all_order') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Status Cards -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pending Orders</span>
                        <span class="info-box-number">{{ $pendingOrders }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Confirmed Orders</span>
                        <span class="info-box-number">{{ $confirmedOrders }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-truck"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Shipped Orders</span>
                        <span class="info-box-number">{{ $shippedOrders }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fas fa-box-open"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Delivered Orders</span>
                        <span class="info-box-number">{{ $deliveredOrders }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue & Users Section -->
        <div class="row">
            <!-- Total Revenue -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-purple">
                    <div class="inner">
                        <h3>৳{{ number_format($totalRevenue, 2) }}</h3>
                        <p>Total Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="{{ route('order.all_order') }}" class="small-box-footer">
                        View Orders <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Today's Revenue -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-orange">
                    <div class="inner">
                        <h3>৳{{ number_format($todayRevenue, 2) }}</h3>
                        <p>Today's Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <a href="{{ route('order.all_order') }}" class="small-box-footer">
                        View Today's Orders <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-teal">
                    <div class="inner">
                        <h3>{{ $totalCustomers }}</h3>
                        <p>Total Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                        View Customers <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Low Stock Products -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-pink">
                    <div class="inner">
                        <h3>{{ $lowStockProducts }}</h3>
                        <p>Low Stock Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="{{ route('product.index') }}" class="small-box-footer">
                        Check Stock <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Charts & Recent Activity -->
        <div class="row">
            <!-- Recent Orders -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Orders</h3>
                        <div class="card-tools">
                            <span class="badge badge-danger">{{ $recentOrders->count() }} New Orders</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($recentOrders as $order)
                            <li class="item">
                                <div class="product-info">
                                    <a href="{{ route('order.show', $order->id) }}" class="product-title">
                                        Order #{{ $order->order_number }}
                                        <span class="badge badge-{{ $order->status == 'pending' ? 'warning' : 'info' }} float-right">
                                            ৳{{ number_format($order->grand_total, 2) }}
                                        </span>
                                    </a>
                                    <span class="product-description">
                                        {{ $order->billing_name }} • {{ $order->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('order.all_order') }}" class="uppercase">View All Orders</a>
                    </div>
                </div>
            </div>

            <!-- Recent Products -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recently Added Products</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($recentProducts as $product)
                            <li class="item">
                                <div class="product-img">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-size-50">
                                    @else
                                        <img src="https://via.placeholder.com/50" alt="Product Image" class="img-size-50">
                                    @endif
                                </div>
                                <div class="product-info">
                                    <a href="{{ route('product.show', $product->id) }}" class="product-title">
                                        {{ Str::limit($product->name, 25) }}
                                        <span class="badge badge-success float-right">৳{{ number_format($product->price, 2) }}</span>
                                    </a>
                                    <span class="product-description">
                                        {{ $product->category->category_name ?? 'N/A' }} • {{ $product->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('product.index') }}" class="uppercase">View All Products</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Row -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Inventory Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="progress-group">
                            In Stock Products
                            <span class="float-right"><b>{{ $inStockProducts }}</b>/{{ $totalProducts }}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: {{ $totalProducts > 0 ? ($inStockProducts/$totalProducts)*100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            Out of Stock Products
                            <span class="float-right"><b>{{ $outOfStockProducts }}</b>/{{ $totalProducts }}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger" style="width: {{ $totalProducts > 0 ? ($outOfStockProducts/$totalProducts)*100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order Status Overview</h3>
                    </div>
                    <div class="card-body">
                        <div class="progress-group">
                            Completed Orders
                            <span class="float-right"><b>{{ $deliveredOrders }}</b>/{{ $totalOrders }}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: {{ $totalOrders > 0 ? ($deliveredOrders/$totalOrders)*100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            Pending Orders
                            <span class="float-right"><b>{{ $pendingOrders }}</b>/{{ $totalOrders }}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: {{ $totalOrders > 0 ? ($pendingOrders/$totalOrders)*100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">System Info</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Server Time:</span>
                            <span class="font-weight-bold">{{ now()->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Laravel Version:</span>
                            <span class="font-weight-bold">{{ app()->version() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>PHP Version:</span>
                            <span class="font-weight-bold">{{ PHP_VERSION }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Environment:</span>
                            <span class="font-weight-bold badge badge-{{ app()->environment('production') ? 'success' : 'info' }}">
                                {{ app()->environment() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.small-box {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}
.small-box:hover {
    transform: translateY(-5px);
}
.info-box {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.products-list .item {
    border-bottom: 1px solid #f4f4f4;
    padding: 10px 0;
}
.products-list .item:last-child {
    border-bottom: none;
}
</style>
@endpush
