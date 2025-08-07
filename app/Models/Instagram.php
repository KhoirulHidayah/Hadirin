<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instagram extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'instagram_username',
        'show_gallery'
    ];

    // Cast untuk memastikan show_gallery selalu boolean
    protected $casts = [
        'show_gallery' => 'boolean'
    ];

    // Default values
    protected $attributes = [
        'show_gallery' => true
    ];
}