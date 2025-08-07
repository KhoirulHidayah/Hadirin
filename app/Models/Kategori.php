<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama',
    ];

    public $timestamps = true;

    /**
     * Relasi berdasarkan nama kategori (manual)
     * Asumsinya: kolom 'kategori' di tabel pegawai menyimpan teks nama kategori
     */
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'kategori', 'nama');
    }
}
