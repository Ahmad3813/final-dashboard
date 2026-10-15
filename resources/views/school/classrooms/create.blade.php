@extends('layouts.parts.school_layout')

@section('title', 'Add classroom')
@section('topbar', 'Classrooms')

@section('content')
<div class="school-page school-teacher-page">
    <header class="school-page-heading">
        <div>
            <p class="school-teacher-eyebrow">CLASSROOMS / NEW</p>
            <h1>Add classroom</h1>
            <p>Create a classroom for students and teaching assignments.</p>
        </div>
    </header>

    <div class="school-teacher-grid">
        <section class="school-panel school-teacher-form-panel">
            <div class="school-panel-header">
                <h2>Classroom details</h2>
            </div>

            <form class="school-teacher-form" action="{{ route('school.store-classroom') }}" method="POST">
                @csrf
                <div class="school-form-field">
                    <label for="name">Classroom name <span>*</span></label>
                    <input id="name" name="name" type="text"
                        value="{{ old('name') }}"
                        placeholder="e.g. Grade 2" required>
                </div>

                <div class="school-form-field">
                    <label for="capacity">Capacity <span>*</span></label>
                    <input id="capacity" name="capacity" type="number"
                        value="{{ old('capacity') }}"
                        min="1" placeholder="e.g. 30" required>
                    <small>Maximum number of students in this classroom.</small>
                </div>

                <div class="school-form-field">
                    <label for="class_year">School year <span>*</span></label>
                    <input id="class_year" name="class_year" type="text"
                        value="{{ old('class_year') }}"
                        placeholder="e.g. 2026–2027" required>
                </div>

                <div class="school-teacher-form-actions">
                    <a href="{{ route('school.dashboard') }}"
                        class="school-secondary-action">Cancel</a>
                    <button type="submit" class="school-primary-action">
                        Add classroom
                    </button>
                </div>
            </form>
        </section>

        <aside class="school-panel school-teacher-help">
            <span class="school-teacher-help-icon" aria-hidden="true">▦</span>
            <h2>What happens next?</h2>
            <p>You can place students in this classroom and assign teachers to teach courses there.</p>
        </aside>
    </div>
</div>
@endsection