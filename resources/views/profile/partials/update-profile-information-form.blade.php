<section>
    <header>
        <h3 class="fw-bold text-dark mb-4">Profile Information</h3>
        <p class="text-muted mb-4">Update your account's profile information and email address.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo Upload -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="text-center">
                    <div class="profile-photo-upload mb-3">
                        <div class="profile-photo-preview mb-3">
                            <img id="profilePhotoPreview"
                                 src="{{ auth()->user()->profile_photo_url }}"
                                 alt="Profile Photo"
                                 class="rounded-circle shadow"
                                 width="120"
                                 height="120"
                                 style="object-fit: cover;">
                        </div>
                        <div class="profile-photo-actions">
                            <input type="file"
                                   id="profile_photo"
                                   name="profile_photo"
                                   class="d-none"
                                   accept="image/*">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('profile_photo').click()">
                                <i class="fas fa-camera me-1"></i> Change Photo
                            </button>
                            @if(auth()->user()->profile_photo)
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeProfilePhoto()">
                                <i class="fas fa-trash me-1"></i> Remove
                            </button>
                            @endif
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Basic Information -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name *</label>
                    <input id="name" name="name" type="text" class="form-control"
                           value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address *</label>
                    <input id="email" name="email" type="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required autocomplete="email">
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input id="phone" name="phone" type="tel" class="form-control"
                           value="{{ old('phone', $user->phone) }}" autocomplete="tel">
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
            </div>

            <!-- Additional Information -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" class="form-control"
                           value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
                    <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select id="gender" name="gender" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input id="website" name="website" type="url" class="form-control"
                           value="{{ old('website', $user->website) }}" placeholder="https://example.com">
                    <x-input-error class="mt-2" :messages="$errors->get('website')" />
                </div>
            </div>
        </div>

        <!-- Bio -->
        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea id="bio" name="bio" class="form-control" rows="3"
                      placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="alert alert-warning">
                <p class="mb-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Your email address is unverified.
                </p>
                <button form="send-verification" class="btn btn-outline-warning btn-sm">
                    Click here to re-send the verification email.
                </button>

                @if (session('status') === 'verification-link-sent')
                    <p class="text-success mt-2 mb-0">
                        A new verification link has been sent to your email address.
                    </p>
                @endif
            </div>
        @endif

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-success mb-0">
                    <i class="fas fa-check-circle me-2"></i>Profile updated successfully!
                </p>
            @endif
        </div>
    </form>
</section>

<script>
// Profile photo preview
document.getElementById('profile_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePhotoPreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

function removeProfilePhoto() {
    if (confirm('Are you sure you want to remove your profile photo?')) {
        // You can implement AJAX call to remove photo or handle in controller
        document.getElementById('profilePhotoPreview').src = 'https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF';
        document.getElementById('profile_photo').value = '';
    }
}
</script>

<style>
.profile-photo-preview img {
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
}

.profile-photo-preview img:hover {
    border-color: #007bff;
}

.profile-photo-actions .btn {
    margin: 0 5px;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
}
</style>
