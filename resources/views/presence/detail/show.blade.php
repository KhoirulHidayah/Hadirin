@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4"> {{-- Changed to card with larger shadow --}}
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap"> {{-- Flex container for title and buttons --}}
            <h6 class="mb-0 text-white">
                <i class="fas fa-info-circle mr-2"></i> Detail Kegiatan
            </h6>
            <div class="ml-auto d-flex flex-wrap gap-2"> {{-- Buttons grouped with ml-auto to push to right, flex-wrap for responsiveness, gap-2 for spacing (Bootstrap 5, but should degrade gracefully) --}}
                <button type="button" onclick="copyLink()" class="btn btn-warning btn-sm mr-2">
                    <i class="fas fa-link"></i> Copy Link
                </button>
                <a href="{{ route('presence_details.export.pdf', ['id' => $Presence->presence_id]) }}" class="btn btn-danger btn-sm mr-2"> {{-- Changed to btn-light --}}
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('presence_details.export.excel', ['id' => $Presence->presence_id]) }}" class="btn btn-success btn-sm mr-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ url('presence') }}" class="btn btn-secondary btn-sm"> {{-- Changed to btn-info for consistent return button --}}
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-borderless table-detail-info"> {{-- Added custom class for detail info table --}}
            <tr>
                <td class="font-weight-bold" width="180">Nama Kegiatan</td> {{-- Added font-weight-bold for labels --}}
                <td width="10">:</td>
                <td>{{ $Presence->nama_kegiatan }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Tempat</td>
                <td>:</td>
                <td>{{ $Presence->tempat }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Tanggal Kegiatan</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Waktu</td>
                <td>:</td>
                <td>{{ date('H:i', strtotime($Presence->waktu_mulai)) }} - {{ date('H:i', strtotime($Presence->waktu_selesai)) }}</td> {{-- Displaying both start and end time --}}
            </tr>
            <tr>
                <td class="font-weight-bold">Status</td>
                <td>:</td>
                <td>
                    @if ($Presence->status == 'aktif')
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-secondary">Tidak Aktif</span>
                    @endif
                </td>
            </tr>
        </table>

        <hr class="my-4"> {{-- Added a separator --}}

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h6 class="mb-3 text-dark"><i class="fas fa-list-alt mr-2"></i> Daftar Peserta</h6> {{-- Added a heading for the participants list --}}

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm w-100" id="presences"> {{-- Ensure ID is consistent with JS --}}
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Waktu Absen</th>
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
        table = $('#presences').DataTable({ // Make sure this ID matches the table ID in HTML
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
                { data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center" }, // Added text-center
                { data: 'waktu_absen', name: 'waktu_absen' },
                { data: 'nama', name: 'nama' },
                { data: 'nip', name: 'nip' },
                { data: 'jabatan', name: 'jabatan' },
                { data: 'email', name: 'email' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'asal_instansi', name: 'asal_instansi' },
                {
                    data: 'tanda_tangan', name: 'tanda_tangan', orderable: false, searchable: false, className: 'text-center', // Added class for center alignment
                    render: function (data) {
                        return data ? `<img src="/storage/tanda_tangan/${data}" alt="Tanda Tangan" class="img-fluid" style="max-width:80px;"/>` : '-'; // Added alt and check for null
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
        document.addEventListener('shown.lte.pushmenu', function () { // Changed to document.addEventListener
            setTimeout(() => {
                table.columns.adjust().draw(false);
            }, 300);
        });

        document.addEventListener('collapsed.lte.pushmenu', function () { // Changed to document.addEventListener
            setTimeout(() => {
                table.columns.adjust().draw(false);
            }, 300);
        });
    });

    function copyLink() {
        navigator.clipboard.writeText("{{ route('absen.index', $Presence->slug) }}")
            .then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Disalin!',
                    text: 'Link kehadiran berhasil disalin ke clipboard.',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyalin!',
                    text: 'Terjadi kesalahan saat menyalin link.',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
    }
</script>
@endpush

@push('css')
<style>
    /* Overall improvements - consistent with other pages */
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

    /* Info Table Styling */
    table.table-detail-info td {
        padding: 8px 0 !important; /* Adjust padding for info table */
        font-size: 14px;
        vertical-align: top;
    }

    table.table-detail-info td.font-weight-bold {
        color: #343a40; /* Darker text for labels */
    }


    /* Table specific styles - matched with presence index and pegawai page */
    table#presences { /* Ensure this ID is correct for the DataTable */
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

    /* Adjusted options column width to match other tables */
    table#presences td:last-child,
    table#presences th:last-child {
        width: 120px !important; /* Adjusted width for options column */
        text-align: center;
    }

    /* Tanda Tangan column styling */
    table#presences td:nth-child(9),
    table#presences th:nth-child(9) {
        width: 100px; /* Adjust width for signature column */
        text-align: center;
    }
    table#presences img {
        max-width: 80px;
        height: auto;
        display: block; /* Ensures image centers properly */
        margin: 0 auto; /* Centers image */
    }


    /* DataTables pagination and info styles - matched with other pages */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 13px;
        padding: 1rem 0;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.3em 0.6em;
    }

    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }

    /* Alert messages - matched with other pages */
    .alert {
        margin-bottom: 1.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem;
    }

    /* Bootstrap 5 gap utility fallback for older Bootstrap versions (if needed) */
    .gap-2 > *:not(:last-child) {
        margin-right: 0.5rem;
    }
</style>
@endpush