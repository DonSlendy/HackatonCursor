<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeminiController;


Route::post('/recibir-ingredientes', [GeminiController::class, 'recibirIngredientes']);
Route::post('/crear-receta', [GeminiController::class, 'crearReceta']);