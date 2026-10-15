@extends('layouts.parts.app')

@section('title', 'User Management')

@section('content')
<section class="admin-users-page">
    <header class="admin-users-header">
        <div>
            <span class="admin-page-kicker">SUPER ADMIN CONTROL CENTER</span>
            <h1>User Management</h1>
            <p>View accounts and manage access roles across your dashboard.</p>
        </div>

        <a href="{{ route('dashboard') }}" class="admin-back-button">
            ← Back to dashboard
        </a>
    </header>

    @if (session('error'))
    <div class="admin-delete-alert" role="alert">
        <span class="admin-delete-alert-icon" aria-hidden="true">!</span>

        <div>
            <strong>User could not be deleted</strong>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <section class="admin-stats-grid">

        <article class="admin-stat-card admin-stat-total">
            <div class="admin-stat-icon">👥</div>
            <div>
                <span>Total accounts</span>
                <strong>{{ $users->count() }}</strong>
            </div>
        </article>
        <article class="admin-stat-card admin-stat-qa">
            <div class="admin-stat-icon">✓</div>
            <div>
                <span>QA</span>
                <strong>{{ $users->filter(fn ($user) => $user->isQA())->count() }}</strong>
            </div>
        </article>

        <article class="admin-stat-card admin-stat-tester">
            <div class="admin-stat-icon">◈</div>
            <div>
                <span>Testers</span>
                <strong>{{ $users->filter(fn ($user) => $user->isTester())->count() }}</strong>
            </div>
        </article>

        <article class="admin-stat-card admin-stat-super">
            <div class="admin-stat-icon">✦</div>
            <div>
                <span>Super admins</span>
                <strong>{{ $users->filter(fn ($user) => $user->isSuperAdmin())->count() }}</strong>
            </div>
        </article>

        <article class="admin-stat-card admin-stat-admin">
            <div class="admin-stat-icon">◆</div>
            <div>
                <span>Admins</span>
                <strong>
                    {{ $users->filter(fn ($user) => $user->role === 'admin')->count() }}
                </strong>
            </div>
        </article>

        <article class="admin-stat-card admin-stat-user">
            <div class="admin-stat-icon">●</div>
            <div>
                <span>Standard users</span>
                <strong>{{ $users->filter(fn ($user) => $user->isUser())->count() }}</strong>
            </div>
        </article>
    </section>

    <section class="admin-users-card">
        <div class="admin-users-card-header">
            <div>
                <h2>All accounts</h2>
                <p>A complete overview of registered dashboard users.</p>
            </div>

            <span class="admin-user-count">
                {{ $users->count() }} users
            </span>
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-users-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="admin-action-column">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $listedUser)
                    <tr>
                        <td>
                            <div class="admin-user-cell">
                                <span class="admin-user-avatar">
                                    {{ strtoupper(substr($listedUser->name, 0, 1)) }}
                                </span>

                                <div>
                                    <strong>{{ $listedUser->name }}</strong>
                                    <small>User ID: #{{ $listedUser->id }}</small>
                                </div>
                            </div>
                        </td>

                        <td class="admin-email-cell">
                            {{ $listedUser->email }}
                        </td>

                        <td>
                            @if ($listedUser->isSuperAdmin())
                            <span class="admin-role-badge admin-role-super">
                                <span></span>
                                Super Admin
                            </span>
                            @elseif ($listedUser->isAdmin())
                            <span class="admin-role-badge admin-role-admin">
                                <span></span>
                                Admin
                            </span>
                            @elseif ($listedUser->isUser())
                            <span class="admin-role-badge admin-role-user">
                                <span></span>
                                User
                            </span>
                            @elseif ($listedUser->isQA())
                            <span class="admin-role-badge admin-role-qa">
                                <span></span>
                                QA
                            </span>
                            @elseif ($listedUser->isTester())
                            <span class="admin-role-badge admin-role-tester">
                                <span></span>
                                Tester
                            </span>
                            @else
                            <span class="admin-role-badge">
                                <span></span>
                                {{ ucwords(str_replace('_', ' ', $listedUser->role)) }}
                            </span>
                            @endif

                        </td>

                        <td>
                            <span class="admin-status">
                                <span></span>
                                Active
                            </span>
                        </td>

                        <td class="admin-action-column">
                            <div class="admin-action-buttons">
                                @if ($listedUser->id === auth()->id())
                                <span class="admin-current-account">Your account</span>
                                @else
                                <a href="{{ route('admin.users.edit', $listedUser->id) }}"
                                    class="admin-manage-button">
                                    Manage <span>→</span>
                                </a>

                                <form action="{{ route('admin.users.destroy', $listedUser->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete {{ $listedUser->name }}? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="admin-delete-button">
                                        Delete <span>×</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="admin-empty-state">
                                <span>👤</span>
                                <h3>No users found</h3>
                                <p>Registered users will appear here.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</section>
@endsection