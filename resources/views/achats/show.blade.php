<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détail de l'achat
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <p><span class="font-medium">Produit :</span> {{ $achat->produit->nom }}</p>
                <p><span class="font-medium">Acheteur :</span> {{ $achat->acheteur->nom }}</p>
                <p><span class="font-medium">Quantité :</span> {{ $achat->quantite }}</p>
                <p><span class="font-medium">Date d'achat :</span> {{ $achat->date_achat->format('d/m/Y') }}</p>

                <div class="flex space-x-2 pt-4">
                    <a href="{{ route('achats.edit', $achat) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Modifier</a>
                    <a href="{{ route('achats.index') }}" class="px-4 py-2 rounded border">Retour</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>