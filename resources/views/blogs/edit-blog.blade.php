@extends('layouts.parts.app')

@section('title', 'Edit Blog | User Dashboard')

@section('content')
    <section class="blog-form-page">

        <div class="blog-form-page-header">
            <div>
                <p class="page-kicker">EDIT ARTICLE</p>
                <h1>Edit blog</h1>
                <p>Update your article information and save your changes.</p>
            </div>

            <a href="{{ route('blog') }}" class="secondary-button">
                ← Back to blogs
            </a>
        </div>

        <form
            action="{{ route('update',$blog->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="blog-form-card"
        >
            @csrf
            @method('PUT')

            <div class="blog-form-heading">
                <h2>Blog details</h2>
                <p>Edit the article information below.</p>
            </div>

            <div class="blog-form-fields">

                <div class="blog-form-row">
                    <label for="short_title">Short title</label>

                    <input
                        type="text"
                        id="short_title"
                        name="short_title"
                        value="{{ old('short_title', $blog->short_title) }}"
                        placeholder="Write a short title"
                    >
                </div>

                <div class="blog-form-row">
                    <label for="title">Blog title</label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $blog->title) }}"
                        placeholder="Write the full article title"
                    >
                </div>

                <div class="blog-form-row">
                    <label for="short_description">Short description</label>

                    <textarea
                        id="short_description"
                        name="short_description"
                        rows="4"
                        placeholder="Write a short summary"
                    >{{ old('short_description', $blog->short_description) }}</textarea>
                </div>

                <div class="blog-form-row">
                    <label for="content">Article content</label>

                    <textarea
                        id="content"
                        name="content"
                        rows="10"
                        placeholder="Write the full article content"
                    >{{ old('content', $blog->content) }}</textarea>
                </div>

                <div class="blog-form-row">
                    <label for="image">Change image</label>

                    <div>
                        @if ($blog->image)
                            <img
                                class="current-blog-image"
                                src="{{ asset('storage/' . $blog->image) }}"
                                alt="{{ $blog->title }}"
                            >
                        @endif

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                        >
                    </div>
                </div>

                <div class="blog-form-row">
                    <label for="published_at">Publishing date</label>

                    <input
                        type="date"
                        id="published_at"
                        name="published_at"
                        value="{{ old('published_at', $blog->published_at) }}"
                    >
                </div>

            </div>

            <div class="blog-form-actions">
                <a href="{{ route('blog') }}" class="secondary-button">
                    Cancel
                </a>

                <button type="submit" class="primary-button">
                    Save changes
                </button>
            </div>
        </form>

    </section>
@endsection