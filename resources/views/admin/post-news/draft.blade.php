@extends('layouts.admin')

@section('content')
<div class="container admin-view-index">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="display-4 h2-headline-admin">Draft Posts</h2>
            <p class="admin-paragraph">This page allows you to manage all draft posts. You can edit or delete any post using the buttons provided in the Actions column.</p>
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($draftPosts as $index => $post)
                        <tr>
                            <td>{{ ($draftPosts->currentPage() - 1) * $draftPosts->perPage() + $index + 1 }}</td>
                            <td>{{ $post->headline }}</td>
                            <td>{{ $post->category->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($post->date)->format('M d, Y') }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="{{ route('post-news.edit', $post->id) }}">Edit</a>
                                <a class="btn btn-success btn-sm" href="{{ route('admin.post-news.show', $post->id) }}">View</a>
                                <form action="{{ route('post-news.destroy', $post->id) }}" method="POST" style="display:inline-block;">
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
            {{ $draftPosts->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>
</div>
@endsection









































{{-- @extends('layouts.admin')

@section('content')
<div class="container admin-view-index">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="display-4 h2-headline-admin">Draft Posts</h2>
            <p class="admin-paragraph">This page allows you to manage all draft posts. You can edit or delete any post using the buttons provided in the Actions column.</p>
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($draftPosts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $post->headline }}</td>
                            <td>{{ $post->category->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($post->date)->format('M d, Y') }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('post-news.edit', $post->id) }}">Edit</a>
                                <a class="btn btn-success btn-sm" href="{{ route('admin.post-news.show', $post->id) }}">View</a>
                                <form action="{{ route('post-news.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                  <!-- Pagination Links -->
               <div class="d-flex justify-content-center mt-4">
                {{ $draftPosts->links('pagination::simple-bootstrap-5') }}
            </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}







































{{-- @extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Draft Posts</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Headline</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($draftPosts as $post)
                <tr>
                    <td>{{ $post->headline }}</td>
                    <td>
                        <a href="{{ route('post-news.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('post-news.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}
