@extends('layouts.parts.app')

@section('title', 'Edit Task')

@section('content')
<section class="task-create-page task-edit-page">
    <header class="task-create-header">
        <div>
            <p class="task-create-eyebrow">WORKSPACE / TASKS / EDIT</p>
            <h1>Edit task</h1>
            <p>Update the assignment details and keep everyone on the same page.</p>
        </div>

        <a href="{{ route('admin.tasks.index') }}" class="task-create-back">
            ← Back to tasks
        </a>
    </header>

    <div class="task-create-layout">
        <aside class="task-create-side task-edit-side">
            <div class="task-create-side-icon">✎</div>

            <div>
                <span class="task-create-side-label">TASK #{{ $task->id }}</span>
                <h2>{{ $task->name }}</h2>
                <p>
                    Review the current details, make your changes,
                    then save the updated task.
                </p>
            </div>

            <div class="task-create-side-footer">
                <span class="task-create-side-dot"></span>
                {{ $task->duration_hours }} planned hours
            </div>
        </aside>

        <div class="task-create-card">
            <div class="task-create-card-heading">
                <span class="task-create-step">01 / EDIT DETAILS</span>
                <h2>Task information</h2>
                <p>Fields marked * are required.</p>
            </div>

            @if ($errors->any())
            <div class="task-edit-errors" role="alert">
                <strong>Please check these details:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form
                class="task-create-form"
                action="{{ route('admin.tasks.update', $task->id) }}"
                method="POST">
                @csrf
                @method('PUT')
                @if ($user->isQA())
                <div class="task-create-field">
                    <label for="task-name">Task name <span>*</span></label>
                    <input
                        id="task-name"
                        name="name"
                        type="text"
                        value="{{ old('name', $task->name) }}"
                        maxlength="255"
                        required>
                    <small>Give the task a clear, short name.</small>
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
                                value="{{ old('duration_hours', $task->duration_hours) }}"
                                required>
                            <span>hours</span>
                        </div>
                    </div>

                    <div class="task-create-field">
                        <label for="task-assignee">Assign to <span>*</span></label>
                        <select id="task-assignee" name="assigned_to" required>
                            @foreach ($users as $assignee)
                            <option
                                value="{{ $assignee->id }}"
                                @selected(old('assigned_to', $task->assigned_to) == $assignee->id)>
                                {{ $assignee->name }} · {{ strtoupper($assignee->role) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                <div class="task-create-field">
                    <label for="task-comment">
                        Comment <span class="task-create-optional">Optional</span>
                    </label>
                    <textarea
                        id="task-comment"
                        name="comment"
                        rows="5"
                        placeholder="Add helpful context for this task...">{{ old('comment', $task->comment) }}</textarea>
                    <small>You can leave this empty.</small>
                </div>

                <div class="task-edit-note">
                    <span class="task-edit-note-icon">↻</span>
                    <div>
                        <strong>Updating task #{{ $task->id }}</strong>
                        <p>Your changes will be saved to this existing task.</p>
                    </div>
                </div>

                <div class="task-create-actions">
                    <a href="{{ route('admin.tasks.index') }}" class="task-create-cancel">
                        Cancel
                    </a>

                    <button type="submit" class="task-create-submit">
                        Save changes <span>→</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection