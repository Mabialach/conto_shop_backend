<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PromotionController;
use Illuminate\Support\Facades\Route;


Route::apiResource('roles', RoleController::class);

Route::apiResource('categories', CategorieController::class);
Route::apiResource('produits', ProduitController::class);
Route::apiResource('promotions', PromotionController::class);

