@extends('layouts.parts.app')

@section('title', 'My Profile')

@section('content')
    <section class="profile-shell">
        <div class="profile-heading">
            <div>
                <h1>My Profile</h1>
                <p>View your account information and manage your profile.</p>
            </div>

            <a href="{{ route('edit-profile') }}" class="profile-action">
                Edit profile
            </a>
        </div>

        <article class="profile-overview">
            <div class="profile-overview-top">
                <div class="profile-identity">
                    <div class="profile-monogram">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div>
                        <p class="profile-label">Your account</p>
                        <h2>{{ $user->name }}</h2>
                        <p class="profile-email">{{ $user->email }}</p>
                    </div>
                </div>

                <span class="profile-status">
                    <span></span>
                    Active account
                </span>
            </div>

            <div class="profile-info-grid">
                <div class="profile-info-item">
                    <span>Full name</span>
                    <strong>{{ $user->name }}</strong>
                </div>

                <div class="profile-info-item">
                    <span>Email address</span>
                    <strong>{{ $user->email }}</strong>
                </div>
            </div>
        </article>
    </section>
@endsection