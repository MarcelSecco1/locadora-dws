<?php

use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VeiculoController;
use App\Models\Locacao;
use App\Models\Veiculo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $hasVeiculosTable = Schema::hasTable('veiculos');
    $hasLocacoesTable = Schema::hasTable('locacoes');

    return view('welcome', [
        'veiculos' => $hasVeiculosTable ? Veiculo::query()->latest()->take(4)->get() : collect(),
        'locacoes' => $hasLocacoesTable ? Locacao::query()->with('veiculo')->latest()->take(4)->get() : collect(),
        'veiculosCount' => $hasVeiculosTable ? Veiculo::count() : 0,
        'locacoesCount' => $hasLocacoesTable ? Locacao::count() : 0,
        'disponiveisCount' => $hasVeiculosTable ? Veiculo::where('status', 'disponivel')->count() : 0,
    ]);
});

Route::get('/dashboard', function () {
    $hasVeiculosTable = Schema::hasTable('veiculos');
    $hasLocacoesTable = Schema::hasTable('locacoes');

    return view('dashboard', [
        'veiculosCount' => $hasVeiculosTable ? Veiculo::count() : 0,
        'locacoesCount' => $hasLocacoesTable ? Locacao::count() : 0,
        'disponiveisCount' => $hasVeiculosTable ? Veiculo::where('status', 'disponivel')->count() : 0,
        'alugadosCount' => $hasVeiculosTable ? Veiculo::where('status', 'alugado')->count() : 0,
        'recentesVeiculos' => $hasVeiculosTable ? Veiculo::query()->latest()->take(6)->get() : collect(),
        'recentesLocacoes' => $hasLocacoesTable ? Locacao::query()->with('veiculo')->latest()->take(6)->get() : collect(),
    ]);
})->middleware(['auth', 'permission:acessar dashboard'])->name('dashboard');

Route::get('/veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
Route::get('/veiculos/{veiculo}', [VeiculoController::class, 'show'])->name('veiculos.show');

Route::get('/locacoes', [LocacaoController::class, 'index'])->name('locacoes.index');
Route::get('/locacoes/{locacao}', [LocacaoController::class, 'show'])->name('locacoes.show');

Route::middleware(['auth', 'permission:gerenciar veiculos'])->group(function () {
    Route::get('/veiculos/criar', [VeiculoController::class, 'create'])->name('veiculos.create');
    Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');
    Route::get('/veiculos/{veiculo}/editar', [VeiculoController::class, 'edit'])->name('veiculos.edit');
    Route::put('/veiculos/{veiculo}', [VeiculoController::class, 'update'])->name('veiculos.update');
    Route::delete('/veiculos/{veiculo}', [VeiculoController::class, 'destroy'])->name('veiculos.destroy');
});

Route::middleware(['auth', 'permission:gerenciar locacoes'])->group(function () {
    Route::get('/locacoes/criar', [LocacaoController::class, 'create'])->name('locacoes.create');
    Route::post('/locacoes', [LocacaoController::class, 'store'])->name('locacoes.store');
    Route::get('/locacoes/{locacao}/editar', [LocacaoController::class, 'edit'])->name('locacoes.edit');
    Route::put('/locacoes/{locacao}', [LocacaoController::class, 'update'])->name('locacoes.update');
    Route::delete('/locacoes/{locacao}', [LocacaoController::class, 'destroy'])->name('locacoes.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:gerenciar usuarios'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/criar', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
});

require __DIR__.'/auth.php';
