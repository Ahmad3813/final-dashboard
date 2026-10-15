@extends('layouts.parts.school_layout')

@section('title', 'School overview')

@section('content')
<div class="school-page">
    <header class="school-page-heading">
        <div>
            <h1>School overview</h1>
            <p>Manage your classrooms, courses, teachers, students, and teaching assignments.</p>
        </div>
        <button class="school-primary-action" type="button" disabled title="Assignment form coming next"><span aria-hidden="true">＋</span> New assignment</button>
    </header>

    <section class="school-stats" aria-label="School totals">
        @foreach ([['classrooms', 'Classrooms', 'blue', '▦'], ['courses', 'Courses', 'green', '▤'], ['teachers', 'Teachers', 'purple', '♙'], ['students', 'Students', 'orange', '♧']] as [$key, $label, $tone, $icon])
        <article class="school-stat">
            <span class="school-stat-icon {{ $tone }}" aria-hidden="true">{{ $icon }}</span>
            <div><span>{{ $label }}</span><strong>{{ number_format($counts[$key]) }}</strong></div>
        </article>
        @endforeach
    </section>

    <div class="school-content-grid">

        <div class="school-side-panels">
            <section class="school-panel school-quick" aria-labelledby="quick-title">
                <div class="school-panel-header">
                    <h2 id="quick-title">Quick actions</h2>
                </div>
                <a href="{{ route('school.create-classroom') }}" class="school-quick-link">
                    <span class="school-quick-icon blue" aria-hidden="true">▦</span>
                    Add classroom
                    <span class="school-quick-arrow" aria-hidden="true">›</span>
                </a> <a href="{{ route('school.create-course') }}" class="school-quick-link">
                    <span class="school-quick-icon green" aria-hidden="true">▤</span> Add course
                    <span class="school-quick-arrow" aria-hidden="true">›</span></a>
                <a href="{{ route('school.add-teacher') }}" class="school-quick-link">
                    <span class="school-quick-icon purple" aria-hidden="true">♙</span>
                    Add teacher
                    <span class="school-quick-arrow" aria-hidden="true">›</span>
                </a>
            </section>
            <section class="school-panel school-snapshot" aria-labelledby="snapshot-title">
                <div class="school-panel-header">
                    <h2 id="snapshot-title">Classroom snapshot</h2>
                </div>
                @forelse ($classrooms as $classroom)
                <div class="school-snapshot-row"><span>{{ $classroom->name }}</span><span>{{ $classroom->students_count }} {{ \Illuminate\Support\Str::plural('student', $classroom->students_count) }}</span></div>
                @empty
                <p class="school-snapshot-empty">No classrooms yet.</p>
                @endforelse

        </div>
    </div>
</div>
@endsection