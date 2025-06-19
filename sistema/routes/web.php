<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MensalidadeController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('socios', SocioController::class);
  

    Route::get('/mensalidades', [MensalidadeController::class, 'index'])->name('mensalidades.index');
    Route::get('/mensalidades/create', [MensalidadeController::class, 'create'])->name('mensalidades.create');
    Route::post('/mensalidades', [MensalidadeController::class, 'store'])->name('mensalidades.store');
    Route::get('/mensalidades/{mensalidade}/edit', [MensalidadeController::class, 'edit'])->name('mensalidades.edit');
    Route::put('/mensalidades/{mensalidade}', [MensalidadeController::class, 'update'])->name('mensalidades.update');
    Route::delete('/mensalidades/{mensalidade}', [MensalidadeController::class, 'destroy'])->name('mensalidades.destroy');
    Route::get('/mensalidades/inadimplentes', [MensalidadeController::class, 'inadimplentes'])->name('mensalidades.inadimplentes');
    Route::patch('/mensalidades/{mensalidade}/marcar-pago', [MensalidadeController::class, 'marcarPago'])->name('mensalidades.marcar-pago');
    Route::post('/mensalidades/gerar-mes', [MensalidadeController::class, 'gerarMensalidadesMes'])->name('mensalidades.gerar-mes');


    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
