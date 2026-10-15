@extends('layouts.parts.school_layout')

@section('title', 'Teachers')
@section('topbar', 'Teachers')

@section('content')
<div class="school-page">
    <header class="school-page-heading">
        <div>
            <h1>Teachers</h1>
            <p>View teachers, their courses, and assigned classrooms.</p>
        </div>

        <a href="{{ route('school.add-teacher') }}"
            class="school-primary-action"
            style="text-decoration: none;">
            <span aria-hidden="true">＋</span> Add teacher
        </a>
    </header>

    <section class="school-panel school-assignments" aria-labelledby="teachers-title">
        <div class="school-panel-header">
            <h2 id="teachers-title">Teacher list</h2>
        </div>

        <div class="school-table-wrap">
            <table class="school-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Classrooms</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->user?->email ?? '—' }}</td>
                        <td>{{ $teacher->course?->name ?? '—' }}</td>
                        <td>{{ $teacher->classrooms->pluck('name')->join(', ') ?: '—' }}</td>
                        <td>
                            <div class="school-teacher-actions">
                                <a href="{{ route('school.teachers.show', $teacher->id) }}"
                                    class="school-teacher-show">Show</a>

                                <form action="{{ route('school.teachers.destroy', $teacher->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this teacher and their account?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="school-delete-button">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="school-table-empty">
                            No teachers yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection