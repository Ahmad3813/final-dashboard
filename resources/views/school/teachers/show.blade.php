@extends('layouts.parts.school_layout')

@section('title', 'Teacher details')
@section('topbar', 'Teachers')

@section('content')
<div class="school-page">
    <header class="school-page-heading">
        <div>
            <h1>{{ $teacher->name }}</h1>
            <p>Teacher details and assigned classrooms.</p>
        </div>

        <a href="{{ route('school.teachers.index') }}"
           class="school-secondary-action">Back to teachers</a>
    </header>

    <section class="school-panel school-assignments">
        <div class="school-panel-header">
            <h2>Teacher details</h2>
        </div>

        <div class="school-table-wrap">
            <table class="school-table">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $teacher->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $teacher->user?->email ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td>{{ $teacher->course?->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Classrooms</th>
                        <td>{{ $teacher->classrooms->pluck('name')->join(', ') ?: 'Not assigned' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection