@extends('layouts.template')

{{-- Custom CSS untuk tampilan modern dan elegan --}}
@push('css')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<style>
    :root {
        /* Adjusted primary gradient to darker blue, matching sidebar's base */
        --primary-gradient: linear-gradient(135deg, #003366 0%, #002244 100%);
        /* Info gradient similar to primary for cohesion */
        --info-gradient: linear-gradient(135deg, #004488 0%, #003366 100%);
        /* Success, warning, danger can retain some distinctiveness but with a cooler tone */
        --success-gradient: linear-gradient(135deg, #28a745 0%, #218838 100%); /* Green for success */
        --warning-gradient: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); /* Yellow for warning */
        --danger-gradient: linear-gradient(135deg, #dc3545 0%, #c82333 100%);   /* Red for danger */
        --shadow-soft: 0 10px 30px rgba(0, 0, 0, 0.15); /* Slightly darker shadow */
        --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.25); /* Darker hover shadow */
        --border-radius: 20px;
        --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    body {
        /* Darker, blue-toned background for the body */
        background: linear-gradient(135deg, #e0e6ed 0%, #c1cfe0 100%); /* Lighter blue-grey for main background */
        min-height: 100vh;
    }

    /* Modern KPI Cards */
    .stats-card {
        background: rgba(255, 255, 255, 0.98); /* Slightly more opaque white for cards */
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius);
        border: 1px solid rgba(0, 0, 0, 0.05); /* Softer border */
        box-shadow: var(--shadow-soft);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        margin-bottom: 2rem;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        transition: var(--transition);
    }

    .stats-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .stats-card:hover::before {
        height: 100%;
        opacity: 0.05; /* Less opaque on hover */
    }

    .stats-card.info::before { background: var(--info-gradient); }
    .stats-card.success::before { background: var(--success-gradient); }
    .stats-card.warning::before { background: var(--warning-gradient); }
    .stats-card.danger::before { background: var(--danger-gradient); }

    .stats-content {
        padding: 2rem;
        position: relative;
        z-index: 2;
    }

    .stats-number {
        font-size: 3rem;
        font-weight: 800;
        /* Use primary gradient for numbers by default for consistency */
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stats-card.success .stats-number { background: var(--success-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .stats-card.warning .stats-number { background: var(--warning-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .stats-card.danger .stats-number { background: var(--danger-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

    .stats-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #4a5568; /* Slightly darker grey for better contrast */
        margin-bottom: 1rem;
    }

    .stats-icon {
        position: absolute;
        top: 2rem;
        right: 2rem;
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        background: var(--primary-gradient); /* Default to primary gradient */
        transition: var(--transition);
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stats-card.success .stats-icon { background: var(--success-gradient); }
    .stats-card.warning .stats-icon { background: var(--warning-gradient); }
    .stats-card.danger .stats-icon { background: var(--danger-gradient); }
    .stats-card.info .stats-icon { background: var(--info-gradient); } /* Ensure info also uses its gradient */


    .stats-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #64748b;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        padding: 0.5rem 0;
        border-top: 1px solid rgba(0, 0, 0, 0.05); /* Softer border */
        margin-top: 1rem;
    }

    .stats-link:hover {
        color: #003366; /* Darker blue on hover */
        text-decoration: none;
    }

    /* Modern Cards */
    .modern-card {
        background: rgba(255, 255, 255, 0.98); /* Slightly more opaque white for cards */
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius);
        border: 1px solid rgba(0, 0, 0, 0.05); /* Softer border */
        box-shadow: var(--shadow-soft);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .modern-card-header {
        padding: 2rem 2rem 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Softer border */
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.1) 100%);
    }

    .modern-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        background: var(--primary-gradient); /* Use primary gradient for titles */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }

    .modern-card-body {
        padding: 0;
    }

    /* Activity List Styling */
    .activity-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .activity-list::-webkit-scrollbar {
        width: 6px;
    }

    .activity-list::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05); /* Lighter track */
        border-radius: 3px;
    }

    .activity-list::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2); /* Softer thumb */
        border-radius: 3px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Softer border */
        transition: var(--transition);
        position: relative;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item:hover {
        background: linear-gradient(135deg, rgba(0, 51, 102, 0.05) 0%, rgba(0, 34, 68, 0.05) 100%); /* Blue tint on hover */
        transform: translateX(5px);
    }

    .activity-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .activity-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: inherit;
        filter: blur(10px);
        opacity: 0.3;
        z-index: -1;
    }

    .activity-icon.bg-success { background: var(--success-gradient); }
    .activity-icon.bg-primary { background: var(--primary-gradient); }
    .activity-icon.bg-info { background: var(--info-gradient); } /* Ensure info uses its gradient */

    .activity-content {
        flex-grow: 1;
        min-width: 0;
    }

    .activity-title {
        font-weight: 600;
        color: #1a202c; /* Darker text for readability */
        display: block;
        margin-bottom: 0.25rem;
        text-decoration: none;
        font-size: 1rem;
        transition: var(--transition);
    }

    .activity-title:hover {
        color: #003366; /* Darker blue on hover */
        text-decoration: none;
    }

    .activity-subtitle {
        font-size: 0.875rem;
        color: #718096; /* Slightly darker grey for better contrast */
        line-height: 1.4;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #718096;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Chart Container */
    .chart-container {
        padding: 2rem;
        position: relative;
        height: 400px;
    }

    /* Calendar Styling */
    #calendar-container {
        padding: 2rem;
    }
    .fc .fc-button-primary {
        background-image: var(--primary-gradient);
        border: none;
        transition: var(--transition);
        box-shadow: var(--shadow-soft);
    }
    .fc .fc-button-primary:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }
    .fc .fc-daygrid-day.fc-day-today {
        background-color: rgba(0, 51, 102, 0.1);
    }
    .fc-event {
        cursor: pointer;
        border: none !important;
        padding: 5px 8px;
        font-weight: 500;
        transition: var(--transition);
    }
    .fc-event:hover {
        transform: scale(1.05);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .stats-content {
            padding: 1.5rem;
        }

        .stats-number {
            font-size: 2.5rem;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }

        .modern-card-header {
            padding: 1.5rem 1.5rem 1rem;
        }

        .activity-item {
            padding: 1rem 1.5rem;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stats-card, .modern-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .stats-card:nth-child(1) { animation-delay: 0.1s; }
    .stats-card:nth-child(2) { animation-delay: 0.2s; }
    .stats-card:nth-child(3) { animation-delay: 0.3s; }
    .stats-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Total Pegawai --}}
        <div class="col-lg-3 col-md-6 col-12">
            <div class="stats-card info">
                <div class="stats-content">
                    <div class="stats-number">{{ $totalPegawai }}</div>
                    <div class="stats-label">Total Pegawai</div>
                    <a href="{{ url('/pegawai') }}" class="stats-link">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        {{-- Total Kegiatan --}}
        <div class="col-lg-3 col-md-6 col-12">
            <div class="stats-card success">
                <div class="stats-content">
                    <div class="stats-number">{{ $totalKegiatan }}</div>
                    <div class="stats-label">Total Kegiatan</div>
                    <a href="{{ url('/presence') }}" class="stats-link">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>

        {{-- Kegiatan Aktif --}}
        <div class="col-lg-3 col-md-6 col-12">
            <div class="stats-card warning">
                <div class="stats-content">
                    <div class="stats-number">{{ $kegiatanAktif }}</div>
                    <div class="stats-label">Kegiatan Aktif</div>
                    <a href="{{ url('/presence') }}" class="stats-link">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
            </div>
        </div>

        {{-- Rata-rata Kehadiran --}}
        <div class="col-lg-3 col-md-6 col-12">
            <div class="stats-card danger">
                <div class="stats-content">
                    <div class="stats-number">
                        {{ $rataRataKehadiran }} <span style="font-size: 1rem; font-weight: 600;">org</span>
                    </div>
                    <div class="stats-label">Rata-rata Kehadiran</div>
                    <div class="stats-link" style="cursor: default; color: #94a3b8;">
                        <span>Per kegiatan selesai</span>
                        <i class="fas fa-info-circle"></i>
                    </div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- Upcoming Activities --}}
        <div class="col-lg-12">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">
                        <i class="fas fa-calendar-check me-2"></i>
                        Kegiatan Akan Datang & Aktif
                    </h3>
                </div>
                <div class="modern-card-body">
                    <div class="activity-list">
                        @forelse ($kegiatanMendatang as $kegiatan)
                            <div class="activity-item">
                                @if ($kegiatan->status == 'aktif')
                                    <div class="activity-icon bg-success">
                                        <i class="fas fa-broadcast-tower"></i>
                                    </div>
                                @else
                                    <div class="activity-icon bg-primary">
                                        <i class="fas fa-hourglass-half"></i>
                                    </div>
                                @endif
                                <div class="activity-content">
                                    <a href="{{ url('/presence/detail/' . $kegiatan->presence_id) }}" class="activity-title">
                                        {{ $kegiatan->nama_kegiatan }}
                                    </a>
                                    <div class="activity-subtitle">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($kegiatan->tgl_kegiatan)->isoFormat('dddd, D MMM YYYY - HH:mm') }} WIB
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-calendar-times"></i>
                                <p class="mb-0">Tidak ada kegiatan mendatang</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart Section --}}
        <div class="col-lg-7">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">
                        <i class="fas fa-chart-bar me-2"></i>
                        Grafik Kehadiran Peserta
                    </h3>
                </div>
                <div class="modern-card-body">
                    <div class="chart-container">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            {{-- Recent Attendance --}}
            <div class="modern-card">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">
                        <i class="fas fa-history me-2"></i>
                        Absensi Terkini
                    </h3>
                </div>
                <div class="modern-card-body">
                    <div class="activity-list">
                        @forelse ($logAbsensi as $log)
                            <div class="activity-item">
                                <div class="activity-icon bg-info">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $log->nama }}</div>
                                    <div class="activity-subtitle">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Absen di <strong>{{ $log->presence->nama_kegiatan ?? 'N/A' }}</strong>
                                        <br>
                                        <i class="fas fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($log->waktu_absen)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-user-times"></i>
                                <p class="mb-0">Belum ada aktivitas absensi</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Calendar Section --}}
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Kalender Kegiatan
                    </h3>
                </div>
                <div class="modern-card-body">
                    <div id="calendar-container">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Data dari Controller
        const labels = @json($chartLabels);
        const data = @json($chartData);
        const ctx = document.getElementById('attendanceChart').getContext('2d');

        // Modern gradient untuk chart (matching primary-gradient)
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(0, 51, 102, 0.8)'); /* Darker blue */
        gradient.addColorStop(0.5, 'rgba(0, 34, 68, 0.6)');  /* Even darker blue */
        gradient.addColorStop(1, 'rgba(0, 51, 102, 0.1)');

        const borderGradient = ctx.createLinearGradient(0, 0, 0, 400);
        borderGradient.addColorStop(0, '#003366'); /* Darker blue */
        borderGradient.addColorStop(1, '#002244'); /* Even darker blue */

        // Konfigurasi Chart Modern
        const chartConfig = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peserta',
                    backgroundColor: gradient,
                    borderColor: borderGradient,
                    borderWidth: 3,
                    borderRadius: 8,
                    borderSkipped: false,
                    data: data,
                    maxBarThickness: 60,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.95)',
                        titleColor: '#f1f5f9',
                        bodyColor: '#e2e8f0',
                        borderColor: '#003366', /* Match primary blue */
                        borderWidth: 1,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `👥 ${context.parsed.y} peserta hadir`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        border: {
                            display: false
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)', /* Lighter grid lines */
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                weight: 500
                            },
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            },
                        }
                    },
                    x: {
                        border: {
                            display: false
                        },
                        grid: {
                            display: false,
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                weight: 500
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        };

        // Render Chart dengan animasi
        new Chart(ctx, chartConfig);

        // --- Calendar Initialization ---
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id', // Set bahasa ke Indonesia
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                list: 'Daftar'
            },
            events: @json($calendarEvents), // Memuat data dari controller
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // Mencegah browser mengikuti link
                if (info.event.url) {
                    window.location.href = info.event.url; // Buka link di tab yang sama
                }
            },
            eventColor: '#003366' // Menyamakan warna acara dengan tema
        });
        calendar.render();
    });
</script>
@endpush