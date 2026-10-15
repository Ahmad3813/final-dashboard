@extends('layouts.parts.school_layout')

@section('title', 'Courses')
@section('topbar', 'Courses')

@section('content')
<div class="school-page">
    <header class="school-page-heading">
        <div>
            <h1>Courses</h1>
            <p>View and manage the school's courses.</p>
        </div>

        <a href="{{ route('school.create-course') }}"
            class="school-primary-action"
            style="text-decoration: none;">
            <span aria-hidden="true">＋</span> Add course
        </a>
    </header>

    <section class="school-panel school-assignments" aria-labelledby="courses-title">
        <div class="school-panel-header">
            <h2 id="courses-title">Course list</h2>
        </div>

        <div class="school-table-wrap">
            <table class="school-table">
                <thead>
                    <tr>
                        <th>Course name</th>
                        <th>Teachers</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->teachers->pluck('name')->join(', ') ?: 'Not assigned' }}</td>
                        <td>
                            <form action="{{ route('school.courses.destroy', $course->id) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this course?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="school-delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="school-table-empty">No courses yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection