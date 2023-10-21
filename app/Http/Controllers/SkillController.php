<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Skill::orderBy('name')->get();

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

        $insert = Skill::create([
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
    public function show(Skill $skill)
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

        $update = Skill::where('id', $id)
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
        $Skill = Skill::find($id);

        if (!$Skill) {
            return response()->json(['message' => 'Keahlian not found'], 404);
        }

        $Skill->delete();

        return response()->json(['message' => 'Keahlian deleted successfully'], 200);
    }
}
