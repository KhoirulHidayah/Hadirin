@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="mb-0 text-white">
                <i class="fas fa-info-circle mr-2"></i> Detail Kegiatan
            </h6>
            <div class="ml-auto d-flex flex-wrap gap-2">
                {{-- QR Code Button --}}
                <button type="button" class="btn btn-info btn-sm mr-2" data-toggle="modal" data-target="#qrCodeModal">
                    <i class="fas fa-qrcode"></i> Tampilkan QR
                </button>
                <button type="button" onclick="copyLink()" class="btn btn-warning btn-sm mr-2">
                    <i class="fas fa-link"></i> Copy Link
                </button>
                <a href="#" class="btn btn-danger btn-sm btn-export-pdf" id="export-pdf">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('presence_details.export.excel', ['id' => $Presence->presence_id]) }}" class="btn btn-success btn-sm mr-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('presence_details.export.word', ['id' => $Presence->presence_id]) }}"
                class="btn btn-sm"
                style="background-color: #0000FF; color: white;">
                    <i class="fas fa-file-word"></i> Export Word
                </a>
                <a href="{{ url('presence') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-borderless table-detail-info">
            <tr>
                <td class="font-weight-bold" width="180">Nama Kegiatan</td>
                <td width="10">:</td>
                <td>{{ $Presence->nama_kegiatan }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Tempat</td>
                <td>:</td>
                <td>{{ $Presence->tempat }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Tanggal Kegiatan</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Waktu</td>
                <td>:</td>
                <td>{{ date('H:i', strtotime($Presence->tgl_kegiatan)) }} - {{ date('H:i', strtotime($Presence->waktu_selesai)) }} WIB</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Status</td>
                <td>:</td>
                <td>
                    @if ($Presence->status == 'aktif')
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-secondary">Tidak Aktif</span>
                    @endif
                </td>
            </tr>
        </table>

        <hr class="my-4">

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2 fa-lg"></i>
                <div>{{ session('success') }}</div>
                <button type="button"
                        class="btn-close ms-auto align-self-center"
                        data-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif
        {{-- Notifikasi Eror --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2 fa-lg"></i>
                <div>{{ session('error') }}</div>
                <button type="button"
                        class="btn-close ms-auto align-self-center"
                        data-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif

        <h6 class="mb-3 text-dark"><i class="fas fa-list-alt mr-2"></i> Daftar Peserta</h6>

        @php
            $instansis = \App\Models\PresenceDetail::where('presence_id', $Presence->presence_id)
                ->pluck('asal_instansi')
                ->unique()
                ->filter()
                ->sort();
            
            $kategoris = \App\Models\PresenceDetail::where('presence_id', $Presence->presence_id)
                ->pluck('kategori')
                ->unique()
                ->filter()
                ->sort();
        @endphp

        {{-- Filter Section --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="filter_instansi" class="form-label">Filter Unit:</label>
                <select id="filter_instansi" class="form-control form-control-sm">
                    <option value="">-- Semua Unit --</option>
                    @foreach($instansis as $instansi)
                        <option value="{{ $instansi }}">{{ $instansi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="filter_kategori" class="form-label">Filter Perusahaan:</label>
                <select id="filter_kategori" class="form-control form-control-sm">
                    <option value="">-- Semua Perusahaan --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-secondary" id="reset-filter">
                    <i class="fas fa-sync-alt"></i> Reset
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm w-100" id="presences">
                <thead class="thead-light">
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
                        <th class="text-center align-middle">Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
      data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>

{{-- Modern Landscape QR Code Modal --}}
<div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modern-modal">
            <div class="modal-header modern-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="header-text">
                        <h5 class="modal-title" id="qrCodeModalLabel">QR Code Absensi</h5>
                        <p class="modal-subtitle">Scan untuk melakukan absensi</p>
                    </div>
                </div>
                <button type="button" class="close modern-close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body modern-body">
                <div class="modal-content-grid">
                    <!-- Left Column: Event Info & Actions -->
                    <div class="left-column">
                        <div class="event-info">
                            <h4 class="event-title">{{ $Presence->nama_kegiatan }}</h4>
                            <div class="event-details">
                                <div class="detail-item">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>{{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="far fa-clock"></i>
                                    <span>{{ date('H:i', strtotime($Presence->tgl_kegiatan)) }} - {{ date('H:i', strtotime($Presence->waktu_selesai)) }} WIB</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $Presence->tempat }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            <button class="btn modern-btn primary-btn" onclick="downloadQrCode()">
                                <i class="fas fa-download"></i>
                                <span>Unduh QR</span>
                            </button>
                            <button class="btn modern-btn secondary-btn" id="downloadCardBtn">
                                <i class="fas fa-id-card"></i>
                                <span>Unduh Kartu</span>
                            </button>
                            <button class="btn modern-btn outline-btn" onclick="copyLink()">
                                <i class="fas fa-link"></i>
                                <span>Salin Link</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Right Column: QR Code -->
                    <div class="qr-section">
                        <div class="qr-code-wrapper">
                            <div class="qr-code-container">
                                {!! QrCode::size(180)->generate(route('absen.index', ['presence_id' => $Presence->presence_id, 'slug' => $Presence->slug])) !!}
                            </div>
                        </div>
                        <p class="scan-instruction">Arahkan kamera smartphone ke QR Code untuk melakukan absensi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modern Landscape Hidden QR Card for Download --}}
<div id="qrCard" style="display: none;">
    <div class="modern-qr-card">
        <div class="card-header-design">
            <div class="gradient-bg"></div>
            <div class="header-pattern">
                <div class="pattern-circle circle-1"></div>
                <div class="pattern-circle circle-2"></div>
                <div class="pattern-circle circle-3"></div>
            </div>
            <div class="header-content">
                <div class="event-badge">
                    <i class="fas fa-calendar-check"></i>
                    <span>ABSENSI</span>
                </div>
            </div>
        </div>
        
        <div class="card-body-design">
            <!-- Left Content -->
            <div class="card-left-content">
                <div class="event-title">{{ $Presence->nama_kegiatan }}</div>
                <div class="event-meta">
                    <div class="meta-item">
                        <i class="far fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($Presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}
                    </div>
                    <div class="meta-item">
                        <i class="far fa-clock"></i>
                        {{ date('H:i', strtotime($Presence->tgl_kegiatan)) }} - {{ date('H:i', strtotime($Presence->waktu_selesai)) }} WIB
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $Presence->tempat }}
                    </div>
                </div>
            </div>
            
            <!-- Right Content: QR Code -->
            <div class="card-right-content">
                <div class="qr-container">
                    <div class="qr-wrapper">
                        {!! QrCode::size(140)->generate(route('absen.index', ['presence_id' => $Presence->presence_id, 'slug' => $Presence->slug])) !!}
                    </div>
                    <div class="scan-text">Scan QR Code<br>untuk Absensi</div>
                </div>
            </div>
            
            <!-- Full Width Link Section -->
            <div class="link-section">
                <div class="link-label">Link Absensi:</div>
                <div class="link-url">{{ route('absen.index',['presence_id' => $Presence->presence_id, 'slug' => $Presence->slug]) }}</div>
            </div>
        </div>
            
        <div class="card-footer-design">
            <div class="footer-pattern"></div>
            <div class="generated-text">Generated by <strong><a href="#">Hadirin</a></strong> - PLN </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    let table;

    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function () {
        table = $('#presences').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: true,
            ajax: {
                url: "{{ url('presence_details/list') }}",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d._token = '{{ csrf_token() }}';
                    d.presence_id = '{{ $Presence->presence_id }}';
                    d.asal_instansi = $('#filter_instansi').val();
                    d.kategori = $('#filter_kategori').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center" },
                { data: 'waktu_absen', name: 'waktu_absen' },
                { data: 'nama', name: 'nama' },
                { data: 'nip', name: 'nip' },
                { data: 'jabatan', name: 'jabatan' },
                { data: 'email', name: 'email' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'asal_instansi', name: 'asal_instansi' },
                { data: 'kategori', name: 'kategori', defaultContent: '-' },
                {
                    data: 'tanda_tangan', name: 'tanda_tangan', orderable: false, searchable: false, className: 'text-center',
                    render: function (data) {
                        return data ? `<img src="/storage/tanda_tangan/${data}" alt="Tanda Tangan" class="img-fluid" style="max-width:80px;"/>` : '-';
                    }
                },
                {
                    data: 'id', orderable: false, searchable: false, className: 'text-center',
                    render: function (data) {
                        return `
                            <form action="/presence_details/${data}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"> Hapus</i></button>
                            </form>`;
                    }
                }
            ]
        });

        // Event handler untuk filter instansi
        $('#filter_instansi').change(function () {
            table.ajax.reload();
        });

        // Event handler untuk filter kategori
        $('#filter_kategori').change(function () {
            table.ajax.reload();
        });

        // Tombol Reset Filter
        $('#reset-filter').on('click', function () {
            $('#filter_instansi').val('');
            $('#filter_kategori').val('');
            table.ajax.reload();
        });

        // Export PDF dengan filter
        $('#export-pdf').on('click', function (e) {
            e.preventDefault();

            const instansi = $('#filter_instansi').val();
            const kategori = $('#filter_kategori').val();
            const baseUrl = "{{ route('presence_details.export.pdf', $Presence->presence_id) }}";
            
            let params = [];
            if (instansi) params.push(`instansi=${encodeURIComponent(instansi)}`);
            if (kategori) params.push(`kategori=${encodeURIComponent(kategori)}`);
            
            const newUrl = params.length > 0 ? `${baseUrl}?${params.join('&')}` : baseUrl;
            window.location.href = newUrl;
        });

        // Event handler untuk tombol unduh card
        $('#downloadCardBtn').on('click', function() {
            downloadQrCard();
        });

        // Fix lebar kolom saat sidebar pushmenu toggle
        document.addEventListener('shown.lte.pushmenu', function () {
            setTimeout(() => {
                table.columns.adjust().draw(false);
            }, 300);
        });

        document.addEventListener('collapsed.lte.pushmenu', function () {
            setTimeout(() => {
                table.columns.adjust().draw(false);
            }, 300);
        });
    });

    function copyLink() {
        navigator.clipboard.writeText("{{ route('absen.index',['presence_id' => $Presence->presence_id, 'slug' => $Presence->slug]) }}")
            .then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Disalin!',
                    text: 'Link kehadiran berhasil disalin ke clipboard.',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyalin!',
                    text: 'Terjadi kesalahan saat menyalin link.',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
    }

    // Function to download QR code (Updated)
    function downloadQrCode() {
        const qrCodeSvg = document.querySelector('#qrCodeModal .qr-code-container svg');
        if (!qrCodeSvg) {
            console.error('QR code SVG not found.');
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'QR Code tidak ditemukan untuk diunduh.',
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }

        const svgData = new XMLSerializer().serializeToString(qrCodeSvg);
        const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
        const svgUrl = URL.createObjectURL(svgBlob);

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const img = new Image();

        img.onload = function() {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);

            const pngUrl = canvas.toDataURL('image/png');
            const downloadLink = document.createElement('a');
            downloadLink.href = pngUrl;
            downloadLink.download = 'QR_Code_Absensi_{{ $Presence->presence_id }}_{{ $Presence->slug }}.png';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
            URL.revokeObjectURL(svgUrl); // Clean up

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'QR Code berhasil diunduh.',
                showConfirmButton: false,
                timer: 1500
            });
        };
        img.onerror = function() { // Handle image loading errors
            console.error('Failed to load QR code SVG for download.');
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Tidak dapat mengunduh QR Code. Coba lagi.',
                showConfirmButton: false,
                timer: 2000
            });
            URL.revokeObjectURL(svgUrl); // Clean up even on error
        };
        img.src = svgUrl;
    }

    // New function to download the card as an image
    function downloadQrCard() {
        // Tampilkan SweetAlert loading
        Swal.fire({
            title: 'Memproses...',
            text: 'Harap tunggu sebentar, file sedang dibuat.',
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false,
            allowEscapeKey: false
        });

        const cardElement = document.getElementById('qrCard');
        
        // Panggil html2canvas
        html2canvas(cardElement, {
            scale: 2, // Meningkatkan resolusi untuk hasil yang lebih baik
            useCORS: true, // Penting jika ada gambar eksternal (misalnya QR code)
            backgroundColor: '#ffffff'
        }).then(canvas => {
            // Ubah canvas menjadi URL gambar
            const image = canvas.toDataURL('image/png');

            // Buat link download
            const a = document.createElement('a');
            a.href = image;
            a.download = 'Card_Absensi_{{ $Presence->presence_id }}_{{ $Presence->slug }}.png';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            // Tutup SweetAlert dan tampilkan notifikasi sukses
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Card absensi berhasil diunduh.',
                showConfirmButton: false,
                timer: 2000
            });
        }).catch(err => {
            console.error('Error saat membuat card:', err);
            // Tutup SweetAlert dan tampilkan notifikasi error
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat mengunduh card. Coba lagi.',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }
</script>
@endpush

@push('css')
<style>
    /* Overall improvements - consistent with other pages */
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
        font-size: 1.1rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Info Table Styling */
    table.table-detail-info td {
        padding: 8px 0 !important;
        font-size: 14px;
        vertical-align: top;
    }

    table.table-detail-info td.font-weight-bold {
        color: #343a40;
    }

    /* Filter Section Styling */
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    .form-control-sm {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }

    /* Table specific styles */
    table#presences {
        font-size: 13px;
        width: 100% !important;
        table-layout: auto;
        border-collapse: separate;
        border-spacing: 0;
    }

    table#presences th,
    table#presences td {
        padding: 10px 12px !important;
        vertical-align: middle !important;
        white-space: nowrap;
        border: 1px solid #e9ecef;
    }

    table#presences th {
        background-color: #e9ecef;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    table#presences tr:hover {
        background-color: #f2f2f2;
    }

    /* Adjusted options column width */
    table#presences td:last-child,
    table#presences th:last-child {
        width: 120px !important;
        text-align: center;
    }

    /* Tanda Tangan column styling */
    table#presences td:nth-last-child(2),
    table#presences th:nth-last-child(2) {
        width: 100px;
        text-align: center;
    }

    table#presences img {
        max-width: 80px;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    /* DataTables pagination and info styles */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 13px;
        padding: 1rem 0;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.3em 0.6em;
    }

    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }

    /* Alert messages */
    .alert {
        margin-bottom: 1.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem;
    }

    /* Bootstrap 5 gap utility fallback */
    .gap-2 > *:not(:last-child) {
        margin-right: 0.5rem;
    }

