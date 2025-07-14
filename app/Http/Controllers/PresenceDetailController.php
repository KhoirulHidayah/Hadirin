<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class PresenceDetailController extends Controller
{
    public function list(Request $request)
    {
        $data = PresenceDetail::where('presence_id', $request->presence_id);

        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'presence_id' => 'required|exists:presences,presence_id',
            'nama' => 'required',
            'nip' => 'required|numeric',
            'email' => 'required|email',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'asal_instansi' => 'required',
            'tanda_tangan' => 'required',
        ]);

        $data = $request->tanda_tangan;
        $image = str_replace('data:image/png;base64,', '', $data);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::uuid() . '.png';
        Storage::put("public/tanda_tangan/{$imageName}", base64_decode($image));

        \App\Models\PresenceDetail::create([
            'presence_id' => $request->presence_id,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'asal_instansi' => $request->asal_instansi,
            'tanda_tangan' => $imageName,
        ]);

        return back()->with('success', 'Absensi berhasil disimpan.');
    }

    public function show($id)
    {
        App::setLocale('id'); // Set locale ke Indonesia
        Carbon::setLocale('id'); // Ini untuk Carbon
        $Presence = Presence::findOrFail($id);

        // Ambil semua data detail yang berkaitan dengan presence_id
        $presence_details = PresenceDetail::where('presence_id', $id)->get();

        return view('absen.index', compact('Presence', 'presence_details'));
    }

    public function export_pdf($id)
    {
        $Presence = Presence::findOrFail($id);
        $presence_details = PresenceDetail::where('presence_id', $id)->get();

        $pdf = PDF::loadView('presence.detail.pdf', [
            'Presence' => $Presence,
            'presence_details' => $presence_details
        ]);

        return $pdf->download('Daftar Absensi - ' . $Presence->nama_kegiatan . ' - ' . now()->format('Ymd_His') . '.pdf');
    }

    public function destroy($id)
    {
        $detail = PresenceDetail::findOrFail($id);

        // Hapus tanda tangan dari storage jika perlu
        if ($detail->tanda_tangan && Storage::exists('public/tanda_tangan/' . $detail->tanda_tangan)) {
            Storage::delete('public/tanda_tangan/' . $detail->tanda_tangan);
        }

        $detail->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

}
