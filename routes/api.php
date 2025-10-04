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
<<<<<<< Updated upstream

//Este comentario es para probar el git stash y git stash pop
?>
=======
?>

//el rap de fernanflo es el mejor
>>>>>>> Stashed changes
