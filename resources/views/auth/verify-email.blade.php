<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verify Email | User Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/web/css/style.css') }}">
</head>

<body>
    <main class="auth-layout">

        <!-- Left side -->
        <aside class="brand-panel" aria-label="User Dashboard">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true">U.</span>
                <span>User Dashboard</span>
            </a>

            <div class="brand-copy">
                <p class="eyebrow">ONE LAST STEP</p>

                <h1>Almost there.<br>Make it yours.</h1>

                <p class="brand-description">
                    Verify your email to complete your registration
                    and get started with your account.
                </p>
            </div>

            <p class="copyright">
                © {{ date('Y') }} User Dashboard
            </p>
        </aside>

        <!-- Right side -->
        <section class="form-panel" aria-labelledby="verification-title">
            <div class="login-card">

                <header class="heading">
                    <h2 id="verification-title">
                        Verify your email<span>.</span>
                    </h2>

                    <p>
                        Enter the 6-digit code from your verification
                        email. The code expires after 10 minutes.
                    </p>
                </header>

                <!-- Connect this form to the OTP verification route later. -->
                <form action="{{ route('verification.verify') }}" method="POST">
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
                        <label for="otp">Verification code</label>

                        <input
                            type="text"
                            id="otp"
                            name="otp"
                            value="{{ old('otp') }}"
                            placeholder="Enter 6-digit code"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            required
                            class="@error('otp') input-invalid @enderror">

                        @error('otp')
                        <p class="input-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="sign-in" type="submit">
                        Verify Email
                    </button>
                </form>

                <p class="register">
                    Check your inbox and spam folder for the code.
                </p>

                <p class="register">
                    Used the wrong email?
                    <a href="{{ url('/register') }}">Back to registration</a>
                </p>

            </div>
        </section>

    </main>
</body>

</html>