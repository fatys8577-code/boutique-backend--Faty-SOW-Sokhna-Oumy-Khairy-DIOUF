<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Afficher toutes les catégories
     */
    public function index()
    {
        $categories = Categorie::with('produits')->get();

        return response()->json($categories);
    }


    /**
     * Ajouter une catégorie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
        ]);


        $categorie = Categorie::create($validated);


        return response()->json([
            'message' => 'Catégorie créée avec succès',
            'categorie' => $categorie
        ], 201);
    }


    /**
     * Afficher une catégorie
     */
    public function show(Categorie $categorie)
    {
        return response()->json(
            $categorie->load('produits')
        );
    }


    /**
     * Modifier une catégorie
     */
    public function update(Request $request, Categorie $categorie)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,'.$categorie->id,
            'description' => 'nullable|string',
        ]);


        $categorie->update($validated);


        return response()->json([
            'message' => 'Catégorie modifiée avec succès',
            'categorie' => $categorie
        ]);
    }


    /**
     * Supprimer une catégorie
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();


        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ]);
    }
}