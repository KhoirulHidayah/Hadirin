@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white">
            <i class="fas fa-edit mr-2"></i> Edit Perusahaan
        </h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('kategori.update', $kategori->id) }}" class="form-horizontal">
            @csrf
            @method('PUT')

            <div class="form-group row mb-4">
                <label for="nama" class="col-sm-2 col-form-label text-md-right">Nama Perusahaan</label>
                <div class="col-sm-10">
                    <input type="text" name="nama" id="nama" class="form-control form-control-sm" value="{{ old('nama', $kategori->nama) }}" required>
                    @error('nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
{{-- Gunakan CSS yang sama seperti pada create --}}
<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
        padding: 1.25rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    .form-horizontal .col-form-label {
        font-size: 0.9rem;
        color: #343a40;
    }

    .form-control-sm {
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }

    .btn-sm {
        padding: 0.3rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }

    .text-danger {
        font-size: 0.8rem;
    }

    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }
</style>
@endpush
