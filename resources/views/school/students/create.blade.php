@extends('layouts.parts.school_layout')

@section('title', 'Add student')
@section('topbar', 'Students')

@section('content')
<div class="school-page">
    <header class="school-page-heading">
        <div>
            <p class="school-teacher-eyebrow">STUDENTS / NEW</p>
            <h1>Add student</h1>
            <p>Create a student account and assign a classroom.</p>
        </div>
    </header>

    <div class="school-teacher-grid">
        <section class="school-panel school-teacher-form-panel">
            <div class="school-panel-header">
                <h2>Student details</h2>
            </div>

            <form class="school-teacher-form" action="{{route('school.students.store')}}" method="POST">
                @csrf

                <div class="school-form-field">
                    <label for="name">Student name <span>*</span></label>
                    <input id="name" name="name" type="text"
                        value="{{ old('name') }}" required>
                    @error('name') <small>{{ $message }}</small> @enderror
                </div>

                <div class="school-form-field">
                    <label for="email">Email <span>*</span></label>
                    <input id="email" name="email" type="email"
                        value="{{ old('email') }}" required>
                    @error('email') <small>{{ $message }}</small> @enderror
                </div>

                <div class="school-form-field">
                    <label for="password">Password <span>*</span></label>
                    <input id="password" name="password" type="password"
                        autocomplete="new-password" required>
                    @error('password') <small>{{ $message }}</small> @enderror
                </div>

                <div class="school-form-field">
                    <label for="classroom_id">Classroom <span>*</span></label>
                    <select id="classroom_id" name="classroom_id" required>
                        <option value="">Choose a classroom</option>
                        @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}"
                            @selected(old('classroom_id')==$classroom->id)>
                            {{ $classroom->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('classroom_id') <small>{{ $message }}</small> @enderror
                </div>

                <div class="school-teacher-form-actions">
                    <a href="{{ route('school.students.index') }}"
                        class="school-secondary-action">Cancel</a>
                    <button class="school-primary-action" type="submit">
                        Add student
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection