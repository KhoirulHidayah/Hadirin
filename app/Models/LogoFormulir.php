<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoFormulir extends Model
{
    use HasFactory;
    protected $table = 'logo_formulir'; 
    protected $fillable = ['app_name', 'header_title', 'logo_left', 'logo_right'];
}
