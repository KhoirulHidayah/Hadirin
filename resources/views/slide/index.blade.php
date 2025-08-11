@extends('layouts.template') {{-- Make sure this matches your actual admin layout --}}

@section('content')
<div class="card shadow-lg mb-4"> {{-- Consistent card styling with larger shadow and margin-bottom --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white">
            <i class="fas fa-images mr-2"></i> Kelola Slide Gambar
        </h6>
    </div>

    <div class="card-body">

        {{-- Section: Information and Notifications --}}
        <div class="mb-4">
            <div class="alert alert-info d-flex align-items-center position-relative fade show" role="alert">
                <i class="fas fa-info-circle me-2 fa-lg"></i>
                <div>
                    Format gambar yang diperbolehkan: <strong>JPG, JPEG, PNG, WEBP</strong>. Maksimal ukuran file: <strong>2MB</strong>.
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-dismiss="alert" aria-label="Close"></button>
            </div>

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center position-relative fade show" role="alert">
                    <i class="fas fa-check-circle me-2 fa-lg"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-start position-relative fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2 fa-lg mt-1"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        {{-- Form: Gallery Visibility Toggle (Moved to separate form for AJAX) --}}
        <h6 class="text-primary mb-3"><i class="fas fa-eye mr-2"></i> Pengaturan Tampilan Galeri</h6>
        <div class="mb-5 p-3 border rounded bg-light">
            <form id="form-toggle-gallery">
                @csrf
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="ps-3"> {{-- Tambahkan padding agar lebih dalam --}}
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_gallery_toggle"
                                    {{ old('show_gallery', $instagrams->show_gallery ?? 1) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="show_gallery_toggle">
                                    Tampilkan Galeri Slide di Halaman Publik
                                </label>
                                <div class="form-text">
                                    Centang untuk menampilkan galeri slide pada halaman publik, hapus centang untuk menyembunyikan.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status indicator for gallery visibility --}}
                <div id="gallery-status-indicator" class="mt-3 ps-3">
                    @if($instagrams && $instagrams->show_gallery)
                        <span class="badge bg-success fs-6 p-2">
                            Galeri sedang ditampilkan
                        </span>
                    @else
                        <span class="badge bg-warning text-dark fs-6 p-2">
                            Galeri sedang disembunyikan
                        </span>
                    @endif
                </div>
            </form>
        </div>

        <h6 class="text-primary mb-3"><i class="fas fa-cogs mr-2"></i> Pengaturan Umum</h6>
        {{-- Form: Update Logo & Instagram Username --}}
        <form action="{{ route('instagrams.update') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-3 border rounded bg-light">
            @csrf
            @method('PUT')
            <div class="row">
                {{-- Kolom untuk Upload Logo Baru, mengambil 12 kolom pada layar kecil dan 6 kolom pada layar medium --}}
                <div class="col-md-6 mb-3">
                    <label for="logo" class="form-label font-weight-bold">Upload Logo Baru</label>
                    <input type="file" name="logo" id="logo" class="form-control form-control-sm" accept=".jpg,.jpeg,.png,.webp">
                    @if($instagrams && $instagrams->logo)
                        <div class="mt-2 text-muted small">Logo Saat Ini:</div>
                        <img src="{{ asset('storage/' . $instagrams->logo) }}" alt="Logo Sekarang" class="mt-1 border p-1 rounded" style="max-height: 80px; width: auto; object-fit: contain;">
                    @else
                        <div class="mt-2 text-muted small">Belum ada logo terupload.</div>
                    @endif
                    @error('logo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                {{-- Kolom untuk Username Instagram, sejajar dengan Website URL --}}
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="instagram_username" class="form-label font-weight-bold">Username Instagram</label>
                            <input type="text" name="instagram_username" id="instagram_username" class="form-control form-control-sm"
                                value="{{ old('instagram_username', $instagrams->instagram_username ?? '') }}" placeholder="username_anda">
                            @error('instagram_username') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        {{-- Kolom untuk Website URL, sejajar dengan Username Instagram --}}
                        <div class="col-12 mb-3">
                            <label for="website_url" class="form-label font-weight-bold">Website URL</label>
                            <input type="url" name="website_url" id="website_url" class="form-control form-control-sm"
                                value="{{ old('website_url', $instagrams->website_url ?? '') }}" placeholder="contoh: https://www.pln.co.id">
                            @error('website_url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm mt-3"><i class="fas fa-save mr-1"></i> Update Pengaturan</button>
        </form>

        <h6 class="text-primary mb-3"><i class="fas fa-plus-circle mr-2"></i> Tambah Gambar Slide Baru</h6>
        {{-- Form: Upload New Slide Image --}}
        <form action="{{ route('slide.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-3 border rounded bg-light">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label font-weight-bold">Pilih Gambar untuk Diupload</label>
                <input type="file" name="image" id="image" class="form-control form-control-sm @error('image') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp" required>
                @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-sm mt-3"><i class="fas fa-upload mr-1"></i> Upload Gambar</button>
        </form>

        <h6 class="text-primary mb-3"><i class="fas fa-th-list mr-2"></i> Daftar Gambar Slide</h6>

        {{-- List of Images --}}
        <div class="row">
            @forelse($slides as $slide)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4"> {{-- Responsive columns --}}
                <div class="card h-100 shadow-sm border"> {{-- Enhanced card for each image --}}
                    <img src="{{ asset('storage/slides/' . $slide->filename) }}" class="card-img-top" alt="Slide Image" style="height:200px; object-fit:cover;">
                    <div class="card-body d-flex flex-column justify-content-between p-3">
                        <small class="text-muted mb-2 text-truncate" title="{{ $slide->filename }}">
                            <i class="fas fa-file-image mr-1"></i> {{ $slide->filename }}
                        </small>
                        <form action="{{ route('slide.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100 mt-2">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-secondary text-center py-4">
                    <i class="fas fa-info-circle mr-2"></i> Belum ada gambar slide yang ditambahkan.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

{{-- Pindahkan ig-info ke dalam card-body setelah konten utama --}}
@push('css')
<style>
    /* Global styles for consistency (from previous responses) */
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
        font-size: 1rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }

    /* Alerts styling */
    .alert {
        border-radius: 0.5rem;
        font-size: 0.9rem;
        padding: 1rem 1.5rem;
    }
    .alert .fa-lg {
        font-size: 1.25rem; /* Larger icon for alerts */
    }
    .alert ul {
        margin-bottom: 0;
        padding-left: 20px;
    }
    .alert li {
        margin-bottom: 5px;
    }
    .alert-success .fas,
    .alert-info .fas {
        color: inherit; /* Inherit color from alert */
    }
    .alert-danger .fas {
        color: inherit;
    }

    /* Form specific styles */
    .form-label {
        font-size: 0.9rem;
        color: #343a40;
    }
    .form-control-sm {
        height: calc(1.5em + 0.75rem + 2px); /* Adjusted height */
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }

    /* Button styling */
    .btn-sm {
        padding: 0.3rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }

    /* Image grid card styling */
    .card.h-100 {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border-color: #e9ecef; /* Lighter border for image cards */
    }
    .card.h-100:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.15) !important;
    }
    .card-img-top {
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
    }
    .card-body.d-flex {
        padding-top: 0.75rem; /* Adjust padding for better look with image */
    }
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%; /* Ensure truncation works */
    }

    /* Toggle switch styling */
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.25em;
    }

    /* Badge styling */
    .badge.fs-6 {
        font-size: 0.875rem !important;
    }

    .ig-info {
        display: flex;
        align-items: center;
        gap: 20px; /* Jarak antara ig-info dan website */
        margin-top: 15px; /* Sesuaikan margin atas jika perlu */
    }

    .ig-info .logo-wrapper {
        display: inline-block;
    }

    .ig-info img {
        height: 30px;
        width: auto;
    }

    .ig-info .instagram-link, .ig-info .website-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #000;
        font-weight: 500;
        font-size: 1rem;
    }

    .ig-info .instagram-link img, .ig-info .website-link img {
        height: 20px;
        width: 20px;
        margin-right: 8px;
    }
