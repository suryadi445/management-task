<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;



class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Absensi::latest()
            ->join('karyawans', 'absensis.user', '=', 'karyawans.id')
            ->select('absensis.*', 'karyawans.nama as nama_karyawan', 'karyawans.jabatan')
            ->get();


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
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $imageData = $request->input('image');

        if ($imageData == 'data:,') {
            return response()->json([
                'status' => 'false',
                'message' => 'Kamera Harus Terbuka',
            ], 422);
            exit();
        }

        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $imageData = base64_decode($imageData);
        $imageName = time() . '.jpg';
        $path = public_path('image/absensi/' . $imageName);

        file_put_contents($path, $imageData);


        $insert = Absensi::create([
            'image' => $imageName,
            'path' => '/image/absensi/',
            'user' => 3,
            'tanggal' => date('Y-m-d'),
            'jam' => date('H:i:s'),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);


        return response()->json([
            "id" => $insert->id,
            "message" => 'Data berhasil disimpan',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        //
    }
}
