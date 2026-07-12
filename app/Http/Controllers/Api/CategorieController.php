<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategorieResource;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Categories", description: "Gestion des catégories de produits")]
class CategorieController extends Controller
{
    #[OA\Get(
        path: "/api/categories",
        tags: ["Categories"],
        summary: "Lister toutes les catégories",
        responses: [
            new OA\Response(response: 200, description: "Liste des catégories")
        ]
    )]
    public function index()
    {
        $categories = Categorie::withCount('produits')->get();
        return CategorieResource::collection($categories);
    }

    #[OA\Post(
        path: "/api/categories",
        tags: ["Categories"],
        summary: "Créer une catégorie",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Électronique"),
                    new OA\Property(property: "description", type: "string", example: "Produits électroniques"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Catégorie créée"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $categorie = Categorie::create($validator->validated());

        return new CategorieResource($categorie);
    }

    #[OA\Get(
        path: "/api/categories/{id}",
        tags: ["Categories"],
        summary: "Détail d'une catégorie",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Détail de la catégorie"),
            new OA\Response(response: 404, description: "Catégorie non trouvée"),
        ]
    )]
    public function show(Categorie $categorie)
    {
        $categorie->load('produits');
        return new CategorieResource($categorie);
    }

    #[OA\Put(
        path: "/api/categories/{id}",
        tags: ["Categories"],
        summary: "Modifier une catégorie",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Électronique"),
                    new OA\Property(property: "description", type: "string", example: "Produits électroniques"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Catégorie modifiée"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function update(Request $request, Categorie $categorie)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|required|string|max:255|unique:categories,nom,' . $categorie->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $categorie->update($validator->validated());

        return new CategorieResource($categorie);
    }

    #[OA\Delete(
        path: "/api/categories/{id}",
        tags: ["Categories"],
        summary: "Supprimer une catégorie",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 204, description: "Catégorie supprimée")
        ]
    )]
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
        return response()->json(null, 204);
    }
}