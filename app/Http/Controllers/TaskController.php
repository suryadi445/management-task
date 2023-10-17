<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentPage = $request->query('page', 1);
        $pageSize = $request->query('pageSize');

        $totalData = Task::count();
        $totalPages = ceil($totalData / $pageSize);

        $data = Task::paginate($pageSize, ['*'], 'page', $currentPage);

        return response()->json([
            'tasks' => $data,
            'totalPages' => $totalPages
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'task' => 'required',
            'programmer' => 'required',
            'deadline' => 'required',
            'project' => 'required',
            'status' => 'required',
        ]);

        Task::create([
            'task' => $request->task,
            'project' => $request->project,
            'programmer' => $request->programmer,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Data berhasil disimpan'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Task::findOrFail($id);

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'task' => 'required',
            'programmer' => 'required',
            'deadline' => 'required',
            'project' => 'required',
            'status' => 'required',
        ]);

        $update = Task::where('id', $id)
            ->update([
                'task' => $request->task,
                'project' => $request->project,
                'programmer' => $request->programmer,
                'deadline' => $request->deadline,
                'status' => $request->status,
            ]);

        if ($update) {
            return response()->json(['message' => 'Data berhasil diubah'], 200);
        } else {
            return response()->json(['message' => 'Data gagal diubah'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $delete = $task->delete();

        if ($delete) {
            return response()->json(['message' => 'Task deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Task deleted failed'], 500);
        }
    }
}
