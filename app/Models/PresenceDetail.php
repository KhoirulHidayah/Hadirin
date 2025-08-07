<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceDetail extends Model
{
    use HasFactory;

    protected $table = 'presence_details';

    protected $fillable = [
        'presence_id',
        'nama',
        'nip',
        'email',
        'jabatan',
        'no_hp',
        'asal_instansi',
        'kategori', // Ubah dari 'kategori_nama' ke 'kategori'
        'tanda_tangan',
        'waktu_absen',
    ];

    /**
     * Define a belongsTo relationship with the Presence model.
     */
    public function presence()
    {
        return $this->belongsTo(\App\Models\Presence::class, 'presence_id', 'presence_id');
    }

    /**
     * Define a belongsTo relationship with the Kategori model.
     * It uses 'kategori' in presence_details to match 'nama' in the kategori table.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori', 'nama');
    }
}