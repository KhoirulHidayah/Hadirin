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
    UserController
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
    Route::get('/search', [PegawaiController::class, 'search']);
});

// ========== SLIDE ==========
Route::prefix('slide')->middleware('auth')->group(function () {
    Route::get('/', [SlideController::class, 'index'])->name('slide.index');
    Route::post('/', [SlideController::class, 'store'])->name('slide.store');
    Route::delete('/{id}', [SlideController::class, 'destroy'])->name('slide.destroy');
    Route::put('/instagrams/update', [SlideController::class, 'updateInstagrams'])->name('instagrams.update');
});

// ========== LOGO FORMULIR ==========
Route::prefix('logo_formulir')->middleware('auth')->group(function () {
    Route::get('/', [LogoFormulirController::class, 'edit'])->name('logo_formulir.edit');
    Route::put('/update', [LogoFormulirController::class, 'update'])->name('logo_formulir.update');
    Route::delete('/delete/{posisi}', [LogoFormulirController::class, 'deleteLogo'])->name('logo_formulir.deleteLogo');
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

// ========== PUBLIK ==========
Route::get('absen/{slug}', [PresenceController::class, 'absenBySlug'])->name('absen.index');