/* ============================================
   LANDSCAPE QR CODE MODAL STYLES
============================================ */

.modern-modal {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

/* Modal Dialog Landscape */
.modal-lg {
    max-width: 900px; /* Increased width for landscape */
}

.modern-header {
    background: transparent;
    border: none;
    padding: 0;
    position: relative;
    overflow: hidden;
}

.header-content {
    display: flex;
    align-items: center;
    padding: 1.5rem 2rem; /* Reduced top/bottom padding */
    position: relative;
    z-index: 2;
}

.header-icon {
    width: 50px; /* Slightly smaller */
    height: 50px;
    background: rgba(255,255,255,0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.25rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
}

.header-icon i {
    font-size: 24px;
    color: white;
}

.header-text .modal-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: white;
    margin: 0;
    letter-spacing: -0.5px;
}

.modal-subtitle {
    color: rgba(255,255,255,0.8);
    font-size: 0.85rem;
    margin: 0.25rem 0 0 0;
    font-weight: 400;
}

.modern-close {
    position: absolute;
    top: 1rem;
    right: 1.5rem;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 12px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    transition: all 0.3s ease;
    z-index: 3;
    backdrop-filter: blur(10px);
}

.modern-close:hover {
    background: rgba(255,255,255,0.3);
    transform: rotate(90deg);
    color: white;
}

/* Landscape Body Layout */
.modern-body {
    background: white;
    padding: 2rem;
    border-radius: 0;
}

/* Main Content Grid - Landscape Layout */
.modal-content-grid {
    display: grid;
    grid-template-columns: 1fr 300px; /* Left content, right QR */
    gap: 2.5rem;
    align-items: start;
}

.event-info {
    text-align: left; /* Changed to left align for landscape */
}

.event-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #004488;
    margin-bottom: 1.25rem;
    line-height: 1.3;
}

