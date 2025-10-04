<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'platillo_id' => $this->platillo_id,
            'platillo' => $this->whenLoaded('platillo', function () {
                return [
                    'id' => $this->platillo->id,
                    'nombre' => $this->platillo->nombre,
                    'calorias' => $this->platillo->calorias,
                    'indicaciones' => $this->platillo->indicaciones,
                ];
            }),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
