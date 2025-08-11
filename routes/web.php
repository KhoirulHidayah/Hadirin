<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\{
    DashboardController,
    PresenceController,
    LogoFormulirController,
    PresenceDetailController,
    PegawaiController,
    SlideController,
    AuthController,
    ProfileController, 
    UserController,
    KategoriController,
    AsalInstansiController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua rute aplikasi didefinisikan di sini.
|--------------------------------------------------------------------------
*/

// ========== AUTH ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ========== UPDATE PSSWORD DAN PROFIL ==========
Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

// ========== DASHBOARD ==========
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

// ========== PRESENCE ==========
Route::prefix('presence')->middleware('auth')->group(function () {
    Route::get('/', [PresenceController::class, 'index']);
    Route::post('/list', [PresenceController::class, 'list']);
    Route::get('/create', [PresenceController::class, 'create']);
    Route::post('/', [PresenceController::class, 'store']);
    Route::get('/detail/{presence_id}', [PresenceController::class, 'show']);
    Route::get('/{presence_id}/edit', [PresenceController::class, 'edit']);
    Route::put('/{presence_id}', [PresenceController::class, 'update']);
    Route::delete('/{presence_id}', [PresenceController::class, 'destroy']);
    Route::get('/export/pdf', [PresenceController::class, 'export_pdf'])->name('presence.export.pdf');
});

// ========== PRESENCE DETAILS ==========
Route::prefix('presence_details')->middleware('auth')->group(function () {
    Route::post('/list', [PresenceDetailController::class, 'list'])->name('presence_details.list');
    Route::post('/store', [PresenceDetailController::class, 'store'])->name('presence_details.store');
    Route::get('/{id}', [PresenceDetailController::class, 'show'])->name('presence.show');
    Route::get('/export/pdf/{id}', [PresenceDetailController::class, 'export_pdf'])->name('presence_details.export.pdf');
    Route::get('/export/excel/{id}', [PresenceDetailController::class, 'export_excel'])->name('presence_details.export.excel');
    Route::delete('/{id}', [PresenceDetailController::class, 'destroy'])->name('presence_details.destroy');
    Route::get('/export/word/{id}', [PresenceDetailController::class, 'exportWord'])->name('presence_details.export.word');

});

// ========== PEGAWAI ==========
Route::prefix('pegawai')->middleware('auth')->group(function () {
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
    Route::get('/by-kategori/{kategori}', [PresenceDetailController::class, 'getPegawaiByKategori']);
});

// ========== SLIDE ==========
Route::prefix('slide')->middleware('auth')->group(function () {
    Route::get('/', [SlideController::class, 'index'])->name('slide.index');
    Route::post('/', [SlideController::class, 'store'])->name('slide.store');
    Route::delete('/{id}', [SlideController::class, 'destroy'])->name('slide.destroy');
    Route::put('/instagrams/update', [SlideController::class, 'updateInstagrams'])->name('instagrams.update');
    Route::post('/instagrams/update-gallery-visibility', [SlideController::class, 'updateGalleryVisibility'])->name('instagrams.update-gallery-visibility');
    Route::post('/instagrams/update-aspect-ratio', [SlideController::class, 'updateAspectRatio'])->name('instagrams.update-aspect-ratio');
});

// ========== LOGO FORMULIR ==========
Route::prefix('logo_formulir')->middleware('auth')->group(function () {
    Route::get('/', [LogoFormulirController::class, 'edit'])->name('logo_formulir.edit');
    Route::put('/update', [LogoFormulirController::class, 'update'])->name('logo_formulir.update');
    Route::delete('/logo-left', [LogoFormulirController::class, 'destroyLeft'])->name('logo_formulir.delete_left');
    Route::delete('/logo-right', [LogoFormulirController::class, 'destroyRight'])->name('logo_formulir.delete_right');
});

// ========== USER ==========
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

// ========== KATEGORI ==========
Route::prefix('kategori')->middleware('auth')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/list', [KategoriController::class, 'list'])->name('kategori.list');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

// ========== ASAL INSTANSI ==========
Route::prefix('asal_instansi')->middleware('auth')->group(function () {
    Route::get('/', [AsalInstansiController::class, 'index'])->name('asal_instansi.index');
    Route::post('/list', [AsalInstansiController::class, 'list'])->name('asal_instansi.list');
    Route::get('/create', [AsalInstansiController::class, 'create'])->name('asal_instansi.create');
    Route::post('/', [AsalInstansiController::class, 'store'])->name('asal_instansi.store');
    Route::get('/{asalInstansi}/edit', [AsalInstansiController::class, 'edit'])->name('asal_instansi.edit');
    Route::put('/{asalInstansi}', [AsalInstansiController::class, 'update'])->name('asal_instansi.update');
    Route::delete('/{asalInstansi}', [AsalInstansiController::class, 'destroy'])->name('asal_instansi.destroy');
});
// ========== PUBLIK ==========
Route::get('absen/{presence_id}/{slug}', [PresenceController::class, 'absenBySlug'])->name('absen.index');

