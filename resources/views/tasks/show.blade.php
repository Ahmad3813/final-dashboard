@extends('layouts.parts.app')

@section('title', 'Task Details')

@section('content')
<section class="task-create-page">
    <header class="task-create-header">
        <div>
            <p class="task-create-eyebrow">WORKSPACE / TASKS / DETAILS</p>
            <h1>{{ $task->name }}</h1>
            <p>Task #{{ $task->id }}</p>
        </div>

        <a href="{{ route('admin.tasks.index') }}" class="task-create-back">
            ← Back to tasks
        </a>
    </header>

    <div class="task-create-layout">
        <aside class="task-create-side">
            <div class="task-create-side-icon">✦</div>
            <div>
                <span class="task-create-side-label">TASK SUMMARY</span>
                <h2>{{ $task->duration_hours }} hours</h2>
                <p>Planned duration for this assignment.</p>
            </div>
        </aside>

        <div class="task-create-card">
            <div class="task-create-card-heading">
                <span class="task-create-step">TASK #{{ $task->id }}</span>
                <h2>Assignment details</h2>
                <p>People and notes related to this task.</p>
            </div>

            <div class="task-create-form">
                <div class="task-create-field">
                    <label>Task name</label>
                    <p>{{ $task->name }}</p>
                </div>

                <div class="task-create-field-row">
                    <div class="task-create-field">
                        <label>Assigned to</label>
                        <p>{{ $task->assignee->name }} · {{ strtoupper($task->assignee->role) }}</p>
                    </div>

                    <div class="task-create-field">
                        <label>Added by</label>
                        <p>{{ $task->addedBy->name }} · {{ strtoupper($task->addedBy->role) }}</p>
                    </div>
                </div>

                <div class="task-create-field">
                    <label>Comment</label>
                    <p>{{ $task->comment ?: 'No comment added.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection