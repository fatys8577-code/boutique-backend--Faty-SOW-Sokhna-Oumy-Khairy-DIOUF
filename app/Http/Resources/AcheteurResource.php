<?php

namespace App\Http\Resources;

use App\Http\Resources\AchatResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcheteurResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'achats' => AchatResource::collection($this->whenLoaded('achats')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}