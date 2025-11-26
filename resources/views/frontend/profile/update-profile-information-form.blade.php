<section>
    <header>
        <h3 class="fw-bold text-dark mb-4">Profile Information</h3>
        <p class="text-muted mb-4">Update your account's profile information and email address.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" name="name" type="text" class="form-control"
                           value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required autocomplete="username">
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm text-muted">
                    Your email address is unverified.
                    <button form="send-verification" class="btn btn-link p-0">
                        Click here to re-send the verification email.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="text-success">
                        A new verification link has been sent to your email address.
                    </p>
                @endif
            </div>
        @endif

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">Save Changes</button>

            @if (session('status') === 'profile-updated')
                <p class="text-success mb-0">Profile updated successfully!</p>
            @endif
        </div>
    </form>
</section>
