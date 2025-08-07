<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Kategori; // Make sure this Kategori model exists and is correctly structured
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\SimpleCustomerImporter; // Make sure this path is correct
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
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
        // Ambil daftar asal_instansi unik saja untuk filter dropdown
        $instansiList = Pegawai::select('asal_instansi')->distinct()->pluck('asal_instansi')->sort(); // Added ->sort() for alphabetical order

        // Ambil daftar kategori (Perusahaan) unik saja untuk filter dropdown
        $kategoriList = Pegawai::select('kategori')->distinct()->pluck('kategori')->sort(); // Added ->sort() for alphabetical order

        $activeMenu = 'pegawai';
        return view('pegawai.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'instansiList' => $instansiList, // dikirim ke view
            'kategoriList' => $kategoriList // <--- NEW: Dikirim ke view untuk filter Perusahaan
        ]);
    }

    public function list(Request $request)
    {
        $Pegawai = Pegawai::select('id', 'nama', 'nip', 'jabatan', 'email', 'no_hp', 'asal_instansi', 'kategori');

        // Tambahkan filter jika ada
        if ($request->has('asal_instansi') && $request->asal_instansi != '') {
            $Pegawai->where('asal_instansi', $request->asal_instansi);
        }

        // <--- NEW: Tambahkan filter untuk kategori (Perusahaan)
        if ($request->has('kategori') && $request->kategori != '') {
            $Pegawai->where('kategori', $request->kategori);
        }

        return DataTables::of($Pegawai)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn  = '<a href="' . url('/pegawai/detail/' . $row->id) . '" class="btn btn-info btn-sm me-1">
                                <i class="fas fa-eye"> Detail</i>
                            </a>';
                $btn .= '<a href="' . url('/pegawai/' . $row->id . '/edit') . '" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"> Edit</i>
                            </a>';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/pegawai/' . $row->id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin hapus data ini?\')">
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
            'title' => 'Tambah Pegawai',
            'list'  => ['Home', 'Daftar Pegawai', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah pegawai baru'
        ];
        $activeMenu = 'pegawai';
        // Ambil semua data kategori dari tabel kategori
        // It's good practice to ensure 'pluck' results are array for consistency if using them in a dropdown.
        // If Kategori table has 'nama' column for category names, this is correct.
        $kategoriList = Kategori::pluck('nama', 'nama'); // ['nama_kategori' => 'nama_kategori']
        return view('pegawai.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kategoriList' => $kategoriList
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:255',
            'nip'             => 'required|string|unique:pegawai,nip|max:100',
            'jabatan'         => 'required|string|max:255',
            'email'           => 'nullable|email|max:255',
            'no_hp'           => 'nullable|regex:/^[0-9]{10,15}$/',
            'asal_instansi'   => 'nullable|string|max:255',
            'kategori'        => 'nullable|string|max:100|exists:kategori,nama', // Ensure 'kategori' exists in 'kategori' table 'nama' column
        ]);

        Pegawai::create([
            'nama'            => $request->nama,
            'nip'             => $request->nip,
            'jabatan'         => $request->jabatan,
            'email'           => $request->email,
            'no_hp'           => $request->no_hp,
            'asal_instansi'   => $request->asal_instansi,
            'kategori'        => $request->kategori
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
        // Ambil semua data kategori dari tabel kategori
        $kategoriList = Kategori::pluck('nama', 'nama');
        return view('pegawai.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'Pegawai' => $Pegawai,
            'activeMenu' => $activeMenu,
            'kategoriList' => $kategoriList
        ]);
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'            => 'required|string|max:100',
            'nip'             => 'required|string|max:25|unique:pegawai,nip,' . $id,
            'jabatan'         => 'required|string|max:100',
            'email'           => 'nullable|email|max:100',
            'no_hp'           => 'nullable|string|max:20',
            'asal_instansi'   => 'nullable|string|max:150',
            'kategori'        => 'nullable|string|max:100|exists:kategori,nama', // Ensure 'kategori' exists in 'kategori' table 'nama' column
        ]);

        $pegawai = Pegawai::findOrFail($id);

        $pegawai->update([
            'nama'            => $request->nama,
            'nip'             => $request->nip,
            'jabatan'         => $request->jabatan,
            'email'           => $request->email,
            'no_hp'           => $request->no_hp,
            'asal_instansi'   => $request->asal_instansi,
            'kategori'        => $request->kategori,
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

            // Ambil ringkasan
            $inserted = $importer->getInsertedCount();
            $updated = $importer->getUpdatedCount();
            $errors = $importer->getErrors();

            // Rangkai pesan
            $message = "Berhasil mengimpor {$inserted} data baru";
            if ($updated > 0) {
                $message .= " dan memperbarui {$updated} data.";
            } else {
                $message .= ".";
            }

            // Jika ada error
            if (count($errors) > 0) {
                return redirect('/pegawai')
                    ->with('error', $message . ' Namun ada data yang gagal diproses.')
                    ->with('import_errors', $errors);
            }

            return redirect('/pegawai')->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return redirect('/pegawai')->with('error', 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage());
        }
    }
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ==========================
        // 1. Header Kolom
        // ==========================
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'NIP');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Jabatan');
        $sheet->setCellValue('F1', 'No HP');
        $sheet->setCellValue('G1', 'Unit');
        $sheet->setCellValue('H1', 'Perusahaan');

        // Format kolom sebagai teks
        $sheet->getStyle('C:C')->getNumberFormat()->setFormatCode('@');
        $sheet->getStyle('F:F')->getNumberFormat()->setFormatCode('@');

        // ==========================
        // 2. Data Contoh
        // ==========================
        $dataContoh = [
            ['1', 'John Doe',     '0123456789012345', 'john.doe@email.com',   'Manager',      '081234567890', 'UPT Malang',   'PLN UIT JBM'],
            ['2', 'Jane Smith',   '0098765432109876', 'jane.smith@email.com',  'Staff',       '082345678901', 'UPT Surabaya', 'PLN UIT JBT'],
            ['3', 'Ahmad Wijaya', '0001234567890123', 'ahmad.wijaya@email.com', 'Supervisor', '085123456789', 'UPT Jakarta',  'PLN UIT JBB'],
        ];

        foreach ($dataContoh as $index => $data) {
            $row = $index + 2;
            [$no, $nama, $nip, $email, $jabatan, $hp, $unit, $perusahaan] = $data;

            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $nama);
            $sheet->setCellValueExplicit("C{$row}", $nip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue("D{$row}", $email);
            $sheet->setCellValue("E{$row}", $jabatan);
            $sheet->setCellValueExplicit("F{$row}", $hp, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue("G{$row}", $unit);
            $sheet->setCellValue("H{$row}", $perusahaan);
        }

        // ==========================
        // 3. Styling Header
        // ==========================
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50']
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Border dan warna baris bergantian
        $sheet->getStyle('A1:H4')->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A2:H2')->getFill()->setFillType('solid')->getStartColor()->setRGB('F8F9FA');
        $sheet->getStyle('A4:H4')->getFill()->setFillType('solid')->getStartColor()->setRGB('F8F9FA');

        // ==========================
        // 4. Auto Width & Column Width
        // ==========================
        $columns = ['A' => 8, 'B' => 20, 'C' => 20, 'D' => 25, 'E' => 15, 'F' => 15, 'G' => 18, 'H' => 18];
        foreach ($columns as $col => $width) {
            $sheet->getColumnDimension($col)->setAutoSize(true)->setWidth($width);
        }

        // ==========================
        // 5. Ketentuan Pengisian
        // ==========================
        $notes = [
            'A6'  => 'KETENTUAN PENGISIAN DATA:',
            'A7'  => '• No: Nomor urut (boleh dikosongkan)',
            'A8'  => '• Nama: Wajib diisi, nama lengkap pegawai',
            'A9'  => '• NIP: Wajib diisi, unik, maksimal 25 karakter (angka 0 di depan akan dipertahankan)',
            'A10' => '• Email: Wajib diisi, format valid (contoh: user@email.com)',
            'A11' => '• Jabatan: Wajib diisi, sesuai jabatan/bidang kerja',
            'A12' => '• No HP: Wajib diisi, minimal 10 digit angka (angka 0 di depan akan dipertahankan)',
            'A13' => '• Unit: Wajib diisi, nama unit/instansi asal',
            'A14' => '• Perusahaan: Wajib diisi, harus PERSIS sesuai data kategori di database',
        ];

        foreach ($notes as $cell => $text) {
            $sheet->setCellValue($cell, $text);
            $sheet->mergeCells(str_replace('A', 'A', $cell) . ':I' . substr($cell, 1));
        }

        $sheet->getStyle('A6')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'FFC107']
            ],
        ]);
        $sheet->getStyle('A7:A14')->getFont()->setSize(10);
        $sheet->getStyle('A7:A14')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A6:I14')->getBorders()->getOutline()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        // ==========================
        // 6. Catatan Penting
        // ==========================
        $sheet->setCellValue('A17', 'PENTING:');
        $sheet->mergeCells('A17:I17');
        $sheet->getStyle('A17')->getFont()->setBold(true)->getColor()->setRGB('DC3545');

        $sheet->setCellValue('A18', 'Kolom NIP dan No HP sudah diformat sebagai TEXT untuk mempertahankan angka 0 di depan.');
        $sheet->setCellValue('A19', 'Jangan mengubah format kolom tersebut agar angka tetap utuh saat import.');
        $sheet->mergeCells('A18:I18');
        $sheet->mergeCells('A19:I19');

        $sheet->getStyle('A18:A19')->getFont()->setSize(10);
        $sheet->getStyle('A18:A19')->getAlignment()->setWrapText(true);

        // ==========================
        // 7. Format Tambahan
        // ==========================
        $sheet->getRowDimension(1)->setRowHeight(25); // Header
        $sheet->getRowDimension(6)->setRowHeight(20); // Ketentuan
        $sheet->freezePane('A2');

        // ==========================
        // 8. Simpan dan Download
        // ==========================
        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_pegawai_' . date('Y-m-d_H-i-s') . '.xlsx';
        $tempPath = storage_path('app/temp/' . $fileName);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $writer->save($tempPath);

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }
}