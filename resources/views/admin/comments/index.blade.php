@extends('layouts.admin')

@section('content')
<div class="container admin-view-index">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="display-4 h2-headline-admin">Comments</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Pending --}}
            <h4 class="mt-3">Pending Approval ({{ $pending->count() }})</h4>
            @if ($pending->isEmpty())
                <p class="text-muted">No comments awaiting approval.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Article</th>
                                <th>Author</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pending as $comment)
                            <tr>
                                <td>
                                    <a href="{{ route('post-news.read-more', [
                                        'year'  => \Carbon\Carbon::parse($comment->postNews->date)->format('Y'),
                                        'month' => \Carbon\Carbon::parse($comment->postNews->date)->format('m'),
                                        'day'   => \Carbon\Carbon::parse($comment->postNews->date)->format('d'),
                                        'slug'  => $comment->postNews->slug,
                                    ]) }}" target="_blank">
                                        {{ Str::limit($comment->postNews->headline, 50) }}
                                    </a>
                                </td>
                                <td>{{ $comment->name }}<br><small class="text-muted">{{ $comment->email }}</small></td>
                                <td>{{ Str::limit($comment->body, 120) }}</td>
                                <td>{{ $comment->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this comment?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Approved --}}
            <h4 class="mt-4">Approved Comments</h4>
            @if ($approved->isEmpty())
                <p class="text-muted">No approved comments yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Article</th>
                                <th>Author</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approved as $comment)
                            <tr>
                                <td>{{ Str::limit($comment->postNews->headline, 50) }}</td>
                                <td>{{ $comment->name }}</td>
                                <td>{{ Str::limit($comment->body, 120) }}</td>
                                <td>{{ $comment->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this comment?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $approved->links('pagination::simple-bootstrap-5') }}
            @endif

        </div>
    </div>
</div>
@endsection
