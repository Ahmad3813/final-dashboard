@extends('layouts.parts.app')

@section('title', 'My Blogs')

@section('content')
<div class="page-heading">
    <div>
        <p class="page-kicker">CONTENT</p>
        <h1>My Blogs</h1>
        <p>Manage and write your blog posts here.</p>
    </div>

    <a href="{{ route('createblog') }}" class="primary-button">
        + Create post
    </a>
</div>

<section class="blogs-card">
    <div class="blogs-card-heading">
        <div>
            <h2>Your blog posts</h2>
            <p>View, edit, or remove your posts.</p>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="blogs-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Blog title</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($blogs as $blog)


                <tr>
                    <td>
                        <img class="blog-thumbnail"
                            src="{{ asset('storage/' . $blog->image) }}"
                            alt="{{ $blog->title }}">
                    </td>

                    <td>
                        <strong>{{ $blog->title }}</strong>
                        <span class="blog-status"></span>
                    </td>

                    <td>
                        <div class="table-actions">
                            <a href="{{ route('view-blog',$blog->id) }}" class="action-button show-button">Show</a>
                            <a href="{{ route('edit-blog',$blog->id) }}" class="action-button edit-button">Edit</a>

                            <form action="{{ route('delete',$blog->id) }}" method="POSt" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-button delete-button">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</section>
@endsection