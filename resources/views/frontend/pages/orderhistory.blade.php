@extends('frontend.front_app')
@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Order History<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order History</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>{{ $order->Items->count() }} items</td>
                            <td>${{ number_format($order->grand_total, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('order.details', $order->id) }}" class="btn btn-sm btn-primary">
                                    <i class="icon-eye"></i> View
                                </a>
                                @if(in_array($order->status, ['pending', 'confirmed']))
                                <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#cancelModal{{ $order->id }}">
                                    <i class="icon-close"></i> Cancel
                                </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Cancel Order Modal -->
                        <div class="modal fade" id="cancelModal{{ $order->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cancel Order</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to cancel order <strong>{{ $order->order_number }}</strong>?</p>
                                            <div class="form-group">
                                                <label for="reason">Cancellation Reason</label>
                                                <textarea class="form-control" id="reason" name="cancellation_reason" rows="3" required placeholder="Please tell us why you want to cancel this order"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="icon-shopping-bag" style="font-size: 80px; color: #ccc; margin-bottom: 20px;"></i>
                <h3>No Orders Found</h3>
                <p class="mb-4">You haven't placed any orders yet.</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Start Shopping</a>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection
