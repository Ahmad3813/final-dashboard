<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'School Admin')</title>
    <link rel="stylesheet" href="{{ asset('assets/web/css/school.css') }}">
</head>

<body class="school-shell">
    <div class="school-overlay" id="school-overlay"></div>
    <aside class="school-sidebar" id="school-sidebar" aria-label="School navigation">
        <div class="school-brand">
            <span class="school-brand-mark" aria-hidden="true">✦</span>
            <span>School Management</span>
            <button class="school-close" type="button" id="school-close" aria-label="Close navigation">×</button>
        </div>
        <nav class="school-nav" aria-label="Primary">
            <span class="school-nav-label">SCHOOL ADMIN</span>
            <a href="{{ route('school.dashboard') }}"
                class="school-nav-link {{ request()->routeIs('school.dashboard') ? 'active' : '' }}"
                @if(request()->routeIs('school.dashboard')) aria-current="page" @endif>
                <span aria-hidden="true">⌂</span> Overview
            </a> <a href="{{ route('school.classrooms.index') }}"
                class="school-nav-link {{ request()->routeIs('school.classrooms.*') ? 'active' : '' }}">
                <span aria-hidden="true">▦</span> Classrooms
            </a> <a href="{{ route('school.courses.index') }}"
                class="school-nav-link {{ request()->routeIs('school.courses.*') ? 'active' : '' }}">
                <span aria-hidden="true">▤</span> Courses
            </a> <a href="{{ route('school.teachers.index') }}"
                class="school-nav-link {{ request()->routeIs('school.teachers.*') ? 'active' : '' }}">
                <span aria-hidden="true">♙</span> Teachers
            </a> <a class="school-nav-link {{ request()->routeIs('school.students.*') ? 'active' : '' }}"
                href="{{ route('school.students.index') }}">
                <span aria-hidden="true">♧</span> Students
            </a>
            <a href="{{ route('school.assignments.index') }}"
                class="school-nav-link {{ request()->routeIs('school.assignments.*') ? 'active' : '' }}">
                <span aria-hidden="true">▣</span> Teaching Assignments
            </a>
        </nav>
        <div class="school-sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="school-logout"><span aria-hidden="true">↪</span> Log out</button>
            </form>
        </div>
    </aside>
    <div class="school-workspace">
        <header class="school-topbar">
            <div class="school-topbar-left">
                <button class="school-menu" id="school-menu" type="button" aria-label="Open navigation" aria-controls="school-sidebar" aria-expanded="false">☰</button>
                <strong>@yield('topbar', 'School Admin')</strong>
            </div>
            <div class="school-account">
                <span class="school-account-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span>{{ auth()->user()->name }}</span>
            </div>
        </header>
        <main class="school-main">
            @yield('content')
        </main>
    </div>
    <script>
        const menu = document.getElementById('school-menu');
        const closeMenu = document.getElementById('school-close');
        const overlay = document.getElementById('school-overlay');

        function setSchoolMenu(open) {
            document.body.classList.toggle('school-menu-open', open);
            menu.setAttribute('aria-expanded', String(open));
        }
        menu.addEventListener('click', () => setSchoolMenu(true));
        closeMenu.addEventListener('click', () => setSchoolMenu(false));
        overlay.addEventListener('click', () => setSchoolMenu(false));
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') setSchoolMenu(false);
        });
    </script>
</body>

</html>