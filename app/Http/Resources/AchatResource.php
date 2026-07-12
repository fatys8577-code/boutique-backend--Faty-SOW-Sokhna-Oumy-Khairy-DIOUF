<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantite' => $this->quantite,
            'date_achat' => $this->date_achat,
            'produit' => new ProduitResource($this->whenLoaded('produit')),
            'acheteur_id' => $this->acheteur_id,
        ];
    }
}