@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-body small-form">
        @empty($Pegawai)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data pegawai tidak ditemukan.
            </div>
            <a href="{{ url('pegawai') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('/pegawai/'.$Pegawai->id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-2 col-form-label">ID Pegawai</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" value="{{ $Pegawai->id }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Nama Pegawai</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="nama" value="{{ old('nama', $Pegawai->nama) }}" required>
                        @error('nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">NIP</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="nip" value="{{ old('nip', $Pegawai->nip) }}" required>
                        @error('nip')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Jabatan/Bidang</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="jabatan" value="{{ old('jabatan', $Pegawai->jabatan) }}" required>
                        @error('jabatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Email</label>
                    <div class="col-10">
                        <input type="email" class="form-control form-control-sm" name="email" value="{{ old('email', $Pegawai->email) }}">
                        @error('email')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">No HP</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="no_hp" value="{{ old('no_hp', $Pegawai->no_hp) }}">
                        @error('no_hp')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Unit/Asal Instansi</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="asal_instansi" value="{{ old('asal_instansi', $Pegawai->asal_instansi) }}">
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
        @endempty
    </div>
</div>
@endsection

@push('css')
<style>
    .small-form {
        font-size: 0.875rem; /* set font lebih kecil (14px) */
    }
</style>
@endpush
