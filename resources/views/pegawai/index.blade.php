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
        {{-- Notifikasi Error Validasi Import --}}
        @if(session('import_errors'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-triangle me-2 fa-lg mt-1 text-warning"></i>
                    <div class="flex-grow-1">
                        <strong>Beberapa baris gagal diimpor:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach (session('import_errors') as $error)
                                <li class="mb-1">
                                    @if(isset($error['row']))
                                        <strong>Baris {{ $error['row'] }}</strong>
                                    @endif
                                    @if(isset($error['nip']) && $error['nip'] && $error['nip'] !== 'NIP Kosong')
                                        (NIP: {{ $error['nip'] }})
                                    @endif
                                    : {{ $error['error'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <form class="form-inline mb-3" id="filter-form">
            <div class="form-group mr-2 mb-2"> {{-- Added mb-2 for spacing on smaller screens --}}
                <label for="filter-instansi" class="mr-2 font-weight-bold">Filter Unit:</label>
                <select class="form-control form-control-sm" id="filter-instansi" name="tahun">
                    <option value="">-- Semua Unit --</option>
                    @foreach ($instansiList as $instansi)
                        <option value="{{ $instansi }}">{{ $instansi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mr-2 mb-2"> {{-- Added new filter for Perusahaan (Kategori) --}}
                <label for="filter-perusahaan" class="mr-2 font-weight-bold">Filter Perusahaan:</label>
                <select class="form-control form-control-sm" id="filter-perusahaan" name="kategori">
                    <option value="">-- Semua Perusahaan --</option>
                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn btn-sm btn-secondary mb-2" id="reset-filter"> {{-- Added mb-2 --}}
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </form>

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
                        <th>Unit</th>
                        <th>Perusahaan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> {{-- Made modal larger --}}
        <form action="{{ url('/pegawai/import') }}" method="POST" enctype="multipart/form-data" id="importForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-success text-white"> {{-- Changed to success color --}}
                    <h5 class="modal-title">
                        <i class="fas fa-file-import mr-2"></i>Import Data Pegawai
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="file" class="font-weight-bold">
                                    <i class="fas fa-file-excel mr-1"></i>Pilih File Excel (.xlsx / .csv)
                                </label>
                                <input type="file" name="file" id="file" class="form-control-file" required accept=".xlsx,.xls,.csv">
                                <small class="form-text text-muted">
                                    <strong>Format header kolom Excel:</strong> No, Nama, NIP, Email, Jabatan, No HP, Unit, Perusahaan
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Ketentuan Format Data --}}
                    <div class="mt-4">
                        <div class="card border-info">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 text-info">
                                    <i class="fas fa-info-circle mr-2"></i>Ketentuan Format Data
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="small mb-0 pl-3">
                                            <li><strong>No</strong>: nomor urut (opsional)</li>
                                            <li><strong>Nama</strong>: wajib diisi</li>
                                            <li><strong>NIP</strong>: wajib, unik, maks 25 karakter</li>
                                            <li><strong>Email</strong>: wajib, format valid</li>
                                            <li><strong>Jabatan</strong>: wajib diisi</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="small mb-0 pl-3">
                                            <li><strong>No HP</strong>: wajib, min 10 digit angka</li>
                                            <li><strong>Unit</strong>: wajib, nama unit</li>
                                            <li><strong>Perusahaan</strong>: wajib, sesuai kategori di DB</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mt-3 p-2 bg-warning text-dark rounded">
                                    <small>
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <strong>Penting:</strong> Pastikan kolom "Perusahaan" berisi nama perusahaan yang sudah ada di Data Perusahaan.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3 text-center">
                        <a href="{{ route('pegawai.template') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download mr-1"></i>Download Template Excel
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="importBtn">
                        <i class="fas fa-upload mr-1"></i>Import Data
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Tutup
                    </button>
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

    table#pegawai td:nth-child(9),
    table#pegawai th:nth-child(9) {
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
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        background-color: #fff;
    }

    /* Enhanced import modal styles */
    .modal-lg {
        max-width: 700px;
    }

    .border-info {
        border-color: #17a2b8 !important;
    }

    /* Loading state for import button */
    .btn.loading {
        position: relative;
        pointer-events: none;
    }

    .btn.loading:after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
            data: function (d) {
                d._token = '{{ csrf_token() }}';
                d.asal_instansi = $('#filter-instansi').val();
                d.kategori = $('#filter-perusahaan').val(); // Added filter for kategori (Perusahaan)
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
            { data: 'kategori', name: 'kategori' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: "text-center" }
        ]
    });

    // Trigger filters
    $('#filter-instansi').change(function () {
        presenceTable.ajax.reload();
    });

    $('#filter-perusahaan').change(function () { // New change event for Perusahaan filter
        presenceTable.ajax.reload();
    });

    // Reset filter
    $('#reset-filter').on('click', function () {
        $('#filter-instansi').val('').trigger('change');
        $('#filter-perusahaan').val('').trigger('change'); // Reset Perusahaan filter
    });

    // Handle import form submission with loading state
    $('#importForm').on('submit', function() {
        var fileInput = $('#file');
        if (fileInput[0].files.length === 0) {
            alert('Please select a file to import.');
            return false;
        }

        // Add loading state to button
        $('#importBtn').addClass('loading').prop('disabled', true);
        $('#importBtn').html('<i class="fas fa-spinner fa-spin mr-1"></i>Importing...');
        
        return true; // Allow form submission
    });

    // Reset import modal when closed
    $('#importModal').on('hidden.bs.modal', function () {
        $('#importForm')[0].reset();
        $('#importBtn').removeClass('loading').prop('disabled', false);
        $('#importBtn').html('<i class="fas fa-upload mr-1"></i>Import Data');
    });

    // DataTable responsive adjustments
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