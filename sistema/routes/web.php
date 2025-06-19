<?php

use App\Http\Controllers\CarteirinhaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MensalidadeController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [HomeController::class, 'index'])->name('home');



Route::get('/dashboard', [DashboardController::class, 'index'])
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


    Route::get('/admin/eventos', [EventoController::class, 'index'])->name('admin.eventos.index');
    Route::get('/admin/eventos/create', [EventoController::class, 'create'])->name('admin.eventos.create');
    Route::post('/admin/eventos', [EventoController::class, 'store'])->name('admin.eventos.store');
    Route::get('/admin/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('admin.eventos.edit');
    Route::put('/admin/eventos/{evento}', [EventoController::class, 'update'])->name('admin.eventos.update');
    Route::delete('/admin/eventos/{evento}', [EventoController::class, 'destroy'])->name('admin.eventos.destroy');

    Route::get('/carteirinha/{socio}', [CarteirinhaController::class, 'show'])->name('carteirinha.show');
    Route::get('/carteirinha/{socio}/pdf', [CarteirinhaController::class, 'downloadPdf'])->name('carteirinha.pdf');
    Route::get('/carteirinha/validar/{socio}', [CarteirinhaController::class, 'validar'])->name('carteirinha.validar');

    // Admin - Carteirinhas
    Route::get('/admin/carteirinhas', [CarteirinhaController::class, 'index'])->name('admin.carteirinhas.index');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
