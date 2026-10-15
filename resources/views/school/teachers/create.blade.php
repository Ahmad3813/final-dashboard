@extends('layouts.parts.school_layout')

@section('title', 'Add teacher')
@section('topbar', 'Teachers')

@section('content')
<div class="school-page school-teacher-page">
    <header class="school-page-heading">
        <div>
            <p class="school-teacher-eyebrow">TEACHERS / NEW</p>
            <h1>Add teacher</h1>
            <p>Create a teacher record and choose the course they teach.</p>
        </div>
    </header>

    <div class="school-teacher-grid">
        <section class="school-panel school-teacher-form-panel">
            <div class="school-panel-header">
                <h2>Teacher details</h2>
            </div>

            <form class="school-teacher-form" action="{{ route('school.store-teacher') }}" method="POST">
                @csrf
                <div class="school-form-field">
                    <label for="name">Full name <span>*</span></label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        placeholder="e.g. Sara Ahmed"
                        autocomplete="name"
                        required>
                    <small>Use the teacher’s full name as it should appear in school records.</small>
                </div>

                <div class="school-form-field">
                    <label for="email">Email <span>*</span></label>
                    <input id="email" name="email" type="email"
                        value="{{ old('email') }}" required>
                    @error('email')
                    <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="school-form-field">
                    <label for="password">Password <span>*</span></label>
                    <input id="password" name="password" type="password"
                        minlength="8" autocomplete="new-password" required>
                    @error('password')
                    <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="school-form-field">
                    <label for="course_id">Course <span>*</span></label>
                    <select id="course_id" name="course_id" required>
                        <option value="">Select a course</option>
                        @foreach ($courses ?? [] as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                    <small>A teacher can be assigned to this course in multiple classrooms.</small>
                </div>

                <div class="school-teacher-form-actions">
                    <a href="{{ route('school.dashboard') }}" class="school-secondary-action">
                        Cancel
                    </a>
                    <button type="submit" class="school-primary-action"
                        title="Saving will be added next">
                        Add teacher
                    </button>
                </div>
            </form>
        </section>

        <aside class="school-panel school-teacher-help">
            <span class="school-teacher-help-icon" aria-hidden="true">♙</span>
            <h2>What happens next?</h2>
            <p>
                The new teacher will appear in the Teacher record list when a
                Super Admin assigns a user account the Teacher role.
            </p>
            <p>
                You can assign the teacher to a classroom separately under
                Teaching Assignments.
            </p>
        </aside>
    </div>
</div>
@endsection