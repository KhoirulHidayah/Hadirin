<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\PresenceDetailController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Admin
Route::get('/', [DashboardController::class, 'index']);

Route::prefix('presence')->group(function () {
    Route::get('/', [PresenceController::class, 'index']);
    Route::post('/list', [PresenceController::class, 'list']);
    Route::get('/create', [PresenceController::class, 'create']);
    Route::post('/', [PresenceController::class, 'store']);             
    Route::get('/detail/{presence_id}', [PresenceController::class, 'show']);
    Route::get('/{presence_id}/edit', [PresenceController::class, 'edit']);    
    Route::put('/{presence_id}', [PresenceController::class, 'update']);      
    Route::delete('/{presence_id}', [PresenceController::class, 'destroy']);
});

Route::prefix('presence_details')->group(function () {
    // Digunakan oleh DataTables untuk mengambil data peserta
    Route::post('/list', [PresenceDetailController::class, 'list'])->name('presence_details.list');
    Route::post('/store', [PresenceDetailController::class, 'store'])->name('presence_details.store');
    Route::get('/{id}', [PresenceDetailController::class, 'show'])->name('presence.show');
    Route::get('/export/pdf/{id}', [PresenceDetailController::class, 'export_pdf'])->name('presence_details.export.pdf');
    Route::delete('/{id}', [PresenceDetailController::class, 'destroy'])->name('presence_details.destroy');
    Route::get('/export/excel/{id}', [PresenceDetailController::class, 'export_excel'])->name('presence_details.export.excel');
});

Route::prefix('pegawai')->group(function () {
    Route::get('/', [PegawaiController::class, 'index']);
    Route::post('/list', [PegawaiController::class, 'list']);
    Route::get('/create', [PegawaiController::class, 'create']);
    Route::post('/', [PegawaiController::class, 'store']);             
    Route::get('/detail/{id}', [PegawaiController::class, 'show']);
    Route::get('/{id}/edit', [PegawaiController::class, 'edit']);    
    Route::put('/{id}', [PegawaiController::class, 'update']);      
    Route::delete('/{id}', [PegawaiController::class, 'destroy']);
    Route::post('/import', [PegawaiController::class, 'import']);
    Route::get('/template/download', [PegawaiController::class, 'downloadTemplate'])->name('pegawai.template');
});


//Publik
Route::get('absen/{slug}', [AbsenController::class, 'index'])->name('absen.index');