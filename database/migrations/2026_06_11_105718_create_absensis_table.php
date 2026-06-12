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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_siang')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->string('keterangan')->default('Hadir'); // Hadir, Sakit, Izin, Alpa
            $table->timestamps();

            // Mencegah double input pegawai di tanggal yang sama
            $table->unique(['pegawai_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
