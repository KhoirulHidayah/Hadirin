@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-body">
        <div class="text-right mb-3">
                <button type="button" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import"></i> Import Data
                </button>
                <a class="btn btn-primary btn-sm" href="{{ url('pegawai/create') }}">
                    <i class="fas fa-plus"></i> Tambah Pegawai
                </a> 
        </div>
        <!-- Tabel -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="pegawai">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pegawai</th>
                        <th>NIP</th>
                        <th>Jabatan/Bidang</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Unit/Instansi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/pegawai/import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="file">Pilih File Excel (.xlsx / .csv)</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                    <small class="form-text text-muted">Format header kolom: nip, nama, jabatan, email, no_hp, asal_instansi</small>

                    <!-- Tombol Download Template -->
                    <div class="mt-2">
                        <a href="{{ route('pegawai.template') }}" class="btn btn-sm btn-outline-primary">
                            Download Template
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Import</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('css')
<style>
    table#pegawai {
        font-size: 12px;
        width: 100% !important;
        table-layout: auto;
    }

    table#pegawai th,
    table#pegawai td {
        padding: 4px 6px !important;
        vertical-align: middle !important;
        white-space: nowrap;
    }

    table#pegawai td:nth-child(8),
    table#pegawai th:nth-child(8) {
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

    
    /* Styling tombol Import dan Tambah Pegawai */
    .card-body.text-right .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.2;
    }

    .card-body.text-right .btn-sm i {
        margin-right: 0.35em;
        vertical-align: middle;
    }

    .card-body.text-right .mr-2 {
        margin-right: 0.5rem;
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
    presenceTable = $('#pegawai').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('pegawai/list') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: 'nama', name: 'nama' },
            { data: 'nip', name: 'nip' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' }, 
            { data: 'asal_instansi', name: 'asal_instansi' },   
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
