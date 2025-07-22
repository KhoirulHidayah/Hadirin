@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4"> {{-- Changed to card with larger shadow --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white">
            <i class="fas fa-calendar-plus mr-2"></i> Tambah Kegiatan
        </h6>
        {{-- No buttons on the right for a create form, typically --}}
    </div>
    <div class="card-body"> {{-- Removed small-form class here, will handle sizing via general CSS --}}
        <form method="POST" action="{{ url('presence') }}" class="form-horizontal">
            @csrf

            <div class="form-group row mb-3"> {{-- Added mb-3 for consistent spacing between rows --}}
                <label for="nama_kegiatan" class="col-sm-2 col-form-label text-md-right">Nama Kegiatan</label> {{-- Adjusted for right alignment on medium screens --}}
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required>
                    @error('nama_kegiatan')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="tempat" class="col-sm-2 col-form-label text-md-right">Tempat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="tempat" name="tempat" value="{{ old('tempat') }}" required>
                    @error('tempat')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="tgl_kegiatan" class="col-sm-2 col-form-label text-md-right">Tanggal Kegiatan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm flatpickr-date" id="tgl_kegiatan" name="tgl_kegiatan" value="{{ old('tgl_kegiatan') }}" placeholder="YYYY-MM-DD" required>
                    @error('tgl_kegiatan')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="waktu_mulai" class="col-sm-2 col-form-label text-md-right">Waktu Mulai</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm flatpickr-time" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" placeholder="HH:mm" required>
                    @error('waktu_mulai')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="waktu_selesai" class="col-sm-2 col-form-label text-md-right">Waktu Selesai</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm flatpickr-time" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}" placeholder="HH:mm" required>
                    @error('waktu_selesai')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-4"> {{-- Increased margin-bottom for better separation --}}
                <label for="status" class="col-sm-2 col-form-label text-md-right">Status</label>
                <div class="col-sm-10">
                    <select name="status" id="status" class="form-control form-control-sm" required>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
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
        font-size: 1rem; /* Slightly larger title */
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

    /* Remove spinner on number input (though this form doesn't use type="number") */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
    .flatpickr-time.input,
    .flatpickr-time.input::placeholder,
    .flatpickr-time {
        text-align: left !important;
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