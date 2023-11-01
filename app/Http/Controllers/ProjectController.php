<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::latest()->get();

        return response([
            "data" => $projects,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nama_project" => 'required',
        ]);

        $insert = Project::create([
            "nama_project" => $request->nama_project,
            "user" => 1,
        ]);

        return response()->json([
            "id" => $insert->id,
            "message" => 'Data berhasil disimpan',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "nama_project" => 'required',
        ]);

        $update = Project::where('id', $id)
            ->update([
                "nama_project" => $request->nama_project,
                "user" => 1,
            ]);

        return response()->json([
            "id" => $update,
            "message" => 'Data berhasil disimpan',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::findOrfail($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}
