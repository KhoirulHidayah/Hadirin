@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white">
            <i class="fas fa-building mr-2"></i> Tambah Asal Instansi
        </h6>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('asal_instansi.store') }}" class="form-horizontal">
            @csrf

            <div class="form-group row mb-3">
                <label for="nama_instansi" class="col-sm-2 col-form-label text-md-right">Nama Unit</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi') }}" required>
                    @error('nama_instansi')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="kategori" class="col-sm-2 col-form-label text-md-right">Perusahaan</label>
                <div class="col-sm-10">
                    <select name="kategori_nama" id="kategori" class="form-control form-control-sm">
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->nama }}" {{ old('kategori_nama') == $item->nama ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="{{ route('asal_instansi.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
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
    .form-group.row {
        align-items: center;
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