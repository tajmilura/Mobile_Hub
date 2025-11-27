@extends('admin.index')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment Methods</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Payment Methods</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title" id="formTitle">Add New Payment Method</h3>
                            <button type="button" class="btn btn-success btn-sm d-none" id="addNewBtn">
                                <i class="fas fa-plus"></i> Add New
                            </button>
                        </div>

                        <!-- form start -->
                        <form action="{{ route('admin.payment-methods.store') }}" method="POST" id="paymentMethodForm">
                            @csrf
                            <div class="card-body">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Payment Method Name *</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="e.g., Credit Card, PayPal, bKash" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Code -->
                                <div class="form-group">
                                    <label for="code">Unique Code *</label>
                                    <input type="text" name="code" class="form-control" id="code"
                                        placeholder="e.g., credit_card, paypal, bkash" value="{{ old('code') }}" required>
                                    <small class="text-muted">Unique identifier (lowercase, underscore)</small>
                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="2"
                                        placeholder="Short description about this payment method">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Configuration -->
                                <div class="form-group">
                                    <label for="config">Configuration (JSON)</label>
                                    <textarea name="config" class="form-control" id="config" rows="3"
                                        placeholder='{"api_key": "your_key", "secret": "your_secret"}'>{{ old('config') }}</textarea>
                                    <small class="text-muted">Optional: Store API keys or configuration data as JSON</small>
                                    @error('config')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <!-- Charge -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="charge">Service Charge (%)</label>
                                            <input type="number" name="charge" class="form-control" id="charge"
                                                placeholder="0.00" step="0.01" min="0" value="{{ old('charge', 0) }}">
                                            @error('charge')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Sort Order -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sort_order">Sort Order</label>
                                            <input type="number" name="sort_order" class="form-control" id="sort_order"
                                                placeholder="1" min="0" value="{{ old('sort_order', 0) }}">
                                            @error('sort_order')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Switches -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" value="1" checked>
                                                <label class="custom-control-label" for="is_active">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="is_online" class="custom-control-input" id="is_online" value="1" checked>
                                                <label class="custom-control-label" for="is_online">Online Payment</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Create Payment Method</button>
                                <button type="button" class="btn btn-secondary d-none" id="cancelBtn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #28a745; color: white;">
                            <h3 class="card-title">All Payment Methods</h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- Loader -->
                        <div id="loader" style="display:none; text-align:center; padding:20px;">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                        </div>

                        <div class="card-body" id="payment-methods-table">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Charge</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paymentMethods as $index => $method)
                                        <tr>
                                            <td>{{ $paymentMethods->firstItem() + $index }}.</td>
                                            <td>
                                                <strong>{{ $method->name }}</strong>
                                                @if($method->description)
                                                    <br><small class="text-muted">{{ Str::limit($method->description, 30) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <code>{{ $method->code }}</code>
                                            </td>
                                            <td class="text-center">
                                                @if($method->charge > 0)
                                                    <span class="badge badge-warning">{{ $method->charge }}%</span>
                                                @else
                                                    <span class="badge badge-success">Free</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-{{ $method->is_active ? 'success' : 'danger' }}">
                                                    {{ $method->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ $method->is_online ? 'Online' : 'Offline' }}</small>
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="#" data-id="{{ $method->id }}"
                                                    data-name="{{ $method->name }}"
                                                    data-code="{{ $method->code }}"
                                                    data-description="{{ $method->description }}"
                                                    data-config="{{ $method->config }}"
                                                    data-charge="{{ $method->charge }}"
                                                    data-sort_order="{{ $method->sort_order }}"
                                                    data-is_active="{{ $method->is_active }}"
                                                    data-is_online="{{ $method->is_online }}"
                                                    class="text-primary pr-3 editPaymentMethodBtn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="#" class="text-danger delete-btn" title="Delete"
                                                    data-url="{{ route('admin.payment-methods.destroy', $method->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-credit-card fa-2x mb-2"></i><br>
                                                No payment methods available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $paymentMethods->links('pagination::bootstrap-5') }}
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
<script>
    // Auto-generate code from name
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const codeField = document.getElementById('code');

        if (codeField.value === '') {
            const generatedCode = name
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '_')
                .replace(/^_+|_+$/g, '');
            codeField.value = generatedCode;
        }
    });

    // Format JSON in config field
    document.getElementById('config').addEventListener('blur', function() {
        try {
            if (this.value.trim()) {
                const parsed = JSON.parse(this.value);
                this.value = JSON.stringify(parsed, null, 2);
            }
        } catch (e) {
            // Invalid JSON, leave as is
        }
    });