.event-details {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.95rem;
    color: #4a5568;
    background: #f7fafc;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    justify-content: flex-start;
}

.detail-item i {
    color: #007bff;
    font-size: 1rem;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
}

/* QR Section - Right Side */
.qr-section {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
}

.qr-code-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.qr-code-container {
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border: 3px solid #f0f4f8;
    position: relative;
    z-index: 2;
    overflow: hidden;
}

.qr-code-container svg {
    display: block;
    border-radius: 8px;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
    width: 180px !important; /* Fixed size for consistency */
    height: 180px !important;
}

.scan-instruction {
    color: #4a5568;
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0 0 1.5rem 0;
    text-align: center;
}

/* Action Buttons - Bottom of Left Column */
.action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: auto;
}

.action-buttons .modern-btn:last-child {
    grid-column: 1 / -1; /* Full width for last button */
}

.modern-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    position: relative;
    overflow: hidden;
    color: white !important;
}

.modern-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.modern-btn:hover::before {
    left: 100%;
}

.primary-btn {
    /* Warna biru utama */
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
}

.primary-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.5);
    color: white;
}

.secondary-btn {
    /* Warna biru-hijau yang senada */
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
}

.secondary-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.5);
    color: white;
}

.outline-btn {
    /* Warna biru-kuning yang senada */
    background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
}

