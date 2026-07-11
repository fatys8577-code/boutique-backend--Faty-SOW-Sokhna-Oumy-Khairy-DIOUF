<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acheteur;
use Illuminate\Http\Request;

class AcheteurController extends Controller
{
    /**
     * Afficher tous les acheteurs
     */
    public function index()
    {
        $acheteurs = Acheteur::with('achats.produit')->get();

        return response()->json($acheteurs);
    }


    /**
     * Ajouter un acheteur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email',
            'telephone' => 'nullable|string|max:20',
        ]);


        $acheteur = Acheteur::create($validated);


        return response()->json([
            'message' => 'Acheteur créé avec succès',
            'acheteur' => $acheteur
        ], 201);
    }


    /**
     * Afficher un acheteur
     */
    public function show(Acheteur $acheteur)
    {
        return response()->json(
            $acheteur->load('achats.produit')
        );
    }


    /**
     * Modifier un acheteur
     */
    public function update(Request $request, Acheteur $acheteur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email,'.$acheteur->id,
            'telephone' => 'nullable|string|max:20',
        ]);


        $acheteur->update($validated);


        return response()->json([
            'message' => 'Acheteur modifié avec succès',
            'acheteur' => $acheteur
        ]);
    }


    /**
     * Supprimer un acheteur
     */
    public function destroy(Acheteur $acheteur)
    {
        $acheteur->delete();


        return response()->json([
            'message' => 'Acheteur supprimé avec succès'
        ]);
    }
}