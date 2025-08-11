<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsalInstansi extends Model
{
    use HasFactory;

    protected $table = 'asal_instansi';

    protected $fillable = [
        'asal_instansi',
        'kategori_nama',
    ];

    /**
     * Relasi many-to-one (belongsTo) ke model Kategori.
     * Menggunakan 'kategori_nama' sebagai foreign key dan 'nama' sebagai local key.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_nama', 'nama');
    }

    /**
     * Relasi one-to-many (hasMany) ke model Pegawai.
     * Menggunakan 'asal_instansi' sebagai foreign key.
     */
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'asal_instansi', 'asal_instansi');
    }
}