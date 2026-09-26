<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password | User Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/web/css/style.css') }}">
</head>

<body>
    <main class="auth-layout">

        <aside class="brand-panel" aria-label="User Dashboard">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true">U.</span>
                <span>User Dashboard</span>
            </a>

            <div class="brand-copy">
                <p class="eyebrow">PASSWORD RECOVERY</p>

                <h1>Create a new<br>password.</h1>

                <p class="brand-description">
                    Choose a secure new password to protect your account.
                </p>
            </div>

            <p class="copyright">
                © {{ date('Y') }} User Dashboard
            </p>
        </aside>

        <section class="form-panel" aria-labelledby="reset-title">
            <div class="login-card">

                <header class="heading">
                    <h2 id="reset-title">Reset password<span>.</span></h2>

                    <p>
                        Create a new password for your account.
                    </p>
                </header>

                <!-- We will connect this form to the password update route next. -->
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                    <div class="form-error-summary" role="alert">
                        <strong>Please fix the following:</strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="field">
                        <label for="password">New password</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Create a new password"
                            autocomplete="new-password"
                            required
                            class="@error('password') input-invalid @enderror">

                        <p class="field-help">
                            Use 8+ characters with uppercase, lowercase, a number, and a special character.
                        </p>

                        @error('password')
                        <p class="input-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirm new password</label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Re-enter your new password"
                            autocomplete="new-password"
                            required
                            class="@error('password_confirmation') input-invalid @enderror">

                        @error('password_confirmation')
                        <p class="input-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="sign-in" type="submit">
                        Reset password
                    </button>
                </form>

            </div>
        </section>

    </main>
</body>

</html>