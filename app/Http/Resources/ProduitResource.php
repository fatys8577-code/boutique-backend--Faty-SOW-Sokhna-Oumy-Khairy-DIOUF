<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prix' => $this->prix,
            'stock' => $this->stock,
            'description' => $this->description,
            'categorie' => new CategorieResource($this->whenLoaded('categorie')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}