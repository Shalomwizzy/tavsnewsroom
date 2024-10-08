@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    @foreach($todos as $date => $group)
    <div class="mb-4">
        {{-- <h5 class="text-light">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</h5> --}}
        <div class="row">
            <div class="col-sm-12 col-md-6 col-xl-3 mb-4">
                <div class="h-100 bg-dark rounded p-4 to-do-list">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0 dashboard-h6">To Do List for {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</h6>
                    </div>
                    <div class="d-flex mb-2">
                        <form action="{{ route('todos.store') }}" method="POST" class="w-100">
                            @csrf
                            <div class="input-group">
                                <input id="new-task" name="task" class="form-control todo-input bg-dark border-0" type="text" placeholder="Enter task" required>
                                <button type="submit" class="btn btn-primary ms-2">Add</button>
                            </div>
                        </form>
                    </div>
                    <ul id="tasks-list" class="list-group">
                        @foreach($group as $todo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <input class="form-check-input me-1" type="checkbox" {{ $todo->completed ? 'checked' : '' }} data-id="{{ $todo->id }}" onchange="toggleTask(this, {{ $todo->id }})">
                                <span class="{{ $todo->completed ? 'text-decoration-line-through' : '' }}" id="task-{{ $todo->id }}">{{ ucfirst($todo->task) }}</span>
                            </div>
                            <button class="btn btn-sm btn-danger" onclick="deleteTask({{ $todo->id }})"><i class="fa fa-times"></i></button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    function toggleTask(checkbox, taskId) {
        const completed = checkbox.checked;
        const taskElement = document.getElementById(`task-${taskId}`);
        if (completed) {
            taskElement.classList.add('text-decoration-line-through');
        } else {
            taskElement.classList.remove('text-decoration-line-through');
        }

        fetch(`/todos/${taskId}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ completed }),
        });
    }

    function deleteTask(taskId) {
        fetch(`/todos/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        }).then(() => {
            location.reload(); // Reload the page after deletion
        });
    }
</script>
@endsection


