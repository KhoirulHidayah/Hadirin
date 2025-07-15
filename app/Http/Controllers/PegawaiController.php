<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\SimpleCustomerImporter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;


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
                            <i class="fas fa-eye"></i>
                        </a>';
                $btn .= '<a href="' . url('/pegawai/' . $row->id . '/edit') . '" class="btn btn-warning btn-sm me-1">
                            <i class="fas fa-edit"></i>
                        </a>';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/pegawai/' . $row->id) . '">'
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
            'title' => 'Tambah Pegawai',
            'list'  => ['Home', 'Daftar Pegawai', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah pegawai baru'
        ];
        $activeMenu = 'pegawai';

        return view('pegawai.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'nip'            => 'required|string|unique:pegawai,nip|max:100',
            'jabatan'        => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'no_hp'          => 'nullable|regex:/^[0-9]{10,15}$/',
            'asal_instansi'  => 'nullable|string|max:255',
        ]);

        Pegawai::create([
            'nama'           => $request->nama,
            'nip'            => $request->nip,
            'jabatan'        => $request->jabatan,
            'email'          => $request->email,
            'no_hp'          => $request->no_hp,
            'asal_instansi'  => $request->asal_instansi,
        ]);

        return redirect('/pegawai')->with('success', 'Data pegawai berhasil disimpan');
    }

    // Edit
    public function edit($id)
    {
        $Pegawai = Pegawai::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Edit Pegawai',
            'list'  => ['Home', 'Daftar Pegawai', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit data pegawai'
        ];

        $activeMenu = 'pegawai';

        return view('pegawai.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'Pegawai' => $Pegawai,
            'activeMenu' => $activeMenu
        ]);
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'nip'            => 'required|string|max:25|unique:pegawai,nip,' . $id,
            'jabatan'        => 'required|string|max:100',
            'email'          => 'nullable|email|max:100',
            'no_hp'          => 'nullable|string|max:20',
            'asal_instansi'  => 'nullable|string|max:150',
        ]);

        $pegawai = Pegawai::findOrFail($id);

        $pegawai->update([
            'nama'           => $request->nama,
            'nip'            => $request->nip,
            'jabatan'        => $request->jabatan,
            'email'          => $request->email,
            'no_hp'          => $request->no_hp,
            'asal_instansi'  => $request->asal_instansi,
        ]);

        return redirect('/pegawai')->with('success', 'Data pegawai berhasil diubah');
    }

    public function show($id)
    {
        $Pegawai = Pegawai::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail Data Pegawai',
            'list' => ['Home', 'Data Pegawai', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Data Pegawai'
        ];
        $activeMenu = 'pegawai';
        return view('pegawai.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Pegawai' => $Pegawai, 'activeMenu' => $activeMenu]);
    }

    // Delete
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect('/pegawai')->with('success', 'Data pegawai berhasil dihapus');
    }

public function import(Request $request)
{
    $validator = Validator::make($request->all(), [
        'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect('/pegawai')->with('error', $validator->errors()->first());
    }

    try {
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        Log::info('Import file: ' . $originalName);

        $importer = new SimpleCustomerImporter();
        Excel::import($importer, $file);

        $message = "Berhasil mengimpor {$importer->getInsertedCount()} data baru";
        if ($importer->getUpdatedCount() > 0) {
            $message .= " dan memperbarui {$importer->getUpdatedCount()} data yang sudah ada";
        }

        return redirect('/pegawai')->with('success', $message);

    } catch (\Exception $e) {
        Log::error('Import error: ' . $e->getMessage());
        return redirect('/pegawai')->with('error', 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage());
    }
}


public function downloadTemplate()
{
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header dan data contoh
    $headers = ['nip', 'nama', 'jabatan', 'email', 'no_hp', 'asal_instansi'];
    $data = ['1234567890123456', 'Contoh Nama', 'Pegawai', 'nama@email.com', '081234567890', 'UPT Malang'];

    foreach ($headers as $index => $header) {
        $col = chr(65 + $index); // A, B, C, ...
        $sheet->setCellValue($col . '1', $header);
        $sheet->setCellValue($col . '2', $data[$index]);

        // Set border untuk header dan contoh data
        $sheet->getStyle($col . '1:' . $col . '2')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Set auto width
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Styling header: Bold dan rata tengah
    $sheet->getStyle('A1:F1')->getFont()->setBold(true);
    $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Simpan file
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $fileName = 'template_pegawai.xlsx';
    $tempPath = storage_path('app/public/' . $fileName);
    $writer->save($tempPath);

    return response()->download($tempPath)->deleteFileAfterSend(true);
}

}
