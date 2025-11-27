@extends('admin.index')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-2 font-weight-bold" style="color: rgba(3, 152, 139, 0.622);">User Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin_dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
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
                <h3 class="card-title">All Users</h3>
                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal">
                        <i class="fas fa-plus"></i> Add New User
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Search and Filters -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search by name, email...">
                    </div>
                    <div class="col-md-3">
                        <select id="roleFilter" class="form-control">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="statusFilter" class="form-control">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="resetFilters" class="btn btn-secondary btn-block">Reset</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="usersTable" class="table table-bordered table-striped text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Email Verified</th>
                                <th>Registered At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar mr-3">
                                                @if($user->avatar)
                                                    <img src="{{ asset('storage/' . $user->avatar) }}"
                                                         alt="{{ $user->name }}"
                                                         class="img-circle"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="img-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                         style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="user-info text-left">
                                                <div class="font-weight-bold">{{ $user->name }}</div>
                                                <small class="text-muted">ID: {{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'moderator' ? 'warning' : 'info') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $user->status ? 'success' : 'danger' }}">
                                            {{ $user->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">Verified</span>
                                            <br>
                                            <small class="text-muted">{{ $user->email_verified_at->format('M j, Y') }}</small>
                                        @else
                                            <span class="badge badge-warning">Not Verified</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M j, Y') }}</td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#viewUserModal"
                                                   data-user-id="{{ $user->id }}"
                                                   data-user-name="{{ $user->name }}"
                                                   data-user-email="{{ $user->email }}"
                                                   data-user-phone="{{ $user->phone }}"
                                                   data-user-role="{{ $user->role }}"
                                                   data-user-status="{{ $user->status }}"
                                                   data-user-avatar="{{ $user->avatar }}"
                                                   data-user-created="{{ $user->created_at->format('M j, Y g:i A') }}">
                                                    <i class="fas fa-eye mr-2"></i>View Details
                                                </a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editUserModal"
                                                   data-user-id="{{ $user->id }}"
                                                   data-user-name="{{ $user->name }}"
                                                   data-user-email="{{ $user->email }}"
                                                   data-user-phone="{{ $user->phone }}"
                                                   data-user-role="{{ $user->role }}"
                                                   data-user-status="{{ $user->status }}">
                                                    <i class="fas fa-edit mr-2"></i>Edit User
                                                </a>

                                                @if($user->id != auth()->id())
                                                    <div class="dropdown-divider"></div>
                                                    @if($user->role != 'admin')
                                                        <a class="dropdown-item make-admin-btn" href="#" data-user-id="{{ $user->id }}">
                                                            <i class="fas fa-user-shield mr-2"></i>Make Admin
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item remove-admin-btn" href="#" data-user-id="{{ $user->id }}">
                                                            <i class="fas fa-user mr-2"></i>Remove Admin
                                                        </a>
                                                    @endif

                                                    @if($user->status)
                                                        <a class="dropdown-item deactivate-user" href="#" data-user-id="{{ $user->id }}">
                                                            <i class="fas fa-user-slash mr-2"></i>Deactivate
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item activate-user" href="#" data-user-id="{{ $user->id }}">
                                                            <i class="fas fa-user-check mr-2"></i>Activate
                                                        </a>
                                                    @endif

                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger delete-user-btn" href="#" data-user-id="{{ $user->id }}">
                                                        <i class="fas fa-trash mr-2"></i>Delete User
                                                    </a>
                                                @else
                                                    <div class="dropdown-divider"></div>
                                                    <span class="dropdown-item text-muted">
                                                        <i class="fas fa-info-circle mr-2"></i>Current User
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                            </div>
                            <div>
                                {{ $users->links() }}
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

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password *</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role *</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                            <label class="custom-control-label" for="status">Active User</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editUserForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id" name="id">
                    <div class="form-group">
                        <label for="edit_name">Full Name *</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email Address *</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone">Phone Number</label>
                        <input type="text" class="form-control" id="edit_phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="edit_role">Role *</label>
                        <select class="form-control" id="edit_role" name="role" required>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="edit_status" name="status" value="1">
                            <label class="custom-control-label" for="edit_status">Active User</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div id="userAvatar" class="mb-3">
                            <!-- Avatar will be loaded here -->
                        </div>
                        <h4 id="userName" class="font-weight-bold"></h4>
                        <span id="userRole" class="badge badge-primary"></span>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Email:</th>
                                <td id="userEmail"></td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td id="userPhone"></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td id="userStatus"></td>
                            </tr>
                            <tr>
                                <th>Registered:</th>
                                <td id="userCreated"></td>
                            </tr>
                            <tr>
                                <th>User ID:</th>
                                <td id="userId"></td>
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

<!-- Make Admin Search Modal -->
<div class="modal fade" id="makeAdminModal" tabindex="-1" role="dialog" aria-labelledby="makeAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="makeAdminModalLabel">Make User Admin by Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="makeAdminForm" action="{{ route('admin.users.makeAdminByEmail') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search_email">Enter User Email</label>
                        <input type="email" class="form-control" id="search_email" name="email" required placeholder="user@example.com">
                        <small class="text-muted">Enter the email of the user you want to make admin</small>
                    </div>
                    <div id="userSearchResult" class="mt-3" style="display: none;">
                        <!-- Search results will appear here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="makeAdminBtn" disabled>Make Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.user-avatar .img-circle {
    border-radius: 50%;
}
.table td {
    vertical-align: middle;
}
.badge {
    font-size: 0.75rem;
}
.dropdown-menu {
    min-width: 200px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#usersTable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#usersTable_wrapper .col-md-6:eq(0)');

    // Search functionality
    $('#searchInput').on('keyup', function() {
        $('#usersTable').DataTable().search($(this).val()).draw();
    });

    // Role filter
    $('#roleFilter').on('change', function() {
        const value = $(this).val();
        $('#usersTable').DataTable().column(4).search(value).draw();
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        const value = $(this).val();
        $('#usersTable').DataTable().column(5).search(value).draw();
    });

    // Reset filters
    $('#resetFilters').on('click', function() {
        $('#roleFilter').val('');
        $('#statusFilter').val('');
        $('#searchInput').val('');
        $('#usersTable').DataTable()
            .search('')
            .columns().search('')
            .draw();
    });

    // Edit User Modal
    $('#editUserModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const userId = button.data('user-id');
        const userName = button.data('user-name');
        const userEmail = button.data('user-email');
        const userPhone = button.data('user-phone');
        const userRole = button.data('user-role');
        const userStatus = button.data('user-status');

        const modal = $(this);
        modal.find('#edit_user_id').val(userId);
        modal.find('#edit_name').val(userName);
        modal.find('#edit_email').val(userEmail);
        modal.find('#edit_phone').val(userPhone || '');
        modal.find('#edit_role').val(userRole);
        modal.find('#edit_status').prop('checked', userStatus == 1);

        // Update form action
        modal.find('#editUserForm').attr('action', '/admin/users/' + userId);
    });

    // View User Modal
    $('#viewUserModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const userId = button.data('user-id');
        const userName = button.data('user-name');
        const userEmail = button.data('user-email');
        const userPhone = button.data('user-phone');
        const userRole = button.data('user-role');
        const userStatus = button.data('user-status');
        const userAvatar = button.data('user-avatar');
        const userCreated = button.data('user-created');

        const modal = $(this);
        modal.find('#userId').text(userId);
        modal.find('#userName').text(userName);
        modal.find('#userEmail').text(userEmail);
        modal.find('#userPhone').text(userPhone || 'N/A');
        modal.find('#userRole').text(userRole.charAt(0).toUpperCase() + userRole.slice(1));
        modal.find('#userStatus').html(userStatus == 1 ?
            '<span class="badge badge-success">Active</span>' :
            '<span class="badge badge-danger">Inactive</span>');
        modal.find('#userCreated').text(userCreated);

        // Set avatar
        const avatarContainer = modal.find('#userAvatar');
        if (userAvatar) {
            avatarContainer.html(`<img src="{{ asset('storage/') }}/${userAvatar}" alt="${userName}" class="img-circle" style="width: 100px; height: 100px; object-fit: cover;">`);
        } else {
            const initial = userName.charAt(0).toUpperCase();
            avatarContainer.html(`<div class="img-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; font-size: 2rem;">${initial}</div>`);
        }
    });

    // Make Admin by Email Search
    $('#search_email').on('input', function() {
        const email = $(this).val();
        const resultContainer = $('#userSearchResult');
        const makeAdminBtn = $('#makeAdminBtn');

        if (email.length > 3) {
            $.ajax({
                url: '{{ route("admin.users.searchByEmail") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email
                },
                success: function(response) {
                    if (response.success && response.user) {
                        resultContainer.html(`
                            <div class="alert alert-success">
                                <strong>User Found:</strong> ${response.user.name} (${response.user.email})
                                <br>
                                <small>Current Role: ${response.user.role}</small>
                            </div>
                        `);
                        resultContainer.show();
                        makeAdminBtn.prop('disabled', false);
                    } else {
                        resultContainer.html(`
                            <div class="alert alert-warning">
                                No user found with this email address.
                            </div>
                        `);
                        resultContainer.show();
                        makeAdminBtn.prop('disabled', true);
                    }
                }
            });
        } else {
            resultContainer.hide();
            makeAdminBtn.prop('disabled', true);
        }
    });

    // Make Admin Action
    $('.make-admin-btn').on('click', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');

        Swal.fire({
            title: 'Make User Admin?',
            text: "This user will have full administrative privileges.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, make admin!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("admin/users") }}/' + userId + '/make-admin',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('User has been made admin successfully');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to make user admin');
                    }
                });
            }
        });
    });

    // Remove Admin Action
    $('.remove-admin-btn').on('click', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');

        Swal.fire({
            title: 'Remove Admin Privileges?',
            text: "This user will lose administrative access.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove admin!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("admin/users") }}/' + userId + '/remove-admin',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Admin privileges removed successfully');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to remove admin privileges');
                    }
                });
            }
        });
    });

    // Activate/Deactivate User
    $('.activate-user, .deactivate-user').on('click', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        const action = $(this).hasClass('activate-user') ? 'activate' : 'deactivate';

        Swal.fire({
            title: `${action.charAt(0).toUpperCase() + action.slice(1)} User?`,
            text: `Are you sure you want to ${action} this user?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, ${action}!`,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("admin/users") }}/' + userId + '/toggle-status',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        action: action
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(`User ${action}d successfully`);
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function() {
                        toastr.error(`Failed to ${action} user`);
                    }
                });
            }
        });
    });

    // Delete User
    $('.delete-user-btn').on('click', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');

        Swal.fire({
            title: 'Delete User?',
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
                    url: '{{ url("admin/users") }}/' + userId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('User deleted successfully');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to delete user');
                    }
                });
            }
        });
    });

    // Open Make Admin by Email Modal
    $('#openMakeAdminModal').on('click', function() {
        $('#makeAdminModal').modal('show');
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
