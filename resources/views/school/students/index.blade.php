@extends('layouts.parts.school_layout')

@section('title', 'Students')
@section('topbar', 'Students')

@section('content')
<div class="school-page">
    <header class="school-page-heading">
        <div>
            <h1>Students</h1>
            <p>View students and the classrooms assigned to them.</p>
        </div>

        <a href="{{ route('school.students.create') }}"
            class="school-primary-action"
            style="text-decoration: none;">
            <span aria-hidden="true">＋</span> Add student
        </a>
    </header>

    <section class="school-panel school-assignments" aria-labelledby="students-title">
        <div class="school-panel-header">
            <h2 id="students-title">Student list</h2>
        </div>

        <div class="school-table-wrap">
            <table class="school-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Classroom</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->user?->email ?? '—' }}</td>
                        <td>{{ $student->classroom?->name ?? '—' }}</td>
                        <td>
                            <div class="school-student-actions">
                                <a href="{{ route('school.students.show', $student->id) }}"
                                    class="school-student-show">Show</a>

                                <form action="{{ route('school.students.destroy', $student->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this student and their account?')">
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
                            No students yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection