<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\CommandeFourController;
use App\Http\Controllers\LivraisonController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('users', UserController::class)->middleware('auth');
Route::resource('marques', MarqueController::class)->middleware('auth');
Route::resource('clients', ClientController::class)->middleware('auth');
Route::resource('fournisseurs', FournisseurController::class)->middleware('auth');
Route::resource('articles', ArticleController::class)->middleware('auth');
Route::resource('operations', OperationController::class)->middleware('auth');
Route::resource('commande-fours', CommandeFourController::class)->middleware('auth');
Route::post('commande-fours/{commandeFour}/validate', [CommandeFourController::class, 'validate'])->name('commande-fours.validate')->middleware('auth');
Route::resource('livraisons', LivraisonController::class)->middleware('auth');
Route::post('livraisons/{livraison}/update-status', [LivraisonController::class, 'updateStatus'])->name('livraisons.update-status')->middleware('auth');

require __DIR__.'/auth.php';
