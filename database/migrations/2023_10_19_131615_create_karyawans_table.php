<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->string('tgl_lahir')->nullable();
            $table->string('provinsi_kelahiran')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('namaProv')->nullable();
            $table->string('namaKab')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('alamat')->nullable();
            $table->string('status')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('tgl_join')->nullable();
            $table->string('selesai_kontrak')->nullable();
            $table->string('keahlian')->nullable();
            $table->string('npwp')->nullable();
            $table->string('rekening')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
