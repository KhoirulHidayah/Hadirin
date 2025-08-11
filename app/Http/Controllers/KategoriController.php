<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Perusahaan',
            'list'  => ['Home', 'Data Perusahaan']
        ];
        $page = (object) [
            'title' => ''
        ];
        $activeMenu = 'kategori';
        // PERBAIKAN:
        return view('kategori.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $kategori = Kategori::select(['id', 'nama']);

            return DataTables::of($kategori)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $request->search['value'] != '') {
                        $search = $request->search['value'];
                        $query->where('nama', 'like', "%{$search}%");
                    }
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '<a href="' . route('kategori.edit', $row->id) . '" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"> Edit</i>
                            </a>';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . route('kategori.destroy', $row->id) . '">' .
                            csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin hapus kategori ini?\')">
                                <i class="fas fa-trash"> Hapus</i>
                            </button></form>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Perusahaan',
            'list'  => ['Home', 'Data Perusahaan', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah perusahaan baru'
        ];
        $activeMenu = 'kategori';
        return view('kategori.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kategori,nama|max:255',
        ]);

        Kategori::create($request->only('nama'));

        return redirect()->route('kategori.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Edit Perusahaan',
            'list'  => ['Home', 'Data Perusahaan', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit perusahaan'
        ];
        $activeMenu = 'kategori';
        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255|unique:kategori,nama,' . $id . ',id',
        ]);

        $kategori = Kategori::findOrFail($id);
        $namaLama = $kategori->nama;
        $namaBaru = $request->nama;

        // Update nama di tabel perusahaan
        $kategori->nama = $namaBaru;
        $kategori->save();

        // Update semua pegawai yang sebelumnya pakai nama perusahaan lama
        \App\Models\Pegawai::where('kategori', $namaLama)
            ->update(['kategori' => $namaBaru]);

        // Update semua pegawai yang sebelumnya pakai nama perusahaan lama
        \App\Models\AsalInstansi::where('kategori_nama', $namaLama)
            ->update(['kategori_nama' => $namaBaru]);
        return redirect()->route('kategori.index')->with('success', 'Perusahaan dan data pegawai terkait berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
