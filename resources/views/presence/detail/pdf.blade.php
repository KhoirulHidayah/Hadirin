<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Daftar Hadir Rapat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo {
            width: 60px;
        }
        .header-wrapper {
            border: 1px solid #000;
            padding: 5px;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            padding: 4px 0;
        }
        .doc-info {
            font-size: 11px;
            border: 1px solid black;
        }
        .doc-info td {
            border: 1px solid black;
            padding: 2px 5px;
        }
        .meeting-info {
            margin-top: 10px;
            font-size: 12px;
        }
        .meeting-info td {
            padding: 4px;
        }
        .meeting-info .label {
            width: 120px;
            font-weight: bold;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid black;
            padding: 4px;
        }
    </style>
</head>
<body>

    <div class="header-wrapper">
        <table>
            <tr>
                <td width="15%">
                    <img src="{{ public_path('logo_pln.png') }}" class="logo" alt="Logo PLN">
                </td>
                <td width="60%" style="text-align: center;">
                    <div style="font-weight: bold;">PT PLN (PERSERO)</div>
                    <div>UNIT INDUK TRANSMISI JAWA BAGIAN TIMUR DAN BALI</div>
                    <br>
                    <div class="header-title">FORMULIR DAFTAR HADIR RAPAT</div>
                </td>
                <td width="25%">
                    <table class="doc-info">
                        <tr>
                            <td>No. Dokumen</td>
                            <td>FK3.TJBTB.01.00.02</td>
                        </tr>
                        <tr>
                            <td>Edisi / Revisi</td>
                            <td>00 / 00</td>
                        </tr>
                        <tr>
                            <td>Berlaku Efektif</td>
                            <td>01 JANUARI 2019</td>
                        </tr>
                        <tr>
                            <td>Halaman</td>
                            <td>1 dari 4</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <br>

    <table class="meeting-info">
        <tr>
            <td class="label">Hari / Tanggal</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Waktu</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->format('H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Tempat</td>
            <td>:</td>
            <td>{{ $Presence->tempat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Rapat</td>
            <td>:</td>
            <td>{{ $Presence->nama_kegiatan ?? '-' }}</td>
        </tr>
    </table>

    <br>

    <table class="table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan/Bidang</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Unit/Instansi</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presence_details as $index => $presence_details)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $presence_details->nama }}</td>
                    <td>{{ $presence_details->nip }}</td>
                    <td>{{ $presence_details->jabatan }}</td>
                    <td>{{ $presence_details->email }}</td>
                    <td>{{ $presence_details->no_hp }}</td>
                    <td>{{ $presence_details->asal_instansi }}</td>
                    <td>
                        @if($presence_details->tanda_tangan)
                            <img src="{{ public_path('storage/tanda_tangan/' . $presence_details->tanda_tangan) }}" width="80">
                        @else
                            Tidak Ada
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
