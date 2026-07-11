<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\AcheteurController;
use App\Http\Controllers\Api\AchatController;


Route::apiResource('produits', ProduitController::class);

Route::apiResource('categories', CategorieController::class);

Route::apiResource('acheteurs', AcheteurController::class);

Route::apiResource('achats', AchatController::class);