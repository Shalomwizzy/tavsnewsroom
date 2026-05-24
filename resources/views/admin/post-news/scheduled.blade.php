@extends('layouts.admin')

@section('content')
<div class="container admin-view-index">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="display-4 h2-headline-admin">Scheduled Posts</h2>
            <p class="admin-paragraph">Articles queued to publish automatically at a future date and time.</p>

            <a href="{{ route('post-news.index') }}" class="btn btn-secondary mb-3">&larr; Back to All Posts</a>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($posts->isEmpty())
                <div class="alert alert-info">No posts are currently scheduled for future publication.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Headline</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Publishes In</th>
                                <th>Scheduled For</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $index => $post)
                            <tr>
                                <td>{{ ($posts->currentPage() - 1) * $posts->perPage() + $index + 1 }}</td>
                                <td>{{ $post->headline }}</td>
                                <td>{{ $post->category->name ?? '—' }}</td>
                                <td>{{ $post->user->name ?? '—' }}</td>
                                <td>
                                    <span class="badge badge-info bg-info text-white">
                                        {{ \Carbon\Carbon::parse($post->scheduled_for)->diffForHumans() }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($post->scheduled_for)->format('M d, Y \a\t g:i A') }}</td>
                                <td>
                                    <a href="{{ route('post-news.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $posts->links('pagination::simple-bootstrap-5') }}
            @endif
        </div>
    </div>
</div>
@endsection
