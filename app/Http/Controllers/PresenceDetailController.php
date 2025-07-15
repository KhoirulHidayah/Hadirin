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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

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
        ])->setPaper('a4', 'portrait');

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

public function export_excel($id)
{
    // Ambil data Presence & PresenceDetail
    $Presence = Presence::findOrFail($id);
    $presence_details = PresenceDetail::where('presence_id', $id)->get();

    // Buat Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama');
    $sheet->setCellValue('C1', 'NIP');
    $sheet->setCellValue('D1', 'Email');
    $sheet->setCellValue('E1', 'Jabatan');
    $sheet->setCellValue('F1', 'No HP');
    $sheet->setCellValue('G1', 'Asal Instansi');
    $sheet->setCellValue('H1', 'Tanda Tangan');

    // Style header: bold & rata tengah
    $headerRange = 'A1:H1';
    $sheet->getStyle($headerRange)->getFont()->setBold(true);
    $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle($headerRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // Isi data
    $row = 2;
    $no = 1;

    foreach ($presence_details as $detail) {
        $sheet->setCellValue('A' . $row, $no);
        $sheet->setCellValue('B' . $row, $detail->nama);
        $sheet->setCellValue('C' . $row, $detail->nip);
        $sheet->setCellValue('D' . $row, $detail->email);
        $sheet->setCellValue('E' . $row, $detail->jabatan);
        $sheet->setCellValue('F' . $row, $detail->no_hp);
        $sheet->setCellValue('G' . $row, $detail->asal_instansi);

        // Teks rata tengah
        $sheet->getStyle('A' . $row . ':G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . $row . ':G' . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Tanda tangan
        $signaturePath = storage_path('app/public/tanda_tangan/' . $detail->tanda_tangan);
        if ($detail->tanda_tangan && file_exists($signaturePath)) {
            $drawing = new Drawing();
            $drawing->setName('Tanda Tangan');
            $drawing->setPath($signaturePath);
            $drawing->setHeight(35); // tinggi gambar px
            $drawing->setCoordinates('H' . $row);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        } else {
            $sheet->setCellValue('H' . $row, 'Tidak Ada');
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Tinggi baris agar tanda tangan tidak terpotong
        $sheet->getRowDimension($row)->setRowHeight(35);

        $row++;
        $no++;
    }

    // Kolom auto size A-G
    foreach (range('A', 'G') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    // Kolom tanda tangan fix width
    $sheet->getColumnDimension('H')->setWidth(20);

    // Judul sheet
    $sheet->setTitle('Daftar Hadir');

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

}
