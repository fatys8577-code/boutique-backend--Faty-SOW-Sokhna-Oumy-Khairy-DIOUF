<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AcheteurResource;
use App\Http\Resources\AchatResource;
use App\Models\Acheteur;
use App\Models\Achat;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Acheteurs", description: "Gestion des acheteurs et de leurs achats")]
class AcheteurController extends Controller
{
    #[OA\Get(
        path: "/api/acheteurs",
        tags: ["Acheteurs"],
        summary: "Lister tous les acheteurs",
        responses: [
            new OA\Response(response: 200, description: "Liste des acheteurs")
        ]
    )]
    public function index()
    {
        $acheteurs = Acheteur::all();
        return AcheteurResource::collection($acheteurs);
    }

    #[OA\Post(
        path: "/api/acheteurs",
        tags: ["Acheteurs"],
        summary: "Créer un acheteur",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom", "email"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Mamadou Diop"),
                    new OA\Property(property: "email", type: "string", example: "mamadou@mail.com"),
                    new OA\Property(property: "telephone", type: "string", example: "771234567"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Acheteur créé"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email',
            'telephone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $acheteur = Acheteur::create($validator->validated());

        return new AcheteurResource($acheteur);
    }

    #[OA\Get(
        path: "/api/acheteurs/{id}",
        tags: ["Acheteurs"],
        summary: "Détail d'un acheteur",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Détail de l'acheteur"),
            new OA\Response(response: 404, description: "Acheteur non trouvé"),
        ]
    )]
    public function show(Acheteur $acheteur)
    {
        $acheteur->load('achats.produit');
        return new AcheteurResource($acheteur);
    }

    #[OA\Put(
        path: "/api/acheteurs/{id}",
        tags: ["Acheteurs"],
        summary: "Modifier un acheteur",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Mamadou Diop"),
                    new OA\Property(property: "email", type: "string", example: "mamadou@mail.com"),
                    new OA\Property(property: "telephone", type: "string", example: "771234567"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Acheteur modifié"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function update(Request $request, Acheteur $acheteur)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:acheteurs,email,' . $acheteur->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $acheteur->update($validator->validated());

        return new AcheteurResource($acheteur);
    }

    #[OA\Delete(
        path: "/api/acheteurs/{id}",
        tags: ["Acheteurs"],
        summary: "Supprimer un acheteur",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 204, description: "Acheteur supprimé")
        ]
    )]
    public function destroy(Acheteur $acheteur)
    {
        $acheteur->delete();
        return response()->json(null, 204);
    }

    #[OA\Post(
        path: "/api/acheteurs/{id}/acheter",
        tags: ["Acheteurs"],
        summary: "Enregistrer un achat",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["produit_id", "quantite"],
                properties: [
                    new OA\Property(property: "produit_id", type: "integer", example: 1),
                    new OA\Property(property: "quantite", type: "integer", example: 2),
                    new OA\Property(property: "date_achat", type: "string", format: "date", example: "2026-07-11"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Achat enregistré"),
            new OA\Response(response: 422, description: "Stock insuffisant ou erreur de validation"),
        ]
    )]
    public function acheter(Request $request, Acheteur $acheteur)
    {
        $validator = Validator::make($request->all(), [
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'date_achat' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $produit = Produit::findOrFail($data['produit_id']);

        if ($produit->stock < $data['quantite']) {
            return response()->json([
                'message' => 'Stock insuffisant pour ce produit.',
            ], 422);
        }

        $achat = DB::transaction(function () use ($acheteur, $produit, $data) {
            $achat = Achat::create([
                'acheteur_id' => $acheteur->id,
                'produit_id' => $produit->id,
                'quantite' => $data['quantite'],
                'date_achat' => $data['date_achat'] ?? now(),
            ]);

            $produit->decrement('stock', $data['quantite']);

            return $achat;
        });

        return new AchatResource($achat->load('produit'));
    }
}