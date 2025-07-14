<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
        public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Pegawai',
            'list'  => ['Home', 'Data Pegawai']
        ];
        $page = (object) [
            'title' => ''
        ];
        $Pegawai = Pegawai::all();
        $activeMenu = 'pegawai';
        return view('pegawai.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

        public function list(Request $request)
    {
        $Pegawai = Pegawai::select('id', 'nama', 'nip', 'jabatan', 'email', 'no_hp', 'asal_instansi');

        return DataTables::of($Pegawai)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn  = '<a href="' . url('/pegawai/detail/' . $row->id) . '" class="btn btn-info btn-sm me-1">
                            <i class="fas fa-eye"></i> Detail
                        </a>';
                $btn .= '<a href="' . url('/pegawai/' . $row->id . '/edit') . '" class="btn btn-warning btn-sm me-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/pegawai/' . $row->id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin hapus data ini?\')">
                        <i class="fas fa-trash"></i> Hapus
                    </button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

}
