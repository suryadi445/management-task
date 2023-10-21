<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Jabatan::orderBy('name')->get();

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

        $insert = Jabatan::create([
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
    public function show(Jabatan $jabatan)
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

        $update = Jabatan::where('id', $id)
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
        $Jabatan = Jabatan::find($id);

        if (!$Jabatan) {
            return response()->json(['message' => 'Jabatan not found'], 404);
        }

        $Jabatan->delete();

        return response()->json(['message' => 'Jabatan deleted successfully'], 200);
    }
}
