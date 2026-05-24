<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{

//     public function index()
// {
//     $todos = ToDo::orderBy('created_at', 'desc')->get(); // Fetch all tasks
//     return view('admin.dashboard.todos-index', compact('todos'));
// }


public function index()
{
    // Grouping todos by date
    $todos = ToDo::orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

    return view('admin.dashboard.todos-index', compact('todos'));
}

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
        ]);

        ToDo::create([
            'task' => $request->task,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Task added successfully!');
    }

    public function toggle(Request $request, $id)
{
    $todo = ToDo::find($id);
    $todo->completed = $request->completed;
    $todo->save();

    return response()->json(['success' => true]);
}

public function destroy($id)
{
    $todo = ToDo::find($id);
    $todo->delete();

    return response()->json(['success' => true]);
}

}
