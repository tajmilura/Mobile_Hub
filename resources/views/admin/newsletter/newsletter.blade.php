@extends('admin.index')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Newsletter Subscribers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Newsletter</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalSubscribers }}</h3>
                            <p>Total Subscribers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $activeSubscribers }}</h3>
                            <p>Active Subscribers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $inactiveSubscribers }}</h3>
                            <p>Inactive Subscribers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-ban"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $todaySubscribers }}</h3>
                            <p>Today's Subscribers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #17a2b8; color: white;">
                            <h3 class="card-title">Subscribers List</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                           placeholder="Search by email..." id="searchInput">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <!-- Loader -->
                        <div id="loader" style="display:none; text-align:center; padding:20px;">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                        </div>

                        <div class="card-body">
                            <!-- Export Buttons -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-sm" id="exportCSV">
                                            <i class="fas fa-file-csv"></i> Export CSV
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" id="exportExcel">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="filterAll">
                                            All ({{ $totalSubscribers }})
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm" id="filterActive">
                                            Active ({{ $activeSubscribers }})
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm" id="filterInactive">
                                            Inactive ({{ $inactiveSubscribers }})
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="subscribers-table">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 35%">Email</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 20%">Subscribed At</th>
                                            <th style="width: 15%">Last Updated</th>
                                            <th style="width: 10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($subscribers as $index => $subscriber)
                                            <tr data-status="{{ $subscriber->is_active ? 'active' : 'inactive' }}">
                                                <td>{{ $subscribers->firstItem() + $index }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-envelope text-muted mr-2"></i>
                                                        <span class="font-weight-bold">{{ $subscriber->email }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $subscriber->is_active ? 'success' : 'warning' }}">
                                                        <i class="fas fa-{{ $subscriber->is_active ? 'check' : 'ban' }} mr-1"></i>
                                                        {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-calendar text-muted mr-1"></i>
                                                    {{ $subscriber->created_at->format('M d, Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ $subscriber->created_at->format('h:i A') }}</small>
                                                </td>
                                                <td>
                                                    <i class="fas fa-clock text-muted mr-1"></i>
                                                    {{ $subscriber->updated_at->diffForHumans() }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm">
                                                        @if($subscriber->is_active)
                                                            <button type="button" class="btn btn-warning btn-sm unsubscribe-btn"
                                                                    data-email="{{ $subscriber->email }}" title="Unsubscribe">
                                                                <i class="fas fa-ban"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-success btn-sm subscribe-btn"
                                                                    data-email="{{ $subscriber->email }}" title="Subscribe">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        @endif

                                                        <button type="button" class="btn btn-info btn-sm view-btn"
                                                                data-email="{{ $subscriber->email }}"
                                                                data-status="{{ $subscriber->is_active ? 'Active' : 'Inactive' }}"
                                                                data-created="{{ $subscriber->created_at->format('M d, Y h:i A') }}"
                                                                data-updated="{{ $subscriber->updated_at->format('M d, Y h:i A') }}"
                                                                title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                                data-url="{{ route('newsletter.destroy', $subscriber->id) }}"
                                                                data-email="{{ $subscriber->email }}" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                                    <h5>No subscribers found</h5>
                                                    <p class="mb-0">No one has subscribed to the newsletter yet.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="float-left">
                                <p class="mb-0 text-muted">
                                    Showing {{ $subscribers->firstItem() ?? 0 }} to {{ $subscribers->lastItem() ?? 0 }}
                                    of {{ $subscribers->total() }} entries
                                </p>
                            </div>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $subscribers->links('pagination::bootstrap-5') }}
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <!-- View Details Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-circle mr-2"></i>Subscriber Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%"><i class="fas fa-envelope mr-2"></i>Email</th>
                                    <td id="modal-email"></td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-toggle-on mr-2"></i>Status</th>
                                    <td id="modal-status"></td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-calendar-plus mr-2"></i>Subscribed At</th>
                                    <td id="modal-created"></td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-clock mr-2"></i>Last Updated</th>
                                    <td id="modal-updated"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Search functionality
    $('#searchInput').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('#subscribers-table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1);
        });
    });

    // Filter functionality
    $('#filterAll').on('click', function() {
        $('#subscribers-table tbody tr').show();
    });

    $('#filterActive').on('click', function() {
        $('#subscribers-table tbody tr').hide();
        $('#subscribers-table tbody tr[data-status="active"]').show();
    });

    $('#filterInactive').on('click', function() {
        $('#subscribers-table tbody tr').hide();
        $('#subscribers-table tbody tr[data-status="inactive"]').show();
    });

    // Pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        $('#loader').show();
        var url = $(this).attr('href');

        fetch(url)
            .then(res => res.text())
            .then(html => {
                $('#subscribers-table').html($(html).find('#subscribers-table').html());
                $('#loader').hide();
            });
    });

    // View details modal
    $(document).on('click', '.view-btn', function() {
        const email = $(this).data('email');
        const status = $(this).data('status');
        const created = $(this).data('created');
        const updated = $(this).data('updated');

        $('#modal-email').text(email);
        $('#modal-status').html('<span class="badge badge-' + (status === 'Active' ? 'success' : 'warning') + '">' + status + '</span>');
        $('#modal-created').text(created);
        $('#modal-updated').text(updated);

        $('#viewModal').modal('show');
    });

    // Subscribe/Unsubscribe functionality
    $(document).on('click', '.subscribe-btn, .unsubscribe-btn', function() {
        const email = $(this).data('email');
        const isSubscribe = $(this).hasClass('subscribe-btn');
        const action = isSubscribe ? 'subscribe' : 'unsubscribe';
        const button = $(this);

        Swal.fire({
            title: isSubscribe ? 'Subscribe User?' : 'Unsubscribe User?',
            text: isSubscribe
                ? 'This will activate newsletter subscription for ' + email
                : 'This will deactivate newsletter subscription for ' + email,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: isSubscribe ? 'Yes, Subscribe' : 'Yes, Unsubscribe',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("newsletter") }}/' + action,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                });
            }
        });
    });

    // Delete functionality
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        var url = $(this).data('url');
        var email = $(this).data('email');
        var row = $(this).closest('tr');

        Swal.fire({
            title: 'Delete Subscriber?',
            text: "This will permanently remove " + email + " from newsletter list",
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
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            row.fadeOut(300, function() {
                                $(this).remove();
                                if ($('#subscribers-table tbody tr').length === 0) {
                                    location.reload();
                                }
                            });
                            toastr.success('Subscriber deleted successfully.');
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong.');
                    }
                });
            }
        });
    });

    // Export functionality
    $('#exportCSV').on('click', function() {
        window.location.href = '{{ route("newsletter.export") }}?type=csv';
    });

    $('#exportExcel').on('click', function() {
        window.location.href = '{{ route("newsletter.export") }}?type=excel';
    });
</script>
@endpush

@push('styles')
<style>
.small-box {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.025);
    transform: translateY(-1px);
    transition: all 0.2s;
}
.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
}
</style>
@endpush
