<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'User Dashboard')</title>

    <link rel="stylesheet" href="{{ asset('assets/web/css/dashboard.css') }}">
</head>

<body>
    <div class="overlay" id="overlay"></div>

    <aside class="sidebar">
        <div class="sidebar-top">
            <a class="sidebar-brand" href="{{ route('dashboard') }}">
                <span class="brand-icon">U.</span>
                <span>User Dashboard</span>
            </a>

            <button class="close-menu" id="close-menu" type="button" aria-label="Close menu">
                ×
            </button>
        </div>

        <nav class="sidebar-menu">
            <a
                class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                href="{{ route('dashboard') }}">
                Dashboard
            </a>

            <a
                class="menu-link {{ request()->routeIs('blog') ? 'active' : '' }}"
                href="{{ route('blog') }}">
                My Blogs
            </a>

            <a class="menu-link" href="{{ route('view-profile') }}">
                My Profile
            </a>

            <a class="menu-link" href="#">
                Settings
            </a>
            @if (auth()->check() && auth()->user()->isSuperAdmin())
            <a
                href="{{ route('admin.users.index') }}"
                class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                User Management
            </a>
            @endif

            @auth
            @if (auth()->user()->isAdmin() || auth()->user()->isQA() || auth()->user()->isTester())
            <a
                href="{{ route('admin.tasks.index') }}"
                class="menu-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                Tasks
            </a>
            @endif
            @endauth
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button class="menu-link logout-button" type="submit">
                    Log out
                </button>
            </form>
        </div>
    </aside>

    <div class="workspace">
        <header class="navbar">
            <div class="navbar-left">
                <button class="open-menu" id="open-menu" type="button" aria-label="Open menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <h2 class="navbar-title">@yield('title', 'Dashboard')</h2>
            </div>

            <div class="navbar-right">
                @auth
                <div class="navbar-account">
                    <div class="navbar-account-details">
                        <div class="navbar-account-top">
                            <span class="user-name">{{ auth()->user()->name }}</span>

                            @if (auth()->user()->isSuperAdmin())
                            <span class="role-badge role-super-admin">
                                <span class="role-dot"></span>
                                Super Admin
                            </span>
                            @elseif (auth()->user()->isAdmin())
                            <span class="role-badge role-admin">
                                <span class="role-dot"></span>
                                Admin
                            </span>
                            @elseif (auth()->user()->isUser())
                            <span class="role-badge role-user">
                                <span class="role-dot"></span>
                                User
                            </span>
                            @elseif (auth()->user()->isQA())
                            <span class="role-badge role-qa">
                                <span class="role-dot"></span>
                                QA
                            </span>
                            @elseif (auth()->user()->isTester())
                            <span class="role-badge role-tester">
                                <span class="role-dot"></span>
                                Tester
                            </span>
                            @endif
                        </div>

                        <span class="user-email">
                            {{ auth()->user()->email }}
                        </span>
                    </div>

                    <span class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
                @endauth
            </div>
        </header>

        <main class="main-content">
            <section class="page-section">
                @yield('content')
            </section>
        </main>
    </div>

    <script>
        const body = document.body;
        const openMenu = document.getElementById('open-menu');
        const closeMenu = document.getElementById('close-menu');
        const overlay = document.getElementById('overlay');
        const menuLinks = document.querySelectorAll('.menu-link');

        openMenu.addEventListener('click', () => {
            body.classList.add('menu-open');
        });

        closeMenu.addEventListener('click', () => {
            body.classList.remove('menu-open');
        });

        overlay.addEventListener('click', () => {
            body.classList.remove('menu-open');
        });

        menuLinks.forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    body.classList.remove('menu-open');
                }
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                body.classList.remove('menu-open');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>