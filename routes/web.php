<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\Users\Inlistusers;
use App\Livewire\Master\PL\Index as PL;
use App\Livewire\Master\Cpl\Index as Cpl;
use App\Livewire\Master\Bk\Index as BK;
use App\Livewire\Master\Cpmk\Index as Cpmk;
use App\Livewire\Master\SubCpmk\Index as SubCpmk;
use App\Livewire\Master\Matakuliah\Index as Matkul;
use App\Livewire\Master\Dosen\Index as Dosen;
use App\Livewire\Master\ProgramStudi\Index as ProgramStudi;
use App\Livewire\Kurikulum\Index as Kurikulum;


Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::view('master', 'pages.datamaster.profile-lulusan.list')->name('master.index');
    Route::get('user', Inlistusers::class)->name('user.index');
    // Route::view('users', 'pages.users.list')->name('user.index');

    Route::prefix('master')
        ->name('master.')
        ->group(function () {

            Route::get('profile-lulusan', PL::class)->name('pl.index');
            Route::get('cpl', Cpl::class)->name('cpl.index');
            Route::get('bk', BK::class)->name('bk.index');
            Route::get('cpmk', Cpmk::class)->name('cpmk.index');
            Route::get('subcpmk', SubCpmk::class)->name('subcpmk.index');
            Route::get('matakuliah', Matkul::class)->name('matkul.index');
            Route::get('dosen', Dosen::class)->name('dosen.index');
            Route::get('program-studi', ProgramStudi::class)->name('program-studi.index');

        });
    Volt::route('kurikulum', Kurikulum::class)->name('kurikulum.index');
    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
