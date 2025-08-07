@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white">
            <i class="fas fa-cog mr-2"></i> Pengaturan Header & Logo
        </h6>
    </div>

    <div class="card-body">
        {{-- === ALERTS === --}}
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center position-relative fade show" role="alert">
                <i class="fas fa-check-circle mr-3 fa-lg"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="close position-absolute top-0 end-0 m-2" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger d-flex align-items-start position-relative fade show" role="alert">
                <i class="fas fa-exclamation-triangle mr-3 fa-lg mt-1"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="close position-absolute top-0 end-0 m-2" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- === FORM UPDATE === --}}
        <form action="{{ route('logo_formulir.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- APP NAME --}}
            <div class="form-group mb-3">
                <label for="app_name" class="form-label font-weight-bold">Nama Aplikasi (APP_NAME)</label>
                <input type="text" class="form-control form-control-sm" id="app_name" name="app_name"
                       value="{{ old('app_name', $logoFormulir->app_name ?? '') }}" placeholder="Masukkan nama aplikasi">
                @error('app_name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- HEADER TITLE --}}
            <div class="form-group mb-3">
                <label for="header_title" class="form-label font-weight-bold">Judul Header</label>
                <input type="text" class="form-control form-control-sm" id="header_title" name="header_title"
                       value="{{ old('header_title', $logoFormulir->header_title ?? '') }}" placeholder="Masukkan judul header">
                @error('header_title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- LOGO KIRI --}}
            <div class="form-group mb-3">
                <label for="logo_left" class="form-label font-weight-bold">Logo Kiri</label><br>
                @if (!empty($logoFormulir->logo_left))
                    <div class="mb-2 text-muted small">Logo Saat Ini:</div>
                    <img src="{{ asset('storage/' . $logoFormulir->logo_left) }}" alt="Logo Kiri"
                         class="img-thumbnail mb-2" style="max-height: 100px; width: auto; object-fit: contain;">
                @else
                    <div class="mb-2 text-muted small">Belum ada logo kiri terupload.</div>
                @endif
                <input class="form-control form-control-sm" type="file" id="logo_left" name="logo_left" accept="image/*">
                <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks: 2MB.</small>
                @error('logo_left') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- LOGO KANAN --}}
            <div class="form-group mb-3">
                <label for="logo_right" class="form-label font-weight-bold">Logo Kanan</label><br>
                @if (!empty($logoFormulir->logo_right))
                    <div class="mb-2 text-muted small">Logo Saat Ini:</div>
                    <img src="{{ asset('storage/' . $logoFormulir->logo_right) }}" alt="Logo Kanan"
                         class="img-thumbnail mb-2" style="max-height: 100px; width: auto; object-fit: contain;">
                @else
                    <div class="mb-2 text-muted small">Belum ada logo kanan terupload.</div>
                @endif
                <input class="form-control form-control-sm" type="file" id="logo_right" name="logo_right" accept="image/*">
                <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks: 2MB.</small>
                @error('logo_right') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- BUTTON UPDATE --}}
            <div class="d-flex justify-content-start mt-3">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save mr-1"></i> Update Pengaturan
                </button>
            </div>
        </form>

        {{-- === FORM DELETE LOGO KIRI === --}}
        @if (!empty($logoFormulir->logo_left))
            <div class="mt-4 border-top pt-3">
                <form action="{{ route('logo_formulir.delete_left') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus logo kiri?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus Logo Kiri
                    </button>
                </form>
            </div>
        @endif

        {{-- === FORM DELETE LOGO KANAN === --}}
        @if (!empty($logoFormulir->logo_right))
            <div class="mt-3">
                <form action="{{ route('logo_formulir.delete_right') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus logo kanan?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus Logo Kanan
                    </button>
                </form>
            </div>
        @endif
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
    .form-label {
        font-size: 0.9rem; /* Slightly larger font for labels */
        color: #343a40; /* Darker text for labels */
    }

    .form-control-sm {
        height: calc(1.5em + 0.75rem + 2px); /* Adjusted height for better aesthetics */
        padding: 0.375rem 0.75rem; /* Standard Bootstrap small input padding */
        font-size: 0.875rem; /* Consistent small font size */
        border-radius: 0.25rem; /* Standard border radius */
    }

    .form-group {
        margin-bottom: 1.5rem; /* Default margin for form groups */
    }

    .img-thumbnail {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 0.25rem;
        background-color: #fff;
    }

    /* Button styling */
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
        padding: 1rem 1.5rem;
    }
    .alert h5 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .alert .fa-lg {
        font-size: 1.25rem; /* Larger icon for alerts */
    }
    .alert ul {
        margin-bottom: 0;
        padding-left: 20px;
    }
    .alert li {
        margin-bottom: 5px;
    }
    .alert-success .fas,
    .alert-info .fas {
        color: inherit; /* Inherit color from alert */
    }
    .alert-danger .fas {
        color: inherit;
    }
</style>
@endpush

@push('js')
    {{-- No specific JS needed here beyond what Bootstrap/AdminLTE provides for alerts --}}
@endpush