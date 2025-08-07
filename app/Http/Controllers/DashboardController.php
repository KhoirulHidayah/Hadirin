<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Presence;
use App\Models\Kategori;
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

        // 1. Data for KPI Cards
        $totalPegawai = Pegawai::count();
        $totalKegiatan = Presence::count();
        
        $totalKategori = Kategori::count();

        // Calculate average attendance percentage (0-100)
        // Calculated from activities with 'selesai' status
        $kegiatanSelesai = Presence::where('status', 'selesai')->withCount('details')->get();
        $kegiatanSelesaiCount = $kegiatanSelesai->count();
        
        $rataRataKehadiran = 0; // Default value

        if ($kegiatanSelesaiCount > 0 && $totalPegawai > 0) {
            $totalHadir = $kegiatanSelesai->sum('details_count');
            $totalPotensial = $kegiatanSelesaiCount * $totalPegawai;
            $rataRataKehadiran = ($totalHadir / $totalPotensial) * 100;
        }
        
        // 2. Data for Attendance Chart (last 5 completed activities)
        $kegiatanChart = Presence::where('status', 'selesai')
            ->withCount('details')
            ->orderBy('tgl_kegiatan', 'desc')
            ->limit(5)
            ->get();
        
        $kegiatanChart = $kegiatanChart->reverse(); // Reverse for chronological order on chart
        
        $chartLabels = $kegiatanChart->pluck('nama_kegiatan');
        $chartData = $kegiatanChart->pluck('details_count');

        // 3. Data for Upcoming & Ongoing Activities List
        // --- LOGIKA BARU UNTUK KEGIATAN MENDATANG/BERLANGSUNG ---
        // Ambil 5 kegiatan yang tgl_kegiatan-nya >= waktu_sekarang (termasuk hari ini)
        // DAN statusnya bukan 'selesai'. Ini akan mencakup kegiatan mendatang dan yang masih 'aktif'
        $kegiatanMendatang = Presence::where('tgl_kegiatan', '>=', Carbon::now()->startOfDay()) 
                                    ->where('status', '!=', 'selesai')
                                    ->orderBy('tgl_kegiatan', 'asc')
                                    ->limit(5)
                                    ->get();
        // --- AKHIR LOGIKA BARU ---

        // 4. Data for Recent Attendance Logs
        $logAbsensi = PresenceDetail::with('presence')
            ->latest('waktu_absen')
            ->limit(5)
            ->get();
        
        // 5. Data for Calendar
        $allKegiatan = Presence::all();
        $calendarEvents = $allKegiatan->map(function ($kegiatan) {
            return [
                'title' => $kegiatan->nama_kegiatan,
                'start' => Carbon::parse($kegiatan->tgl_kegiatan)->toDateString(),
                'url'   => url('/presence/detail/' . $kegiatan->presence_id),
                'color' => '#003366',
            ];
        });         
            
        $response = response()->view('dashboard', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu,
            'totalPegawai' => $totalPegawai,
            'totalKegiatan' => $totalKegiatan,
            'totalKategori' => $totalKategori, 
            'rataRataKehadiran' => $rataRataKehadiran,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'kegiatanMendatang' => $kegiatanMendatang, 
            'logAbsensi' => $logAbsensi,
            'calendarEvents'    => $calendarEvents,
        ]);

        // Add cache control headers to prevent browser caching
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }
}