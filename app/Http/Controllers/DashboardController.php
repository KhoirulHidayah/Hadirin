<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard']
        ];
        $activeMenu = 'dashboard';

        // 1. Data untuk Kartu Statistik (KPI Cards)
        $totalPegawai = Pegawai::count();
        $totalKegiatan = Presence::count();
        $kegiatanAktif = Presence::where('status', 'aktif')->count();
        
        // Menghitung rata-rata kehadiran per kegiatan yang sudah selesai
        $kegiatanSelesaiCount = Presence::where('status', 'selesai')->count();
        $totalAbsensi = PresenceDetail::count();
        $rataRataKehadiran = ($kegiatanSelesaiCount > 0) ? number_format($totalAbsensi / $kegiatanSelesaiCount, 0, ',', '.') : 0;


        // 2. Data untuk Grafik Kehadiran (5 kegiatan terakhir)
        $kegiatanChart = Presence::where('status', 'selesai')
            ->withCount('details') // Menghitung jumlah relasi 'details'
            ->orderBy('tgl_kegiatan', 'desc')
            ->limit(5)
            ->get();
        
        // Membalik urutan agar yang terlama di kiri
        $kegiatanChart = $kegiatanChart->reverse();
        
        $chartLabels = $kegiatanChart->pluck('nama_kegiatan');
        $chartData = $kegiatanChart->pluck('details_count');


        // 3. Data untuk Daftar Kegiatan Akan Datang & Sedang Berlangsung
        $kegiatanMendatang = Presence::where('status', 'aktif')
            ->orWhere('tgl_kegiatan', '>', now())
            ->orderBy('tgl_kegiatan', 'asc')
            ->limit(5)
            ->get();

        // 4. Data untuk Log Absensi Terkini
        $logAbsensi = PresenceDetail::with('presence')
            ->latest('waktu_absen')
            ->limit(5)
            ->get();
        
       // 5. Data untuk Kalender
        $allKegiatan = Presence::all();
        $calendarEvents = $allKegiatan->map(function ($kegiatan) {
            return [
                'title' => $kegiatan->nama_kegiatan,
                'start' => Carbon::parse($kegiatan->tgl_kegiatan)->toDateString(),
                'url'   => url('/presence/detail/' . $kegiatan->presence_id), // Link saat acara diklik
                'color' => '#003366', // Warna acara sesuai tema
            ];
        });       
            
        return view('dashboard', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu,
            'totalPegawai' => $totalPegawai,
            'totalKegiatan' => $totalKegiatan,
            'kegiatanAktif' => $kegiatanAktif,
            'rataRataKehadiran' => $rataRataKehadiran,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'kegiatanMendatang' => $kegiatanMendatang,
            'logAbsensi' => $logAbsensi,
            'calendarEvents'    => $calendarEvents,
        ]);
    }
}