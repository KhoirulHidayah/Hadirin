@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-body small-detail">
            @empty($Pegawai)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data pegawai yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('pegawai') }}" class="btn btn-sm btn-secondary mt-2">Kembali</a>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th style="width: 30%">ID Pegawai</th>
                        <td>{{ $Pegawai->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $Pegawai->nama }}</td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td>{{ $Pegawai->nip }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan/Bidang</th>
                        <td>{{ $Pegawai->jabatan }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $Pegawai->email }}</td>
                    </tr>
                    <tr>
                        <th>No.HP</th>
                        <td>{{ $Pegawai->no_hp }}</td>
                    </tr>
                    <tr>
                        <th>Unit/Instansi</th>
                        <td>{{ $Pegawai->asal_instansi }}</td>
                    </tr>
                </table>

                <!-- Tombol Kembali -->
                <div class="mt-3">
                    <a href="{{ url('pegawai') }}" class="btn btn-sm btn-secondary">Kembali</a>
                </div>
            @endempty
        </div>
    </div>
@endsection

@push('css')
<style>
    .small-detail {
        font-size: 0.875rem; /* 14px */
    }
    .table td, .table th {
        padding: 0.35rem 0.5rem;
        vertical-align: middle;
    }
</style>
@endpush

@push('js')
@endpush
