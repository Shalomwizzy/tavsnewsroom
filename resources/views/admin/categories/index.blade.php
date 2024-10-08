@extends('layouts.admin')

@section('content')
<div class="container category-index">

    <div class="page-description">
        <h2 class="h2-headline-admin">Manage Categories</h2>
        <p class="admin-paragraph">This page displays a list of all categories that have been created. You can edit or delete categories as needed.</p>
    </div>
    <div class="col-lg-12">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Create New Category</a>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Image</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $category)
            <tr>
                <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $index + 1 }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    @if($category->image)
                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="100">
                    @else
                    No Image
                    @endif
                </td>
                <td>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('categories.edit', $category->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $categories->links('pagination::simple-bootstrap-5') }}
    </div>
</div>


@endsection



