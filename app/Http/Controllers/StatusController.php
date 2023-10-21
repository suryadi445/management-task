<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Status::orderBy('name')->get();

        return response()->json([
            "data" => $data,
            "message" => 'success',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $insert = Status::create([
            "name" => $request->name,
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
    public function show(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $update = Status::where('id', $id)
            ->update([
                'name' => $request->name,
                'user' => 1,
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
    public function destroy($id)
    {
        $Status = Status::find($id);

        if (!$Status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        $Status->delete();

        return response()->json(['message' => 'Status deleted successfully'], 200);
    }
}
