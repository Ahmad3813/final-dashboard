@extends('layouts.parts.app')

@section('title', 'Tasks')

@section('content')
<section class="tasks-page">
    <header class="tasks-header">
        <div>
            <p class="tasks-eyebrow">WORKSPACE / TASKS</p>
            <h1>Task management</h1>
            <p class="tasks-subtitle">
                Track assignments, time, and the people behind every task.
            </p>
        </div>

        @if ($user->isSuperAdmin() || $user->isQA())
        <a href="{{ route('admin.tasks.create') }}" class="tasks-create-button">
            <span class="tasks-create-icon">+</span>
            Create task
        </a>
        @endif

    </header>

    <div class="tasks-overview">
        <div class="tasks-overview-icon">✦</div>

        <div>
            <strong>Everything in one place</strong>
            <p>
                Review the work assigned to your team and keep each task moving.
            </p>
        </div>

        <span class="tasks-overview-label">TEAM WORKSPACE</span>
    </div>

    <section class="tasks-panel">
        <div class="tasks-panel-header">
            <div>
                <h2>All tasks</h2>
                <p>A clear view of assignments and their progress.</p>
            </div>

            <span class="tasks-count">{{ $tasks->count() }} {{ $tasks->count() === 1 ? 'task' : 'tasks' }}</span>
        </div>

        <div class="tasks-table-scroll">
            <table class="tasks-table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Duration</th>
                        <th>Assigned to</th>
                        <th>Assignee role</th>
                        <th>Added by</th>
                        <th>Creator role</th>
                        <th>Comment</th>
                        <th class="tasks-actions-heading">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tasks as $task)
                    <tr>
                        <td>
                            <div class="tasks-name-cell">
                                <span class="tasks-id-mark">Task #{{ $task->id }}</span>
                                <strong>{{ $task->name }}</strong>
                            </div>
                        </td>

                        <td>
                            <span class="tasks-duration">{{ $task->duration_hours }} <small>hours</small></span>
                        </td>

                        <td>
                            <div class="tasks-person">
                                <span class="tasks-avatar tasks-avatar-orange">{{ mb_strtoupper(mb_substr($task->assignee->name, 0, 1)) }}</span>
                                <span>{{ $task->assignee->name }}</span>
                            </div>
                        </td>

                        <td>
                            <span class="tasks-role tasks-role-{{ str_replace('_', '-', $task->assignee->role) }}">
                                <span class="tasks-role-dot"></span>
                                {{ ucwords(str_replace('_', ' ', $task->assignee->role)) }}
                            </span>
                        </td>

                        <td>
                            <div class="tasks-person">
                                <span class="tasks-avatar tasks-avatar-purple">{{ mb_strtoupper(mb_substr($task->addedBy->name, 0, 1)) }}</span>
                                <span>{{ $task->addedBy->name }}</span>
                            </div>
                        </td>

                        <td>
                            <span class="tasks-role tasks-role-{{ str_replace('_', '-', $task->addedBy->role) }}">
                                <span class="tasks-role-dot"></span>
                                {{ ucwords(str_replace('_', ' ', $task->addedBy->role)) }}
                            </span>
                        </td>

                        <td>
                            <span class="tasks-comment {{ blank($task->comment) ? 'tasks-comment-empty' : '' }}" title="{{ $task->comment }}">
                                {{ filled($task->comment) ? $task->comment : 'No comment' }}
                            </span>
                        </td>

                        <td>
                            <div class="tasks-actions">
                                <a href="{{ route('admin.tasks.show', $task->id) }}" class="tasks-action-show">
                                    <span aria-hidden="true">↗</span> Show
                                </a>

                                @if ($user->isTester() || $user->isQA())
                                <a href="{{ route('admin.tasks.edit', $task->id) }}" class="tasks-action-edit">
                                    Edit
                                </a>
                                @endif

                                @if ($user->isQA())
                                <form action="{{ route('admin.tasks.destroy', $task->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="tasks-action-delete">Delete</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="tasks-empty">No tasks yet. Create the first task to see it here.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </section>

</section>
@endsection