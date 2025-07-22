@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4"> {{-- Consistent card styling --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white">
            <i class="fas fa-user-edit mr-2"></i> Edit Pegawai
        </h6>
    </div>
    <div class="card-body"> {{-- Removed small-form class here for unified styling --}}
        @empty($Pegawai)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="icon fas fa-ban mr-2"></i> Kesalahan!</h5>
                Data pegawai tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <a href="{{ url('pegawai') }}" class="btn btn-sm btn-secondary mt-3"> {{-- Consistent button styling and spacing --}}
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        @else
            <form method="POST" action="{{ url('/pegawai/'.$Pegawai->id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row mb-3"> {{-- Added mb-3 for consistent spacing --}}
                    <label for="id_pegawai" class="col-sm-2 col-form-label text-md-right">ID Pegawai</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="id_pegawai" value="{{ $Pegawai->id }}" readonly>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label text-md-right">Nama Pegawai</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="nama" name="nama" value="{{ old('nama', $Pegawai->nama) }}" required>
                        @error('nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="nip" class="col-sm-2 col-form-label text-md-right">NIP</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="nip" name="nip" value="{{ old('nip', $Pegawai->nip) }}" required>
                        @error('nip')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="jabatan" class="col-sm-2 col-form-label text-md-right">Jabatan/Bidang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="jabatan" name="jabatan" value="{{ old('jabatan', $Pegawai->jabatan) }}" required>
                        @error('jabatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="email" class="col-sm-2 col-form-label text-md-right">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ old('email', $Pegawai->email) }}" required> {{-- Added required for consistency --}}
                        @error('email')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="no_hp" class="col-sm-2 col-form-label text-md-right">No. HP</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="no_hp" name="no_hp" value="{{ old('no_hp', $Pegawai->no_hp) }}" required> {{-- Added required for consistency --}}
                        @error('no_hp')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-4"> {{-- Increased margin-bottom for better separation --}}
                    <label for="asal_instansi" class="col-sm-2 col-form-label text-md-right">Unit/Instansi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="asal_instansi" name="asal_instansi" value="{{ old('asal_instansi', $Pegawai->asal_instansi) }}" required> {{-- Added required for consistency --}}
                        @error('asal_instansi')
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
    {{-- No specific JS needed for this form --}}
@endpush