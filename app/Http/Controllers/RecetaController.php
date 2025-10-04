<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecetaResource;
use App\Models\Receta;
use App\Models\Platillo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RecetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $recetas = Receta::with('platillo')->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => RecetaResource::collection($recetas)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'platillo_id' => 'required|exists:platillos,id',
            ]);

            $receta = Receta::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Receta creada exitosamente',
                'data' => new RecetaResource($receta->load('platillo'))
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Receta $receta): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new RecetaResource($receta->load('platillo'))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receta $receta): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:255',
                'platillo_id' => 'sometimes|required|exists:platillos,id',
            ]);

            $receta->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Receta actualizada exitosamente',
                'data' => new RecetaResource($receta->load('platillo'))
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receta $receta): JsonResponse
    {
        $receta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Receta eliminada exitosamente'
        ]);
    }

    /**
     * Get recetas by platillo ID.
     */
    public function getByPlatillo(Platillo $platillo): JsonResponse
    {
        $recetas = $platillo->recetas()->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => RecetaResource::collection($recetas)
        ]);
    }

    public function storeMultiple(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'platillo_id' => 'required|exists:platillos,id',
                'recetas' => 'required|array|min:1',
                'recetas.*.nombre' => 'required|string|max:255',
            ]);

            $recetas = [];
            
            foreach ($validated['recetas'] as $recetaData) {
                $recetas[] = Receta::create([
                    'nombre' => $recetaData['nombre'],
                    'platillo_id' => $validated['platillo_id']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => count($recetas) . ' recetas creadas exitosamente',
                'data' => RecetaResource::collection(Receta::whereIn('id', collect($recetas)->pluck('id'))->with('platillo')->get())
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
