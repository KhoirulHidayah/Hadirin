@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-body small-form"> {{-- tambahkan class untuk pengaturan kecil --}}
        <form method="POST" action="{{ url('pegawai') }}" class="form-horizontal">
            @csrf

            <div class="form-group row">
                <label for="nama" class="col-2 col-form-label">Nama Pegawai</label>
                <div class="col-10">
                    <input type="text" class="form-control form-control-sm" id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="nip" class="col-2 col-form-label">NIP</label>
                <div class="col-10">
                    <input type="number" class="form-control form-control-sm" id="nip" name="nip" value="{{ old('nip') }}" required>
                    @error('nip')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="jabatan" class="col-2 col-form-label">Jabatan/Bidang</label>
                <div class="col-10">
                    <input type="text" class="form-control form-control-sm" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                    @error('jabatan')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-2 col-form-label">Email</label>
                <div class="col-10">
                    <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="no_hp" class="col-2 col-form-label">No. HP</label>
                <div class="col-10">
                    <input type="text" class="form-control form-control-sm" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                    @error('no_hp')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="asal_instansi" class="col-2 col-form-label">Unit/Instansi</label>
                <div class="col-10">
                    <input type="text" class="form-control form-control-sm" id="asal_instansi" name="asal_instansi" value="{{ old('asal_instansi') }}" required>
                    @error('asal_instansi')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mt-3">
                <div class="col-10 offset-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a href="{{ url('pegawai') }}" class="btn btn-sm btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .small-form {
        font-size: 0.875rem; /* 14px */
    }
    .form-control-sm {
        padding: 0.25rem 0.5rem;
        height: calc(1.5em + 0.5rem + 2px);
    }
</style>
@endpush
