<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instagram extends Model
{
    use HasFactory;
    protected $table = 'instagrams'; 
    protected $fillable = ['logo', 'instagram_username'];
}
