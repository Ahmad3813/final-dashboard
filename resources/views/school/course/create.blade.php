@extends('layouts.parts.school_layout')

@section('title', 'Add course')
@section('topbar', 'Courses')

@section('content')
<div class="school-page school-teacher-page">
    <header class="school-page-heading">
        <div>
            <p class="school-teacher-eyebrow">COURSES / NEW</p>
            <h1>Add course</h1>
            <p>Create a new course for your school.</p>
        </div>
    </header>

    <div class="school-teacher-grid">
        <section class="school-panel school-teacher-form-panel">
            <div class="school-panel-header">
                <h2>Course details</h2>
            </div>

            <form method="post"  action="{{ route('school.store-course') }}" class="school-teacher-form">
                @csrf
                <div class="school-form-field">
                    <label for="name">Course name <span>*</span></label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        placeholder="e.g. Mathematics"
                        required>
                    <small>Enter the name that teachers and students will see.</small>
                </div>

                <div class="school-teacher-form-actions">
                    <a href="{{ route('school.dashboard') }}" class="school-secondary-action">
                        Cancel
                    </a>
                    <button type="submit" class="school-primary-action" >
                        Add course
                    </button>
                </div>
            </form>
        </section>

        <aside class="school-panel school-teacher-help">
            <span class="school-teacher-help-icon" aria-hidden="true">▤</span>
            <h2>What happens next?</h2>
            <p>After creating the course, you can select it when adding a teacher.</p>
        </aside>
    </div>
</div>
@endsection