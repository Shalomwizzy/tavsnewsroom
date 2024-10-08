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

export { toggleTask, deleteTask };

