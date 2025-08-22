<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\DashboardController;
use App\Livewire\Admin\KelolaUser;

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
        // middleware opsional, nanti bisa bikin Gate/Policy untuk admin
});

require __DIR__.'/auth.php';
