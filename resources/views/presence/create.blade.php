@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-body small-form">
        <form method="POST" action="{{ url('presence') }}" class="form-horizontal">
            @csrf

            <div class="form-group row">
                <label class="col-2 col-form-label">Nama Kegiatan</label>
                <div class="col-10">
                    <input type="text" class="form-control form-control-sm" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required>
                    @error('nama_kegiatan')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">Tempat</label>
                <div class="col-10">
                    <input type="text" class="form-control form-control-sm" name="tempat" value="{{ old('tempat') }}" required>
                    @error('tempat')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">Tanggal Kegiatan</label>
                <div class="col-10">
                    <input type="text" class="form-control form-control-sm" name="tgl_kegiatan" value="{{ old('tgl_kegiatan') }}" placeholder="YYYY-MM-DD" required>
                    @error('tgl_kegiatan')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">Waktu Kegiatan</label>
                <div class="col-10">
                    <input type="text" class="form-control form-control-sm" name="waktu_mulai" value="{{ old('waktu_mulai') }}" placeholder="HH:mm" required>
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

@push('js')
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
