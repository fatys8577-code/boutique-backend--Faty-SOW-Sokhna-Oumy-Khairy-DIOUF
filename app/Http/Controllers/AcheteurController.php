<?php

namespace App\Http\Controllers;

use App\Models\Acheteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AcheteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acheteurs = Acheteur::all();

        return view('acheteurs.index', compact('acheteurs'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('gerer-catalogue');

        return view('acheteurs.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('gerer-catalogue');

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email',
            'telephone' => 'nullable|string|max:20',
        ]);

        Acheteur::create($validated);

        return redirect()
            ->route('acheteurs.index')
            ->with('success', 'Acheteur créé avec succès.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Acheteur $acheteur)
    {
        $acheteur->load('achats.produit');

        return view('acheteurs.show', compact('acheteur'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Acheteur $acheteur)
    {
        Gate::authorize('gerer-catalogue');

        return view('acheteurs.edit', compact('acheteur'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Acheteur $acheteur)
    {
        Gate::authorize('gerer-catalogue');

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email,' . $acheteur->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        $acheteur->update($validated);

        return redirect()
            ->route('acheteurs.index')
            ->with('success', 'Acheteur modifié avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acheteur $acheteur)
    {
        Gate::authorize('gerer-catalogue');

        $acheteur->delete();

        return redirect()
            ->route('acheteurs.index')
            ->with('success', 'Acheteur supprimé avec succès.');
    }
}