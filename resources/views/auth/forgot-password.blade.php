<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password | User Dashboard</title>

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
                <p class="eyebrow">PASSWORD RECOVERY</p>

                <h1>Reset your<br>password.</h1>

                <p class="brand-description">
                    Enter your email address and we will send you
                    a verification code to reset your password.
                </p>
            </div>

            <p class="copyright">
                © {{ date('Y') }} User Dashboard
            </p>
        </aside>

        <!-- Right side -->
        <section class="form-panel" aria-labelledby="forgot-title">
            <div class="login-card">

                <header class="heading">
                    <h2 id="forgot-title">Forgot password<span>.</span></h2>

                    <p>
                        Enter the email address associated with your account.
                    </p>
                </header>

                <!-- We will connect this form to the POST route next. -->
                <form action="{{ route('password.email') }}" method="POST">
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
                        <label for="email">Gmail address</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@gmail.com"
                            autocomplete="email"
                            required
                            class="@error('email') input-invalid @enderror">

                        @error('email')
                        <p class="input-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="sign-in" type="submit">
                        Send verification code
                    </button>
                </form>

                <p class="register">
                    Remember your password?
                    <a href="{{ route('login') }}">Sign in</a>
                </p>

            </div>
        </section>

    </main>
</body>

</html>