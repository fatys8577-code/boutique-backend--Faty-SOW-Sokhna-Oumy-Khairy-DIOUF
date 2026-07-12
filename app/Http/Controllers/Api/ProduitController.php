<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProduitResource;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Produits", description: "Gestion des produits")]
class ProduitController extends Controller
{
    #[OA\Get(
        path: "/api/produits",
        tags: ["Produits"],
        summary: "Lister tous les produits",
        responses: [
            new OA\Response(response: 200, description: "Liste des produits")
        ]
    )]
    public function index()
    {
        $produits = Produit::with('categorie')->get();
        return ProduitResource::collection($produits);
    }

    #[OA\Post(
        path: "/api/produits",
        tags: ["Produits"],
        summary: "Créer un produit",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom", "prix", "stock", "categorie_id"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Clavier mécanique"),
                    new OA\Property(property: "prix", type: "number", format: "float", example: 49.99),
                    new OA\Property(property: "stock", type: "integer", example: 25),
                    new OA\Property(property: "description", type: "string", example: "Clavier rétroéclairé"),
                    new OA\Property(property: "categorie_id", type: "integer", example: 1),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Produit créé"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $produit = Produit::create($validator->validated());

        return new ProduitResource($produit->load('categorie'));
    }

    #[OA\Get(
        path: "/api/produits/{id}",
        tags: ["Produits"],
        summary: "Détail d'un produit",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Détail du produit"),
            new OA\Response(response: 404, description: "Produit non trouvé"),
        ]
    )]
    public function show(Produit $produit)
    {
        $produit->load(['categorie', 'achats.acheteur']);
        return new ProduitResource($produit);
    }

    #[OA\Put(
        path: "/api/produits/{id}",
        tags: ["Produits"],
        summary: "Modifier un produit",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Clavier mécanique"),
                    new OA\Property(property: "prix", type: "number", format: "float", example: 49.99),
                    new OA\Property(property: "stock", type: "integer", example: 25),
                    new OA\Property(property: "description", type: "string", example: "Clavier rétroéclairé"),
                    new OA\Property(property: "categorie_id", type: "integer", example: 1),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Produit modifié"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function update(Request $request, Produit $produit)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|required|string|max:255',
            'prix' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'sometimes|required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $produit->update($validator->validated());

        return new ProduitResource($produit->load('categorie'));
    }

    #[OA\Delete(
        path: "/api/produits/{id}",
        tags: ["Produits"],
        summary: "Supprimer un produit",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 204, description: "Produit supprimé")
        ]
    )]
    public function destroy(Produit $produit)
    {
        $produit->delete();
        return response()->json(null, 204);
    }
}