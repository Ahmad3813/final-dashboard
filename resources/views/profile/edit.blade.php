@extends('layouts.parts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="account-edit-page">
    <header class="account-edit-header">
        <div>
            <h1>Account settings</h1>
            <p>Update your profile details and password.</p>
        </div>

        <a href="#" class="account-back-link">
            ← Back to profile
        </a>
    </header>

    <div class="account-edit-layout">
        <aside class="account-summary">
            <div class="account-summary-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }}</p>

            <div class="account-summary-divider"></div>

            <span class="account-summary-status">
                <i></i>
                Account active
            </span>
        </aside>

        <form
            class="account-form"
            id="profile-edit-form"
            action="{{ route('update-profile', $user->id) }}"
            method="POST">
            @csrf
            @method('PUT')

            @if ($errors->any())
            <div class="account-error-summary" role="alert">
                <strong>Please fix the following:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <section class="account-form-section">
                <div class="account-section-heading">
                    <h2>Personal information</h2>
                    <p>This information is visible on your account.</p>
                </div>

                <div class="account-field">
                    <label for="name">Full name</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        maxlength="255"
                        autocomplete="name"
                        class="@error('name') account-input-invalid @enderror">

                    @error('name')
                    <small class="input-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="account-field">
                    <label for="email">Email address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        autocomplete="email"
                        pattern="^[^\s@]+@[^\s@]+\.com$"
                        title="Email must end with .com"
                        class="@error('email') account-input-invalid @enderror">

                    @error('email')
                    <small class="input-error">{{ $message }}</small>
                    @enderror
                </div>
            </section>

            <section class="account-form-section">
                <div class="account-section-heading">
                    <h2>Change password</h2>
                    <p>Leave these fields empty if you do not want to change your password.</p>
                </div>

                <div class="account-field">
                    <label for="current_password">Current password</label>

                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        placeholder="Enter your current password"
                        autocomplete="current-password"
                        class="@error('current_password') account-input-invalid @enderror">

                    @error('current_password')
                    <small class="input-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="account-field">
                    <label for="password">New password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a new password"
                        minlength="8"
                        autocomplete="new-password"
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}"
                        title="Use 8+ characters with uppercase, lowercase, number, and special character."
                        class="@error('password') account-input-invalid @enderror">

                    <small class="account-field-hint">
                        Use 8+ characters with uppercase, lowercase, a number, and a special character.
                    </small>

                    @error('password')
                    <small class="input-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="account-field">
                    <label for="password_confirmation">Confirm new password</label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Re-enter your new password"
                        autocomplete="new-password"
                        class="@error('password_confirmation') account-input-invalid @enderror">

                    @error('password_confirmation')
                    <small class="input-error">{{ $message }}</small>
                    @enderror
                </div>
            </section>

            <footer class="account-form-footer">
                <a href="{{ route('view-profile') }}" class="account-cancel-button">
                    Cancel
                </a>

                <button type="submit" class="account-save-button">
                    Save changes
                </button>
            </footer>
        </form>

        <script>
            const form = document.getElementById('profile-edit-form');
            const currentPassword = document.getElementById('current_password');
            const password = document.getElementById('password');
            const confirmation = document.getElementById('password_confirmation');

            function validatePasswordFields() {
                const isChangingPassword = password.value.length > 0;

                currentPassword.required = isChangingPassword;
                confirmation.required = isChangingPassword;

                if (isChangingPassword && password.value !== confirmation.value) {
                    confirmation.setCustomValidity('Passwords do not match.');
                } else {
                    confirmation.setCustomValidity('');
                }
            }

            password.addEventListener('input', validatePasswordFields);
            confirmation.addEventListener('input', validatePasswordFields);
            form.addEventListener('submit', validatePasswordFields);
        </script>
    </div>
</section>
@endsection