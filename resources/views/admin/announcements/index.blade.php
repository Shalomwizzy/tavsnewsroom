@extends('layouts.admin')

@section('content')
    <div class="container admin-view-index">
        <h2 class="display-4 h2-headline-admin">Announcements</h2>
     
        <p class="admin-paragraph">
            This page allows you to manage announcements that will be displayed on the homepage. 
            You can create new announcements, edit or delete existing ones, and activate or deactivate 
            them as needed. Use the buttons below to perform these actions.
        </p>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <a href="{{ route('announcements.create') }}" class="btn btn-primary">Create Announcement</a>
        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($announcements as $index => $announcement)
                        <tr>
                            <td>{{ ($announcements->currentPage() - 1) * $announcements->perPage() + $index + 1 }}</td>
                            <td>{{ $announcement->title }}</td>
                            <td>{!! $announcement->message !!}</td>
                            <td>{{ $announcement->active ? 'Yes' : 'No' }}</td>
                            <td>
                                <form action="{{ route('announcements.toggle', $announcement->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn {{ $announcement->active ? 'btn-danger' : 'btn-success' }}">
                                        {{ $announcement->active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this announcement?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $announcements->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>
@endsection
















{{-- @extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="h2-headline-admin">Announcements</h2>
     
        <p class="admin-paragraph">
            This page allows you to manage announcements that will be displayed on the homepage. 
            You can create new announcements, edit or delete existing ones, and activate or deactivate 
            them as needed. Use the buttons below to perform these actions.
        </p>
        <a href="{{ route('announcements.create') }}" class="btn btn-primary">Create Announcement</a>
        <table class="table announcement-index-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td>{!! $announcement->message !!}</td>
                        <td>{{ $announcement->active ? 'Yes' : 'No' }}</td>
                        <td>
                            <form action="{{ route('announcements.toggle', $announcement->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $announcement->active ? 'btn-danger' : 'btn-success' }}">
                                    {{ $announcement->active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display:inline-block;">
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
@endsection

<style>
.announcement-index-title {
    font-size: 2em;
    margin-bottom: 20px;
}

.announcement-index-table {
    width: 100%;
    margin-top: 20px;
}

.announcement-index-table th, .announcement-index-table td {
    text-align: left;
    padding: 10px;
}

.announcement-index-table th {
    background-color: #0000 !important;
    color: #6C7293 !important; 
}

.announcement-index-table td {
    background-color: #0000 !important;
    color: #6C7293 !important; 
}

.announcement-index-table .btn {
    margin-right: 5px;
}

.btn-active-green {
    background-color: green;
    border-color: green;
}

.btn-active-green:hover {
    background-color: darkgreen;
    border-color: darkgreen;
}
</style> --}}
