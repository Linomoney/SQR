<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Ustadz;
use App\Http\Controllers\Wali;
use App\Http\Controllers\Public as PublicCtrl;

// ─── Public Routes ────────────────────────────────────────────
Route::get('/', [PublicCtrl\HomeController::class, 'index'])->name('home');
Route::get('/ppdb', [PublicCtrl\PpdbController::class, 'create'])->name('ppdb.create');
Route::post('/ppdb', [PublicCtrl\PpdbController::class, 'store'])->middleware('throttle:5,1')->name('ppdb.store');
Route::get('/ppdb/sukses', [PublicCtrl\PpdbController::class, 'success'])->name('ppdb.success');
Route::get('/lokasi', [PublicCtrl\HomeController::class, 'lokasi'])->name('lokasi');
Route::get('/kontak', [PublicCtrl\HomeController::class, 'kontak'])->name('kontak');
Route::get('/struktur', [PublicCtrl\HomeController::class, 'struktur'])->name('struktur');
Route::get('/galeri', [PublicCtrl\HomeController::class, 'galeri'])->name('galeri');
Route::get('/kalender', [Admin\ScheduleController::class, 'publicView'])->name('kalender');
Route::get('/berbagi/{slug}', [PublicCtrl\HomeController::class, 'campaignDetail'])->name('berbagi.detail');
Route::get('/artikel', [PublicCtrl\HomeController::class, 'artikel'])->name('artikel');
Route::get('/artikel/{slug}', [PublicCtrl\HomeController::class, 'artikelDetail'])->name('artikel.detail');
Route::get('/api/artikel-list', [PublicCtrl\HomeController::class, 'apiArticles'])->name('api.artikel');

// ─── Auth Routes (Breeze) ─────────────────────────────────────
require __DIR__.'/auth.php';

