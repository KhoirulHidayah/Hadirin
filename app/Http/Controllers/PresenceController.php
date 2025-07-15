<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

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
        $Presence = Presence::select('presence_id', 'nama_kegiatan', 'tempat', 'slug', 'tgl_kegiatan');

        return DataTables::of($Presence)
            ->addIndexColumn()
            ->addColumn('tgl_kegiatan', function ($row) {
                return \Carbon\Carbon::parse($row->tgl_kegiatan)->format('d-m-Y');
            })
            ->addColumn('waktu_mulai', function ($row) {
                return \Carbon\Carbon::parse($row->tgl_kegiatan)->format('H:i');
            })
            ->addColumn('aksi', function ($row) {
                $btn  = '<a href="' . url('/presence/detail/' . $row->presence_id) . '" class="btn btn-info btn-sm me-1">
                            <i class="fas fa-eye"></i> 
                        </a>';
                $btn .= '<a href="' . url('/presence/' . $row->presence_id . '/edit') . '" class="btn btn-warning btn-sm me-1">
                            <i class="fas fa-edit"></i> 
                        </a>';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/presence/' . $row->presence_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin hapus data ini?\')">
                        <i class="fas fa-trash"></i> 
                    </button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
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
        ]);

        // Gabungkan tanggal dan waktu menjadi satu datetime
        $tanggalWaktu = Carbon::createFromFormat('Y-m-d H:i', $request->tgl_kegiatan . ' ' . $request->waktu_mulai);

        // 🔥 Generate custom UUID presence_id
        $presence_id = $this->generatePresenceID($tanggalWaktu);

        $data = [
            'presence_id'    => $presence_id,
            'nama_kegiatan'  => $request->nama_kegiatan,
            'tempat'  => $request->tempat,
            'slug'           => Str::slug($request->nama_kegiatan),
            'tgl_kegiatan'   => $tanggalWaktu,
        ];

        Presence::create($data);

        return redirect('/presence')->with('success', 'Data kegiatan berhasil disimpan');
    }

    private function generatePresenceID($tgl_kegiatan)
    {
        // Format KEG-YYYYMM
        $prefixDate = Carbon::parse($tgl_kegiatan)->format('Ym');
        $prefix = 'KEG-' . $prefixDate;

        // Ambil ID terakhir dengan prefix yang sama
        $latest = Presence::where('presence_id', 'like', $prefix . '-%')
            ->orderBy('presence_id', 'desc')
            ->first();

        if (!$latest) {
            $newNumber = 1;
        } else {
            // Ambil 3 digit terakhir dan +1
            $lastNumber = (int) substr($latest->presence_id, -3);
            $newNumber = $lastNumber + 1;
        }

        // Format akhir: KEG-202507-001
        return $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function show($presence_id)
    {
        $Presence = Presence::findOrFail($presence_id);

        $breadcrumb = (object)[
            'title' => 'Detail Daftar Absen Kegiatan',
            'list' => ['Home','Daftar Kegiatan', 'Detail Daftar Absen Kegiatan']
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
        ]);

        $presence = Presence::findOrFail($presence_id);

        // Gabungkan tanggal dan waktu jadi datetime
        $tanggalWaktu = Carbon::createFromFormat('Y-m-d H:i', $request->tgl_kegiatan . ' ' . $request->waktu_mulai);

        $presence->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tempat' => $request->tempat,
            'slug' => Str::slug($request->nama_kegiatan),
            'tgl_kegiatan' => $tanggalWaktu,
        ]);

        return redirect('/presence')->with('success', 'Data kegiatan berhasil diubah');
    }

    public function destroy($presence_id)
    {
        // Delete data detail absen
        $presenceDetail = PresenceDetail::where('presence_id', $presence_id)->get();
        foreach ($presenceDetail as $pd) {
            if ($pd->tanda_tangan) {
                Storage::delete('public/tanda_tangan/' . $pd->tanda_tangan);
            }
            $pd->delete();
        }

        // Delete presence
        $presence = Presence::findOrFail($presence_id);
        $presence->delete();

        return redirect('/presence')->with('success', 'Data kegiatan berhasil dihapus');
    }

}
