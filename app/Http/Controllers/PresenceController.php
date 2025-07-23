<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Presence;
use App\Models\PresenceDetail;
use App\Models\Instagram;
use App\Models\Slide;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PresenceController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kegiatan',
            'list'  => ['Home', 'Daftar Kegiatan']
        ];
        $page = (object) [
            'title' => 'Daftar Kegiatan'
        ];
        $presences = Presence::all();
        $activeMenu = 'presence';
        return view('presence.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu], compact('presences'));
    }

    public function list(Request $request)
    {
        $Presence = Presence::select('presence_id', 'nama_kegiatan', 'tempat', 'slug', 'tgl_kegiatan', 'waktu_selesai', 'status')->get();

        foreach ($Presence as $item) {
            $endTime = Carbon::parse($item->tgl_kegiatan)
                            ->setTimeFromTimeString($item->waktu_selesai);

            if (now()->gt($endTime) && $item->status !== 'selesai') {
                $item->update(['status' => 'selesai']);
            }
        }

        return DataTables::of(Presence::select('presence_id', 'nama_kegiatan', 'tempat', 'slug', 'tgl_kegiatan', 'waktu_selesai', 'status'))
            ->addIndexColumn()
            ->addColumn('tgl_kegiatan', function ($row) {
                return \Carbon\Carbon::parse($row->tgl_kegiatan)->format('d-m-Y');
            })
            ->addColumn('waktu_mulai', function ($row) {
                return \Carbon\Carbon::parse($row->tgl_kegiatan)->format('H:i');
            })
            ->addColumn('waktu_selesai', function($row) {
                return \Carbon\Carbon::parse($row->waktu_selesai)->format('H:i');
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 'aktif') {
                    return '<span class="badge bg-success">Aktif</span>';
                } else {
                    return '<span class="badge bg-secondary">Selesai</span>';
                }
            })
            ->addColumn('aksi', function ($row) {
                $btn  = '<a href="' . url('/presence/detail/' . $row->presence_id) . '" class="btn btn-info btn-sm me-1"><i class="fas fa-eye"></i></a>';
                $btn .= '<a href="' . url('/presence/' . $row->presence_id . '/edit') . '" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i></a>';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/presence/' . $row->presence_id) . '">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin hapus data ini?\')">
                        <i class="fas fa-trash"></i> 
                    </button></form>';
                return $btn;
            })
            ->rawColumns(['status', 'aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kegiatan',
            'list'  => ['Home', 'Daftar Kegiatan', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah kegiatan baru'
        ];
        $activeMenu = 'presence';
        return view('presence.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tempat' => 'required',
            'tgl_kegiatan' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'status' => 'required|in:aktif,selesai',
        ]);

        $tanggalWaktu = Carbon::createFromFormat('Y-m-d H:i', $request->tgl_kegiatan . ' ' . $request->waktu_mulai);
        $waktu_selesai = Carbon::createFromFormat('Y-m-d H:i', $request->tgl_kegiatan . ' ' . $request->waktu_selesai);

        $presence_id = $this->generatePresenceID($tanggalWaktu);

        $data = [
            'presence_id'    => $presence_id,
            'nama_kegiatan'  => $request->nama_kegiatan,
            'tempat'         => $request->tempat,
            'slug'           => Str::slug($request->nama_kegiatan),
            'tgl_kegiatan'   => $tanggalWaktu,
            'waktu_selesai'  => $waktu_selesai,
            'status'         => $request->status,
        ];

        Presence::create($data);

        return redirect('/presence')->with('success', 'Data kegiatan berhasil disimpan');
    }

    private function generatePresenceID($tgl_kegiatan)
    {
        $prefixDate = Carbon::parse($tgl_kegiatan)->format('Ym');
        $prefix = 'KEG-' . $prefixDate;

        $latest = Presence::where('presence_id', 'like', $prefix . '-%')
            ->orderBy('presence_id', 'desc')
            ->first();

        $newNumber = $latest ? (int) substr($latest->presence_id, -3) + 1 : 1;

        return $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function show($presence_id)
    {
        $Presence = Presence::findOrFail($presence_id);

        $breadcrumb = (object)[
            'title' => 'Detail Daftar Kegiatan',
            'list' => ['Home','Daftar Kegiatan', 'Detail Daftar Kegiatan']
        ];
        $page = (object)[
            'title' => 'Detail Daftar Absen Kegiatan'
        ];
        $activeMenu = 'presence';
        return view('presence.detail.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Presence' => $Presence, 'activeMenu' => $activeMenu]);
    }

    public function edit($presence_id)
    {
        $Presence = Presence::findOrFail($presence_id);
        $breadcrumb = (object) [
            'title' => 'Edit Kegiatan',
            'list'  => ['Home', 'Daftar Kegiatan', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit kegiatan'
        ];
        $activeMenu = 'presence';
        return view('presence.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Presence' => $Presence, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $presence_id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:100',
            'tempat' => 'required|string|max:100',
            'tgl_kegiatan' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'status' => 'required|in:aktif,selesai',
        ]);

        $presence = Presence::findOrFail($presence_id);

        $tanggalWaktu = Carbon::createFromFormat('Y-m-d H:i', $request->tgl_kegiatan . ' ' . $request->waktu_mulai);
        $waktu_selesai = Carbon::createFromFormat('Y-m-d H:i', $request->tgl_kegiatan . ' ' . $request->waktu_selesai);

        $presence->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tempat' => $request->tempat,
            'slug' => Str::slug($request->nama_kegiatan),
            'tgl_kegiatan' => $tanggalWaktu,
            'waktu_selesai' => $waktu_selesai,
            'status' => $request->status,
        ]);

        return redirect('/presence')->with('success', 'Data kegiatan berhasil diubah');
    }

    public function destroy($presence_id)
    {
        $presenceDetail = PresenceDetail::where('presence_id', $presence_id)->get();
        foreach ($presenceDetail as $pd) {
            if ($pd->tanda_tangan) {
                Storage::delete('public/tanda_tangan/' . $pd->tanda_tangan);
            }
            $pd->delete();
        }

        $presence = Presence::findOrFail($presence_id);
        $presence->delete();

        return redirect('/presence')->with('success', 'Data kegiatan berhasil dihapus');
    }

    public function absenBySlug($slug)
    {
        $Presence = Presence::where('slug', $slug)->firstOrFail();

        // Cek dan update status otomatis jika waktu sudah selesai
        $endTime = Carbon::parse($Presence->tgl_kegiatan)
                    ->setTimeFromTimeString($Presence->waktu_selesai);

        if (now()->gt($endTime) && $Presence->status !== 'selesai') {
            $Presence->update(['status' => 'selesai']);
        }

        // Cek status kegiatan
        if ($Presence->status === 'selesai') {
            abort(403, 'Presensi telah ditutup karena kegiatan sudah selesai.');
        }

        // Cek waktu mulai kegiatan
        $startTime = Carbon::parse($Presence->tgl_kegiatan);
        if (now()->lt($startTime)) {
            abort(403, 'Presensi belum dibuka.');
        }

        $slides = Slide::all();
        $instagrams = Instagram::first();

        return view('absen.index', [
            'Presence' => $Presence,
            'slides' => $slides,
            'instagrams' => $instagrams
        ]);
    }

    public function export_pdf()
    {
    $presences = Presence::all();

    // Ensure the 'presence.pdf' view exists
    $pdf = PDF::loadView('presence.pdf', ['presences' => $presences]);

    // Return PDF response to prompt file download
    return $pdf->download('Data Kegiatan ' . now()->format('Y-m-d H:i:s') . '.pdf');
    }
}
