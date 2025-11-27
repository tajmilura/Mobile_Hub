@extends('admin.index')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-2 font-weight-bold" style="color: rgba(3, 152, 139, 0.622);">All Orders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Orders List</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search orders...">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="statusFilter" class="form-control">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="paymentStatusFilter" class="form-control">
                                <option value="">All Payment Status</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="failed">Failed</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" id="dateFilter" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <button id="resetFilters" class="btn btn-secondary btn-block">Reset Filters</button>
                        </div>
                    </div>

                    <table id="ordersTable" class="table table-bordered table-striped text-center align-middle">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Payment Method</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->order_number }}</strong>
                                    </td>
                                    <td>
                                        <div class="text-left">
                                            <div class="font-weight-bold">{{ $order->billing_name }}</div>
                                            <small class="text-muted">{{ $order->billing_email }}</small>
                                            <br>
                                            <small class="text-muted">{{ $order->billing_phone }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $order->created_at->format('M j, Y') }}<br>
                                        <small class="text-muted">{{ $order->created_at->format('g:i A') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $order->items->count() }} items</span>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-success">৳{{ number_format($order->grand_total, 2) }}</div>
                                        @if($order->coupon_discount > 0)
                                            <small class="text-muted">Discount: -৳{{ number_format($order->coupon_discount, 2) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $paymentStatusColors = [
                                                'pending' => 'warning',
                                                'paid' => 'success',
                                                'failed' => 'danger',
                                                'refunded' => 'info'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $paymentStatusColors[$order->payment_status] ?? 'secondary' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'secondary',
                                                'confirmed' => 'info',
                                                'processing' => 'primary',
                                                'shipped' => 'warning',
                                                'delivered' => 'success',
                                                'cancelled' => 'danger',
                                                'refunded' => 'dark'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border">{{ ucfirst($order->payment_method) }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('order.show', $order->id) }}">
                                                    <i class="fas fa-eye mr-2"></i>View Details
                                                </a>
                                                <a class="dropdown-item" href="{{ route('order.edit', $order->id) }}">
                                                    <i class="fas fa-edit mr-2"></i>Edit Order
                                                </a>
                                                <div class="dropdown-divider"></div>

                                                <!-- Status Update Options -->
                                                @if($order->status !== 'cancelled' && $order->status !== 'refunded' && $order->status !== 'delivered')
                                                    <a class="dropdown-item status-update" href="#" data-id="{{ $order->id }}" data-status="confirmed">
                                                        <i class="fas fa-check mr-2"></i>Mark as Confirmed
                                                    </a>
                                                    <a class="dropdown-item status-update" href="#" data-id="{{ $order->id }}" data-status="processing">
                                                        <i class="fas fa-cog mr-2"></i>Mark as Processing
                                                    </a>
                                                    <a class="dropdown-item status-update" href="#" data-id="{{ $order->id }}" data-status="shipped">
                                                        <i class="fas fa-shipping-fast mr-2"></i>Mark as Shipped
                                                    </a>
                                                    <a class="dropdown-item status-update" href="#" data-id="{{ $order->id }}" data-status="delivered">
                                                        <i class="fas fa-box-open mr-2"></i>Mark as Delivered
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                @endif

                                                @if($order->canBeCancelled())
                                                    <a class="dropdown-item status-update text-warning" href="#" data-id="{{ $order->id }}" data-status="cancelled">
                                                        <i class="fas fa-times mr-2"></i>Cancel Order
                                                    </a>
                                                @endif

                                                @if($order->payment_status === 'paid' && $order->status !== 'refunded')
                                                    <a class="dropdown-item status-update text-danger" href="#" data-id="{{ $order->id }}" data-status="refunded">
                                                        <i class="fas fa-undo mr-2"></i>Refund Order
                                                    </a>
                                                @endif

                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('order.destroy', $order->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this order?')">
                                                        <i class="fas fa-trash mr-2"></i>Delete Order
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
                                </div>
                                <div>
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('styles')
<style>
    .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75rem;
    }
    .dropdown-menu {
        min-width: 200px;
    }
    .card-header {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    }
    .status-update:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#ordersTable').DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#ordersTable_wrapper .col-md-6:eq(0)');

        // Search functionality
        $('#searchInput').on('keyup', function() {
            $('#ordersTable').DataTable().search($(this).val()).draw();
        });

        // Status filter
        $('#statusFilter').on('change', function() {
            const value = $(this).val();
            $('#ordersTable').DataTable().column(6).search(value).draw();
        });

        // Payment status filter
        $('#paymentStatusFilter').on('change', function() {
            const value = $(this).val();
            $('#ordersTable').DataTable().column(5).search(value).draw();
        });

        // Date filter
        $('#dateFilter').on('change', function() {
            const value = $(this).val();
            $('#ordersTable').DataTable().column(2).search(value).draw();
        });

        // Reset filters
        $('#resetFilters').on('click', function() {
            $('#statusFilter').val('');
            $('#paymentStatusFilter').val('');
            $('#dateFilter').val('');
            $('#searchInput').val('');
            $('#ordersTable').DataTable()
                .search('')
                .columns().search('')
                .draw();
        });

        // Status update
        $('.status-update').on('click', function(e) {
            e.preventDefault();

            const orderId = $(this).data('id');
            const newStatus = $(this).data('status');
            const button = $(this);

            Swal.fire({
                title: 'Update Order Status?',
                text: `Are you sure you want to mark this order as ${newStatus}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("admin/orders") }}/' + orderId + '/status',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: newStatus
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Order status updated successfully');
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function() {
                            toastr.error('Failed to update order status');
                        }
                    });
                }
            });
        });

        // Delete order
        $(document).on('click', '.delete-order-btn', function(e) {
            e.preventDefault();

            var url = $(this).data('url');
            var row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                                toastr.success('Order deleted successfully.');
                            }
                        },
                        error: function() {
                            toastr.error('Something went wrong.');
                        }
                    });
                }
            });
        });
    });
</script>

@if(session('success'))
<script>
    toastr.success('{{ session('success') }}');
</script>
@endif

@if(session('error'))
<script>
    toastr.error('{{ session('error') }}');
</script>
@endif
@endpush
