<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Base styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8faff; /* Lighter, clean background */
            color: #34495e; /* Darker text for readability */
        }

        .container {
            max-width: 1200px;
        }

        /* Remove spinner on number input */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Header Styling */
        .responsive-logo {
            max-height: 65px; /* Slightly larger logos */
            height: auto;
            width: auto;
            object-fit: contain;
        }
        @media (max-width: 576px) {
            .responsive-logo {
                max-height: 45px;
            }
        }
        @media (max-width: 400px) {
            .responsive-logo {
                max-height: 35px;
            }
        }

        .header-section {
            background: linear-gradient(to right, #007bff, #0056b3); /* Blue gradient header */
            color: white;
            padding: 20px 0;
            margin-bottom: 40px;
            border-bottom: 5px solid #feda00; /* Darker blue line */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);

            /* Sticky Header Styles */
            position: sticky; /* Make the header sticky */
            top: 0; /* Stick it to the top of the viewport */
            z-index: 1020; /* Ensure it stays above other content (Bootstrap default is 1020 for fixed nav) */
            width: 100%; /* Ensure it spans full width */
        }
        .header-section strong {
            font-size: clamp(16px, 2.5vw, 24px); /* Larger, more dynamic text */
            font-weight: 700;
            display: block; /* Ensure it takes full width */
        }
        .header-section span {
            font-size: clamp(13px, 1.8vw, 18px);
            opacity: 0.9;
            display: block;
        }
        .header-content {
            padding: 0 15px; /* Add some horizontal padding */
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 15px; /* More rounded corners */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* Deeper, softer shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden; /* Ensures internal elements respect border-radius */
        }
        .card:hover {
            transform: translateY(-5px); /* Subtle lift on hover */
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(to right, #007bff, #0056b3); /* Matching header gradient */
            color: white;
            padding: 18px 25px; /* More padding */
            font-weight: 600;
            font-size: 1.35rem; /* Slightly larger title */
            border-bottom: none; /* Remove default border */
        }
        .card-header .card-title {
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .card-header .card-title i {
            margin-right: 10px;
            font-size: 1.4rem;
        }

        /* Adjusted Card Body Padding */
        .card-body {
            padding: 20px 25px; /* Reduced padding here */
        }

        /* Info Kegiatan Table */
        .info-card .table-borderless td {
            padding: 8px 0; /* Slightly reduced padding */
            font-size: 1.05rem;
        }
        .info-card .table-borderless td:first-child {
            font-weight: 500; /* Medium weight for labels */
            color: #555;
        }

        /* Form Styling */
        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 6px; /* Reduced margin */
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            border-radius: 10px; /* More rounded inputs */
            padding: 10px 15px; /* Reduced padding */
            height: auto; /* Allow height to adjust naturally */
            min-height: 42px; /* Minimum height for consistency */
            border: 1px solid #dee2e6;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.15); /* Softer focus glow */
        }

        .btn-primary {
            background: linear-gradient(to right, #007bff, #0056b3); /* Gradient button */
            border: none;
            border-radius: 10px;
            padding: 12px 20px; /* Reduced padding */
            font-weight: 600;
            font-size: 1rem; /* Slightly smaller font */
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #0056b3, #004085);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.4);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            border-radius: 8px;
            padding: 8px 15px; /* Reduced padding */
            font-weight: 500;
            font-size: 0.9rem; /* Slightly smaller font */
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-1px);
        }

        #signature-pad {
            background-color: #f0f4f7; /* Light gray background for signature */
            border: 1px solid #ced4da;
            border-radius: 10px;
            width: 100%;
            height: 180px; /* Slightly reduced height */
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            font-size: 0.95rem; /* Slightly smaller font */
            padding: 12px 20px; /* Reduced padding */
            display: flex;
            align-items: center;
        }
        .alert i {
            margin-right: 8px; /* Reduced margin */
            font-size: 1.1rem;
        }

        /* Carousel/Gallery Styling */
        .gallery-card .card-body {
            position: relative; /* For absolute positioning of IG info */
            display: flex; /* To center content vertically */
            align-items: center; /* To center content vertically */
            justify-content: center; /* To center content horizontally */
            padding: 20px; /* Adjusted padding */
        }

        #carouselSlides .carousel-inner {
            border-radius: 12px; /* Match card border-radius */
            overflow: hidden; /* Ensure images stay within bounds */
            /* Add a background color to fill empty space behind images */
            background-color: #e9ecef; /* Light gray background for the inner carousel */
        }
        #carouselSlides .carousel-item img {
            max-height: 500px; /* Reduced max height for images on smaller screens */
            object-fit: contain;
            width: 100%;
            display: block;
            margin: auto;
            /* Removed background-color here as it's now on .carousel-inner */
        }

        /* Adjust max-height for larger screens */
        @media (min-width: 992px) { /* For large devices and up */
            #carouselSlides .carousel-item img {
                max-height: 500px; /* Increased max height for larger screens */
            }
        }


        .carousel-control-prev, .carousel-control-next {
            width: 8%; /* Wider touch area */
            background-image: none; /* Remove default Bootstrap icons */
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.6); /* Darker, more visible controls */
            border-radius: 50%;
            padding: 18px; /* Slightly smaller icon circle */
            display: inline-block; /* Ensure padding works */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease;
        }
        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Instagram Info */
        .ig-info {
            background-color: rgba(255, 255, 255, 0.95);
            border-top-left-radius: 18px; /* More rounded top corners */
            border-top-right-radius: 18px;
            padding: 10px 20px; /* Reduced padding */
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.08); /* Stronger shadow above */
            display: flex;
            align-items: center;
            gap: 10px; /* Reduced gap */
        }
        .ig-info img {
            height: 40px; /* Slightly smaller logos */
            border-radius: 8px; /* Rounded corners for logos */
        }
        .ig-info a {
            font-weight: 600;
            color: #007bff; /* Blue link for Instagram */
            transition: color 0.3s ease;
            font-size: 0.95rem; /* Slightly smaller font */
        }
        .ig-info a:hover {
            color: #0056b3;
        }
        .ig-info a img {
            width: 20px; /* Slightly smaller IG icon */
            height: 20px;
            margin-right: 5px;
        }

        /* DataTables Styling */
        .attendance-table-card .table {
            margin-bottom: 0; /* Remove default table margin */
            font-size: 0.9rem; /* Slightly smaller font */
        }
        .attendance-table-card .table thead th {
            background-color: #e9ecef; /* Light header background */
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            padding: 10px; /* Reduced padding */
        }
        .attendance-table-card .table tbody tr:nth-child(even) {
            background-color: #f8f9fa; /* Zebra striping */
        }
        .attendance-table-card .table tbody td {
            padding: 8px 10px; /* Reduced padding */
            vertical-align: middle;
        }
        .attendance-table-card .table tbody img {
            border: 1px solid #eee;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Select2 Customization */
        .select2-container .select2-selection--single {
            height: 42px; /* Match new form control height */
            border-radius: 10px;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px; /* Adjusted line height */
            padding-left: 15px; /* Adjusted padding */
            color: #34495e;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px; /* Adjusted height */
            right: 8px; /* Adjusted position */
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #adb5bd;
        }
        .select2-container--open .select2-dropdown {
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid #ced4da;
            overflow: hidden;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #007bff !important;
            color: white !important;
        }
        .select2-container--default .select2-results__option--selected {
            background-color: #eaf3ff !important; /* Lighter selected background */
            color: #0056b3 !important; /* Blue text for selected */
            font-weight: 500;
        }
        .select2-search input {
            border-radius: 8px !important;
            padding: 8px !important; /* Reduced padding */
            border: 1px solid #dee2e6 !important;
        }

    </style>
</head>
<body>
    @php
        $logoFormulir = \App\Models\LogoFormulir::first();
    @endphp

    <header class="header-section">
        <div class="container d-flex justify-content-between align-items-center flex-wrap header-content">
            <div class="flex-shrink-0 me-md-4 me-2">
                <img src="{{ asset('storage/' . $logoFormulir->logo_left) }}" alt="Logo Kiri" class="img-fluid responsive-logo">
            </div>

            <div class="flex-grow-1 text-center py-2 py-md-0">
                <strong class="d-block">{{ $logoFormulir->app_name ?? 'ABSENSI ONLINE' }}</strong>
                <span class="d-block">{{ $logoFormulir->header_title ?? 'PT PLN (Persero) UPT Malang' }}</span>
            </div>

            <div class="flex-shrink-0 ms-md-4 ms-2">
                <img src="{{ asset('storage/' . $logoFormulir->logo_right) }}" alt="Logo Kanan" class="img-fluid responsive-logo">
            </div>
        </div>
    </header>

    <main class="container my-5">
        <div class="card mb-4 info-card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-info-circle"></i>Detail Kegiatan</h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td width="160"><strong>Nama Kegiatan</strong></td><td width="20">:</td><td>{{ $Presence->nama_kegiatan }}</td></tr>
                    <tr><td><strong>Tempat</strong></td><td>:</td><td>{{ $Presence->tempat }}</td></tr>
                    <tr><td><strong>Tanggal Kegiatan</strong></td><td>:</td><td>{{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td></tr>
                    <tr><td><strong>Waktu</strong></td><td>:</td><td>{{ date('H:i', strtotime($Presence->tgl_kegiatan)) }} WIB</td></tr>
                </table>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li><i class="fas fa-times-circle"></i> {{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row align-items-stretch g-4">
            <div class="col-md-4">
                @php
                    $now = \Carbon\Carbon::now();
                    $batasSelesai = \Carbon\Carbon::parse($Presence->waktu_selesai);
                @endphp

                @if($now->lt($batasSelesai))
                    <div class="card h-100 form-card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-user-check"></i>Form Absensi</h5></div>
                        <div class="card-body">
                            <form action="{{ route('presence_details.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="presence_id" value="{{ $Presence->presence_id }}">
                                                                
                                <div class="mb-3">
                                    <label class="form-label" for="kategori-instansi">Unit/Instansi</label>
                                    <select name="kategori_instansi" id="kategori-instansi" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="PLN">PLN</option>
                                        <option value="PLN Group">PLN Group</option>
                                        <option value="Non PLN">Non PLN</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="dropdown-nama-wrapper" style="display: none;">
                                    <label class="form-label" for="dropdown-nama-pln">Nama Pegawai PLN</label>
                                    <select id="dropdown-nama-pln" class="form-select"></select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="nip">NIP</label>
                                    <input type="number" name="nip" id="nip" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="jabatan">Jabatan</label>
                                    <input type="text" name="jabatan" id="jabatan" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="no_hp">No. HP</label>
                                    <input type="number" name="no_hp" id="no_hp" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="asal_instansi">Asal Instansi</label>
                                    <input type="text" name="asal_instansi" id="asal_instansi" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanda Tangan</label>
                                    <canvas id="signature-pad" class="shadow-sm"></canvas>
                                    <input type="hidden" name="tanda_tangan" id="signature-data">
                                    <button type="button" class="btn btn-sm btn-secondary mt-2 w-100" onclick="clearSignature()">
                                        <i class="fas fa-eraser me-1"></i> Hapus Tanda Tangan
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-3"><i class="fas fa-save me-2"></i>Simpan Absensi</button>
                            </form>
                        </div>
                    </div>
                @else
                <div class="alert alert-warning text-center form-card p-4 h-100 d-flex flex-column justify-content-center align-items-center">
                    <i class="fas fa-calendar-times fa-3x mb-3 text-warning"></i>
                    <strong class="h4">Presensi telah ditutup.</strong>
                    <p class="mb-0 fs-5">Batas waktu: {{ \Carbon\Carbon::parse($Presence->waktu_selesai)->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="card h-100 gallery-card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-images"></i>Galeri Kegiatan</h5>
                </div>
                <div class="card-body position-relative"> <div id="carouselSlides" class="carousel slide w-100" data-bs-ride="carousel" data-bs-interval="4000"> <div class="carousel-inner">
                            @forelse($slides as $index => $slide)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/slides/' . $slide->filename) }}" class="d-block img-fluid" alt="Slide Image">
                            </div>
                            @empty
                                <div class="carousel-item active">
                                    <img src="https://via.placeholder.com/1000x550?text=Tidak+Ada+Gambar+Untuk+Kegiatan+Ini" class="d-block w-100 img-fluid" alt="No Images">
                                </div>
                            @endforelse
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselSlides" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Sebelumnya</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselSlides" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Berikutnya</span>
                        </button>
                    </div>

                    <div class="position-absolute bottom-0 start-50 translate-middle-x ig-info">
                        <div class="d-flex align-items-center gap-3">
                            @if($instagrams && $instagrams->logo)
                                <img src="{{ asset('storage/' . $instagrams->logo) }}" alt="Logo Instansi">
                            @endif

                            @if($instagrams && $instagrams->instagram_username)
                                <a href="https://instagram.com/{{ $instagrams->instagram_username }}" target="_blank"
                                    class="d-flex align-items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram Icon">
                                    <span>{{ '@' . $instagrams->instagram_username }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="card mt-5 attendance-table-card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-list-alt"></i>Daftar Peserta Absensi</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="presences" class="table table-bordered table-striped table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Waktu Absen</th>
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
    </main>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255,255,255,0)', // Ensure transparent background
                penColor: 'rgb(0, 0, 0)' // Black pen color
            });

            window.clearSignature = function () {
                signaturePad.clear();
                document.getElementById('signature-data').value = '';
            };

            document.querySelector('form').addEventListener('submit', function (e) {
                if (signaturePad.isEmpty()) {
                    alert('Mohon berikan tanda tangan Anda sebelum menyimpan.');
                    e.preventDefault();
                } else {
                    document.getElementById('signature-data').value = signaturePad.toDataURL('image/png'); // Save as PNG for transparency
                }
            });
            
            // Adjust canvas size on window resize
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear(); // Clear signature after resize
            }
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas(); // Initial call
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'waktu_absen' },
                    { data: 'nama' },
                    { data: 'nip' },
                    { data: 'jabatan' },
                    { data: 'email' },
                    { data: 'no_hp' },
                    { data: 'asal_instansi' },
                    {
                        data: 'tanda_tangan',
                        render: function(data) {
                            return '<img src="/storage/tanda_tangan/' + data + '" width="100" class="img-fluid rounded shadow-sm" alt="Tanda Tangan"/>';
                        }
                    }
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Inisialisasi Select2
            $('#dropdown-nama-pln').select2({
                placeholder: 'Cari nama pegawai PLN...',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: "{{ url('/pegawai/search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: item.nama,
                                nip: item.nip,
                                jabatan: item.jabatan,
                                email: item.email,
                                no_hp: item.no_hp,
                                asal_instansi: item.asal_instansi
                            }))
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

            // Tampilkan dropdown nama PLN jika PLN dipilih
            $('#kategori-instansi').on('change', function () {
                const kategori = $(this).val();
                if (kategori === 'PLN') {
                    $('#dropdown-nama-wrapper').slideDown(); // Smooth animation
                } else {
                    $('#dropdown-nama-wrapper').slideUp(); // Smooth animation
                    $('#dropdown-nama-pln').val(null).trigger('change');
                    // Kosongkan form for Non-PLN
                    $('#nama').val('');
                    $('#nip').val('');
                    $('#jabatan').val('');
                    $('#email').val('');
                    $('#no_hp').val('');
                    $('#asal_instansi').val('');
                }
            });

            // Ketika nama pegawai dipilih, isi otomatis form
            $('#dropdown-nama-pln').on('select2:select', function (e) {
                const data = e.params.data;
                $('#nama').val(data.text);
                $('#nip').val(data.nip);
                $('#jabatan').val(data.jabatan);
                $('#email').val(data.email);
                $('#no_hp').val(data.no_hp);
                $('#asal_instansi').val(data.asal_instansi);
            });

            // Clear form fields when Select2 selection is cleared
            $('#dropdown-nama-pln').on('select2:clear', function (e) {
                $('#nama').val('');
                $('#nip').val('');
                $('#jabatan').val('');
                $('#email').val('');
                $('#no_hp').val('');
                $('#asal_instansi').val('');
            });

            // Jalankan saat load untuk memastikan visibility berdasarkan nilai awal
            $('#kategori-instansi').trigger('change');
        });
    </script>

</body>
</html>