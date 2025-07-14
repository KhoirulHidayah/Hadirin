@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button type="button" onclick="copyLink()" class="btn btn-warning btn-sm">
                <i class="fas fa-link"></i> Copy Link
            </button>
            <a href="{{ route('presence_details.export.pdf', ['id' => $Presence->presence_id]) }}" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Export to PDF
            </a>
            <a href="{{ url('presence') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-borderless">
            <tr>
                <td width="150">Nama Kegiatan</td>
                <td width="20">:</td>
                <td>{{ $Presence->nama_kegiatan }}</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>:</td>
                <td>{{ $Presence->tempat }}</td>
            </tr>
            <tr>
                <td>Tanggal Kegiatan</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>:</td>
                <td>{{ date('H:i', strtotime($Presence->tgl_kegiatan)) }}</td>
            </tr>
        </table>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm w-100" id="presences">
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
                        <th class="text-center align-middle">Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
    data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
<script>
    let table;

    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function () {
        table = $('#presences').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('presence_details/list') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    presence_id: '{{ $Presence->presence_id }}'
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama', name: 'nama' },
                { data: 'nip', name: 'nip' },
                { data: 'jabatan', name: 'jabatan' },
                { data: 'email', name: 'email' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'asal_instansi', name: 'asal_instansi' },
                {
                    data: 'tanda_tangan', name: 'tanda_tangan',
                    render: function (data) {
                        return `<img src="/storage/tanda_tangan/${data}" width="80"/>`;
                    }
                },
                {
                    data: 'id', orderable: false, searchable: false, className: 'text-center',
                    render: function (data) {
                        return `
                            <form action="/presence_details/${data}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>`;
                    }
                }
            ]
        });

        // Fix lebar kolom saat sidebar pushmenu toggle
        $(document).on('shown.lte.pushmenu collapsed.lte.pushmenu', function () {
            setTimeout(() => {
                table.columns.adjust().draw(false);
            }, 300);
        });
    });

    function copyLink() {
        navigator.clipboard.writeText("{{ route('absen.index', $Presence->slug) }}");
        alert('Link berhasil dicopy ke clipboard!');
    }
</script>
@endpush

@push('css')
<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    .content-wrapper {
        overflow-x: hidden;
        padding: 10px;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    .main-sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 1031;
    }

    .main-footer {
        border-top: 1px solid #dee2e6;
        background: #fff;
        padding: 10px;
        text-align: center;
    }

    .card-body {
        overflow-x: auto;
    }

    table#presences {
        font-size: 12px;
        width: 100% !important;
        table-layout: auto;
    }

    table#presences th,
    table#presences td {
        padding: 4px 6px !important;
        vertical-align: middle;
        white-space: nowrap;
    }

    table#presences td:nth-child(9) {
        width: 80px;
        text-align: center;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 12px;
    }

    .btn-sm-custom {
        padding: 2px 6px;
        font-size: 11px;
        line-height: 1;
        border-radius: 3px;
    }

    table#presences img {
        max-width: 80px;
        height: auto;
    }

    table.table-borderless td {
        padding: 2px 6px !important;
        font-size: 14px;
        vertical-align: top;
    }
</style>
@endpush
