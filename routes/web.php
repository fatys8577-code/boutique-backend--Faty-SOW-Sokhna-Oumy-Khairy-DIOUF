<?php

use App\Http\Controllers\AcheteurController;
use App\Http\Controllers\AchatController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('acheteurs',AcheteurController::class);
Route::resource('achats',AchatController::class);
Route::resource('categories', CategorieController::class);
Route::resource('produits', ProduitController::class);
require __DIR__.'/auth.php';
