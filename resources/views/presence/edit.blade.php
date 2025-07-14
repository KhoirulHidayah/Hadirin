@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Kegiatan</h3>
    </div>
    <div class="card-body">
        @empty($Presence)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Daftar jenis kegiatan yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('presence') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('/presence/'.$Presence->presence_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">ID Kegiatan</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="presence_id"
                            value="{{ old('presence_id', $Presence->presence_id) }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama Kegiatan</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="nama_kegiatan"
                            value="{{ old('nama_kegiatan', $Presence->nama_kegiatan) }}" required>
                        @error('nama_kegiatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Tempat</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="tempat"
                            value="{{ old('tempat', $Presence->tempat) }}" required>
                        @error('tempat')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Tanggal Kegiatan</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="tgl_kegiatan"
                            value="{{ old('tgl_kegiatan', date('Y-m-d', strtotime($Presence->tgl_kegiatan))) }}"
                            placeholder="Format: YYYY-MM-DD" required>
                        @error('tgl_kegiatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Waktu Mulai</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="waktu_mulai"
                            value="{{ old('waktu_mulai', date('H:i', strtotime($Presence->tgl_kegiatan))) }}"
                            placeholder="Format: HH:mm" required>
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
        @endempty
    </div>
</div>
@endsection

@push('css')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