// ─── Admin Routes ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // PPDB
    Route::resource('ppdb', Admin\PpdbController::class)->except(['create', 'edit']);
    Route::patch('ppdb/{ppdb}/status', [Admin\PpdbController::class, 'updateStatus'])->name('ppdb.status');

    // Santri & Classes
    Route::resource('classes', Admin\SqrClassController::class);
    Route::post('classes/{class}/move-santri', [Admin\SqrClassController::class, 'moveSantri'])->name('classes.move-santri');
    Route::resource('santri', Admin\SantriController::class);

    // Users
    Route::resource('users', Admin\UserController::class);

    // Payments & Verification
    Route::get('payments', [Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}', [Admin\PaymentController::class, 'show'])->name('payments.show');
    Route::get('verifikasi-spp', [Admin\PaymentVerificationController::class, 'index'])->name('verifikasi.index');
    Route::patch('verifikasi-spp/{verification}/approve', [Admin\PaymentVerificationController::class, 'approve'])->name('verifikasi.approve');
    Route::patch('verifikasi-spp/{verification}/reject', [Admin\PaymentVerificationController::class, 'reject'])->name('verifikasi.reject');

    // Attendance
    Route::get('absensi', [Admin\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('absensi/santri', [Admin\AttendanceController::class, 'santri'])->name('attendance.santri');
    Route::get('absensi/ustadz', [Admin\AttendanceController::class, 'ustadz'])->name('attendance.ustadz');

    // Finance
    Route::get('keuangan', [Admin\FinanceController::class, 'index'])->name('finance.index');
    Route::get('keuangan/export', [Admin\FinanceController::class, 'exportExcel'])->name('finance.export');
    Route::post('keuangan/income', [Admin\FinanceController::class, 'storeIncome'])->name('finance.income.store');
    Route::post('keuangan/expense', [Admin\FinanceController::class, 'storeExpense'])->name('finance.expense.store');
    Route::delete('keuangan/income/{income}', [Admin\FinanceController::class, 'destroyIncome'])->name('finance.income.destroy');
    Route::delete('keuangan/expense/{expense}', [Admin\FinanceController::class, 'destroyExpense'])->name('finance.expense.destroy');

    // Content Manager
    Route::get('konten', [Admin\ContentManagerController::class, 'index'])->name('content.index');
    Route::post('konten', [Admin\ContentManagerController::class, 'store'])->name('content.store');
    Route::post('konten/section', [Admin\ContentManagerController::class, 'storeSection'])->name('content.section.store');
    Route::post('konten/faq', [Admin\ContentManagerController::class, 'storeFaq'])->name('content.faq.store');
    Route::delete('konten/faq/{index}', [Admin\ContentManagerController::class, 'destroyFaq'])->name('content.faq.destroy');
    Route::post('konten/donasi-laporan', [Admin\ContentManagerController::class, 'storeLaporanDonasi'])->name('content.donasi.store');
    Route::delete('konten/donasi-laporan/{index}', [Admin\ContentManagerController::class, 'destroyLaporanDonasi'])->name('content.donasi.destroy');

    // Articles
    Route::resource('artikel', Admin\ArticleController::class);

    // Campaigns & Galleries
    Route::get('campaigns/export-donasi', [Admin\CampaignController::class, 'exportDonationsExcel'])->name('campaigns.export-donasi');
    Route::resource('campaigns', Admin\CampaignController::class);
    Route::resource('galleries', Admin\GalleryController::class);

    // Notifications
    Route::get('notifikasi', [Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifikasi', [Admin\NotificationController::class, 'store'])->name('notifications.store');
    Route::patch('notifikasi/read-all', [Admin\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::delete('notifikasi/{notification}', [Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Sertifikat & Penghargaan Santri
    Route::get('sertifikat', [Admin\CertificateController::class, 'index'])->name('certificates.index');
    Route::patch('sertifikat/{santri}/template', [Admin\CertificateController::class, 'updateTemplate'])->name('certificates.template');
    Route::get('sertifikat/{santri}/download', [Admin\CertificateController::class, 'download'])->name('certificates.download');
    Route::get('sertifikat/{santri}/rekomendasi/download', [Admin\CertificateController::class, 'downloadRecommendation'])->name('certificates.recommendation.download');
    Route::get('pengaturan-sertifikat', [Admin\CertificateController::class, 'settings'])->name('certificates.settings');
    Route::put('pengaturan-sertifikat', [Admin\CertificateController::class, 'saveSettings'])->name('certificates.settings.save');
    Route::put('pengaturan-sertifikat/threshold', [Admin\CertificateController::class, 'updateClassThresholds'])->name('certificates.threshold.save');

    // Jadwal & Kalender
    Route::get('jadwal', [Admin\ScheduleController::class, 'index'])->name('jadwal.index');
    Route::post('jadwal', [Admin\ScheduleController::class, 'store'])->name('jadwal.store');
    Route::put('jadwal/{jadwal}', [Admin\ScheduleController::class, 'update'])->name('jadwal.update');
    Route::delete('jadwal/{jadwal}', [Admin\ScheduleController::class, 'destroy'])->name('jadwal.destroy');
    Route::put('jadwal-settings', [Admin\ScheduleController::class, 'saveSettings'])->name('jadwal.settings');

    // Penggajian Ustadz (Admin)
    Route::get('penggajian', [Admin\PayrollController::class, 'index'])->name('payroll.index');
    Route::put('penggajian/settings', [Admin\PayrollController::class, 'updateSettings'])->name('payroll.settings');
    Route::post('penggajian/bonus', [Admin\PayrollController::class, 'storeBonus'])->name('payroll.bonus');
    Route::get('penggajian/export', [Admin\PayrollController::class, 'exportExcel'])->name('payroll.export');

    // Manajemen Lokasi Cabang SQR (Admin)
    Route::get('lokasi', [Admin\LocationController::class, 'index'])->name('locations.index');
    Route::post('lokasi', [Admin\LocationController::class, 'store'])->name('locations.store');
    Route::put('lokasi/{location}', [Admin\LocationController::class, 'update'])->name('locations.update');
    Route::post('lokasi/assign-ustadz', [Admin\LocationController::class, 'assignUstadz'])->name('locations.assignUstadz');
    Route::delete('lokasi/{location}', [Admin\LocationController::class, 'destroy'])->name('locations.destroy');

    // Mode Maintenance (Admin Only)
    Route::post('maintenance/toggle', [Admin\MaintenanceController::class, 'toggle'])->name('maintenance.toggle');
    Route::get('maintenance/status', [Admin\MaintenanceController::class, 'status'])->name('maintenance.status');
});

// ─── Public API: Jadwal Events (for calendar JS) ────────────
Route::get('/api/jadwal/{year}/{month}', [Admin\ScheduleController::class, 'apiEvents'])->name('api.jadwal');

// ─── Ustadz & Ustadzah Routes ─────────────────────────────────
foreach (['ustadz', 'ustadzah'] as $prefix) {
    Route::prefix($prefix)->name("{$prefix}.")->middleware(['auth', 'role:ustadz'])->group(function () {

        // Profile & Biodata Settings (Accessible anytime for Ustadz/Ustadzah)
        Route::get('/profile', [Ustadz\ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [Ustadz\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [Ustadz\ProfileController::class, 'updatePassword'])->name('profile.password');

        // Notifikasi Ustadz/Ustadzah
        Route::get('/notifikasi', [Ustadz\NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('/notifikasi/{notification}/read', [Ustadz\NotificationController::class, 'markRead'])->name('notifications.read');
        Route::patch('/notifikasi/read-all', [Ustadz\NotificationController::class, 'markAllRead'])->name('notifications.readAll');

        // Protected Routes (Wajib Lengkapi Biodata jika deadline 3 hari lewat)
        Route::middleware(['profile.completed'])->group(function () {
            Route::get('/dashboard', [Ustadz\DashboardController::class, 'index'])->name('dashboard');

            // Progress Hafalan
            Route::get('/progress', [Ustadz\ProgressController::class, 'index'])->name('progress.index');
            Route::get('/progress/create/{santri}', [Ustadz\ProgressController::class, 'create'])->name('progress.create');
            Route::post('/progress', [Ustadz\ProgressController::class, 'store'])->name('progress.store');
            Route::delete('/progress/{progress}', [Ustadz\ProgressController::class, 'destroy'])->name('progress.destroy');
            Route::get('/santri/{class}', [Ustadz\ProgressController::class, 'santriByClass'])->name('santri.byClass');

            // Kalender Akademik (Read Only)
            Route::get('/kalender', [Admin\ScheduleController::class, 'publicView'])->name('kalender');

            // Gaji & Slip Gaji Ustadz
            Route::get('/gaji', [Ustadz\PayrollController::class, 'index'])->name('payroll.index');
            Route::get('/gaji/download', [Ustadz\PayrollController::class, 'downloadPdf'])->name('payroll.download');

            // Absensi
            Route::get('/absensi', [Ustadz\AttendanceController::class, 'index'])->name('attendance.index');
            Route::get('/absensi/export', [Ustadz\AttendanceController::class, 'exportExcel'])->name('attendance.export');
            Route::post('/absensi/diri', [Ustadz\AttendanceController::class, 'storeSelf'])->middleware('throttle:10,1')->name('attendance.self');
            Route::post('/absensi/santri', [Ustadz\AttendanceController::class, 'storeSantri'])->name('attendance.santri');
            Route::get('/absensi/kelas/{class}', [Ustadz\AttendanceController::class, 'santriList'])->name('attendance.santriList');
            Route::get('/absensi/kelas/{class}/date/{date}', [Ustadz\AttendanceController::class, 'santriListByDate'])->name('attendance.santriListByDate');
        });
    });
}

// ─── Wali Routes ──────────────────────────────────────────────
Route::prefix('wali')->name('wali.')->middleware(['auth', 'role:wali'])->group(function () {

    // Profile & Biodata KK/KTP Wali & Santri (Accessible anytime for Wali)
    Route::get('/profile', [Wali\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [Wali\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [Wali\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Pembayaran SPP (Always accessible so Wali can pay & upload proof when locked)
    Route::get('/pembayaran', [Wali\PaymentController::class, 'index'])->name('payments.index');
    Route::post('/pembayaran/upload', [Wali\PaymentController::class, 'uploadProof'])->middleware('throttle:10,1')->name('payments.upload');

    // Protected Routes (Wajib Lengkapi Biodata 3 hari & Lunas SPP Terutang >= 1 Bulan)
    Route::middleware(['profile.completed', 'spp.unlocked'])->group(function () {
        Route::get('/dashboard', [Wali\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/santri/{santri}/progress', [Wali\DashboardController::class, 'progress'])->name('santri.progress');
        Route::get('/kalender', [Admin\ScheduleController::class, 'publicView'])->name('kalender');

        // Presensi Santri Portal Wali
        Route::get('/absensi', [Wali\AttendanceController::class, 'index'])->name('attendance.index');

        // Gamifikasi – Sertifikat
        Route::get('/sertifikat/{santri}', [Wali\CertificateController::class, 'show'])->name('certificate.show');
        Route::get('/sertifikat/{santri}/download', [Wali\CertificateController::class, 'download'])->name('certificate.download');

        // Gamifikasi – Surat Rekomendasi
        Route::get('/rekomendasi/{santri}', [Wali\RecommendationController::class, 'show'])->name('recommendation.show');
        Route::get('/rekomendasi/{santri}/download', [Wali\RecommendationController::class, 'download'])->name('recommendation.download');

        // Notifikasi Wali
        Route::get('/notifikasi', [Wali\DashboardController::class, 'notifications'])->name('notifications');
        Route::patch('/notifikasi/{notification}/read', [Wali\DashboardController::class, 'markRead'])->name('notifications.read');
    });
});

// ─── Redirect setelah login berdasarkan role ──────────────────
Route::get('/redirect', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('ustadz')) {
        $prefix = $user->teacher_route_prefix;
        return redirect()->route("{$prefix}.dashboard");
    } elseif ($user->hasRole('wali')) {
        return redirect()->route('wali.dashboard');
    }
    return redirect()->route('home');
})->middleware('auth')->name('redirect');
