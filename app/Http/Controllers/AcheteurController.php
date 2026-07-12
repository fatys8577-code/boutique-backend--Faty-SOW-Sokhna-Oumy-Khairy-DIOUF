<?php

namespace App\Http\Controllers;

use App\Models\Acheteur;
use App\Models\Produit;
use Illuminate\Http\Request;

class AcheteurController extends Controller
{
    public function index()
    {
        $acheteurs = Acheteur::all();
        return view('acheteurs.index', compact('acheteurs'));
    }

    public function create()
    {
        return view('acheteurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email',
            'telephone' => 'nullable|string|max:20',
        ]);

        Acheteur::create($validated);

        return redirect()->route('acheteurs.index')->with('success', 'Acheteur créé avec succès.');
    }

    public function show(Acheteur $acheteur)
    {
        $acheteur->load('achats.produit');
        return view('acheteurs.show', compact('acheteur'));
    }

    public function edit(Acheteur $acheteur)
    {
        return view('acheteurs.edit', compact('acheteur'));
    }

    public function update(Request $request, Acheteur $acheteur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email,' . $acheteur->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        $acheteur->update($validated);

        return redirect()->route('acheteurs.index')->with('success', 'Acheteur modifié avec succès.');
    }

    public function destroy(Acheteur $acheteur)
    {
        $acheteur->delete();
        return redirect()->route('acheteurs.index')->with('success', 'Acheteur supprimé avec succès.');
    }
}