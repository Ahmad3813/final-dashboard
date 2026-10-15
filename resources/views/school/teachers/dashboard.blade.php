<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/web/css/teacher.css') }}">
</head>

<body>
    <div class="teacher-layout" id="overview">
        <aside class="teacher-sidebar">
            <div class="teacher-brand">
                <span aria-hidden="true">✦</span>
                School Management
            </div>

            <nav class="teacher-nav" aria-label="Teacher navigation">
                <a href="#overview" class="active" aria-current="page">
                    Overview
                </a>
                <a href="#classrooms">My classrooms</a>
            </nav>

            <form class="teacher-logout-form"
                action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="teacher-logout" type="submit">
                    Log out
                </button>
            </form>
        </aside>

        <div class="teacher-content">
            <header class="teacher-topbar">
                <strong>Teacher dashboard</strong>

                <div class="teacher-account">
                    <span class="teacher-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </header>

            <main class="teacher-main">
                <section class="teacher-welcome">
                    <div>
                        <h1>Welcome, {{ auth()->user()->name }}</h1>
                        <p>Your teaching overview.</p>
                    </div>

                    <div class="teacher-welcome-mark" aria-hidden="true">✦</div>
                </section>

                <div class="teacher-grid">
                    <section class="teacher-panel teacher-subject">
                        <div class="teacher-panel-heading">
                            <span class="teacher-panel-icon" aria-hidden="true">▤</span>
                            <h2>My subject</h2>
                        </div>

                        <strong class="teacher-subject-name">
                            {{ auth()->user()->teacher?->course?->name
                                ?? 'No subject assigned yet' }}
                        </strong>
                        <p>Your subject is assigned by the school admin.</p>
                    </section>

                    <section class="teacher-panel teacher-profile">
                        <h2>My account</h2>

                        <div class="teacher-detail">
                            <span>Name</span>
                            <strong>{{ auth()->user()->name }}</strong>
                        </div>

                        <div class="teacher-detail">
                            <span>Email</span>
                            <strong>{{ auth()->user()->email }}</strong>
                        </div>

                        <div class="teacher-detail">
                            <span>Role</span>
                            <strong>Teacher</strong>
                        </div>
                    </section>
                </div>

                <section class="teacher-panel teacher-classrooms"
                    id="classrooms">
                    <div class="teacher-section-heading">
                        <div>
                            <h2>My classrooms</h2>
                            <p>Classrooms assigned to you by the school admin.</p>
                        </div>
                    </div>

                    <div class="teacher-classroom-list">
                        @forelse (auth()->user()->teacher?->classrooms ?? [] as $classroom)
                        <div class="teacher-classroom-row">
                            <span class="teacher-classroom-icon"
                                aria-hidden="true">▦</span>

                            <div>
                                <strong>{{ $classroom->name }}</strong>
                                <span>
                                    {{ $classroom->class_year }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="teacher-empty">
                            No classrooms assigned yet.
                        </p>
                        @endforelse
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>

</html>