.outline-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(255, 193, 7, 0.5);
    color: white;
}

.modern-btn i {
    font-size: 1rem;
    color: white !important;
}

/* ============================================
   LANDSCAPE QR CARD STYLES
============================================ */

.modern-qr-card {
    width: 600px; /* Landscape width */
    background: white;
    border-radius: 0px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    position: relative;
    display: flex;
    flex-direction: column;
}

.card-header-design {
    height: 80px; /* Reduced height for landscape */
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
    border-bottom: 6px solid #FFEB00; /* Tambahkan garis bawah di sini */
}

.gradient-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.header-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0.15;
}

.pattern-circle {
    position: absolute;
    border-radius: 50%;
    background: white;
}

.circle-1 {
    width: 60px;
    height: 60px;
    top: -15px;
    right: -15px;
}

.circle-2 {
    width: 80px;
    height: 80px;
    top: -25px;
    right: 40px;
}

.circle-3 {
    width: 40px;
    height: 40px;
    bottom: -10px;
    left: -10px;
}

.header-content {
    position: relative;
    z-index: 2;
    padding: 1rem 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.event-badge {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
    padding: 0.5rem 1.25rem;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
    letter-spacing: 1px;
}

.event-badge i {
    font-size: 1rem;
}

/* Landscape Card Body Layout */
.card-body-design {
    padding: 1.5rem 2rem;
    flex: 1;
    display: grid;
    grid-template-columns: 1fr 200px; /* Left content, right QR */
    gap: 2rem;
    align-items: start;
}

.card-left-content {
    display: flex;
    flex-direction: column;
    height: 90%;
}

.event-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #004488;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.event-meta {
    margin-bottom: 1rem;
    flex: 1;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.95rem;
    color: #4a5568;
    background: #f7fafc;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    justify-content: flex-start;
    margin-bottom: 1rem; /* Tambahan ini memberikan jarak antar elemen */
}