</script>

<script>
    // Pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        $('#loader').show();
        var url = $(this).attr('href');

        fetch(url)
            .then(res => res.text())
            .then(html => {
                $('#payment-methods-table').html($(html).find('#payment-methods-table').html());
                $('#loader').hide();
            });
    });
</script>

<script>
    // Delete functionality
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        var url = $(this).data('url');
        var row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "This payment method will be deleted permanently!",
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
                                // Reload table if empty
                                if ($('#payment-methods-table tbody tr').length === 1) {
                                    location.reload();
                                }
                            });
                            toastr.success('Payment method deleted successfully.');
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong.');
                    }
                });
            }
        });
    });
</script>

<script>
    // Edit functionality
    $(document).on('click', '.editPaymentMethodBtn', function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let name = $(this).data('name');
        let code = $(this).data('code');
        let description = $(this).data('description');
        let config = $(this).data('config');
        let charge = $(this).data('charge');
        let sort_order = $(this).data('sort_order');
        let is_active = $(this).data('is_active');
        let is_online = $(this).data('is_online');

        // Fill form data
        $('#name').val(name);
        $('#code').val(code);
        $('#description').val(description);
        $('#config').val(config ? JSON.stringify(config, null, 2) : '');
        $('#charge').val(charge);
        $('#sort_order').val(sort_order);

        // Set checkboxes
        $('#is_active').prop('checked', is_active == 1);
        $('#is_online').prop('checked', is_online == 1);

        // Change form to update mode
        $('#paymentMethodForm').attr('action', '/admin/payment-methods/' + id);
        $('input[name="_method"]').remove();
        $('#paymentMethodForm').append('<input type="hidden" name="_method" value="PUT">');

        // Update UI
        $('#submitBtn').text('Update Payment Method').removeClass('btn-primary').addClass('btn-warning');
        $('#formTitle').text('Edit Payment Method: ' + name);
        $('#addNewBtn').removeClass('d-none');
        $('#cancelBtn').removeClass('d-none');

        // Scroll to form
        $('html, body').animate({
            scrollTop: $("#paymentMethodForm").offset().top - 100
        }, 500);

        toastr.info('Editing: ' + name);
    });

    // Add new button
    $('#addNewBtn').on('click', function() {
        resetForm();
        toastr.success('Ready to add new payment method');
    });

    // Cancel button
    $('#cancelBtn').on('click', function() {
        resetForm();
        toastr.info('Edit cancelled');
    });

    // Reset form function
    function resetForm() {
        $('#paymentMethodForm')[0].reset();
        $('#paymentMethodForm').attr('action', '{{ route('admin.payment-methods.store') }}');
        $('input[name="_method"]').remove();

        $('#submitBtn').text('Create Payment Method').removeClass('btn-warning').addClass('btn-primary');
        $('#formTitle').text('Add New Payment Method');
        $('#addNewBtn').addClass('d-none');
        $('#cancelBtn').addClass('d-none');

        // Reset checkboxes
        $('#is_active').prop('checked', true);
        $('#is_online').prop('checked', true);
    }
</script>

<script>
    // Form validation
    $('#paymentMethodForm').on('submit', function(e) {
        const name = $('#name').val().trim();
        const code = $('#code').val().trim();

        if (!name) {
            e.preventDefault();
            toastr.error('Payment method name is required');
            $('#name').focus();
            return;
        }

        if (!code) {
            e.preventDefault();
            toastr.error('Unique code is required');
            $('#code').focus();
            return;
        }

        // Validate JSON if config is provided
        const config = $('#config').val().trim();
        if (config) {
            try {
                JSON.parse(config);
            } catch (error) {
                e.preventDefault();
                toastr.error('Invalid JSON format in configuration');
                $('#config').focus();
                return;
            }
        }

        // Show loading
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
    });
</script>
@endpush

@push('styles')
<style>
.custom-switch {
    padding-left: 2.25rem;
}
.custom-control-label::before {
    left: -2.25rem;
}
.custom-control-label::after {
    left: -2.25rem;
}
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.025);
}
</style>
@endpush
