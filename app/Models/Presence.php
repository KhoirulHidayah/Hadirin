<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $table = 'presences';

    protected $primaryKey = 'presence_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'presence_id',
        'nama_kegiatan',
        'tempat',
        'slug',
        'tgl_kegiatan',
        'waktu_selesai',
        'status',
    ];

    // app/Models/Presence.php
    public function details()
    {
        // 'presence_id' di tabel PresenceDetail, 'presence_id' di tabel Presence
        return $this->hasMany(\App\Models\PresenceDetail::class, 'presence_id', 'presence_id');
    }

}
