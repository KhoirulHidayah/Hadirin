@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4"> {{-- Changed to card with larger shadow --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white">
            <i class="fas fa-user-plus mr-2"></i> Tambah Pegawai
        </h6>
        {{-- No buttons on the right for a create form, typically --}}
    </div>
    <div class="card-body"> {{-- Removed small-form class here, will handle sizing via general CSS --}}
        <form method="POST" action="{{ url('pegawai') }}" class="form-horizontal">
            @csrf

            <div class="form-group row mb-3"> {{-- Added mb-3 for consistent spacing between rows --}}
                <label for="nama" class="col-sm-2 col-form-label text-md-right">Nama Pegawai</label> {{-- Adjusted for right alignment on medium screens --}}
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="nip" class="col-sm-2 col-form-label text-md-right">NIP</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control form-control-sm" id="nip" name="nip" value="{{ old('nip') }}" required>
                    @error('nip')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="jabatan" class="col-sm-2 col-form-label text-md-right">Jabatan/Bidang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                    @error('jabatan')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="email" class="col-sm-2 col-form-label text-md-right">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="no_hp" class="col-sm-2 col-form-label text-md-right">No. HP</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                    @error('no_hp')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-4"> {{-- Increased margin-bottom for better separation --}}
                <label for="asal_instansi" class="col-sm-2 col-form-label text-md-right">Unit</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="asal_instansi" name="asal_instansi" value="{{ old('asal_instansi') }}" required>
                    @error('asal_instansi')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="kategori" class="col-sm-2 col-form-label text-md-right">Perusahaan</label>
                <div class="col-sm-10">
                    <select name="kategori" id="kategori" class="form-control form-control-sm">
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach($kategoriList as $key => $val)
                            <option value="{{ $key }}" {{ old('kategori', isset($Pegawai) ? $Pegawai->kategori : '') == $key ? 'selected' : '' }}>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2"> {{-- Changed offset-2 to offset-sm-2 for responsiveness --}}
                    <button type="submit" class="btn btn-primary btn-sm mr-2">
                            <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="{{ url('pegawai') }}" class="btn btn-sm btn-secondary">
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
        font-size: 1rem; /* Reduced font-size for title text and icon */
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

    /* Remove spinner on number input */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

{{-- No specific JS needed for this simple form, unless you add date pickers or similar --}}
@push('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // If you plan to use flatpickr, uncomment and configure it:
    // flatpickr(".flatpickr", {
    //     dateFormat: "Y-m-d",
    //     // Add other options as needed
    // });
</script>
@endpush