<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategorieController;
use Illuminate\Support\Facades\Route;


Route::apiResource('roles', RoleController::class);

Route::apiResource('categories', CategorieController::class);

