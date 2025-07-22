<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kegiatan Rapat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .page-wrapper {
            border: 1px solid #0000007c; /* Garis tepi tipis */
            padding: 10px;          /* Jarak isi ke tepi */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-wrapper {
            border: 1px solid #000;
        }

        .kop-logo {
            width: 50px;
            height: auto;
        }

        .kop-title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .kop-subtitle {
            text-align: center;
            font-size: 12px;
        }

        .doc-info {
            border: 1px solid #000;
            font-size: 11px;
        }

        .doc-info td {
            border: 1px solid #000;
            padding: 2px 6px;
        }

        .kop-header td {
            vertical-align: top;
        }

        .header-title-row td {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
            padding: 6px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 4px;
        }

        .meeting-info {
            margin: 10px 0;
        }

        .meeting-info td:nth-child(2) {
            padding-left: 4px;
        }

        .label {
            width: 120px;
            font-weight: bold;
        }

        .table-bordered {
    table-layout: fixed;
    width: 100%;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid black;
    padding: 4px;
    vertical-align: top;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.table-bordered td img {
    max-width: 70px;   /* dibatasi */
    height: auto;
    display: block;
    margin: auto;
}

    </style>
</head>
<body>
    <div class="page-wrapper">
        <table class="kop-wrapper" style="width: 100%; border-collapse: collapse;">
            <!-- Baris 1: KOP -->
            <tr style="border-bottom: 1px solid black;">
                <!-- Logo PLN -->
                <td width="15%" style="text-align: center; vertical-align: middle; padding: 5px;">
                <img src="{{ public_path('images/logo_pln.png') }}" style="width: 60px;"><br>
                </td>
                <!-- Judul Tengah -->
                <td width="70%" style="text-align: left; vertical-align: middle; padding: 0px;">
                <div style="font-weight: bold; font-size: 15px; line-height: 1.2; margin: 2px 0;">PT PLN (PERSERO)</div>
                <div style="font-weight: bold; font-size: 15px; line-height: 1.2; margin: 2px 0;">UNIT INDUK TRANSMISI JAWA BAGIAN TIMUR DAN BALI</div>
                </td>
                <!-- Logo SMK3 dan ISO -->
                <td width="25%" style="text-align: center; vertical-align: middle; padding: 5px;">
                <img src="{{ public_path('images/logo_smk3.jpg') }}" style="width: 45px; margin-top: 24px;">
                <img src="{{ public_path('images/logo_iso.png') }}" style="width: 60px; margin-top: 16px;">
                </td>
            </tr>
            <!-- Baris 2: Judul Formulir + Info Dokumen -->
            <tr>
                <!-- Kolom kiri: Judul Formulir (gabung 2 kolom) -->
                <td colspan="2" style="
                    border: 1px solid #000;
                    text-align: center;
                    font-weight: bold;
                    font-size: 20px;
                    vertical-align: middle;
                    padding: 4px;
                ">
                    DAFTAR KEGIATAN RAPAT
                </td>

                <!-- Kolom kanan: Info Dokumen -->
                <td style="border: 1px solid #000; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
                        <tr>
                            <td style="border: 1px solid #000; padding: 1px; width: 40%;">No. Dokumen</td>
                            <td style="border: 1px solid #000; padding: 1px; width: 60%;">FK3.TJBTB.01.00.02</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 1px;">Edisi / Revisi</td>
                            <td style="border: 1px solid #000; padding: 1px;">00 / 00</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 1px;">BerlakuEfektif</td>
                            <td style="border: 1px solid #000; padding: 1px;">01 JANUARI 2019</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 1px;">Halaman</td>
                            <td style="border: 1px solid #000; padding: 1px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Tabel Daftar Kegiatan -->
        <br>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 16%;">Kode Kegiatan</th>
                    <th style="width: 23%;">Nama Kegiatan</th>
                    <th style="width: 14%;">Tempat</th>
                    <th style="width: 12%;">Tanggal Kegiatan</th>
                    <th style="width: 10%;">Waktu Mulai</th>
                    <th style="width: 10%;">Waktu Selesai</th>
                    <th style="width: 10%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presences as $index => $presence)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $presence->presence_id }}</td>
                    <td>{{ $presence->nama_kegiatan }}</td>
                    <td>{{ $presence->tempat }}</td>
                    <td>{{ \Carbon\Carbon::parse($presence->tgl_kegiatan)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($presence->tgl_kegiatan)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($presence->waktu_selesai)->format('H:i') }}</td>
                    <td>{{ $presence->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
