<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = Karyawan::orderByDesc('id')->get();

        return response()->json([
            'Karyawan' => $result,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $insert = Karyawan::create([
            "nik" => $request->nik,
            "nama" => $request->nama,
            "tgl_lahir" => $request->tgl_lahir,
            "provinsi_kelahiran" => $request->provinsi_kelahiran,
            "tempat_lahir" => $request->tempat_lahir,
            "namaProv" => $request->namaProv,
            "namaKab" => $request->namaKab,
            "no_hp" => $request->no_hp,
            "pendidikan_terakhir" => $request->pendidikan_terakhir,
            "jenis_kelamin" => $request->jenis_kelamin,
            "alamat" => $request->alamat,
            "status" => $request->status,
            "jabatan" => $request->jabatan,
            "tgl_join" => $request->tgl_join,
            "selesai_kontrak" => $request->selesai_kontrak,
            "keahlian" => $request->keahlian,
            "npwp" => $request->npwp,
            "rekening" => $request->rekening,
            "keterangan" => $request->keterangan,
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
    public function show(Karyawan $Karyawan, $id)
    {
        $Karyawan = Karyawan::find($id);

        return response()->json([
            'Karyawan' => $Karyawan,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $insert = Karyawan::where('id', $id)
            ->update([
                "nik" => $request->nik,
                "nama" => $request->nama,
                "tgl_lahir" => $request->tgl_lahir,
                "provinsi_kelahiran" => $request->provinsi_kelahiran,
                "tempat_lahir" => $request->tempat_lahir,
                "namaProv" => $request->namaProv,
                "namaKab" => $request->namaKab,
                "no_hp" => $request->no_hp,
                "pendidikan_terakhir" => $request->pendidikan_terakhir,
                "jenis_kelamin" => $request->jenis_kelamin,
                "alamat" => $request->alamat,
                "status" => $request->status,
                "jabatan" => $request->jabatan,
                "tgl_join" => $request->tgl_join,
                "selesai_kontrak" => $request->selesai_kontrak,
                "keahlian" => $request->keahlian,
                "npwp" => $request->npwp,
                "rekening" => $request->rekening,
                "keterangan" => $request->keterangan,
                "user" => 1,
            ]);


        return response()->json([
            "id" => $insert,
            "message" => 'Data berhasil disimpan',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Karyawan = Karyawan::find($id);

        if (!$Karyawan) {
            return response()->json(['message' => 'Karyawan not found'], 404);
        }

        $Karyawan->delete();

        return response()->json(['message' => 'Karyawan deleted successfully'], 200);
    }
}
