<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account | User Dashboard</title>

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
                <p class="eyebrow">GET STARTED</p>

                <h1>Your journey<br>starts here.</h1>

                <p class="brand-description">
                    Create your account to manage your profile,
                    write blog posts, and share your ideas.
                </p>
            </div>

            <p class="copyright">
                © {{ date('Y') }} User Dashboard
            </p>
        </aside>

        <!-- Right side -->
        <section class="form-panel" aria-labelledby="register-title">
            <div class="login-card">

                <header class="heading">
                    <h2 id="register-title">Create account<span>.</span></h2>
                    <p>Enter your details to get started.</p>
                </header>

                <!-- Frontend only. Connect to your registration route later. -->
                <form action="{{ route('register.store') }}" method="POST">
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
    <label for="name">Full name</label>

    <input
        type="text"
        id="name"
        name="name"
        value="{{ old('name') }}"
        placeholder="Enter your full name"
        autocomplete="name"
        required
        class="@error('name') input-invalid @enderror"
    >

    @error('name')
        <p class="input-error">{{ $message }}</p>
    @enderror
</div>

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
        class="@error('email') input-invalid @enderror"
    >

    @error('email')
        <p class="input-error">{{ $message }}</p>
    @enderror
</div>

<div class="field">
    <label for="password">Password</label>

    <input
        type="password"
        id="password"
        name="password"
        placeholder="Create a password"
        autocomplete="new-password"
        required
        class="@error('password') input-invalid @enderror"
    >

    <p class="field-help">
        Use 8+ characters with uppercase, lowercase, a number, and a special character.
    </p>

    @error('password')
        <p class="input-error">{{ $message }}</p>
    @enderror
</div>

<div class="field">
    <label for="password_confirmation">Confirm password</label>

    <input
        type="password"
        id="password_confirmation"
        name="password_confirmation"
        placeholder="Re-enter your password"
        autocomplete="new-password"
        required
        class="@error('password_confirmation') input-invalid @enderror"
    >

    @error('password_confirmation')
        <p class="input-error">{{ $message }}</p>
    @enderror
</div>

                    <!-- Change to type="submit" after connecting the backend. -->
                    <button class="sign-in" type="submit">
                        Create Account
                    </button>
                </form>

                <p class="register">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </p>

            </div>
        </section>

    </main>
</body>

</html>