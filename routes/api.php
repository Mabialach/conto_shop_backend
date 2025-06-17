<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AviController;
use App\Models\Avi;
use Illuminate\Support\Facades\Route;

//Routes accessibles uniquement aux utilisateurs authentifiés avec un rôle spécifique

Route::middleware(['auth:sanctum'])->group(function(){

    //Routes uniquement accessibles au Super Admin 
    Route::middleware('role:superadmin')->group(function(){
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('users', UserController::class);
    });

    //Routes accessibles au Super Admin et à l'admin 
    Route::middleware('role:admin,superadmin')->group(function(){
        Route::apiResource('categories', CategorieController::class);
        Route::apiResource('produits', ProduitController::class);
        Route::apiResource('promotions', PromotionController::class);
      
    });

        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

});

//Routes accessibles à tout le monde

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
  Route::apiResource('avis', AviController::class);