@extends('layouts.parts.school_layout')

@section('title', 'Student details')
@section('topbar', 'Students')

@section('content')
<div class="school-page">
    <header class="school-page-heading">
        <div>
            <h1>{{ $student->name }}</h1>
            <p>{{ $student->user?->email ?? 'No email' }}</p>
        </div>

        <a href="{{ route('school.students.index') }}"
            class="school-secondary-action">Back to students</a>
    </header>

    <section class="school-panel school-assignments">
        <div class="school-panel-header">
            <h2>Classroom: {{ $student->classroom?->name ?? 'Not assigned' }}</h2>
        </div>

        <div class="school-table-wrap">
            <table class="school-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Teacher</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($student->classroom?->courses ?? collect() as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $teachers[$course->pivot->teacher_id] ?? 'Not assigned' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2">No courses assigned yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection