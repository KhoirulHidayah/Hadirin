<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="generator" content="Microsoft Word">
    <meta http-equiv="Content-Type" content="application/msword; charset=UTF-8">
    <title>Formulir Daftar Hadir Rapat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            width: 21cm;
            max-width: 21cm;
        }

        .page-wrapper {
            border: 1px solid #ccc;
            padding: 15px;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .kop-surat {
            border: 1px solid #000;
            width: 100%;
        }

        .kop-surat td {
            vertical-align: middle;
            padding: 5px;
        }

        .logo-pln-cell {
            width: 80px;
            min-width: 80px;
            max-width: 80px;
            text-align: center;
        }

        .logo-pln {
            width: 60px !important;
            height: 60px !important;
            max-width: 60px !important;
            max-height: 60px !important;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .kop-title-cell {
            padding-left: 10px;
        }

        .kop-main-title {
            font-weight: bold;
            font-size: 14px;
        }

        .logo-kanan-cell {
            width: 120px;
            min-width: 120px;
            max-width: 120px;
            text-align: right;
            vertical-align: middle;
        }

        .logo-kanan {
            display: inline-block;
            margin-left: 5px;
        }

        .logo-kanan img {
            width: 45px !important;
            height: 45px !important;
            max-width: 45px !important;
            max-height: 45px !important;
            object-fit: contain;
            vertical-align: middle;
        }

        .judul-form-cell {
            border: 1px solid #000;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            padding: 8px;
        }

        .info-dokumen-cell {
            width: 200px;
            min-width: 200px;
            max-width: 200px;
            border: 1px solid #000;
            padding: 0;
            vertical-align: top;
        }

        .info-dokumen {
            font-size: 9px;
            width: 100%;
        }

        .info-dokumen td {
            border: 1px solid #000;
            padding: 2px 4px;
        }

        .info-dokumen td:first-child {
            width: 40%;
        }

        .info-rapat {
            margin: 10px 0 5px 0;
            font-size: 12px;
            width: 100%;
            line-height: 1;
        }

        .info-rapat .label {
            width: 120px;
            font-weight: bold;
        }

        .info-rapat td {
            padding: 0;
            line-height: 1;
            height: 14px;
            vertical-align: middle;
        }

        .info-rapat td:nth-child(2) {
            padding-left: 8px;
        }

        .info-rapat tr {
            height: 14px;
        }

        .tabel-hadir {
            table-layout: fixed;
            width: 100%;
        }

        .tabel-hadir th,
        .tabel-hadir td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
            overflow: hidden;
        }

        .tabel-hadir thead th {
            text-align: center;
            font-weight: bold;
            background-color: #cfdce0;
        }

        .tabel-hadir tbody td {
            text-align: left;
        }

        .tabel-hadir tbody td:first-child {
            text-align: center;
        }

        /* Kolom dengan lebar tetap */
        .col-no { width: 30px; min-width: 30px; max-width: 30px; }
        .col-nama { width: 120px; min-width: 120px; max-width: 120px; }
        .col-nip { width: 130px; min-width: 130px; max-width: 130px; }
        .col-jabatan { width: 100px; min-width: 100px; max-width: 100px; }
        .col-email { width: 110px; min-width: 110px; max-width: 110px; }
        .col-hp { width: 90px; min-width: 90px; max-width: 90px; }
        .col-ttd { width: 100px; min-width: 100px; max-width: 100px; }

        .ttd-container {
            width: 100%;
            height: 40px;
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .ttd-img {
            width: 50px !important;
            height: 30px !important;
            max-width: 50px !important;
            max-height: 30px !important;
            object-fit: contain;
            display: inline-block;
            vertical-align: middle;
        }

        /* Media query untuk print */
        @media print {
            body {
                width: 21cm;
                margin: 0;
            }
            
            .page-wrapper {
                border: none;
                padding: 0;
            }
            
            .logo-pln,
            .logo-kanan img,
            .ttd-img {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* Untuk kompatibilitas Word */
        img {
            border: 0;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <table class="kop-surat">
        <tr>
            <td class="logo-pln-cell">
                <img src="{{ asset('images/logo_pln.png') }}" 
                     class="logo-pln"
                     width="60" 
                     height="60"
                     alt="Logo PLN">
            </td>
            <td class="kop-title-cell">
                <div class="kop-main-title">PT PLN (PERSERO)</div>
                <div class="kop-main-title">UNIT INDUK TRANSMISI JAWA BAGIAN TIMUR DAN BALI</div>
            </td>
            <td class="logo-kanan-cell">
                <span class="logo-kanan">
                    <img src="{{ asset('images/logo_smk3.png') }}" 
                         width="45" 
                         height="45"
                         alt="Logo SMK3">
                </span>
                <span class="logo-kanan">
                    <img src="{{ asset('images/logo_iso.png') }}" 
                         width="45" 
                         height="45"
                         alt="Logo ISO">
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="judul-form-cell">
                FORMULIR DAFTAR HADIR RAPAT
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
                        <td><strong>Berlaku Efektif</strong></td>
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

    <table class="info-rapat">
        <tr>
            <td class="label">Hari / Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Waktu</td>
            <td>: {{ date('H:i', strtotime($Presence->tgl_kegiatan)) }} - {{ date('H:i', strtotime($Presence->waktu_selesai)) }}</td> 
        </tr>
        <tr>
            <td class="label">Tempat</td>
            <td>: {{ $Presence->tempat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Rapat</td>
            <td>: {{ $Presence->nama_kegiatan ?? '-' }}</td>
        </tr>
    </table>

    <table class="tabel-hadir">
        <thead>
            <tr>
                <th class="col-no">No.</th>
                <th class="col-nama">Nama</th>
                <th class="col-nip">NIP</th>
                <th class="col-jabatan">Jabatan/Bidang</th>
                <th class="col-email">Email</th>
                <th class="col-hp">No. HP</th>
                <th class="col-ttd">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presence_details as $index => $presence)
            <tr>
                <td class="col-no">{{ $index + 1 }}</td>
                <td class="col-nama">{{ $presence->nama }}</td>
                <td class="col-nip">{{ $presence->nip }}</td>
                <td class="col-jabatan">{{ $presence->jabatan }}</td>
                <td class="col-email">{{ $presence->email }}</td>
                <td class="col-hp">{{ $presence->no_hp }}</td>
                <td class="col-ttd">
                    <div class="ttd-container">
                        @if($presence->tanda_tangan)
                            <img src="{{ asset('storage/tanda_tangan/' . $presence->tanda_tangan) }}" 
                                 alt="TTD" 
                                 class="ttd-img"
                                 width="50"
                                 height="30">
                        @else
                            -
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>