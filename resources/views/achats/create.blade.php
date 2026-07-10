<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouvel achat
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('achats.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Produit</label>
                        <select name="produit_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">-- Choisir un produit --</option>
                            @foreach ($produits as $produit)
                                <option value="{{ $produit->id }}" {{ old('produit_id') == $produit->id ? 'selected' : '' }}>
                                    {{ $produit->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('produit_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Acheteur</label>
                        <select name="acheteur_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">-- Choisir un acheteur --</option>
                            @foreach ($acheteurs as $acheteur)
                                <option value="{{ $acheteur->id }}" {{ old('acheteur_id') == $acheteur->id ? 'selected' : '' }}>
                                    {{ $acheteur->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('acheteur_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Quantité</label>
                        <input type="number" name="quantite" min="1" value="{{ old('quantite') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('quantite')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Date d'achat</label>
                        <input type="date" name="date_achat" value="{{ old('date_achat') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('date_achat')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('achats.index') }}" class="px-4 py-2 rounded border">Annuler</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Enregistrer
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>