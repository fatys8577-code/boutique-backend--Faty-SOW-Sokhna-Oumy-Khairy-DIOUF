<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Afficher tous les produits
     */
    public function index()
    {
        $produits = Produit::with('categorie')->get();

        return response()->json($produits);
    }


    /**
     * Ajouter un produit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);


        $produit = Produit::create($validated);


        return response()->json([
            'message' => 'Produit créé avec succès',
            'produit' => $produit
        ], 201);
    }


    /**
     * Afficher un produit précis
     */
    public function show(Produit $produit)
    {
        return response()->json($produit->load('categorie'));
    }


    /**
     * Modifier un produit
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);


        $produit->update($validated);


        return response()->json([
            'message' => 'Produit modifié avec succès',
            'produit' => $produit
        ]);
    }


    /**
     * Supprimer un produit
     */
    public function destroy(Produit $produit)
    {
        $produit->delete();


        return response()->json([
            'message' => 'Produit supprimé avec succès'
        ]);
    }
}