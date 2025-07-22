@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4"> {{-- Consistent card styling with shadow --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white">
            <i class="fas fa-edit mr-2"></i> Edit Kegiatan
        </h6>
    </div>
    <div class="card-body"> {{-- Removed small-form class; styling handled by general CSS --}}
        @empty($Presence)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="icon fas fa-ban mr-2"></i> Kesalahan!</h5>
                Daftar kegiatan yang Anda cari tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <a href="{{ url('presence') }}" class="btn btn-sm btn-secondary mt-3"> {{-- Consistent button styling and spacing --}}
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        @else
            <form method="POST" action="{{ url('/presence/'.$Presence->presence_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row mb-3"> {{-- Added mb-3 for consistent spacing between rows --}}
                    <label for="presence_id" class="col-sm-2 col-form-label text-md-right">ID Kegiatan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="presence_id" name="presence_id"
                            value="{{ old('presence_id', $Presence->presence_id) }}" readonly>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="nama_kegiatan" class="col-sm-2 col-form-label text-md-right">Nama Kegiatan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="nama_kegiatan" name="nama_kegiatan"
                            value="{{ old('nama_kegiatan', $Presence->nama_kegiatan) }}" required>
                        @error('nama_kegiatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="tempat" class="col-sm-2 col-form-label text-md-right">Tempat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="tempat" name="tempat"
                            value="{{ old('tempat', $Presence->tempat) }}" required>
                        @error('tempat')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="tgl_kegiatan" class="col-sm-2 col-form-label text-md-right">Tanggal Kegiatan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm flatpickr-date" id="tgl_kegiatan" name="tgl_kegiatan"
                            value="{{ old('tgl_kegiatan', date('Y-m-d', strtotime($Presence->tgl_kegiatan))) }}"
                            placeholder="YYYY-MM-DD" required>
                        @error('tgl_kegiatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="waktu_mulai" class="col-sm-2 col-form-label text-md-right">Waktu Mulai</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm flatpickr-time text-left" id="waktu_mulai" name="waktu_mulai"
                            value="{{ old('waktu_mulai', date('H:i', strtotime($Presence->tgl_kegiatan))) }}"
                            placeholder="HH:mm" required>
                        @error('waktu_mulai')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="waktu_selesai" class="col-sm-2 col-form-label text-md-right">Waktu Selesai</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm flatpickr-time text-left" id="waktu_selesai" name="waktu_selesai"
                        value="{{ old('waktu_selesai', date('H:i', strtotime($Presence->waktu_selesai))) }}" placeholder="HH:mm" required>
                        @error('waktu_selesai')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-4"> {{-- Increased margin-bottom for better separation --}}
                    <label for="status" class="col-sm-2 col-form-label text-md-right">Status</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control form-control-sm" required>
                            <option value="aktif" {{ old('status', $Presence->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ old('status', $Presence->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2"> {{-- Changed offset-2 to offset-sm-2 for responsiveness --}}
                        <button type="submit" class="btn btn-primary btn-sm mr-2">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                        <a href="{{ url('presence') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        @endempty
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        font-size: 1rem; /* Consistent title font size */
        font-weight: 600; /* Bolder title */
    }

    .card-body {
        padding: 1.5rem; /* More padding inside card body */
    }

    /* Form specific styles */
    .form-horizontal .col-form-label {
        font-size: 0.9rem; /* Slightly larger font for labels */
        color: #343a40; /* Darker text for labels */
    }

    .form-control-sm {
        height: calc(1.5em + 0.75rem + 2px); /* Adjusted height for better aesthetics */
        padding: 0.375rem 0.75rem; /* Standard Bootstrap small input padding */
        font-size: 0.875rem; /* Consistent small font size */
        border-radius: 0.25rem; /* Standard border radius */
    }

    .form-group.row {
        align-items: center; /* Vertically align labels and inputs in the middle */
    }

    .btn-sm {
        padding: 0.3rem 0.75rem; /* Adjusted padding for small buttons */
        font-size: 0.875rem; /* Consistent font size for buttons */
        border-radius: 0.25rem; /* Consistent border radius */
    }

    .text-danger {
        font-size: 0.8rem; /* Smaller font for error messages */
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".flatpickr-date", {
        dateFormat: "Y-m-d",
        allowInput: true
    });

    flatpickr(".flatpickr-time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        allowInput: true
    });
</script>
@endpush