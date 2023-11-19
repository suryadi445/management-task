<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Setting;
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

        $setting = Setting::first();

        return response()->json([
            "data" => $data,
            "setting" => $setting,
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


        $cekAbsensi = Absensi::where([
            'user' => 3,
            'tanggal' => date('Y-m-d'),
        ])->first();

        if ($cekAbsensi) {

            $keterangan = $request->keterangan;

            if ($keterangan == 'pulang') {
                $cekAbsensi->update([
                    'image' => $imageName,
                    'path' => '/image/absensi/',
                    'jam_pulang' => date('H:i:s'),
                ]);
            } else {
                $cekAbsensi->update([
                    'image' => $imageName,
                    'path' => '/image/absensi/',
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
            }
        } else {
            Absensi::create([
                'user' => 3,
                'tanggal' => date('Y-m-d'),
                'image' => $imageName,
                'path' => '/image/absensi/',
                'jam' => date('H:i:s'),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        }


        return response()->json([
            "id" => date('Y-m-d H:i:s'),
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
