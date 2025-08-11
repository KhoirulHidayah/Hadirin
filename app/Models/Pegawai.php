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
        'asal_instansi', // Kolom ini akan menjadi foreign key
        'kategori'
    ];

    /**
     * Relasi many-to-one (belongsTo) ke model Kategori.
     * Menggunakan 'kategori' sebagai foreign key dan 'nama' sebagai local key.
     */
    public function kategoriRelasi()
    {
        return $this->belongsTo(Kategori::class, 'kategori', 'nama');
    }

    /**
     * Relasi many-to-one (belongsTo) ke model AsalInstansi.
     * Menggunakan 'asal_instansi' sebagai foreign key dan 'asal_instansi' sebagai local key.
     */
    public function asalInstansiRelasi()
    {
        return $this->belongsTo(AsalInstansi::class, 'asal_instansi', 'asal_instansi');
    }
}