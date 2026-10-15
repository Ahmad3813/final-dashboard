@extends('layouts.parts.school_layout')

@section('title', 'Teaching Assignments')
@section('topbar', 'Teaching Assignments')

@section('content')
<div class="school-page school-teacher-page">
    <header class="school-page-heading">
        <div>
            <h1>Teaching Assignments</h1>
            <p>Choose which teacher teaches a course in each classroom.</p>
        </div>
    </header>

    <div class="school-teacher-grid">
        <section class="school-panel school-teacher-form-panel">
            <div class="school-panel-header">
                <h2>Add assignment</h2>
            </div>

            @if (session('success'))
            <p>{{ session('success') }}</p>
            @endif

            <form class="school-teacher-form"
                action="{{ route('school.assignments.store') }}"
                method="POST">
                @csrf

                <div class="school-form-field">
                    <label for="classroom_id">Classroom <span>*</span></label>
                    <select id="classroom_id" name="classroom_id" required>
                        <option value="">Select a classroom</option>
                        @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}"
                            @selected(old('classroom_id')==$classroom->id)>
                            {{ $classroom->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                    <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="school-form-field">
                    <label for="course_id">Course <span>*</span></label>
                    <select id="course_id" name="course_id" required>
                        <option value="">Select a course</option>
                        @foreach ($courses as $course)
                        <option value="{{ $course->id }}"
                            @selected(old('course_id')==$course->id)>
                            {{ $course->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('course_id')
                    <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="school-form-field">
                    <label for="teacher_id">Teacher <span>*</span></label>
                    <select id="teacher_id" name="teacher_id" required>
                        <option value="">Select a teacher</option>
                        @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            @selected(old('teacher_id')==$teacher->id)>
                            {{ $teacher->name }} — {{ $teacher->course?->name ?? 'No course' }}
                        </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                    <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="school-teacher-form-actions">
                    <a href="{{ route('school.dashboard') }}"
                        class="school-secondary-action">Cancel</a>
                    <button type="submit" class="school-primary-action">
                        Add assignment
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection