<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>

    <!-- Bootstrap & DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    div.dataTables_wrapper div.dataTables_length {
        float: right;
        margin-left: 10px;
    }

    div.dataTables_wrapper div.dataTables_filter {
        float: right;
        text-align: right;
        margin-bottom: 15px; /* ✅ ini kunci agar tidak mepet */
    }

    .dataTables_wrapper .dataTables_filter input {
        margin-left: 0.5em;
        width: 200px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.25rem 0.75rem;
        margin: 0 3px;
        border-radius: 0.25rem;
        border: 1px solid #0d6efd;
        background-color: #fff;
        color: #0d6efd !important;
        font-size: 0.875rem;
        transition: 0.3s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
    }

    .dataTables_wrapper .dataTables_info {
        float: left;
        margin-top: 10px;
    }

    .dataTables_wrapper .dataTables_paginate {
        float: right;
        margin-top: 10px;
    }

    /* Garis atas tabel */
    table.dataTable thead th {
        border-top: 1px solid #dee2e6 !important;
    }
</style>

</head>
<body>
    <div class="container my-5">
        <!-- Informasi Kegiatan -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="text-center">{{ env('APP_NAME') }}</h4>
                <table class="table table-borderless">
                    <tr>
                        <td width="150">Nama Kegiatan</td>
                        <td width="20">:</td>
                        <td>{{ $Presence->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td width="150">Tempat</td>
                        <td width="20">:</td>
                        <td>{{$Presence->tempat}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kegiatan</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Waktu</td>
                        <td>:</td>
                        <td>{{ date('H:i', strtotime($Presence->tgl_kegiatan)) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form dan Daftar Absensi -->
        <div class="row">
            <!-- Form Absensi -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Absensi</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('presence_details.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="presence_id" value="{{ $Presence->presence_id }}">

                            <!-- Input Nama -->
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" required>
                                @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Input NIP -->
                            <div class="mb-3">
                                <label class="form-label">NIP</label>
                                <input type="number" name="nip" value="{{ old('nip') }}" class="form-control @error('nip') is-invalid @enderror" required>
                                @error('nip') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Input Jabatan -->
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="form-control @error('jabatan') is-invalid @enderror" required>
                                @error('jabatan') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Input Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Input No HP -->
                            <div class="mb-3">
                                <label class="form-label">No. HP</label>
                                <input type="number" name="no_hp" value="{{ old('no_hp') }}" class="form-control @error('no_hp') is-invalid @enderror" required>
                                @error('no_hp') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Input Instansi -->
                            <div class="mb-3">
                                <label class="form-label">Asal Instansi</label>
                                <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" class="form-control @error('asal_instansi') is-invalid @enderror" required>
                                @error('asal_instansi') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Input Tanda Tangan -->
                            <div class="mb-3">
                                <label class="form-label">Tanda Tangan</label>
                                <canvas id="signature-pad" style="border:1px solid #ccc; width:100%; height:200px;"></canvas>
                                <input type="hidden" name="tanda_tangan" id="signature-data">
                                <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="clearSignature()">
                                    <i class="fas fa-trash"></i> Hapus Tanda Tangan
                                </button>
                                @error('tanda_tangan') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                            </div>

                            <!-- Tombol Simpan -->
                            <button type="submit" class="btn btn-primary w-100 mt-3">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Absensi -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Daftar Absensi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="presences" class="table table-bordered table-striped table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Jabatan/Bidang</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Unit/Instansi</th>
                                        <th>Tanda Tangan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Signature Pad -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255,255,255,0)'
            });

            function clearSignature() {
                signaturePad.clear();
                document.getElementById('signature-data').value = '';
            }

            window.clearSignature = clearSignature;

            document.querySelector('form').addEventListener('submit', function (e) {
                if (!signaturePad.isEmpty()) {
                    const dataURL = signaturePad.toDataURL();
                    document.getElementById('signature-data').value = dataURL;
                } else {
                    alert('Tanda tangan belum diisi.');
                    e.preventDefault();
                }
            });
        });
    </script>

    <!-- jQuery, DataTables, Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- DataTable Initialization -->
    <script>
        $(document).ready(function() {
            $('#presences').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('presence_details/list') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        presence_id: '{{ $Presence->presence_id }}'
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama', name: 'nama' },
                    { data: 'nip', name: 'nip' },
                    { data: 'jabatan', name: 'jabatan' },
                    { data: 'email', name: 'email' },
                    { data: 'no_hp', name: 'no_hp' },
                    { data: 'asal_instansi', name: 'asal_instansi' },
                    {
                        data: 'tanda_tangan',
                        name: 'tanda_tangan',
                        render: function(data) {
                            return '<img src="/storage/tanda_tangan/' + data + '" width="100"/>';
                        }
                    }
                ]
            });
        });
    </script>
</body>
</html>
