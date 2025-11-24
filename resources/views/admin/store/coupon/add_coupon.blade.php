@extends('admin.index')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Coupon/Edit Coupon/All Coupons</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create Coupon</li>
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
                            <h3 class="card-title" id="formTitle">Add New Coupon</h3>
                            <button type="button" class="btn btn-success btn-sm d-none" id="addNewBtn">
                                <i class="fas fa-plus"></i> Add New Coupon
                            </button>
                        </div>

                        <!-- form start -->
                        <form action="{{ route('coupons.store') }}" method="POST" id="couponForm">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="coupon_code">Coupon Code *</label>
                                    <input type="text" name="code" class="form-control" id="coupon_code"
                                        placeholder="Enter coupon code (e.g., WELCOME10)" value="{{ old('code') }}"
                                        required>
                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="coupon_description">Description</label>
                                    <textarea name="description" class="form-control" id="coupon_description"
                                        placeholder="Enter coupon description (optional)" rows="2">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="coupon_type">Discount Type *</label>
                                    <select name="type" class="form-control" id="coupon_type" required>
                                        <option value="">Select Type</option>
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>
                                            Percentage (%)
                                        </option>
                                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>
                                            Fixed Amount ($)
                                        </option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="coupon_value">Discount Value *</label>
                                    <input type="number" name="value" class="form-control" id="coupon_value"
                                        placeholder="Enter discount value" step="0.01" min="0"
                                        value="{{ old('value') }}" required>
                                    @error('value')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="min_order_amount">Minimum Order Amount</label>
                                    <input type="number" name="min_order_amount" class="form-control" id="min_order_amount"
                                        placeholder="Enter minimum order amount (0 for no minimum)" step="0.01"
                                        min="0" value="{{ old('min_order_amount', 0) }}">
                                    @error('min_order_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group" id="max_discount_group">
                                    <label for="max_discount">Maximum Discount (For Percentage)</label>
                                    <input type="number" name="max_discount" class="form-control" id="max_discount"
                                        placeholder="Enter maximum discount amount" step="0.01" min="0"
                                        value="{{ old('max_discount') }}">
                                    @error('max_discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="usage_limit">Usage Limit</label>
                                    <input type="number" name="usage_limit" class="form-control" id="usage_limit"
                                        placeholder="Enter usage limit (leave empty for unlimited)" min="1"
                                        value="{{ old('usage_limit') }}">
                                    @error('usage_limit')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date">Start Date</label>
                                            <input type="datetime-local" name="start_date" class="form-control"
                                                id="start_date" value="{{ old('start_date') }}">
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date">End Date</label>
                                            <input type="datetime-local" name="end_date" class="form-control"
                                                id="end_date" value="{{ old('end_date') }}">
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                    
                                        <input type="checkbox" name="is_active" class="custom-control-input"
                                            id="form_is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="form_is_active">Active Coupon</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save"></i> Create Coupon
                                </button>
                                <button type="button" class="btn btn-secondary" id="cancelBtn" style="display: none;">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #28a745; color: white;">
                            <h3 class="card-title">All Coupons 
                                <span class="badge badge-light">{{ $coupons->total() }}</span>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="loader" style="display:none; text-align:center; padding:20px;">
                                <i class="fas fa-spinner fa-spin fa-2x"></i>
                            </div>
                            <div id="coupon-table">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Usage</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($coupons as $index => $coupon)
                                            <tr id="coupon-row-{{ $coupon->id }}">
                                                <td>{{ $coupons->firstItem() + $index }}.</td>
                                                <td>
                                                    <strong class="text-primary">{{ $coupon->code }}</strong>
                                                    @if($coupon->description)
                                                        <br><small class="text-muted">{{ Str::limit($coupon->description, 25) }}</small>
                                                    @endif
                                                    @if($coupon->end_date && $coupon->end_date->isPast())
                                                        <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Expired</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge {{ $coupon->type == 'percentage' ? 'bg-info' : 'bg-success' }}">
                                                        {{ ucfirst($coupon->type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($coupon->type == 'percentage')
                                                        <strong>{{ $coupon->value }}%</strong>
                                                        @if($coupon->max_discount)
                                                            <br><small class="text-muted">Max: ${{ number_format($coupon->max_discount, 2) }}</small>
                                                        @endif
                                                    @else
                                                        <strong>${{ number_format($coupon->value, 2) }}</strong>
                                                    @endif
                                                    @if($coupon->min_order_amount > 0)
                                                        <br><small class="text-muted">Min: ${{ number_format($coupon->min_order_amount, 2) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        @php
                                                            $usagePercentage = $coupon->usage_limit ? ($coupon->used_count / $coupon->usage_limit) * 100 : 0;
                                                            $progressClass = $usagePercentage >= 80 ? 'bg-danger' : ($usagePercentage >= 50 ? 'bg-warning' : 'bg-success');
                                                        @endphp
                                                        <div class="progress-bar {{ $progressClass }}" 
                                                             role="progressbar" 
                                                             style="width: {{ $usagePercentage }}%"
                                                             aria-valuenow="{{ $usagePercentage }}" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                            {{ $coupon->used_count }}
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">
                                                        @if($coupon->usage_limit)
                                                            {{ $coupon->used_count }} / {{ $coupon->usage_limit }}
                                                        @else
                                                            {{ $coupon->used_count }} used
                                                        @endif
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $coupon->is_active ? 'bg-success' : 'bg-secondary' }} status-badge"
                                                          id="status-badge-{{ $coupon->id }}">
                                                        {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                    <div class="custom-control custom-switch mt-1">
                                                        <input type="checkbox" 
                                                               class="custom-control-input toggle-status" 
                                                               id="status-{{ $coupon->id }}" 
                                                               data-url="{{ route('coupons.toggle-status', $coupon->id) }}"
                                                               {{ $coupon->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="status-{{ $coupon->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="btn-group">
                                                        <button type="button" 
                                                                class="btn btn-info btn-sm editCouponBtn"
                                                                data-id="{{ $coupon->id }}"
                                                                data-code="{{ $coupon->code }}"
                                                                data-description="{{ $coupon->description }}"
                                                                data-type="{{ $coupon->type }}" 
                                                                data-value="{{ $coupon->value }}"
                                                                data-min-order-amount="{{ $coupon->min_order_amount }}"
                                                                data-max-discount="{{ $coupon->max_discount }}"
                                                                data-usage-limit="{{ $coupon->usage_limit }}"
                                                                data-start-date="{{ $coupon->start_date ? $coupon->start_date->format('Y-m-d\TH:i') : '' }}"
                                                                data-end-date="{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d\TH:i') : '' }}"
                                                                data-is-active="{{ $coupon->is_active }}"
                                                                title="Edit Coupon">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        
                                                        <button type="button" 
                                                                class="btn btn-danger btn-sm delete-btn"
                                                                data-url="{{ route('coupons.destroy', $coupon->id) }}"
                                                                title="Delete Coupon">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="fas fa-tags fa-3x mb-3"></i>
                                                    <h5>No coupons available</h5>
                                                    <p class="mb-0">Create your first coupon to get started</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        @if($coupons->hasPages())
                        <div class="card-footer clearfix">
                            <div class="float-left">
                                <span class="text-muted">
                                    Showing {{ $coupons->firstItem() }} to {{ $coupons->lastItem() }} of {{ $coupons->total() }} entries
                                </span>
                            </div>
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $coupons->links('pagination::bootstrap-5') }}
                            </ul>
                        </div>
                        @endif
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
$(document).ready(function() {
    // Initialize max discount visibility
    toggleMaxDiscountVisibility();

    // Toggle max discount field based on coupon type
    $('#coupon_type').on('change', function() {
        toggleMaxDiscountVisibility();
    });

    function toggleMaxDiscountVisibility() {
        if ($('#coupon_type').val() === 'percentage') {
            $('#max_discount_group').show();
        } else {
            $('#max_discount_group').hide();
            $('#max_discount').val('');
        }
    }

    // Form submission
    $('#couponForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let url = $(this).attr('action');
        let isUpdate = $('input[name="_method"]').length > 0;

        let $btn = $('#submitBtn');
        let originalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    resetToAddMode();
                    setTimeout(() => location.reload(), 1500);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Something went wrong!';
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors)[0][0];
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error occurred!';
                }
                showNotification(errorMessage, 'error');
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

    //  coupon status 
    $(document).on('change', '.toggle-status', function(e) {
        e.stopPropagation();
        
        let $switch = $(this);
        let url = $switch.data('url');
        let isChecked = $switch.is(':checked');
        let couponId = $switch.attr('id').replace('status-', '');
        
        // Show loading state
        $switch.prop('disabled', true);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Update status badge
                    let $badge = $('#status-badge-' + couponId);
                    $badge.removeClass('bg-success bg-secondary')
                          .addClass(response.is_active ? 'bg-success' : 'bg-secondary')
                          .text(response.is_active ? 'Active' : 'Inactive');
                    
                    showNotification(response.message, 'success');
                }
            },
            error: function(xhr) {
                // Revert switch on error
                $switch.prop('checked', !isChecked);
                showNotification('Failed to update status', 'error');
            },
            complete: function() {
                $switch.prop('disabled', false);
            }
        });
    });

    // For Form is_active checkbox i use different id
    $('#form_is_active').on('change', function() {
        //
        console.log('Form coupon active status:', $(this).is(':checked') ? 'Active' : 'Inactive');
    });

    // Delete coupon
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        let url = $(this).data('url');
        let $row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
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
                            $row.fadeOut(300, function() {
                                $(this).remove();
                                if ($('#coupon-table tbody tr').length === 0) {
                                    location.reload();
                                }
                            });
                            showNotification(response.message, 'success');
                        }
                    },
                    error: function() {
                        showNotification('Failed to delete coupon', 'error');
                    }
                });
            }
        });
    });

    // Edit coupon
    $(document).on('click', '.editCouponBtn', function(e) {
        e.preventDefault();
        
        let id = $(this).data('id');
        let code = $(this).data('code');
        let description = $(this).data('description');
        let type = $(this).data('type');
        let value = $(this).data('value');
        let minOrderAmount = $(this).data('min-order-amount') || 0;
        let maxDiscount = $(this).data('max-discount') || '';
        let usageLimit = $(this).data('usage-limit') || '';
        let startDate = $(this).data('start-date') || '';
        let endDate = $(this).data('end-date') || '';
        let isActive = $(this).data('is-active');

        // Reset form
        $('#couponForm')[0].reset();
        $('input[name="_method"]').remove();

        // Fill form data
        $('#coupon_code').val(code);
        $('#coupon_description').val(description);
        $('#coupon_type').val(type);
        $('#coupon_value').val(value);
        $('#min_order_amount').val(minOrderAmount);
        $('#max_discount').val(maxDiscount);
        $('#usage_limit').val(usageLimit);
        $('#start_date').val(startDate);
        $('#end_date').val(endDate);
        $('#form_is_active').prop('checked', isActive); // Id change

        // Update form action and method
        $('#couponForm').attr('action', '/coupons/' + id);
        $('#couponForm').append('<input type="hidden" name="_method" value="PUT">');

        // Update UI
        $('#submitBtn').html('<i class="fas fa-save"></i> Update Coupon')
            .removeClass('btn-primary')
            .addClass('btn-warning');
        
        $('#formTitle').text('Edit Coupon: ' + code);
        $('#addNewBtn').removeClass('d-none');
        $('#cancelBtn').show();

        // Toggle max discount visibility
        toggleMaxDiscountVisibility();

        // Scroll to form
        $('html, body').animate({
            scrollTop: $("#couponForm").offset().top - 100
        }, 500);

        showNotification('Now editing: ' + code, 'info');
    });

    // Add new coupon button
    $('#addNewBtn').on('click', function() {
        resetToAddMode();
        showNotification('Ready to create new coupon', 'success');
    });

    // Cancel button
    $('#cancelBtn').on('click', function() {
        resetToAddMode();
        showNotification('Edit cancelled', 'info');
    });

    function resetToAddMode() {
        $('#couponForm')[0].reset();
        $('input[name="_method"]').remove();
        $('#couponForm').attr('action', "{{ route('coupons.store') }}");
        
        $('#submitBtn').html('<i class="fas fa-save"></i> Create Coupon')
            .removeClass('btn-warning')
            .addClass('btn-primary');
        
        $('#formTitle').text('Add New Coupon');
        $('#addNewBtn').addClass('d-none');
        $('#cancelBtn').hide();
        
        // Reset default values
        $('#min_order_amount').val('0');
        $('#form_is_active').prop('checked', true); // id change
        toggleMaxDiscountVisibility();
    }

    // Pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        $('#loader').show();
        let url = $(this).attr('href');

        fetch(url)
            .then(res => res.text())
            .then(html => {
                $('#coupon-table').html($(html).find('#coupon-table').html());
                $('#loader').hide();
            })
            .catch(error => {
                $('#loader').hide();
                showNotification('Failed to load page', 'error');
            });
    });

    // Notification function
    function showNotification(message, type = 'info') {
        if (typeof toastr !== 'undefined') {
            const config = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
            };

            switch(type) {
                case 'success':
                    toastr.success(message, 'Success', config);
                    break;
                case 'error':
                    toastr.error(message, 'Error', config);
                    break;
                case 'warning':
                    toastr.warning(message, 'Warning', config);
                    break;
                default:
                    toastr.info(message, 'Info', config);
            }
        } else {
            // Fallback alert
            alert(message);
        }
    }
});
</script>
@endpush