<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    //  
    protected $fillable = ['nip', 'nama', 'jabatan', 'bidang'];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
