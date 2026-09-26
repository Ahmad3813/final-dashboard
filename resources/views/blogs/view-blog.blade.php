@extends('layouts.parts.app')

@section('title', $blog->title . ' | User Dashboard')

@section('content')
    <section class="blog-view-page">

        <div class="blog-view-header">
            <div>
                <p class="page-kicker">BLOG ARTICLE</p>
                <h1>{{ $blog->title }}</h1>
                <p>Read the complete article and its details.</p>
            </div>

            <a href="{{ route('blog') }}" class="secondary-button">
                ← Back to blogs
            </a>
        </div>

        <article class="blog-detail-card">

            <div class="blog-detail-media">
                @if ($blog->image)
                    <img
                        src="{{ asset('storage/' . $blog->image) }}"
                        alt="{{ $blog->title }}"
                    >
                @else
                    <div class="blog-image-placeholder">
                        No image available
                    </div>
                @endif
            </div>

            <div class="blog-detail-content">
                <span class="blog-detail-label">ARTICLE</span>

                <h2>{{ $blog->title }}</h2>

                <p class="blog-detail-summary">
                    {{ $blog->short_description }}
                </p>

                <div class="blog-detail-meta">
                    <div>
                        <span>Short title</span>
                        <strong>{{ $blog->short_title }}</strong>
                    </div>

                    <div>
                        <span>Published date</span>
                        <strong>{{ $blog->published_at ?? 'Not scheduled' }}</strong>
                    </div>
                </div>

                <div class="blog-detail-body">
                    <h3>About this article</h3>

                    <p>{!! nl2br(e($blog->content)) !!}</p>
                </div>
            </div>

        </article>

    </section>
@endsection