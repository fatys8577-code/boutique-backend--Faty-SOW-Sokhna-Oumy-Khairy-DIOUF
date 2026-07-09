<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Produit;
use App\Models\Acheteur;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achat = Achat::with('produit', 'acheteur')->latest()->get();
        return view('achats.index', compact('achat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = Produit::all();
        $acheteurs = Acheteur::all();
        return view('achats.create', compact('produits', 'acheteurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'quantite' => 'required|integer|min:1',
        'date_achat' => 'required|date',
        'produit_id' => 'required|exists:produits,id',
        'acheteur_id' => 'required|exists:acheteurs,id',
    ]);

    Achat::create($validated);

    return redirect()->route('achats.index')->with('success', 'Achat enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Achat $achat)
    {
        $achat->load('produit', 'acheteur');
        return view('achats.show', compact('achat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achat $achat)
    {
        $produits = Produit::all();
        $acheteurs = Acheteur::all();
        return view('achats.edit', compact('achat', 'produits', 'acheteurs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achat $achat)
    {
        $validated = $request->validate([
        'quantite' => 'required|integer|min:1',
        'date_achat' => 'required|date',
        'produit_id' => 'required|exists:produits,id',
        'acheteur_id' => 'required|exists:acheteurs,id',
    ]);
    $achat->update($validated);
    return redirect()->route('achats.index')->with('success', 'Achat modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achat $achat)
    {
        $achat->delete();
        return redirect()->route('achats.index')->with('success', 'Achat supprimé avec succès.');
    }
}
