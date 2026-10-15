<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/web/css/student.css') }}">
</head>

<body>
    <div class="student-layout">
        <aside class="student-sidebar">
            <div class="student-brand">
                <span aria-hidden="true">✦</span> School Management
            </div>

            <nav class="student-nav" aria-label="Student navigation">
                <a href="{{ route('student.dashboard') }}"
                    class="active" aria-current="page">Overview</a>
            </nav>

            <form class="student-logout-form"
                action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="student-logout" type="submit">
                    ↪ Log out
                </button>
            </form>
        </aside>

        <div class="student-content">
            <header class="student-topbar">
                <strong>Student dashboard</strong>

                <div class="student-account">
                    <span class="student-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </header>

            <main class="student-main">
                <section class="student-welcome">
                    <h1>Welcome, {{ auth()->user()->name }}</h1>
                    <p>Here is your school information.</p>
                </section>

                <div class="student-panels">
                    <section class="student-panel">
                        <h2>My classroom</h2>

                        <p class="student-classroom-name">
                            {{ auth()->user()->student?->classroom?->name
                                ?? 'Not assigned yet' }}
                        </p>

                        <p class="student-muted">
                            Your classroom is assigned by the school admin.
                        </p>
                    </section>

                    <section class="student-panel">
                        <h2>My account</h2>

                        <div class="student-detail">
                            <span>Name</span>
                            <strong>{{ auth()->user()->name }}</strong>
                        </div>

                        <div class="student-detail">
                            <span>Email</span>
                            <strong>{{ auth()->user()->email }}</strong>
                        </div>

                        <div class="student-detail">
                            <span>Role</span>
                            <strong>Student</strong>
                        </div>
                    </section>
                </div>
                <section class="student-panel student-classes">
                    <h2>My classes</h2>

                    @forelse ($courses as $course)
                    <div class="student-class-row">
                        <strong>{{ $course->name }}</strong>
                        <span>Teacher: {{ $course->teacher_name }}</span>
                    </div>
                    @empty
                    <p class="student-muted">No classes assigned to your classroom yet.</p>
                    @endforelse
                </section>
            </main>
        </div>
    </div>
</body>

</html>