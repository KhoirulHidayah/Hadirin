@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4"> {{-- Changed to card with larger shadow --}}
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap">
            <h6 class="mb-0 text-white">
                <i class="fas fa-users mr-2"></i> Data Pegawai
            </h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import"></i> Import Data
                </button>
                <a class="btn btn-info btn-sm" href="{{ url('pegawai/create') }}">
                    <i class="fas fa-plus"></i> Tambah Pegawai
                </a>
            </div>
        </div>
    </div>
    <div class="card-body"> {{-- Wrapped content in card-body --}}
        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2 fa-lg"></i>
                <div>{{ session('success') }}</div>
                <button type="button"
                        class="btn-close ms-auto align-self-center"
                        data-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif
        {{-- Notifikasi Eror --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2 fa-lg"></i>
                <div>{{ session('error') }}</div>
                <button type="button"
                        class="btn-close ms-auto align-self-center"
                        data-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="pegawai">
                <thead class="thead-light">
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
</div>

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/pegawai/import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-info text-white"> {{-- Added info background to modal header --}}
                    <h5 class="modal-title">Import Data Pegawai</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"> {{-- Changed close button color --}}
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group"> {{-- Added form-group for better spacing --}}
                        <label for="file">Pilih File Excel (.xlsx / .csv)</label>
                        <input type="file" name="file" id="file" class="form-control-file" required> {{-- Changed to form-control-file --}}
                        <small class="form-text text-muted">Format header kolom: nip, nama, jabatan, email, no_hp, asal_instansi</small>
                    </div>
                    <div class="mt-3"> {{-- Increased margin-top for template link --}}
                        <a href="{{ route('pegawai.template') }}" class="btn btn-sm btn-outline-secondary">Download Template</a> {{-- Changed template button style --}}
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
    /* Overall improvements */
    body {
        background-color: #f8f9fa; /* Light grey background for the body */
    }

    .card {
        border: none; /* Remove default card border */
        border-radius: 0.75rem; /* More rounded corners for cards */
        overflow: hidden; /* Ensures content respects border-radius */
    }

    .card-header {
        border-bottom: none; /* Remove border under card header */
        padding: 1.25rem 1.5rem; /* More padding */
        font-size: 1.1rem; /* Slightly larger title */
        font-weight: 600; /* Bolder title */
    }

    .card-body {
        padding: 1.5rem; /* More padding inside card body */
    }

    /* Table specific styles */
    table#pegawai {
        font-size: 13px; /* Slightly increased font size for readability */
        width: 100% !important;
        table-layout: auto;
        border-collapse: separate; /* Allows for border-radius on cells */
        border-spacing: 0;
    }

    table#pegawai th,
    table#pegawai td {
        padding: 10px 12px !important; /* Increased padding */
        vertical-align: middle !important;
        white-space: nowrap;
        border: 1px solid #e9ecef; /* Lighter border for cells */
    }

    table#pegawai th {
        background-color: #e9ecef; /* Light grey header background */
        color: #495057; /* Darker text for headers */
        font-weight: 600; /* Bolder headers */
        text-transform: uppercase; /* Uppercase headers */
        letter-spacing: 0.5px;
    }

    table#pegawai tr:hover {
        background-color: #f2f2f2; /* Subtle hover effect on rows */
    }

    table#pegawai td:nth-child(8),
    table#pegawai th:nth-child(8) {
        width: 120px !important; /* Adjusted width for options column */
        text-align: center;
    }

    /* DataTables pagination and info styles */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 13px; /* Slightly increased font size */
        padding: 1rem 0; /* Add padding around these elements */
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.3em 0.6em; /* Adjust pagination button padding */
    }

    .shadow-lg { /* Larger shadow for cards */
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }

    /* Alert messages */
    .alert {
        margin-bottom: 1.5rem; /* More space below alerts */
        padding: 0.75rem 1.25rem; /* Adjust padding */
        border-radius: 0.5rem; /* Slightly more rounded alerts */
    }

    /* Modal specific styles */
    .modal-content {
        border-radius: 0.75rem; /* Rounded corners for modal */
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
        padding: 1.25rem 1.5rem;
    }

    .form-control-file {
        padding: 0.375rem 0.75rem; /* Adjust padding for file input */
        height: auto;
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