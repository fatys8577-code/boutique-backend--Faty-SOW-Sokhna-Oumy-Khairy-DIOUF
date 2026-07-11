<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProduitController extends Controller
{
    /**
     * Liste des produits
     */
    public function index()
    {
        $produits = Produit::with('categorie')
            ->orderBy('nom')
            ->get();

        return view('produits.index', compact('produits'));
    }


    /**
     * Formulaire de création
     */
    public function create()
    {
        Gate::authorize('gerer-catalogue');

        $categories = Categorie::all();

        return view('produits.create', compact('categories'));
    }


    /**
     * Enregistrer un produit
     */
    public function store(Request $request)
    {
        Gate::authorize('gerer-catalogue');

        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        Produit::create($request->all());

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit ajouté avec succès');
    }


    /**
     * Afficher un produit
     */
    public function show(Produit $produit)
    {
        $produit->load([
            'categorie',
            'acheteurs'
        ]);

        return view('produits.show', compact('produit'));
    }


    /**
     * Formulaire modification
     */
    public function edit(Produit $produit)
    {
        Gate::authorize('gerer-catalogue');

        $categories = Categorie::all();

        return view('produits.edit', compact(
            'produit',
            'categories'
        ));
    }


    /**
     * Modifier un produit
     */
    public function update(Request $request, Produit $produit)
    {
        Gate::authorize('gerer-catalogue');

        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $produit->update($request->all());

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit modifié avec succès');
    }


    /**
     * Supprimer un produit
     */
    public function destroy(Produit $produit)
    {
        Gate::authorize('gerer-catalogue');

        $produit->delete();

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit supprimé avec succès');
    }
}