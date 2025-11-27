@extends('admin.index')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-2 font-weight-bold" style="color: rgba(3, 152, 139, 0.622);">Product Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Action Buttons -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="btn-group">
                                <a href="{{ route('product.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left m-2"></i> Back to Products
                                </a>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary m-2">
                                    <i class="fas fa-edit"></i> Edit Product
                                </a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger m-2" onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                                @if($product->status)
                                    <a href="#" class="btn btn-warning status-toggle m-2" data-id="{{ $product->id }}">
                                        <i class="fas fa-pause"></i> Deactivate
                                    </a>
                                @else
                                    <a href="#" class="btn btn-success status-toggle m-2" data-id="{{ $product->id }}">
                                        <i class="fas fa-play"></i> Activate
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left Column - Images & Basic Info -->
                        <div class="col-md-5">
                            <!-- Main Image -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Main Image</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="img-fluid rounded"
                                             style="max-height: 400px; object-fit: contain;">
                                    @else
                                        <div class="text-muted py-5">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p>No Image Available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Gallery Images -->
                            @if($product->gallery && count($product->gallery) > 0)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Gallery Images ({{ count($product->gallery) }})</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($product->gallery as $image)
                                        <div class="col-4 mb-3">
                                            <img src="{{ asset('storage/' . $image) }}"
                                                 alt="Gallery Image {{ $loop->iteration }}"
                                                 class="img-thumbnail"
                                                 style="width: 100%; height: 100px; object-fit: cover;">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Video -->
                            @if($product->video || $product->video_link)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Video</h5>
                                </div>
                                <div class="card-body">
                                    @if($product->video)
                                        <video controls class="w-100 rounded" style="max-height: 300px;">
                                            <source src="{{ asset('storage/' . $product->video) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                    @if($product->video_link)
                                        <div class="mt-3">
                                            <a href="{{ $product->video_link }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fab fa-youtube"></i> YouTube Link
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column - Product Details -->
                        <div class="col-md-7">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th width="40%">Product Name:</th>
                                                    <td>{{ $product->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>SKU:</th>
                                                    <td>{{ $product->sku ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Barcode:</th>
                                                    <td>{{ $product->barcode ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Category:</th>
                                                    <td>
                                                        <span class="badge badge-info">
                                                            {{ $product->category->category_name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Brand:</th>
                                                    <td>
                                                        <span class="badge badge-secondary">
                                                            {{ $product->brand->name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th width="40%">Status:</th>
                                                    <td>
                                                        <span class="badge badge-{{ $product->status ? 'success' : 'danger' }}">
                                                            {{ $product->status ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Stock:</th>
                                                    <td>
                                                        @if($product->stock > 10)
                                                            <span class="badge badge-success">{{ $product->stock }} in stock</span>
                                                        @elseif($product->stock > 0)
                                                            <span class="badge badge-warning">Low stock ({{ $product->stock }})</span>
                                                        @else
                                                            <span class="badge badge-danger">Out of stock</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Created:</th>
                                                    <td>{{ $product->created_at->format('M j, Y g:i A') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Updated:</th>
                                                    <td>{{ $product->updated_at->format('M j, Y g:i A') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Special Badges -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            @if($product->is_featured)
                                                <span class="badge badge-primary mr-2">Featured</span>
                                            @endif
                                            @if($product->is_new_arrival)
                                                <span class="badge badge-success mr-2">New Arrival</span>
                                            @endif
                                            @if($product->is_hot_deal)
                                                <span class="badge badge-danger mr-2">Hot Deal</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Pricing & Stock</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th width="50%">Regular Price:</th>
                                                    <td class="font-weight-bold">৳{{ number_format($product->price) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Discount Price:</th>
                                                    <td>
                                                        @if($product->discount_price)
                                                            <span class="text-success font-weight-bold">৳{{ number_format($product->discount_price) }}</span>
                                                        @else
                                                            <span class="text-muted">No discount</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($product->discount_price)
                                                <tr>
                                                    <th>You Save:</th>
                                                    <td class="text-danger font-weight-bold">
                                                        ৳{{ number_format($product->price - $product->discount_price) }}
                                                        ({{ round(($product->price - $product->discount_price) / $product->price * 100) }}%)
                                                    </td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th width="50%">Current Stock:</th>
                                                    <td>{{ $product->stock }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Warranty:</th>
                                                    <td>{{ $product->warranty ?? 'No warranty' }}</td>
                                                </tr>
                                                @if($product->discount_start && $product->discount_end)
                                                <tr>
                                                    <th>Discount Period:</th>
                                                    <td>
                                                        {{ $product->discount_start->format('M j, Y g:i A') }}<br>
                                                        to<br>
                                                        {{ $product->discount_end->format('M j, Y g:i A') }}
                                                    </td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Description</h5>
                                </div>
                                <div class="card-body">
                                    {!! $product->description ?? '<p class="text-muted">No description available</p>' !!}
                                </div>
                            </div>

                            <!-- Specifications -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Specifications</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if($product->ram || $product->storage || $product->processor)
                                        <div class="col-md-6">
                                            <h6 class="font-weight-bold">Performance</h6>
                                            <table class="table table-sm table-borderless">
                                                @if($product->ram)<tr><th>RAM:</th><td>{{ $product->ram }}</td></tr>@endif
                                                @if($product->storage)<tr><th>Storage:</th><td>{{ $product->storage }}</td></tr>@endif
                                                @if($product->processor)<tr><th>Processor:</th><td>{{ $product->processor }}</td></tr>@endif
                                                @if($product->os)<tr><th>OS:</th><td>{{ $product->os }}</td></tr>@endif
                                            </table>
                                        </div>
                                        @endif

                                        @if($product->display || $product->camera || $product->battery)
                                        <div class="col-md-6">
                                            <h6 class="font-weight-bold">Display & Camera</h6>
                                            <table class="table table-sm table-borderless">
                                                @if($product->display)<tr><th>Display:</th><td>{{ $product->display }}</td></tr>@endif
                                                @if($product->resolution)<tr><th>Resolution:</th><td>{{ $product->resolution }}</td></tr>@endif
                                                @if($product->camera)<tr><th>Camera:</th><td>{{ $product->camera }}</td></tr>@endif
                                                @if($product->front_camera)<tr><th>Front Camera:</th><td>{{ $product->front_camera }}</td></tr>@endif
                                                @if($product->battery)<tr><th>Battery:</th><td>{{ $product->battery }}</td></tr>@endif
                                            </table>
                                        </div>
                                        @endif
                                    </div>

                                    @if($product->network || $product->sim || $product->build)
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6 class="font-weight-bold">Connectivity & Build</h6>
                                            <table class="table table-sm table-borderless">
                                                @if($product->network)<tr><th>Network:</th><td>{{ $product->network }}</td></tr>@endif
                                                @if($product->sim)<tr><th>SIM:</th><td>{{ $product->sim }}</td></tr>@endif
                                                @if($product->build)<tr><th>Build:</th><td>{{ $product->build }}</td></tr>@endif
                                                @if($product->weight)<tr><th>Weight:</th><td>{{ $product->weight }}</td></tr>@endif
                                                @if($product->dimensions)<tr><th>Dimensions:</th><td>{{ $product->dimensions }}</td></tr>@endif
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="font-weight-bold">Additional Features</h6>
                                            <table class="table table-sm table-borderless">
                                                @if($product->fingerprint)<tr><th>Fingerprint:</th><td>{{ $product->fingerprint }}</td></tr>@endif
                                                @if($product->water_resistance)<tr><th>Water Resistance:</th><td>{{ $product->water_resistance }}</td></tr>@endif
                                                @if($product->bluetooth)<tr><th>Bluetooth:</th><td>{{ $product->bluetooth }}</td></tr>@endif
                                                @if($product->wifi)<tr><th>WiFi:</th><td>{{ $product->wifi }}</td></tr>@endif
                                                @if($product->sensors)<tr><th>Sensors:</th><td>{{ $product->sensors }}</td></tr>@endif
                                            </table>
                                        </div>
                                    </div>
                                    @endif

                                    @if($product->colors)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h6 class="font-weight-bold">Available Colors</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $colors = is_array($product->colors) ? $product->colors : json_decode($product->colors, true);
                                                @endphp
                                                @if(is_array($colors))
                                                    @foreach($colors as $color)
                                                        <span class="badge badge-light border">{{ $color }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No colors specified</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($product->tags)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h6 class="font-weight-bold">Tags</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $tags = is_array($product->tags) ? $product->tags : explode(',', $product->tags);
                                                @endphp
                                                @if(is_array($tags))
                                                    @foreach($tags as $tag)
                                                        <span class="badge badge-info">{{ trim($tag) }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No tags specified</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
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
    .table th {
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 0.75rem;
    }
    .card-header {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid #dee2e6;
    }
    .img-thumbnail {
        transition: transform 0.2s;
    }
    .img-thumbnail:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Status toggle
        $('.status-toggle').on('click', function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            const button = $(this);

            $.ajax({
                url: '{{ url("admin/products") }}/' + productId + '/status',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: {{ $product->status ? 0 : 1 }}
                },
                success: function(response) {
                    toastr.success('Status updated successfully');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function() {
                    toastr.error('Failed to update status');
                }
            });
        });
    });
</script>
@endpush
