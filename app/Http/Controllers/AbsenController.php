<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Instagram;

class AbsenController extends Controller
{
public function index($slug)
    {
        $Presence = Presence::where('slug', $slug)->firstOrFail();
        $presence_details = PresenceDetail::where('presence_id', $Presence->id)->get();
        
        $slides = Slide::all();
        $instagrams = Instagram::first();
        return view('absen.index', [
            'Presence' => $Presence,
            'presence_details' => $presence_details,
            'slides' => $slides,
            'instagrams' => $instagrams
        ]);
    }   
}
