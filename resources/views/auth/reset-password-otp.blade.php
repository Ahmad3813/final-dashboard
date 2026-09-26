<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verify Reset Code | User Dashboard</title>

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

                <h1>Check your<br>email.</h1>

                <p class="brand-description">
                    We sent a 6-digit verification code to your email.
                    Enter it below to continue.
                </p>
            </div>

            <p class="copyright">
                © {{ date('Y') }} User Dashboard
            </p>
        </aside>

        <section class="form-panel" aria-labelledby="otp-title">
            <div class="login-card">

                <header class="heading">
                    <h2 id="otp-title">Enter code<span>.</span></h2>

                    <p>
                        Enter the 6-digit code from your email.
                        The code expires after 10 minutes.
                    </p>
                </header>

                <!-- We will connect this form to OTP verification next. -->
                <form action="{{ route('password.verify') }}" method="POST">
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
                            pattern="[0-9]{6}"
                            title="Enter exactly 6 numbers"
                            type="text"
                            id="otp"
                            name="otp"
                            value="{{ old('otp') }}"
                            placeholder="Enter 6-digit code"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            maxlength="6"
                            required
                            class="@error('otp') input-invalid @enderror"
                            pattern="[0-9]{6}"
                            title="Enter exactly 6 numbers">

                        @error('otp')
                        <p class="input-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="sign-in" type="submit">
                        Verify code
                    </button>
                </form>

                <p class="register">
                    Didn’t receive a code?
                    <a href="{{ route('password.request') }}">Try again</a>
                </p>

            </div>
        </section>

    </main>
    <script>
        const otpInput = document.getElementById('otp');

        otpInput.addEventListener('input', () => {
            otpInput.value = otpInput.value.replace(/\D/g, '').slice(0, 6);
        });
    </script>
</body>

</html>