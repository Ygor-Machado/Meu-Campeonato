<?php

use App\Http\Controllers\CampeonatoController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\TimeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('times', TimeController::class);
Route::apiResource('campeonatos', CampeonatoController::class);
Route::apiResource('partidas', PartidaController::class);
