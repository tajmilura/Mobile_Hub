<section class="delete-account-section">
    <div class="delete-header">
        <div class="delete-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h2 class="delete-title">
            {{ __('Delete Account') }}
        </h2>
        <p class="delete-description">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </div>

    <div class="delete-confirmation">
        <form method="post" action="{{ route('profile.destroy') }}" class="delete-form" id="deleteAccountForm">
            @csrf
            @method('delete')

            <div class="password-section">
                <label for="password" class="password-label">
                    <i class="fas fa-key me-2"></i>
                    {{ __('Enter your password to confirm account deletion') }}
                </label>

                <div class="password-input-group">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="password-input"
                        placeholder="{{ __('Enter your current password') }}"
                        required
                    />
                    <button type="button" class="password-toggle-btn" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                @error('password', 'userDeletion')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <div class="warning-message">
                <div class="warning-icon">
                    <i class="fas fa-shield-exclamation"></i>
                </div>
                <div class="warning-content">
                    <strong>Warning: This action cannot be undone</strong>
                    <p>All your data including profile information, orders, and wishlist will be permanently deleted.</p>
                </div>
            </div>

            <div class="action-buttons">
                <button type="button" class="cancel-btn" onclick="resetForm()">
                    <i class="fas fa-times me-2"></i>
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="delete-btn" id="deleteBtn">
                    <i class="fas fa-trash-alt me-2"></i>
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </div>
</section>