.meta-item i {
    color: #007bff;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
}

.card-right-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.qr-container {
    text-align: center;
    margin-bottom: 0.75rem;
}

.qr-wrapper {
    display: inline-block;
    padding: 15px;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    position: relative;
    margin-bottom: 0.75rem;
}

.qr-wrapper::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #007bff, #0056b3);
    border-radius: 14px;
    z-index: -1;
}

.qr-wrapper svg {
    display: block;
    border-radius: 6px;
    width: 160px !important;
    height: 160px !important;
}

.scan-text {
    font-size: 0.75rem;
    color: #718096;
    font-weight: 500;
    text-align: center;
    line-height: 1.3;
}

.link-section {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    margin-top: auto;
    grid-column: 1 / -1; /* Full width */
}

.link-label {
    font-size: 0.75rem;
    color: #718096;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.4rem;
}

.link-url {
    font-size: 0.7rem;
    color: #007bff;
    font-weight: 600;
    word-break: break-all;
    line-height: 1.3;
}

.card-footer-design {
    position: relative;
    padding: 0.75rem 2rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    flex-shrink: 0;
}

.footer-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #007bff, #0056b3);
}

.generated-text {
    text-align: center;
    font-size: 0.7rem;
    color: #a0aec0;
    font-weight: 500;
    margin: 0;
}

/* Hidden card positioning */
#qrCard {
    display: block !important;
    position: absolute;
    left: -9999px;
    top: -9999px;
    z-index: -1;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .modal-lg {
        max-width: 100%;
    }
    
    .modal-content-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .qr-section {
        order: -1;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .action-buttons .modern-btn:last-child {
        grid-column: 1;
    }
}

@media (max-width: 768px) {
    .modal-lg {
        max-width: 100%;
    }

    .modern-body {
        padding: 1.5rem;
    }

    .header-content {
        padding: 1rem 1.5rem;
    }

    .event-title {
        font-size: 1.4rem;
    }

    .modern-qr-card {
        width: 100%;
        max-width: 500px;
        height: auto;
    }
    
    .card-body-design {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 1.25rem;
    }
    
    .card-right-content {
        order: -1;
    }
}

@media (max-width: 480px) {
    .modern-qr-card {
        width: 100%;
        max-width: 400px;
    }
    
    .qr-wrapper svg {
        width: 120px !important;
        height: 120px !important;
    }
}
</style>
@endpush