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
        'tanda_tangan',
        'waktu_absen',
    ];

    // app/Models/PresenceDetail.php
    public function presence()
    {
        // 'presence_id' di tabel PresenceDetail, 'presence_id' di tabel Presence
        return $this->belongsTo(\App\Models\Presence::class, 'presence_id', 'presence_id');
    }
}
