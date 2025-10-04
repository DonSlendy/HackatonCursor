<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlatilloResource;
use App\Models\Platillo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PlatilloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $platillos = Platillo::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => PlatilloResource::collection($platillos)
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
                'calorias' => 'required|numeric|min:0',
                'indicaciones' => 'required|string|max:255',
            ]);

            $platillo = Platillo::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Platillo creado exitosamente',
                'data' => new PlatilloResource($platillo)
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
    public function show(Platillo $platillo): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new PlatilloResource($platillo)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Platillo $platillo): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:255',
                'calorias' => 'sometimes|required|numeric|min:0',
                'indicaciones' => 'sometimes|required|string|max:255',
            ]);

            $platillo->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Platillo actualizado exitosamente',
                'data' => new PlatilloResource($platillo)
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
    public function destroy(Platillo $platillo): JsonResponse
    {
        $platillo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Platillo eliminado exitosamente'
        ]);
    }
}
