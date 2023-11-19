<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Setting::first();

        return response([
            "data" => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'jam_masuk_kerja' => 'required|date_format:H:i',
            'jam_pulang_kerja' => 'required|date_format:H:i',
            'weekdays' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'alamat' => 'required|string',
        ]);

        if ($request->file()) {

            $file = $request->file('logo');

            $nama_file = time() . "_" . $file->getClientOriginalName();

            $tujuan_upload = 'image/setting';
            $file->move($tujuan_upload, $nama_file);

            $image = $nama_file;
        } else {

            $cek_logo = Setting::first()->logo;

            if ($cek_logo) {
                $image = $cek_logo;
            } else {
                $image = NULL;
            }
        }


        Setting::updateOrInsert(
            [
                'phone' => $validatedData['phone'],
            ],
            [
                'jam_masuk_kerja' => $validatedData['jam_masuk_kerja'],
                'jam_pulang_kerja' => $validatedData['jam_pulang_kerja'],
                'weekdays' => $validatedData['weekdays'],
                'logo' => $image,
                'email' => $validatedData['email'],
                'latitude' => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
                'alamat' => $validatedData['alamat'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        return response()->json([
            "message" => 'Data berhasil disimpan',
            "image" => $image,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
