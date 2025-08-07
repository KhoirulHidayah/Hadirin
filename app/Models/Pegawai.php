<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'email',
        'no_hp',
        'asal_instansi',
        'kategori'
    ];

    public function kategoriRelasi()
    {
        return $this->belongsTo(Kategori::class, 'kategori', 'nama');
    }

}
