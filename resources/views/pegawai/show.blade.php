@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4"> {{-- Changed to card with larger shadow --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white"> {{-- Changed to h6 as requested --}}
            <i class="fas fa-user-tie mr-2"></i> Detail Pegawai
        </h6>
    </div>
    <div class="card-body"> {{-- small-detail class removed, styling handled via general CSS --}}
        @empty($Pegawai)
            <div class="alert alert-danger alert-dismissible fade show" role="alert"> {{-- Added Bootstrap dismissible alert classes --}}
                <h5><i class="icon fas fa-ban mr-2"></i> Kesalahan!</h5>
                Data pegawai yang Anda cari tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <a href="{{ url('pegawai') }}" class="btn btn-sm btn-secondary mt-3"> {{-- Consistent button styling and spacing --}}
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        @else
            <table class="table table-bordered table-striped table-sm detail-table"> {{-- Added custom class for detail table styling --}}
                <tr>
                    <th style="width: 30%;">ID Pegawai</th>
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

            <div class="mt-4"> {{-- Increased margin-top for better spacing --}}
                <a href="{{ url('pegawai') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        @endempty
    </div>
</div>
@endsection

@push('css')
<style>
    /* General body and card styling for consistency */
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
        /* Font size for h6 in the header will be handled by the specific h6 rule below */
        font-weight: 600; /* Bolder title */
    }

    .card-header h6 { /* Specific style for h6 within card-header */
        font-size: 0.95rem; /* Slightly smaller for h6 as requested, but still clear */
        font-weight: 700; /* Make it bold for emphasis */
    }

    .card-body {
        padding: 1.5rem; /* More padding inside card body */
    }

    /* Table specific styles for detail view */
    .detail-table th {
        background-color: #e9ecef; /* Light grey background for table headers */
        color: #495057; /* Darker text for headers */
        padding: 0.75rem 1.25rem; /* More padding for headers */
        font-size: 0.875rem; /* Consistent small font size */
        border-color: #dee2e6; /* Consistent border color */
    }

    .detail-table td {
        padding: 0.75rem 1.25rem; /* More padding for table data */
        font-size: 0.875rem; /* Consistent small font size */
        color: #343a40; /* Darker text for data */
        border-color: #dee2e6; /* Consistent border color */
    }

    .detail-table.table-bordered th,
    .detail-table.table-bordered td {
        border-width: 1px; /* Ensure border is visible */
    }

    /* Consistent button styling */
    .btn-sm {
        padding: 0.3rem 0.75rem; /* Adjusted padding for small buttons */
        font-size: 0.875rem; /* Consistent font size for buttons */
        border-radius: 0.25rem; /* Consistent border radius */
    }

    /* Shadow for the card */
    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }

    /* Alert styling for consistency */
    .alert {
        border-radius: 0.5rem;
        font-size: 0.9rem;
    }
    .alert h5 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@push('js')
    {{-- No specific JS needed for a detail view --}}
@endpush