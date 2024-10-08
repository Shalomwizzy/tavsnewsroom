@extends('layouts.admin')

@section('content')
<div class="container admin-view-index">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="display-4 h2-headline-admin">All News Posts</h2>
            <p class="admin-paragraph">
                This page displays all the news posts, categorized into Draft, Pending, and Published statuses. Here, you can edit, view, or delete each post, allowing you to manage the content on your site efficiently. Use the action buttons to make any necessary changes or updates to the posts.
            </p>
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif

            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Headline</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paginatedItems as $index => $post)
                        <tr>
                            <td>{{ ($paginatedItems->currentPage() - 1) * $paginatedItems->perPage() + $index + 1 }}</td>
                            <td>{{ $post->headline }}</td>
                            <td>{{ $post->category->name }}</td>
                            <td>{{ $post->date }}</td>
                            <td>{{ ucfirst($post->status) }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="{{ route('post-news.edit', $post->id) }}">Edit</a>
                                <a class="btn btn-success btn-sm" href="{{ route('admin.post-news.show', $post->id) }}">View</a>
                                <form action="{{ route('post-news.destroy', $post->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            {{ $paginatedItems->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>
</div>
@endsection





























{{-- @extends('layouts.admin')

@section('content')
<div class="container admin-view-index">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="display-4 h2-headline-admin">All News Posts</h2>
            <p class="admin-paragraph">
                This page displays all the news posts, categorized into Draft, Pending, and Published statuses. Here, you can edit, view, or delete each post, allowing you to manage the content on your site efficiently. Use the action buttons to make any necessary changes or updates to the posts.
            </p>
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif

            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Headline</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paginatedItems as $index => $post)
                        <tr>
                            <td>{{ $index + 1 + ($paginatedItems->currentPage() - 1) * $paginatedItems->perPage() }}</td>
                            <td>{{ $post->headline }}</td>
                            <td>{{ $post->category->name }}</td>
                            <td>{{ $post->date }}</td>
                            <td>{{ ucfirst($post->status) }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('post-news.edit', $post->id) }}">Edit</a>
                                <a class="btn btn-success btn-sm" href="{{ route('admin.post-news.show', $post->id) }}">View</a>
                                <form action="{{ route('post-news.destroy', $post->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            {{-- {{ $paginatedItems->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>
</div>
@endsection --}}




































