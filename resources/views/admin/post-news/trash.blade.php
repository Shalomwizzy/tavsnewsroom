@extends('layouts.admin')

@section('content')
<div class="container admin-view-index">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="display-4 h2-headline-admin">Trash</h2>
            <p class="admin-paragraph">Deleted articles are kept here. Restore to bring them back, or permanently delete to remove forever.</p>

            <a href="{{ route('post-news.index') }}" class="btn btn-secondary mb-3">&larr; Back to All Posts</a>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($trashedPosts->isEmpty())
                <p class="text-muted">The trash is empty.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Headline</th>
                                <th>Category</th>
                                <th>Deleted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trashedPosts as $index => $post)
                            <tr>
                                <td>{{ ($trashedPosts->currentPage() - 1) * $trashedPosts->perPage() + $index + 1 }}</td>
                                <td>{{ $post->headline }}</td>
                                <td>{{ $post->category->name ?? '—' }}</td>
                                <td>{{ $post->deleted_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('post-news.restore', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Restore</button>
                                    </form>
                                    <form action="{{ route('post-news.force-delete', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Permanently delete this post? This cannot be undone.')">Delete Forever</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $trashedPosts->links('pagination::simple-bootstrap-5') }}
            @endif
        </div>
    </div>
</div>
@endsection
