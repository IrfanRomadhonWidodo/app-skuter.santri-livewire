<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\DashboardController;
use App\Livewire\Admin\KelolaUser;
use App\Livewire\Admin\PembayaranTagihan;
use App\Livewire\Admin\KelolaSPP;
use App\Livewire\Admin\TagihanSPP;
use App\Livewire\Admin\StatusMahasiswa;
use App\Livewire\Users\TagihanUser;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Route CRUD User (hanya admin)
    Route::get('/admin/users', KelolaUser::class)
        ->name('admin.users')
        ->middleware('can:isAdmin'); 

    // Route Pembayaran Tagihan
    Route::get('/admin/transaksi/pembayaran-tagihan', PembayaranTagihan::class)
        ->name('admin.transaksi.pembayaran-tagihan')
        ->middleware('can:isAdmin'); 

    // Route Kelola SPP
    Route::get('/admin/administrasi/kelola-spp', KelolaSPP::class)
        ->name('admin.administrasi.kelola-spp')
        ->middleware('can:isAdmin');

    // Route Tagihan SPP
    Route::get('/admin/transaksi/tagihan-spp', TagihanSPP::class)
        ->name('admin.transaksi.tagihan-spp')
        ->middleware('can:isAdmin');

        // Route Status Mahasiswa
    Route::get('/admin/administrasi/status-mahasiswa', StatusMahasiswa::class)
        ->name('admin.administrasi.status-mahasiswa')
        ->middleware('can:isAdmin');

    // Routing untuk mahasiswa (user)
    Route::get('/users/tagihan-user', TagihanUser::class)
        ->name('users.tagihan-user')
        ->middleware('can:isMahasiswa'); 
});

require __DIR__.'/auth.php';
