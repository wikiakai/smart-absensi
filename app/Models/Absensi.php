<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    //
    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'jam_masuk',
        'jam_siang',
        'jam_pulang',
        'keterangan',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
