<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategorieResource;
use App\Models\Categorie;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CategorieController extends Controller
{
    /**
     * Afficher la liste des catégories
     */
    public function index()
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('categories.index', compact('categories'));
    }


    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('categories.create');
    }


    /**
     * Enregistrer une catégorie
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);


        Categorie::create($request->all());


        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie ajoutée avec succès');
    }


    /**
     * Afficher une catégorie avec ses produits
     */
    public function show(Categorie $categorie)
    {
        $categorie->load('produits');


        return view('categories.show', compact('categorie'));
    }


    /**
     * Afficher le formulaire de modification
     */
    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }


    /**
     * Modifier une catégorie
     */
    public function update(Request $request, Categorie $categorie)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $categorie->id,
            'description' => 'nullable|string',
        ]);


        $categorie->update($request->all());


        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie modifiée avec succès');
    }


    /**
     * Supprimer une catégorie
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();


        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès');
    }
}

