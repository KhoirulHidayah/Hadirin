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
     <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <style>
        /* Base styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8faff;
            color: #34495e;
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
            max-height: 65px;
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
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            padding: 20px 0;
            border-bottom: 5px solid #FFEB00;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1020;
            width: 100%;
            margin-bottom: 0; /* Remove margin to control spacing via container */
        }
        .header-section strong {
            font-size: clamp(16px, 2.5vw, 24px);
            font-weight: 700;
            display: block;
        }
        .header-section span {
            font-size: clamp(13px, 1.8vw, 18px);
            opacity: 0.9;
            display: block;
        }
        .header-content {
            padding: 0 15px;
        }

        /* Main Container Spacing */
        main.container {
            padding-top: 2rem; /* Consistent top spacing after header */
            padding-bottom: 2rem; /* Consistent bottom spacing */
        }

        /* Card Styling with Consistent Spacing */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            margin-bottom: 1.5rem; /* Consistent spacing between cards */
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        /* Last card should not have bottom margin */
        .card:last-child {
            margin-bottom: 0;
        }

        .card-header {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            padding: 1.25rem; /* Consistent padding */
            font-weight: 600;
            font-size: 1.1rem;
            border-bottom: none;
        }
        .card-header .card-title {
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .card-header .card-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .card-body {
            padding: 1.25rem; /* Consistent padding */
        }

        /* Info Kegiatan Table */
        .info-card .table-borderless td {
            padding: 0.5rem 0;
            font-size: 1rem;
        }
        .info-card .table-borderless td:first-child {
            font-weight: 500;
            color: #555;
        }

        /* Form Styling */
        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            height: auto;
            min-height: 42px;
            border: 1px solid #dee2e6;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1rem; /* Consistent spacing between form elements */
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.15);
        }

        /* Form Group Consistent Spacing */
        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .btn-primary {
            background: linear-gradient(to right, #007bff, #0056b3);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            font-size: 1rem;
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
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-1px);
        }

        #signature-pad {
            background-color: #f0f4f7;
            border: 1px solid #ced4da;
            border-radius: 10px;
            width: 100%;
            height: 180px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* Alerts with Consistent Spacing */
        .alert {
            border-radius: 10px;
            font-size: 0.95rem;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem; /* Consistent spacing */
        }
        .alert i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        /* Row and Column Spacing */
        .row.g-4 {
            margin-bottom: 1.5rem; /* Consistent spacing after grid */
        }

        /* Gallery Card Styling */
        .gallery-card .card-body {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
        }

        #carouselSlides .carousel-inner {
            border-radius: 12px;
            overflow: hidden;
            background-color: #e9ecef;
        }
        #carouselSlides .carousel-item img {
            max-height: 400px;
            object-fit: contain;
            width: 100%;
            display: block;
            margin: auto;
        }

        @media (min-width: 992px) {
            #carouselSlides .carousel-item img {
                max-height: 450px;
            }
        }

        .carousel-control-prev, .carousel-control-next {
            width: 8%;
            background-image: none;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            padding: 18px;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease;
        }
        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* UPDATED: Instagram Info - Centered with vertical layout */
        .ig-info {
            background-color: rgba(255, 255, 255, 0.541);
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            padding: 0.75rem 1.25rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column; /* This will stack items vertically */
            align-items: center; /* Center items horizontally */
            justify-content: center;
            gap: 8px; /* Space between logo and link */
        }

        .ig-info img {
            height: 80px;
            border-radius: 6px;
        }

        .ig-info a.instagram-link {
            font-weight: 600;
            color: #007bff;
            transition: color 0.3s ease;
            font-size: 0.95rem;
            text-decoration: none; /* Remove underline */
        }

        .ig-info a.instagram-link:hover {
            color: #0056b3;
        }

        .ig-info a.instagram-link img {
            width: 14px;
            height: 14px;
            margin-right: 5px;
            border-radius: 0px; /* Mengurangi border radius agar sudut tidak terlalu melengkung */
        }

        /* DataTables Styling - Compact Version */
        .attendance-table-card .table {
            margin-bottom: 0;
            font-size: 0.75rem; /* Smaller font size */
        }
        .attendance-table-card .table thead th {
            background-color: #e9ecef;
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            padding: 0.4rem 0.5rem; /* Reduced padding */
            font-size: 0.7rem; /* Smaller header font */
            white-space: nowrap; /* Prevent text wrapping */
        }
        .attendance-table-card .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .attendance-table-card .table tbody td {
            padding: 0.3rem 0.5rem; /* Reduced padding */
            vertical-align: middle;
            font-size: 0.75rem; /* Consistent small font */
            white-space: nowrap; /* Prevent text wrapping */
        }
        .attendance-table-card .table tbody img {
            border: 1px solid #eee;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            width: 60px; /* Smaller signature image */
            height: auto;
        }
        
        /* DataTables Controls Styling */
        .attendance-table-card .dataTables_wrapper .dataTables_length,
        .attendance-table-card .dataTables_wrapper .dataTables_filter,
        .attendance-table-card .dataTables_wrapper .dataTables_info,
        .attendance-table-card .dataTables_wrapper .dataTables_paginate {
            font-size: 0.75rem; /* Smaller controls font */
        }
        
        .attendance-table-card .dataTables_wrapper .dataTables_length select,
        .attendance-table-card .dataTables_wrapper .dataTables_filter input {
            font-size: 0.75rem; /* Smaller input font */
            padding: 0.25rem 0.5rem; /* Reduced input padding */
            height: auto;
        }
        
        .attendance-table-card .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.25rem 0.5rem; /* Smaller pagination buttons */
            font-size: 0.7rem;
        }
        
        /* Responsive adjustments for table */
        @media (max-width: 991.98px) {
            .attendance-table-card .table {
                font-size: 0.65rem; /* Even smaller on mobile */
            }
            .attendance-table-card .table thead th {
                padding: 0.3rem 0.4rem;
                font-size: 0.65rem;
            }
            .attendance-table-card .table tbody td {
                padding: 0.25rem 0.4rem;
                font-size: 0.65rem;
            }
            .attendance-table-card .table tbody img {
                width: 40px; /* Smaller signature on mobile */
            }
        }

        /* Select2 Customization */
        .select2-container .select2-selection--single {
            height: 42px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
            padding-left: 15px;
            color: #34495e;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 8px;
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
            background-color: #eaf3ff !important;
            color: #0056b3 !important;
            font-weight: 500;
        }
        .select2-search input {
            border-radius: 8px !important;
            padding: 8px !important;
            border: 1px solid #dee2e6 !important;
        }

        /* Spacing Utilities Override */
        .mt-5 {
            margin-top: 2rem !important; /* Consistent large spacing */
        }
        .my-5 {
            margin-top: 2rem !important;
            margin-bottom: 2rem !important;
        }

        /* Form Card Specific Styling - Fixed Height and Alignment */
        .form-card {
            align-self: flex-start; /* Prevent form from stretching */
            min-height: fit-content; /* Let form determine its own height */
        }
        
        .form-card .card-body {
            padding: 1.25rem;
        }
        
        .form-card .card-body form > .mb-3:last-of-type {
            margin-bottom: 1.5rem !important; /* Extra space before submit button */
        }

        /* UPDATED: Layout alignment when gallery is hidden */
        .layout-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: flex-start; /* Align items to top */
        }
        
        .form-column {
            flex: 0 0 auto;
            width: 100%;
        }
        
        .content-column {
            flex: 1;
            min-width: 0; /* Prevent flex item from overflowing */
            width: 100%;
        }
        
        /* Desktop layout adjustments */
        @media (min-width: 768px) {
            .form-column {
                width: 350px; /* Fixed width for form */
                max-width: 350px;
            }
            
            /* When gallery is shown, content column takes remaining space */
            .gallery-shown .content-column {
                flex: 1;
            }
            
            /* When gallery is hidden, table starts at same top level as form */
            .gallery-hidden .content-column {
                flex: 1;
            }
            
            /* Remove top margin when gallery is hidden */
            .gallery-hidden .attendance-table-card {
                margin-top: 0 !important;
            }
            
            /* Add top margin when gallery is shown */
            .gallery-shown .attendance-table-card {
                margin-top: 1.5rem;
            }
        }
        
        /* Mobile layout - stack vertically */
        @media (max-width: 767.98px) {
            .layout-container {
                flex-direction: column;
            }
            
            .form-column,
            .content-column {
                width: 100%;
            }
            
            .attendance-table-card {
                margin-top: 1.5rem !important;
            }
        }

        /* Warning alert for closed attendance */
        .closed-attendance-alert {
            min-height: 300px; /* Set minimum height for closed attendance alert */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

    </style>
</head>
<body>
    @php
        $logoFormulir = \App\Models\LogoFormulir::first();
    @endphp

    <header class="header-section">
        <div class="container d-flex justify-content-between align-items-center flex-wrap header-content">
            {{-- Logo Kiri --}}
            <div class="flex-shrink-0 me-md-4 me-2">
                @if (!empty($logoFormulir->logo_left))
                    <img src="{{ asset('storage/' . $logoFormulir->logo_left) }}" alt="Logo Kiri" class="img-fluid responsive-logo">
                @endif
            </div>

            {{-- Judul --}}
            <div class="flex-grow-1 text-center py-2 py-md-0">
                @if (!empty($logoFormulir->app_name) || !empty($logoFormulir->header_title))
                    <strong class="d-block">{{ $logoFormulir->app_name ?? 'ABSENSI ONLINE' }}</strong>
                    <span class="d-block">{{ $logoFormulir->header_title ?? 'PT PLN (Persero) UPT Malang' }}</span>
                @endif
            </div>

            {{-- Logo Kanan --}}
            <div class="flex-shrink-0 ms-md-4 ms-2">
                @if (!empty($logoFormulir->logo_right))
                    <img src="{{ asset('storage/' . $logoFormulir->logo_right) }}" alt="Logo Kanan" class="img-fluid responsive-logo">
                @endif
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card info-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i>Detail Kegiatan
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td width="160"><strong>Nama Kegiatan</strong></td><td width="20">:</td><td>{{ $Presence->nama_kegiatan }}</td></tr>
                    <tr><td><strong>Tempat</strong></td><td>:</td><td>{{ $Presence->tempat }}</td></tr>
                    <tr><td><strong>Tanggal Kegiatan</strong></td><td>:</td><td>{{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td></tr>
                    <tr><td><strong>Waktu</strong></td><td>:</td><td>{{ date('H:i', strtotime($Presence->tgl_kegiatan)) }} - {{ date('H:i', strtotime($Presence->waktu_selesai)) }} WIB</td></tr>
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

        {{-- UPDATED: New layout container with conditional classes --}}
        <div class="layout-container {{ ($instagrams && $instagrams->show_gallery) ? 'gallery-shown' : 'gallery-hidden' }}">
            <div class="form-column">
                @php
                    $now = \Carbon\Carbon::now();
                    $batasSelesai = \Carbon\Carbon::parse($Presence->waktu_selesai);
                @endphp

                @if($now->lt($batasSelesai))
                    <div class="card form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-check"></i>Form Absensi
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('presence_details.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="presence_id" value="{{ $Presence->presence_id }}">
                                                                        
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Perusahaan</label>
                                    <select name="kategori" id="kategori" class="form-select">
                                        <option value="">-- Pilih Perusahaan --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->nama }}" {{ old('kategori') == $category->nama ? 'selected' : '' }}>
                                                {{ $category->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3" id="dropdown-nama-wrapper" style="display: none;">
                                    <label for="dropdown-nama-pegawai" class="form-label">Nama Pegawai</label>
                                    <select id="dropdown-nama-pegawai" class="form-control">
                                        <option value="">-- Pilih Pegawai --</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="asal_instansi">Unit</label>
                                    <select name="asal_instansi" id="asal_instansi" class="form-select" required>
                                        <option value="">-- Pilih Unit --</option>
                                        @foreach($instansiList as $instansi)
                                            <option value="{{ $instansi }}" {{ old('asal_instansi') == $instansi ? 'selected' : '' }}>
                                                {{ $instansi }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" required pattern="^0[0-9]{9,13}" title="Nomor HP harus diawali 0 dan panjang antara 10-14 digit">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanda Tangan</label>
                                    <canvas id="signature-pad" class="shadow-sm"></canvas>
                                    <input type="hidden" name="tanda_tangan" id="signature-data">
                                    <button type="button" class="btn btn-sm btn-secondary mt-2 w-100" onclick="clearSignature()">
                                        <i class="fas fa-eraser me-1"></i> Hapus Tanda Tangan
                                    </button>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Simpan Absensi
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning closed-attendance-alert">
                        <i class="fas fa-calendar-times fa-3x mb-3 text-warning"></i>
                        <strong class="h4">Presensi telah ditutup.</strong>
                        <p class="mb-0 fs-5">Batas waktu: {{ \Carbon\Carbon::parse($Presence->waktu_selesai)->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                @endif
            </div>

            <div class="content-column">
                {{-- Conditional Gallery Display --}}
                @if($instagrams && $instagrams->show_gallery)
                <div class="card gallery-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-images"></i>Galeri Kegiatan
                        </h5>
                    </div>
                    <div class="card-body position-relative">
                        <div id="carouselSlides" class="carousel slide w-100" data-bs-ride="carousel" data-bs-interval="4000">
                            <div class="carousel-inner">
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
                    </div>
                     {{-- UPDATE: Letakkan ig-info setelah card-body --}}
                    @if($instagrams && ($instagrams->logo || $instagrams->instagram_username))
                        <div class="ig-info">
                            {{-- Update: Struktur HTML untuk menempatkan logo di atas --}}
                            @if($instagrams && $instagrams->logo)
                                <div class="logo-wrapper">
                                    <img src="{{ asset('storage/' . $instagrams->logo) }}" alt="Logo Instansi">
                                </div>
                            @endif

                            @if($instagrams && $instagrams->instagram_username)
                                <a href="https://instagram.com/{{ $instagrams->instagram_username }}" target="_blank"
                                class="instagram-link d-flex align-items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram Icon">
                                    <span>{{ '@' . $instagrams->instagram_username }}</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                @endif

                <div class="card attendance-table-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-alt"></i>Daftar Peserta Absensi
                        </h5>
                    </div>
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
                                        <th>Unit</th>
                                        <th>Perusahaan</th>
                                        <th>Tanda Tangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255,255,255,0)',
                penColor: 'rgb(0, 0, 0)'
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
                    document.getElementById('signature-data').value = signaturePad.toDataURL('image/png');
                }
            });
            
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // DataTable
            $('#presences').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
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
                    { data: 'kategori' },
                    {
                        data: 'tanda_tangan',
                        render: function (data) {
                            if (data) {
                                return '<img src="/storage/tanda_tangan/' + data + '" width="100" class="img-fluid rounded shadow-sm" alt="Tanda Tangan"/>';
                            }
                            return 'Tidak Ada';
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                },
                dom: '<"top"fl>rt<"bottom"ip><"clear">',
                responsive: true,
                scrollX: true
            });

            // Select2 untuk kategori
            $('#kategori').select2({
                placeholder: "-- Pilih Perusahaan --",
                allowClear: true
            });

            // Inisialisasi Select2
            $('#asal_instansi').select2({
                placeholder: "-- Pilih Unit --",
                allowClear: true,
                tags: true
            });

            // Buka dropdown saat select diklik
            $(document).on('mousedown', '#asal_instansi', function (e) {
                e.preventDefault();
                $(this).select2('open');
            });

            // Select2 untuk nama pegawai (diperbarui saat kategori dipilih)
            $('#dropdown-nama-pegawai').select2({
                placeholder: "-- Cari nama Anda --",
                allowClear: true,
                tags: true,
                data: [] // akan diisi dinamis
            });

        // Sembunyikan dropdown saat halaman dimuat
            $('#dropdown-nama-wrapper').hide();

            // Saat kategori berubah
            $('#kategori').on('change', function () {
                const kategori = $(this).val();

                if (kategori) {
                    $.ajax({
                        url: `/pegawai/by-kategori/${kategori}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            if (data.length > 0) {
                                let options = '<option value="">-- Pilih Pegawai --</option>';
                                data.forEach(function (pegawai) {
                                    options += `
                                        <option 
                                            value="${pegawai.nama}" 
                                            data-nip="${pegawai.nip}" 
                                            data-jabatan="${pegawai.jabatan}" 
                                            data-email="${pegawai.email}">
                                            ${pegawai.nama}
                                        </option>`;
                                });
                                $('#dropdown-nama-pegawai').html(options);
                                $('#dropdown-nama-wrapper').show();
                            } else {
                                $('#dropdown-nama-pegawai').html('');
                                $('#dropdown-nama-wrapper').hide();

                                // Kosongkan isian lainnya
                                $('#nama, #nip, #jabatan, #email, #no_hp, #asal_instansi').val('');
                            }
                        },
                        error: function () {
                            alert('Gagal mengambil data pegawai.');
                            $('#dropdown-nama-pegawai').html('');
                            $('#dropdown-nama-wrapper').hide();
                            $('#nama, #nip, #jabatan, #email, #no_hp, #asal_instansi').val('');
                        }
                    });
                } else {
                    $('#dropdown-nama-pegawai').html('');
                    $('#dropdown-nama-wrapper').hide();
                    $('#nama, #nip, #jabatan, #email, #no_hp, #asal_instansi').val('');
                }
            });

            // Saat nama pegawai dipilih
            $('#dropdown-nama-pegawai').on('change', function () {
                const selected = $(this).find(':selected');

                $('#nama').val(selected.val());
                $('#nip').val(selected.data('nip'));
                $('#jabatan').val(selected.data('jabatan'));
                $('#email').val(selected.data('email'));
            });
        });
    </script>

</body>
</html>