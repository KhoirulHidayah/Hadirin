@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('presence') }}" class="form-horizontal">
            @csrf

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Nama Kegiatan</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required>
                    @error('nama_kegiatan')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Tempat</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="tempat" value="{{ old('tempat') }}" required>
                    @error('tempat')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Tanggal Kegiatan</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="tgl_kegiatan" value="{{ old('tgl_kegiatan') }}" placeholder="YYYY-MM-DD" required>
                    @error('tgl_kegiatan')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Waktu Kegiatan</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="waktu_mulai" value="{{ old('waktu_mulai') }}" placeholder="HH:mm" required>
                    @error('waktu_mulai')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label"></label>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <!-- Tombol Kembali -->
                    <a href="{{ url('presence') }}" class="btn btn-sm btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
