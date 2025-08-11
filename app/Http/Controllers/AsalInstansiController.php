<?php

namespace App\Http\Controllers;

use App\Models\AsalInstansi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AsalInstansiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Unit',
            'list'  => ['Home', 'Daftar Unit']
        ];
        $page = (object) [
            'title' => 'Daftar asal instansi yang terdaftar dalam sistem'
        ];
        $activeMenu = 'asal_instansi';
        $kategori = Kategori::all();

        return view('asal_instansi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $asalInstansi = AsalInstansi::select('id', 'asal_instansi', 'kategori_nama')
            ->with('kategori');

        if ($request->filled('kategori_nama')) {
            $asalInstansi->where('kategori_nama', $request->kategori_nama);
        }

        return DataTables::of($asalInstansi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . route('asal_instansi.edit', $row->id) . '" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"> Edit</i>
                            </a>';
                $btn .= '<form class="d-inline-block" method="POST" action="' . route('asal_instansi.destroy', $row->id) . '">' .
                                csrf_field() . method_field('DELETE') .
                                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin hapus asal instansi ini?\')">
                                    <i class="fas fa-trash"> Hapus</i>
                                </button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Unit',
            'list'  => ['Home', 'Daftar Unit', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah unit baru'
        ];
        $activeMenu = 'asal_instansi';
        $kategori = Kategori::all(); // Mengambil semua data kategori

        return view('asal_instansi.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required|unique:asal_instansi,asal_instansi|max:255',
            'kategori_nama' => 'required|exists:kategori,nama' // Perbaikan: Gunakan nama kolom yang benar di tabel kategori
        ]);

        AsalInstansi::create([
            'asal_instansi' => $request->nama_instansi, // Perbaikan: Gunakan nama input dari view
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect()->route('asal_instansi.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function edit(AsalInstansi $asalInstansi)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Unit',
            'list'  => ['Home', 'Edit Unit', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit unit'
        ];
        $activeMenu = 'asal_instansi';
        $kategori = Kategori::all();

        return view('asal_instansi.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'asalInstansi' => $asalInstansi,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asal_instansi' => 'required|max:255|unique:asal_instansi,asal_instansi,' . $id . ',id',
            'kategori_nama' => 'required|exists:kategori,nama'
        ]);

        $asalInstansi = AsalInstansi::findOrFail($id);
        $namaLama = $asalInstansi->asal_instansi;

        // Update di tabel asal_instansi
        $asalInstansi->asal_instansi = $request->asal_instansi;
        $asalInstansi->kategori_nama = $request->kategori_nama;
        $asalInstansi->save();

        // Update di tabel pegawai (jika asal_instansi cocok)
        \App\Models\Pegawai::whereRaw('TRIM(asal_instansi) = ?', [trim($namaLama)])
            ->update(['asal_instansi' => $request->asal_instansi]);

        return redirect()->route('asal_instansi.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(AsalInstansi $asalInstansi)
    {
        $asalInstansi->delete();

        return redirect()->route('asal_instansi.index')->with('success', 'Unit berhasil dihapus.');
    }
}