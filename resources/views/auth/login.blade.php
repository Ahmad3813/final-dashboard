<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign In | User Dashboard</title>

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
                <p class="eyebrow">WELCOME BACK</p>

                <h1>Your dashboard.<br>Your space.</h1>

                <p class="brand-description">
                    Manage your account, write blog posts,
                    and keep everything in one place.
                </p>
            </div>

            <p class="copyright">
                © {{ date('Y') }} User Dashboard
            </p>
        </aside>

        <!-- Right side -->
        <section class="form-panel" aria-labelledby="login-title">
            <div class="login-card">

                <header class="heading">
                    <h2 id="login-title">Sign in<span>.</span></h2>
                    <p>Sign in to access your dashboard.</p>
                </header>

                <!-- Connect the action to your login route when adding the backend. -->
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <div class="field">
                        <label for="email">Gmail address</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@gmail.com"
                            autocomplete="username"
                            pattern="[A-Za-z0-9._%+-]+@gmail\.com"
                            title="Use an email ending with @gmail.com"
                            required
                            class="@error('email') input-invalid @enderror">

                        @error('email')
                        <p class="input-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="label-row">
                            <label for="password">Password</label>

                            <a href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        </div>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                            class="@error('password') input-invalid @enderror">

                        @error('password')
                        <p class="input-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="remember">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1">

                        <span>Remember me</span>
                    </label>

                    <!-- Change to type="submit" after connecting the backend. -->
                    <button class="sign-in" type="submit">
                        Sign In
                    </button>
                </form>

                <p class="register">
                    Don’t have an account?
                    <a href="{{ route('register') }}">Create an account</a>
                </p>

            </div>
        </section>

    </main>
</body>

</html>