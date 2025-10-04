<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Rutas de ejemplo para API
Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando correctamente',
        'status' => 'success',
        'timestamp' => now()
    ]);
});

//Este comentario es para probar el git stash y git stash pop
?>