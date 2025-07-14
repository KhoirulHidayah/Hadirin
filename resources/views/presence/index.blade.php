@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-body">
        <div class="text-right mb-3">
            <a class="btn btn-primary" href="{{ url('presence/create') }}">
                <i class="fas fa-plus"></i> Tambah Kegiatan
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="presences">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Kegiatan</th>
                    <th>Nama Kegiatan</th>
                    <th>Tempat</th>
                    <th>Slug</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Waktu Mulai</th>
                    <th>Opsi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal tetap aktif -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
     data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
<style>
    table#presences {
        font-size: 12px;
        width: 100% !important;
        table-layout: auto;
    }

    table#presences th,
    table#presences td {
        padding: 4px 6px !important;
        vertical-align: middle !important;
        white-space: nowrap;
    }

    table#presences td:nth-child(8),
    table#presences th:nth-child(8) {
        width: 90px !important;
        text-align: center;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 12px;
    }

    .btn-sm-custom {
        padding: 1px 5px;
        font-size: 10px;
        line-height: 1;
        border-radius: 3px;
        margin: 1px;
    }
</style>
@endpush

@push('js')
<script>
let presenceTable;

function modalAction(url = '') {
    $('#myModal').load(url, function () {
        $('#myModal').modal('show');
    });
}

$(document).ready(function () {
    presenceTable = $('#presences').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('presence/list') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: 'presence_id', name: 'presence_id' },
            { data: 'nama_kegiatan', name: 'nama_kegiatan' },
            { data: 'tempat', name: 'tempat' },
            { data: 'slug', name: 'slug' },
            { data: 'tgl_kegiatan', name: 'tgl_kegiatan' },
            { data: 'waktu_mulai', name: 'waktu_mulai' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: "text-center" }
        ]
    });

    // Re-adjust DataTable columns after sidebar is toggled
    document.addEventListener('shown.lte.pushmenu', function () {
        setTimeout(() => {
            presenceTable.columns.adjust().draw(false);
        }, 300);
    });

    document.addEventListener('collapsed.lte.pushmenu', function () {
        setTimeout(() => {
            presenceTable.columns.adjust().draw(false);
        }, 300);
    });
});
</script>
@endpush
