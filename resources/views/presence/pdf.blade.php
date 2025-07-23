<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Daftar Hadir Rapat</title>
    <style>
        /* --- Pengaturan Dasar --- */
        body {
            font-family: Arial, sans-serif;
            font-size: 11px; /* Ukuran font dasar sedikit diperkecil */
            margin: 0;
        }

        .page-wrapper {
            border: 1px solid #ccc;
            padding: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* --- KOP Surat --- */
        .kop-surat {
            border: 1px solid #000;
            width: 100%;
        }

        .kop-surat td {
            vertical-align: middle;
            padding: 5px;
        }

        .logo-pln-cell {
            width: 12%;
            text-align: center;
        }
        
        .logo-pln {
            width: 60px;
        }

        .kop-title-cell {
            width: 70%;
            padding-left: 10px;
        }

        .kop-main-title {
            font-weight: bold;
            font-size: 14px;
        }

        .logo-kanan-cell {
            width: 3%;
            text-align: right;
            vertical-align: bottom;
            padding-bottom: 10px;
            padding-right: 0px;
        }

        .logo-kanan {
            display: inline-flex;
            justify-content: flex-end;
            align-items: flex-end;
            gap: 8px;
            margin-top: 15px;
            margin-right: 10px;
        }

        .logo-kanan img {
            width: 50px;
        }

        /* --- Baris Judul Formulir & Info Dokumen --- */
        .judul-form-cell {
            border: 1px solid #000;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            vertical-align: middle;
            padding: 8px;
        }

        /* --- Tabel Info Dokumen --- */
        .info-dokumen-cell {
            width: 30%;
            border: 1px solid #000;
            padding: 0;
            vertical-align: top;
        }
        .info-dokumen {
            font-size: 9px;
        }
        .info-dokumen td {
            border: 1px solid #000;
            padding: 2px 4px;
        }
        .info-dokumen td:first-child {
            width: 40%;
        }

        /* --- Informasi Rapat --- */
        .info-rapat {
            margin: 20px 0;
            font-size: 12px;
        }
        .info-rapat .label {
            width: 120px;
            font-weight: bold;
        }
        .info-rapat td {
            padding: 1px 0;
        }
        .info-rapat td:nth-child(2) {
            padding-left: 8px; /* Jarak untuk titik dua */
        }
        
        /* --- Tabel Utama Daftar Hadir --- */
        .tabel-hadir {
            table-layout: fixed; /* Mencegah kolom berubah ukuran */
        }
        .tabel-hadir th,
        .tabel-hadir td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word; /* Memastikan teks panjang tidak merusak layout */
        }
        .tabel-hadir thead th {
            text-align: center;
            font-weight: bold;
            background-color: #cfdce0; /* Latar abu-abu untuk header */
        }
        .tabel-hadir tbody td {
            text-align: left;
        }
        .tabel-hadir tbody td:first-child {
            text-align: center; /* Nomor urut di tengah */
        }
        .tabel-hadir .ttd-img {
            max-width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <!-- KOP SURAT -->
        <table class="kop-surat">
            <tr>
                <td class="logo-pln-cell">
                    <img src="{{ public_path('images/logo_pln.png') }}" class="logo-pln">
                </td>
                <td class="kop-title-cell">
                    <div class="kop-main-title">PT PLN (PERSERO)</div>
                    <div class="kop-main-title">UNIT INDUK TRANSMISI JAWA BAGIAN TIMUR DAN BALI</div>
                </td>
                <td class="logo-kanan-cell">
                    <div class="logo-kanan">
                        <img src="{{ public_path('images/logo_smk3.png') }}">
                        <img src="{{ public_path('images/logo_iso.png') }}">
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="judul-form-cell">
                    FORMULIR DAFTAR KEGIATAN RAPAT
                </td>
                <td class="info-dokumen-cell">
                    <table class="info-dokumen">
                        <tr>
                            <td><strong>No. Dokumen</strong></td>
                            <td>FK3.TJBTB.01.00.02</td>
                        </tr>
                        <tr>
                            <td><strong>Edisi / Revisi</strong></td>
                            <td>00 / 00</td>
                        </tr>
                        <tr>
                            <td><strong>BerlakuEfektif</strong></td>
                            <td>01 JANUARI 2019</td>
                        </tr>
                        <tr>
                            <td><strong>Halaman</strong></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- TABEL DAFTAR KEGIATAN -->
        <br>
        <table class="tabel-hadir">
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
