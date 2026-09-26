@extends('layouts.parts.app')

@section('title', 'Create Blog')

@section('content')
    <div class="page-heading">
        <div>
            <p class="page-kicker">CONTENT</p>
            <h1>Create blog</h1>
            <p>Write a new article and share it with your audience.</p>
        </div>
    </div>

    {{-- Frontend only: connect action to blogs.store later --}}
    <form action="{{ route('storeblog') }}" method="POST" enctype="multipart/form-data" class="blog-form">
        @csrf

        <section class="blog-form-card">
            <div class="blog-form-heading">
                <h2>Blog details</h2>
                <p>Add the article information below.</p>
            </div>

            <div class="blog-form-fields">
                <div class="blog-form-row">
                    <label for="short_title">Short title</label>

                    <input
                        type="text"
                        id="short_title"
                        name="short_title"
                        placeholder="e.g. My first Laravel project"
                        value="{{ old('short_title') }}"
                    >
                </div>

                <div class="blog-form-row">
                    <label for="title">Blog title</label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        placeholder="Write the full article title"
                        value="{{ old('title') }}"
                    >
                </div>

                <div class="blog-form-row">
                    <label for="short_description">Short description</label>

                    <textarea
                        id="short_description"
                        name="short_description"
                        rows="4"
                        placeholder="A short summary of the article"
                        {{ old('short_description') }}
                    ></textarea>
                </div>

                <div class="blog-form-row">
                    <label for="content">Blog content</label>

                    <textarea
                        id="content"
                        name="content"
                        rows="10"
                        placeholder="Write the full article content"
                        {{ old('content') }}
                    ></textarea>
                </div>

                <div class="blog-form-row">
                    <label for="image">Article image</label>

                    <label class="image-upload" for="image">
                        <span class="image-upload-icon">+</span>

                        <span>
                            <strong id="image-file-name">Choose an image</strong>
                            <small>PNG, JPG, or WEBP</small>
                        </span>

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                        >
                    </label>
                </div>

                <div class="blog-form-row">
                    <label for="published_at">Publishing date</label>

                    <input
                        type="date"
                        id="published_at"
                        name="published_at"
                        value="{{ old('published_at') }}"
                    >
                </div>
            </div>

            <div class="blog-form-actions">
                <a href="{{ route('blog') }}" class="secondary-button">
                    Cancel
                </a>

                <button class="primary-button" type="submit">
                    Save blog
                </button>
            </div>
        </section>
    </form>
    @push('scripts')
<script>
    const imageInput = document.getElementById('image');
    const imageFileName = document.getElementById('image-file-name');

    imageInput.addEventListener('change', function () {
        imageFileName.textContent = this.files.length
            ? this.files[0].name
            : 'Choose an image';
    });
</script>
@endpush
@endsection