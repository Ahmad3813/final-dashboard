@extends('layouts.parts.app')

@section('title', 'Create Task')

@section('content')
<section class="task-create-page">
    <header class="task-create-header">
        <div>
            <p class="task-create-eyebrow">WORKSPACE / TASKS / NEW</p>
            <h1>Create task</h1>
            <p>Give the task a clear name, set its time, and choose who will work on it.</p>
        </div>

        <a href="{{ route('admin.tasks.index') }}" class="task-create-back">
            ← Back to tasks
        </a>
    </header>

    <div class="task-create-layout">
        <aside class="task-create-side">
            <div class="task-create-side-icon">✦</div>

            <div>
                <span class="task-create-side-label">NEW ASSIGNMENT</span>
                <h2>Make the next step clear.</h2>
                <p>
                    A good task tells your teammate what needs to be done,
                    how much time is planned, and any helpful context.
                </p>
            </div>

            <div class="task-create-side-footer">
                <span class="task-create-side-dot"></span>
                Ready to assign
            </div>
        </aside>

        <div class="task-create-card">
            <div class="task-create-card-heading">
                <span class="task-create-step">01 / TASK DETAILS</span>
                <h2>Task information</h2>
                <p>Fill in the details below to prepare the assignment.</p>
            </div>

            <form class="task-create-form" action="{{ route('admin.tasks.store') }}" method="POST">
                @csrf
                <div class="task-create-field">
                    <label for="task-name">Task name <span>*</span></label>
                    <input
                        id="task-name"
                        name="name"
                        type="text"
                        placeholder="e.g. Test the registration flow"
                        maxlength="255"
                        required>
                    <small>Use a short name that describes the work.</small>
                </div>

                <div class="task-create-field-row">
                    <div class="task-create-field">
                        <label for="task-duration">Duration in hours <span>*</span></label>
                        <div class="task-create-input-suffix">
                            <input
                                id="task-duration"
                                name="duration_hours"
                                type="number"
                                min="1"
                                step="1"
                                placeholder="4"
                                required>
                            <span>hours</span>
                        </div>
                    </div>

                    <div class="task-create-field">
                        <label for="task-assignee">Assign to <span>*</span></label>
                        <select id="task-assignee" name="assigned_to" required>
                            <option value="" selected disabled>Choose a team member</option>

                            {{-- Demo options: replace with users from the database --}}
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} · {{ $user->role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="task-create-field">
                    <label for="task-comment">
                        Comment <span class="task-create-optional">Optional</span>
                    </label>
                    <textarea
                        id="task-comment"
                        name="comment"
                        rows="5"
                        placeholder="Add instructions or anything your teammate should know..."></textarea>
                    <small>Leave this empty if the task needs no extra explanation.</small>
                </div>

                <div class="task-create-creator">
                    <div class="task-create-creator-avatar">A</div>
                    <div>
                        <strong>Added by your account</strong>
                        <span>The creator will be recorded when the task is saved.</span>
                    </div>
                    <span class="task-create-creator-check">✓</span>
                </div>

                <div class="task-create-actions">

                    <a href="{{ route('admin.tasks.index') }}" class="task-create-cancel">
                        Cancel
                    </a>


                    <button type="submit" class="task-create-submit">
                        Create task <span>→</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection