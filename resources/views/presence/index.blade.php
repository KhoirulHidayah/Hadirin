@extends('layouts.template')
@section('content')
<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="mb-0 text-white">
                <i class="fas fa-calendar-alt mr-2"></i> Daftar Kegiatan
            </h6>
            <div class="ml-auto d-flex flex-wrap gap-2">
                <a href="#" onclick="exportPDF()" class="btn btn-danger btn-sm mr-2">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a class="btn btn-info btn-sm" href="{{ url('presence/create') }}">
                    <i class="fas fa-plus"></i> Tambah Kegiatan
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
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

        <form class="form-inline mb-3" id="filter-form">
            <div class="form-group mr-2">
                <label for="filter-bulan" class="mr-2 font-weight-bold">Filter Bulan:</label>
                <select class="form-control form-control-sm" id="filter-bulan" name="bulan">
                    <option value="">-- Semua Bulan --</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->locale('id')->isoFormat('MMMM') }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group mr-2">
                <label for="filter-tahun" class="mr-2 font-weight-bold">Filter Tahun:</label>
                <select class="form-control form-control-sm" id="filter-tahun" name="tahun">
                    <option value="">-- Semua Tahun --</option>
                    @for ($i = now()->year; $i >= 2024; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <button type="button" class="btn btn-sm btn-secondary" id="reset-filter">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="presences">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Kode Kegiatan</th>
                        <th>Nama Kegiatan</th>
                        <th>Tempat</th>
                        <th>Slug</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
     data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
<style>
    /* Overall improvements - similar to pegawai page */
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

    /* Table specific styles - matched with pegawai page */
    table#presences { /* Changed ID from #pegawai to #presences */
        font-size: 13px; /* Slightly increased font size for readability */
        width: 100% !important;
        table-layout: auto;
        border-collapse: separate; /* Allows for border-radius on cells */
        border-spacing: 0;
    }

    table#presences th,
    table#presences td {
        padding: 10px 12px !important; /* Increased padding */
        vertical-align: middle !important;
        white-space: nowrap;
        border: 1px solid #e9ecef; /* Lighter border for cells */
    }

    table#presences th {
        background-color: #e9ecef; /* Light grey header background */
        color: #495057; /* Darker text for headers */
        font-weight: 600; /* Bolder headers */
        text-transform: uppercase; /* Uppercase headers */
        letter-spacing: 0.5px;
    }

    table#presences tr:hover {
        background-color: #f2f2f2; /* Subtle hover effect on rows */
    }

    /* Adjusted options column width to match pegawai page */
    table#presences td:last-child,
    table#presences th:last-child {
        width: 120px !important; /* Adjusted width for options column */
        text-align: center;
    }
    /* The original CSS had nth-child(8), but with new columns, last-child is more robust */


    /* DataTables pagination and info styles - matched with pegawai page */
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

    /* Alert messages - matched with pegawai page */
    .alert {
        margin-bottom: 1.5rem; /* More space below alerts */
        padding: 0.75rem 1.25rem; /* Adjust padding */
        border-radius: 0.5rem; /* Slightly more rounded alerts */
    }

    /* Keep btn-sm-custom if you use it elsewhere for smaller buttons */
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
            data: function(d) {
                d._token = '{{ csrf_token() }}';
                d.bulan = $('#filter-bulan').val();
                d.tahun = $('#filter-tahun').val();
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
            { data: 'waktu_selesai', name: 'waktu_selesai' },
            { data: 'status', name: 'status' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: "text-center" }
        ],
        // Menambahkan urutan default pada kolom status dan tanggal
        order: [
            [8, 'desc'], // Kolom status (index 8), diurutkan secara menurun (aktif di atas)
            [5, 'asc'] // Kolom tanggal (index 5), diurutkan secara menaik (tanggal terkecil)
        ]
    });

    // Reload saat dropdown bulan diubah
    $('#filter-bulan,  #filter-tahun').on('change', function () {
        presenceTable.ajax.reload();
    })

    // Tombol Reset Filter
    $('#reset-filter').on('click', function () {
        $('#filter-bulan').val('');
        $('#filter-tahun').val('');
        presenceTable.ajax.reload();
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

function exportPDF() {
    const bulan = $('#filter-bulan').val();
    const tahun = $('#filter-tahun').val();

    const params = new URLSearchParams();

    if (bulan) params.append('bulan', bulan);
    if (tahun) params.append('tahun', tahun);

    window.location.href = '{{ route("presence.export.pdf") }}' + '?' + params.toString();
}

</script>
@endpush