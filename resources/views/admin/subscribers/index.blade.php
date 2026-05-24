@extends('layouts.admin')

@section('content')
<div class="container subscriber-mail bg-black text-white">
    <h2 class="mt-4 h2-headline-admin">Subscriber List</h3>
    <p class="description admin-paragraph">This page displays the list of email addresses of all subscribers. You can use this list to manage your subscribers and send out emails to them.</p>
    
    <table class="table table-bordered text-white">
        <thead>
            <tr>
                <th>No</th>
                <th>Email</th>
                <th>Subscribed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscribers as $index => $subscriber)
                <tr>
                    <td>{{ ($subscribers->currentPage() - 1) * $subscribers->perPage() + $index + 1 }}</td>
                    <td>{{ $subscriber->email }}</td>
                    <td>{{ $subscriber->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $subscribers->links('pagination::simple-bootstrap-5') }}
    </div>
</div>



<style>
    .subscriber-mail {
        background-color: black;
        color: white;
        padding: 20px;
        border-radius: 10px;
    }

    .subscriber-mail h2, .subscriber-mail h3 {
        color: #fff;
    }

    .subscriber-mail .form-control {
        background-color: black;
        color:   #6C7293 !important;;
        border: none;
    }

    .subscriber-mail .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .subscriber-mail .table {
        color:  #6C7293 !important;
        background-color: black;
    }

    .subscriber-mail .table th, .subscriber-mail .table td {
        border: 1px solid #555;
        background-color: black;
        color:  #6C7293 !important;
    }
</style>
@endsection

