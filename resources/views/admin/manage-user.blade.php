@extends('layouts.parts.app')

@section('title', 'Manage User')

@section('content')

<section class="manage-user-page">
    <header class="manage-user-header">
        <div>
            <span class="admin-page-kicker">USER ACCESS CONTROL</span>
            <h1>Manage user</h1>
            <p>Review account details and choose the appropriate access role.</p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="admin-back-button">
            ← Back to users
        </a>
    </header>

    <div class="manage-user-layout">
        <aside class="manage-user-summary">
            <div class="manage-user-avatar">
                A
            </div>

            <span class="manage-user-label">MANAGING ACCOUNT</span>
            <h2>User name</h2>
            <p>{{ $user->email }}</p>

            <div class="manage-user-id">
                <span>Account ID</span>
                <strong>{{ $user->id }}</strong>
            </div>

            <div class="manage-user-active">
                <span></span>
                Account active
            </div>
        </aside>

        <section class="manage-user-content">
            <div class="manage-user-content-heading">
                <h2>Choose account role</h2>
                <p>Each role has a different level of access in the dashboard.</p>
            </div>

            <form
                class="manage-role-form"
                action="{{ route('admin.users.update-role', [$user->id]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <label class="role-choice-card">
                    <input type="radio" name="role" value="user">

                    <span class="role-choice-icon role-choice-user-icon">●</span>

                    <span class="role-choice-content">
                        <strong>User</strong>
                        <small>Can manage their profile and personal blog posts.</small>
                    </span>

                    <span class="role-choice-check">✓</span>
                </label>

                <label class="role-choice-card">
                    <input type="radio" name="role" value="admin">

                    <span class="role-choice-icon role-choice-admin-icon">◆</span>

                    <span class="role-choice-content">
                        <strong>Admin</strong>
                        <small>Can manage dashboard content and blog posts.</small>
                    </span>

                    <span class="role-choice-check">✓</span>
                </label>

                <label class="role-choice-card">
                    <input type="radio" name="role" value="super_admin">

                    <span class="role-choice-icon role-choice-super-icon">✦</span>

                    <span class="role-choice-content">
                        <strong>Super Admin</strong>
                        <small>Has complete dashboard access and manages user roles.</small>
                    </span>

                    <span class="role-choice-check">✓</span>
                </label>

                <label class="role-choice-card role-choice-qa">
                    <input
                        type="radio"
                        name="role"
                        value="qa">

                    <span class="role-choice-icon role-choice-qa-icon">✓</span>

                    <span class="role-choice-content">
                        <strong>QA <span class="role-choice-tag">Full control</span></strong>
                        <small>View, create, edit, and delete tasks.</small>
                    </span>

                    <span class="role-choice-check">✓</span>
                </label>

                <label class="role-choice-card role-choice-tester">
                    <input
                        type="radio"
                        name="role"
                        value="tester">

                    <span class="role-choice-icon role-choice-tester-icon">⌁</span>

                    <span class="role-choice-content">
                        <strong>Tester <span class="role-choice-tag">Review & edit</span></strong>
                        <small>View and edit tasks.</small>
                    </span>

                    <span class="role-choice-check">✓</span>
                </label>

                <label class="role-choice-card">
                    <input type="radio" name="role" value="school_admin"
                        @checked(old('role', $user->role) === 'school_admin')>

                    <span class="role-choice-icon">◆</span>
                    <span class="role-choice-content">
                        <strong>School Admin</strong>
                        <small>Manages classrooms, courses, teachers, students, and assignments.</small>
                    </span>
                    <span class="role-choice-check">✓</span>
                </label>

                <label class="role-choice-card">
                    <input type="radio" name="role" value="teacher"
                        @checked(old('role', $user->role) === 'teacher')>

                    <span class="role-choice-icon">●</span>
                    <span class="role-choice-content">
                        <strong>Teacher</strong>
                        <small>Views assigned classrooms and courses.</small>
                    </span>
                    <span class="role-choice-check">✓</span>
                </label>

                <label class="role-choice-card">
                    <input type="radio" name="role" value="student"
                        @checked(old('role', $user->role) === 'student')>

                    <span class="role-choice-icon">●</span>
                    <span class="role-choice-content">
                        <strong>Student</strong>
                        <small>Views their classroom and courses.</small>
                    </span>
                    <span class="role-choice-check">✓</span>
                </label>

                <div id="teacher-record-field" hidden>
                    <label for="teacher_id">Teacher record</label>
                    <select id="teacher_id" name="teacher_id">
                        <option value="">Select a teacher</option>
                        @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            @selected(old('teacher_id', $user->teacher?->id) == $teacher->id)>
                            {{ $teacher->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                    <p>{{ $message }}</p>
                    @enderror
                </div>

                <div id="student-record-field" hidden>
                    <label for="student_id">Student record</label>
                    <select id="student_id" name="student_id">
                        <option value="">Select a student</option>
                        @foreach ($students as $student)
                        <option value="{{ $student->id }}"
                            @selected(old('student_id', $user->student?->id) == $student->id)>
                            {{ $student->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('student_id')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="manage-role-warning">
                    <span>!</span>
                    <p>Changing a role affects what this account can access.</p>
                </div>

                <footer class="manage-role-actions">
                    <a href="{{ route('admin.users.index') }}" class="manage-cancel-button">
                        Cancel
                    </a>

                    <button type="submit" class="manage-save-button">
                        Save role changes
                    </button>
                </footer>
            </form>
            <script>
                const roleInputs = document.querySelectorAll('input[name="role"]');
                const teacherField = document.getElementById('teacher-record-field');
                const studentField = document.getElementById('student-record-field');
                const teacherSelect = document.getElementById('teacher_id');
                const studentSelect = document.getElementById('student_id');

                function updateRecordFields() {
                    const role = document.querySelector('input[name="role"]:checked')?.value;

                    teacherField.hidden = role !== 'teacher';
                    studentField.hidden = role !== 'student';

                    teacherSelect.disabled = role !== 'teacher';
                    studentSelect.disabled = role !== 'student';
                }

                roleInputs.forEach(input => input.addEventListener('change', updateRecordFields));
                updateRecordFields();
            </script>
        </section>
    </div>
</section>

@endsection