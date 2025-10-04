<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeminiController;
use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\RecetaController;

// Rutas de ejemplo para API
Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando correctamente',
        'status' => 'success',
        'timestamp' => now()
    ]);
});

Route::post('/recibir-ingredientes', [GeminiController::class, 'recibirIngredientes']);
Route::post('/crear-receta', [GeminiController::class, 'crearReceta']);

// Rutas de Platillos
Route::apiResource('platillos', PlatilloController::class);

// Rutas de Recetas
Route::apiResource('recetas', RecetaController::class);
Route::get('recetas/platillo/{platillo}', [RecetaController::class, 'getByPlatillo']);
//Route::post('recetas/multiple', [RecetaController::class, 'storeMultiple']);

//Este comentario es para probar el git stash y git stash pop
//el rap de fernanflo es el mejor

?>
