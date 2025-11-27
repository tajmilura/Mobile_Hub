@extends('admin.index')

@section('title', 'User Profile')

@section('content')
    <main class="main">
        <!-- Page Header -->
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">My Profile<span>Account</span></h1>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin_dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin_dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </div>
        </nav>
        <!-- Display General Errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <!-- Sidebar Menu -->
                    <div class="col-lg-3">
                        <div class="profile-sidebar">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body text-center p-4">
                                    <div class="profile-avatar mb-3">
                                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                                            class="rounded-circle" width="80" height="80"
                                            style="object-fit: cover; border: 3px solid #e9ecef;">
                                    </div>
                                    <h5 class="fw-bold mb-1 text-dark">{{ Auth::user()->name }}</h5>
                                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                                    <div class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Verified Account
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ route('admin_dashboard') }}"
                                            class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                        </a>
                                        <a href="{{ route('admin.profile.edit') }}"
                                            class="list-group-item list-group-item-action {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                            <i class="fas fa-user me-2"></i>Profile Information
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                class="list-group-item list-group-item-action border-0 text-start w-100">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-lg-9">
                        <!-- Success Messages -->
                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Success!</strong> Profile updated successfully.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Success!</strong> Password updated successfully.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Profile Information Form -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-primary text-white py-3">
                                <h4 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-user-edit me-2"></i>Profile Information
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>

                        <!-- Update Password Form -->
                        <!-- Update Password Form -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-warning text-white py-3">
                                <h4 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-lock me-2"></i>Update Password
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                <section>
                                    <header class="mb-4">
                                        <h5 class="fw-bold text-dark mb-3">Change Your Password</h5>
                                        <p class="text-muted mb-0">
                                            Ensure your account is using a strong and secure password.
                                        </p>
                                    </header>

                                    <form method="POST" action="{{ route('admin.password.update.custom') }}" class="space-y-4"
                                        id="updatePasswordForm">
                                        @csrf
                                        @method('PUT')

                                        <!-- Current Password -->
                                        <div class="mb-4">
                                            <label for="current_password" class="form-label fw-semibold text-dark">
                                                <i class="fas fa-key me-2 text-warning"></i>Current Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password" id="current_password" name="current_password"
                                                    class="form-control password-field"
                                                    placeholder="Enter your current password"
                                                    autocomplete="current-password" required>
                                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                                    data-target="current_password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('current_password')
                                                <div class="text-danger small mt-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- New Password -->
                                        <div class="mb-4">
                                            <label for="new_password" class="form-label fw-semibold text-dark">
                                                <i class="fas fa-lock me-2 text-success"></i>New Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password" id="new_password" name="new_password"
                                                    class="form-control password-field" placeholder="Enter new password"
                                                    autocomplete="new-password" required minlength="8">
                                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                                    data-target="new_password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="password-strength mt-2">
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar" id="passwordStrengthBar" style="width: 0%">
                                                    </div>
                                                </div>
                                                <small class="text-muted" id="passwordStrengthText">Password
                                                    strength</small>
                                            </div>
                                            @error('new_password')
                                                <div class="text-danger small mt-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Confirm New Password -->
                                        <div class="mb-4">
                                            <label for="new_password_confirmation"
                                                class="form-label fw-semibold text-dark">
                                                <i class="fas fa-lock me-2 text-info"></i>Confirm New Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password" id="new_password_confirmation"
                                                    name="new_password_confirmation" class="form-control password-field"
                                                    placeholder="Confirm your new password" autocomplete="new-password"
                                                    required>
                                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                                    data-target="new_password_confirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted" id="passwordMatchText"></small>
                                            </div>
                                        </div>

                                        <!-- Password Requirements -->
                                        <div class="alert alert-light border mb-4">
                                            <h6 class="fw-bold mb-3 text-dark">
                                                <i class="fas fa-shield-alt me-2 text-primary"></i>Password Requirements
                                            </h6>
                                            <ul class="list-unstyled mb-0 small">
                                                <li class="mb-2">
                                                    <i class="fas fa-check text-success me-2 requirement"
                                                        data-requirement="length"></i>
                                                    At least 8 characters
                                                </li>
                                                <li class="mb-2">
                                                    <i class="fas fa-check text-success me-2 requirement"
                                                        data-requirement="uppercase"></i>
                                                    One uppercase letter
                                                </li>
                                                <li class="mb-2">
                                                    <i class="fas fa-check text-success me-2 requirement"
                                                        data-requirement="lowercase"></i>
                                                    One lowercase letter
                                                </li>
                                                <li class="mb-2">
                                                    <i class="fas fa-check text-success me-2 requirement"
                                                        data-requirement="number"></i>
                                                    One number
                                                </li>
                                                <li>
                                                    <i class="fas fa-check text-success me-2 requirement"
                                                        data-requirement="special"></i>
                                                    One special character
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="d-flex align-items-center gap-3">
                                            <button type="submit"
                                                class="btn btn-warning text-white fw-semibold px-4 py-2"
                                                id="updatePasswordBtn">
                                                <i class="fas fa-key me-2"></i>Update Password
                                            </button>

                                            @if (session('status') === 'password-updated')
                                                <div class="text-success fw-semibold">
                                                    <i class="fas fa-check-circle me-2"></i>Password updated successfully!
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                </section>
                            </div>
                        </div>

                        <!-- Delete Account Form -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-danger text-white py-3">
                                <h4 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        .profile-sidebar .list-group-item {
            border: none;
            padding: 15px 20px;
            font-weight: 500;
            color: #495057;
            transition: all 0.3s ease;
            border-radius: 0 !important;
        }

        .profile-sidebar .list-group-item:hover {
            background-color: #f8f9fa;
            color: #007bff;
            transform: translateX(5px);
        }

        .profile-sidebar .list-group-item.active {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border-left: 4px solid #fff;
        }

        .profile-sidebar .list-group-item button {
            background: none;
            border: none;
            text-align: left;
            width: 100%;
        }

        .profile-avatar img {
            border: 3px solid #e9ecef;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .profile-avatar img:hover {
            border-color: #007bff;
            transform: scale(1.05);
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
            border: none;
        }

        /* Form Styling */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
            transform: translateY(-1px);
        }

        .btn {
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Profile Photo Styles */
        .profile-photo-preview img {
            border: 3px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .profile-photo-preview img:hover {
            border-color: #007bff;
            transform: scale(1.05);
        }

        .profile-photo-actions .btn {
            padding: 8px 16px;
            font-size: 14px;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 8px;
            border-left: 4px solid;
        }

        .alert-success {
            border-left-color: #28a745;
            background: linear-gradient(135deg, #f8fff9, #ffffff);
        }

        .alert-warning {
            border-left-color: #ffc107;
            background: linear-gradient(135deg, #fffbf0, #ffffff);
        }

        /* Badge Styles */
        .badge {
            font-size: 0.75rem;
            padding: 0.5em 0.75em;
            border-radius: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-sidebar {
                margin-bottom: 30px;
            }

            .card-body {
                padding: 20px;
            }

            .profile-sidebar .list-group-item {
                padding: 12px 15px;
                font-size: 14px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }

        /* Animation for form elements */
        .form-group {
            transition: all 0.3s ease;
        }

        .form-group:focus-within {
            transform: translateY(-1px);
        }

        /* Custom scrollbar for sidebar */
        .profile-sidebar .list-group {
            max-height: 400px;
            overflow-y: auto;
        }

        .profile-sidebar .list-group::-webkit-scrollbar {
            width: 4px;
        }

        .profile-sidebar .list-group::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .profile-sidebar .list-group::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .profile-sidebar .list-group::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Profile photo preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const profilePhotoInput = document.getElementById('profile_photo');
            const profilePhotoPreview = document.getElementById('profilePhotoPreview');

            if (profilePhotoInput) {
                profilePhotoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profilePhotoPreview.src = e.target.result;
                            profilePhotoPreview.style.transform = 'scale(1.1)';
                            setTimeout(() => {
                                profilePhotoPreview.style.transform = 'scale(1)';
                            }, 300);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        function removeProfilePhoto() {
            if (confirm('Are you sure you want to remove your profile photo?')) {
                //
                document.getElementById('profilePhotoPreview').src = '{{ auth()->user()->profile_photo_url }}';
                document.getElementById('removeProfilePhoto').value = '1';
                document.getElementById('profile_photo').value = '';

                // Default avatar manually set
                document.getElementById('profilePhotoPreview').src =
                    'https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF&size=200&bold=true&rounded=true';
            }
        }

        // Form submission loading states
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                    submitBtn.disabled = true;
                }
            });
        });

        // Add smooth scrolling to form sections
        document.querySelectorAll('.profile-sidebar .list-group-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>

    <script>
        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
            };

            // Update requirement icons
            Object.keys(requirements).forEach(req => {
                const icon = document.querySelector(`.requirement[data-requirement="${req}"]`);
                if (icon) {
                    if (requirements[req]) {
                        icon.className = 'fas fa-check text-success me-2 requirement';
                        strength++;
                    } else {
                        icon.className = 'fas fa-times text-danger me-2 requirement';
                    }
                }
            });

            // Update progress bar
            const totalRequirements = Object.keys(requirements).length;
            const percentage = (strength / totalRequirements) * 100;
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');

            if (strengthBar) {
                strengthBar.style.width = percentage + '%';

                if (percentage < 40) {
                    strengthBar.className = 'progress-bar bg-danger';
                    strengthText.textContent = 'Weak password';
                    strengthText.className = 'text-danger';
                } else if (percentage < 80) {
                    strengthBar.className = 'progress-bar bg-warning';
                    strengthText.textContent = 'Medium strength';
                    strengthText.className = 'text-warning';
                } else {
                    strengthBar.className = 'progress-bar bg-success';
                    strengthText.textContent = 'Strong password';
                    strengthText.className = 'text-success';
                }
            }

            return strength;
        }

        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('new_password_confirmation').value;
            const matchText = document.getElementById('passwordMatchText');

            if (confirmPassword === '') {
                matchText.textContent = '';
                matchText.className = 'text-muted';
            } else if (password === confirmPassword) {
                matchText.innerHTML = '<i class="fas fa-check-circle me-1"></i>Passwords match';
                matchText.className = 'text-success';
            } else {
                matchText.innerHTML = '<i class="fas fa-times-circle me-1"></i>Passwords do not match';
                matchText.className = 'text-danger';
            }
        }

        // Toggle password visibility
        function setupPasswordToggles() {
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordField = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        icon.className = 'fas fa-eye-slash';
                    } else {
                        passwordField.type = 'password';
                        icon.className = 'fas fa-eye';
                    }
                });
            });
        }

        // Form validation
        function setupFormValidation() {
            const form = document.getElementById('updatePasswordForm');
            const submitBtn = document.getElementById('updatePasswordBtn');

            if (form) {
                form.addEventListener('submit', function(e) {
                    const currentPassword = document.getElementById('current_password').value;
                    const newPassword = document.getElementById('new_password').value;
                    const confirmPassword = document.getElementById('new_password_confirmation').value;

                    if (!currentPassword || !newPassword || !confirmPassword) {
                        e.preventDefault();
                        alert('Please fill in all password fields.');
                        return;
                    }

                    if (newPassword !== confirmPassword) {
                        e.preventDefault();
                        alert('New password and confirmation do not match.');
                        return;
                    }

                    // Show loading state
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                        submitBtn.disabled = true;
                    }
                });
            }
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            setupPasswordToggles();
            setupFormValidation();

            // Real-time password strength checking
            const newPasswordField = document.getElementById('new_password');
            const confirmPasswordField = document.getElementById('new_password_confirmation');

            if (newPasswordField) {
                newPasswordField.addEventListener('input', function() {
                    checkPasswordStrength(this.value);
                    checkPasswordMatch();
                });
            }

            if (confirmPasswordField) {
                confirmPasswordField.addEventListener('input', checkPasswordMatch);
            }
        });
    </script>
@endpush
