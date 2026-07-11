<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    /**
     * Afficher tous les achats
     */
    public function index()
    {
        $achats = Achat::with([
            'produit',
            'acheteur'
        ])->get();


        return response()->json($achats);
    }


    /**
     * Créer un achat
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'acheteur_id' => 'required|exists:acheteurs,id',
            'quantite' => 'required|integer|min:1',
            'date_achat' => 'required|date',
        ]);


        $achat = Achat::create($validated);


        return response()->json([
            'message' => 'Achat créé avec succès',
            'achat' => $achat
        ], 201);
    }


    /**
     * Afficher un achat
     */
    public function show(Achat $achat)
    {
        return response()->json(
            $achat->load([
                'produit',
                'acheteur'
            ])
        );
    }


    /**
     * Modifier un achat
     */
    public function update(Request $request, Achat $achat)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'acheteur_id' => 'required|exists:acheteurs,id',
            'quantite' => 'required|integer|min:1',
            'date_achat' => 'required|date',
        ]);


        $achat->update($validated);


        return response()->json([
            'message' => 'Achat modifié avec succès',
            'achat' => $achat
        ]);
    }


    /**
     * Supprimer un achat
     */
    public function destroy(Achat $achat)
    {
        $achat->delete();


        return response()->json([
            'message' => 'Achat supprimé avec succès'
        ]);
    }
}