@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-body small-form">
        @empty($Presence)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Daftar kegiatan yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('presence') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('/presence/'.$Presence->presence_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-2 col-form-label">ID Kegiatan</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="presence_id"
                            value="{{ old('presence_id', $Presence->presence_id) }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Nama Kegiatan</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="nama_kegiatan"
                            value="{{ old('nama_kegiatan', $Presence->nama_kegiatan) }}" required>
                        @error('nama_kegiatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Tempat</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="tempat"
                            value="{{ old('tempat', $Presence->tempat) }}" required>
                        @error('tempat')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Tanggal Kegiatan</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="tgl_kegiatan"
                            value="{{ old('tgl_kegiatan', date('Y-m-d', strtotime($Presence->tgl_kegiatan))) }}"
                            placeholder="Format: YYYY-MM-DD" required>
                        @error('tgl_kegiatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Waktu Mulai</label>
                    <div class="col-10">
                        <input type="text" class="form-control form-control-sm" name="waktu_mulai"
                            value="{{ old('waktu_mulai', date('H:i', strtotime($Presence->tgl_kegiatan))) }}"
                            placeholder="Format: HH:mm" required>
                        @error('waktu_mulai')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <div class="col-10 offset-2">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a href="{{ url('presence') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        @endempty
    </div>
</div>
@endsection

@push('css')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .small-form {
        font-size: 0.875rem; /* font-size 14px */
    }

    .form-control-sm {
        padding: 0.25rem 0.5rem;
        height: calc(1.5em + 0.5rem + 2px);
    }
</style>
@endpush

@push('js')
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("input[name=tgl_kegiatan]", {
        dateFormat: "Y-m-d",
        allowInput: true
    });

    flatpickr("input[name=waktu_mulai]", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        allowInput: true
    });
</script>
@endpush
