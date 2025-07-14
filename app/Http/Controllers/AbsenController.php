<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
public function index($slug)
    {
        $Presence = Presence::where('slug', $slug)->firstOrFail();
        $presence_details = PresenceDetail::where('presence_id', $Presence->id)->get();

        return view('absen.index', [
            'Presence' => $Presence, // HARUS ADA
            'presence_details' => $presence_details
        ]);
    }   
}
