<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use App\Models\Kategori;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill; // Import Fill for background color
use PhpOffice\PhpSpreadsheet\Style\Border; // Import Border for borders
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

class PresenceDetailController extends Controller
{
    public function list(Request $request)
    {
        $data = PresenceDetail::where('presence_id', $request->presence_id);

        // Tambahkan filter jika ada input 'asal_instansi'
        if ($request->filled('asal_instansi')) {
            $data->where('asal_instansi', $request->asal_instansi);
        }

        // Tambahkan filter jika ada input 'kategori'
        if ($request->filled('kategori')) {
            $data->where('kategori', $request->kategori);
        }

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('waktu_absen', function ($row) {
                return $row->waktu_absen ? Carbon::parse($row->waktu_absen)->format('d-m-Y H:i:s') : '-';
            })
            // Gunakan nama kolom yang benar: 'kategori'
            ->editColumn('kategori', function ($row) {
                return $row->kategori ?? '-';
            })
            // Alias untuk kompatibilitas dengan DataTable HTML jika diperlukan
            ->addColumn('kategori_nama', function ($row) {
                return $row->kategori ?? '-';
            })
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
            'kategori' => 'required|string|max:255',
            'tanda_tangan' => 'required',
        ]);

        // Cek apakah email sudah digunakan untuk presence_id yang sama
        $alreadyExists = PresenceDetail::where('presence_id', $request->presence_id)
            ->where('email', $request->email)
            ->exists();

        if ($alreadyExists) {
            return back()->with('error', 'Anda sudah melakukan absensi untuk kegiatan ini.');
        }

        // Proses simpan tanda tangan
        $data = $request->tanda_tangan;
        $image = str_replace('data:image/png;base64,', '', $data);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::uuid() . '.png';
        Storage::put("public/tanda_tangan/{$imageName}", base64_decode($image));

        PresenceDetail::create([
            'presence_id' => $request->presence_id,
            'waktu_absen' => now(),
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'asal_instansi' => $request->asal_instansi,
            'kategori' => $request->kategori,
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

        // Ambil data kategori dari model Kategori
        $categories = Kategori::all();

        // Ambil daftar asal_instansi unik dari tabel pegawai
        $instansiList = Pegawai::select('asal_instansi')
            ->distinct()
            ->whereNotNull('asal_instansi')
            ->where('asal_instansi', '!=', '')
            ->orderBy('asal_instansi')
            ->pluck('asal_instansi');

        return view('absen.index', compact('Presence', 'presence_details', 'categories', 'instansiList'));
    }

    public function export_pdf(Request $request, $id)
    {
        $Presence = Presence::findOrFail($id);

        $presence_details = PresenceDetail::where('presence_id', $id);

        if ($request->filled('instansi')) {
            $presence_details->where('asal_instansi', $request->instansi);
        }

        if ($request->filled('kategori')) {
            $presence_details->where('kategori', $request->kategori);
        }

        $presence_details = $presence_details->get();

        $pdf = PDF::loadView('presence.detail.pdf', [
            'Presence' => $Presence,
            'presence_details' => $presence_details
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Daftar-Hadir-' . $Presence->nama_kegiatan . '-' . now()->format('Ymd_His') . '.pdf');
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

    public function export_excel($id)
    {
        // Ambil data Presence & PresenceDetail
        $Presence = Presence::findOrFail($id);
        $presence_details = PresenceDetail::where('presence_id', $id)->get();

        // Buat Spreadsheet
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
        $sheet->setCellValue('H1', 'Perusahaan'); // Added Perusahaan (Kategori) column
        $sheet->setCellValue('I1', 'Tanda Tangan'); // Moved Tanda Tangan to last column

        // ==========================
        // 2. Styling Header (matching PegawaiController's downloadTemplate)
        // ==========================
        $headerRange = 'A1:I1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50']
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]], // Add borders to header
        ]);

        // ==========================
        // 3. Isi Data
        // ==========================
        $row = 2;
        $no = 1;

        foreach ($presence_details as $detail) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $detail->nama);
            $sheet->setCellValueExplicit('C' . $row, (string)$detail->nip, DataType::TYPE_STRING); // NIP as string
            $sheet->setCellValue('D' . $row, $detail->email);
            $sheet->setCellValue('E' . $row, $detail->jabatan);
            $sheet->setCellValueExplicit('F' . $row, (string)$detail->no_hp, DataType::TYPE_STRING); // No HP as string
            $sheet->setCellValue('G' . $row, $detail->asal_instansi);
            $sheet->setCellValue('H' . $row, $detail->kategori ?? '-'); // Perusahaan (Kategori) data

            // Apply styling for data rows
            $sheet->getStyle('A' . $row . ':I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $row . ':I' . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $row . ':I' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            // Add alternating row colors (optional, matching template style)
            if ($no % 2 == 0) {
                $sheet->getStyle('A' . $row . ':I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8F9FA');
            }

            // Tanda tangan
            $signaturePath = storage_path('app/public/tanda_tangan/' . $detail->tanda_tangan);
            if ($detail->tanda_tangan && file_exists($signaturePath)) {
                $drawing = new Drawing();
                $drawing->setName('Tanda Tangan');
                $drawing->setPath($signaturePath);
                $drawing->setHeight(35); // height in pixels
                $drawing->setCoordinates('I' . $row); // Column I for Tanda Tangan
                $drawing->setOffsetX(5);
                $drawing->setOffsetY(5);
                $drawing->setWorksheet($sheet);
            } else {
                $sheet->setCellValue('I' . $row, 'Tidak Ada');
            }

            // Set row height for signature visibility
            $sheet->getRowDimension($row)->setRowHeight(35);

            $row++;
            $no++;
        }

        // ==========================
        // 4. Auto Width & Column Width
        // ==========================
        $columns = ['A' => 8, 'B' => 20, 'C' => 20, 'D' => 25, 'E' => 15, 'F' => 15, 'G' => 18, 'H' => 18, 'I' => 20]; // Adjusted width for 'I'
        foreach ($columns as $col => $width) {
            // Use setWidth directly as autoSize might override specific widths
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // Apply text format for NIP and No HP columns to preserve leading zeros
        $sheet->getStyle('C:C')->getNumberFormat()->setFormatCode(DataType::TYPE_STRING);
        $sheet->getStyle('F:F')->getNumberFormat()->setFormatCode(DataType::TYPE_STRING);


        // ==========================
        // 5. Final Touches
        // ==========================
        $sheet->setTitle('Daftar Hadir');
        $sheet->freezePane('A2'); // Freeze header row

        // Buat file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Daftar Absensi - ' . $Presence->nama_kegiatan . ' - ' . now()->format('Ymd_His') . '.xlsx';

        // Bersihkan buffer output
        if (ob_get_contents()) ob_end_clean();

        // Download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportWord($id)
    {
        $Presence = Presence::findOrFail($id);
        $presence_details = PresenceDetail::where('presence_id', $id)->get();

        return response()->view('presence.detail.word', [
            'Presence' => $Presence,
            'presence_details' => $presence_details
        ])
        ->header('Content-Type', 'application/vnd.ms-word')
        ->header('Content-Disposition', 'attachment; filename="Daftar Absensi - ' . $Presence->nama_kegiatan . ' - ' . now()->format('Ymd_His') . '.doc"');
    }

    public function getPegawaiByKategori($kategori)
    {
        $pegawai = Pegawai::where('kategori', $kategori)->get();

        return response()->json($pegawai);
    }
}