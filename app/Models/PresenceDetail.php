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
}