</style>
@endpush

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showGalleryToggle = document.getElementById('show_gallery_toggle');
        const galleryStatusIndicator = document.getElementById('gallery-status-indicator');

        if (showGalleryToggle) {
            showGalleryToggle.addEventListener('change', function () {
                const isChecked = this.checked;
                const value = isChecked ? 1 : 0;

                // Send AJAX request
                fetch('{{ route('instagrams.update-gallery-visibility') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ show_gallery: value })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the status indicator immediately
                        if (isChecked) {
                            galleryStatusIndicator.innerHTML = `
                                <span class="badge bg-success fs-6 p-2">
                                    <i class="fas fa-eye mr-1"></i> Galeri sedang ditampilkan
                                </span>
                            `;
                        } else {
                            galleryStatusIndicator.innerHTML = `
                                <span class="badge bg-warning text-dark fs-6 p-2">
                                    <i class="fas fa-eye-slash mr-1"></i> Galeri sedang disembunyikan
                                </span>
                            `;
                        }
                        // Optionally show a temporary success alert
                        showTemporaryAlert('success', data.message);
                    } else {
                        // Revert toggle if update fails and show error
                        this.checked = !isChecked; // Revert
                        showTemporaryAlert('danger', data.message || 'Gagal memperbarui pengaturan galeri.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Revert toggle on network error
                    this.checked = !isChecked;
                    showTemporaryAlert('danger', 'Terjadi kesalahan jaringan atau server.');
                });
            });
        }

        function showTemporaryAlert(type, message) {
            const alertContainer = document.querySelector('.card-body .mb-4'); // Assuming this is the main alert container

            // Remove existing temporary alerts to avoid stacking
            const existingAlerts = alertContainer.querySelectorAll('.temp-alert');
            existingAlerts.forEach(alert => alert.remove());

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} d-flex align-items-center position-relative fade show temp-alert mt-3`;
            alertDiv.setAttribute('role', 'alert');

            const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';

            alertDiv.innerHTML = `
                <i class="${iconClass} me-2 fa-lg"></i>
                <div>${message}</div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-dismiss="alert" aria-label="Close"></button>
            `;

            // Insert after the existing info alert, or at the beginning of the container
            const infoAlert = alertContainer.querySelector('.alert-info');
            if (infoAlert) {
                infoAlert.after(alertDiv);
            } else {
                alertContainer.prepend(alertDiv);
            }


            // Automatically close the alert after 5 seconds
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertDiv); // Use Bootstrap's JS for proper closing animation
                bsAlert.close();
            }, 5000);
        }
    });
</script>
@endpush