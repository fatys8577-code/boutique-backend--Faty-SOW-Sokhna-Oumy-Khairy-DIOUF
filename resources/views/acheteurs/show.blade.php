<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Fiche acheteur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div>
                    <h3 class="text-lg font-semibold mb-2">Informations</h3>
                    <p><span class="font-medium">Nom :</span> {{ $acheteur->nom }}</p>
                    <p><span class="font-medium">Email :</span> {{ $acheteur->email }}</p>
                    <p><span class="font-medium">Téléphone :</span> {{ $acheteur->telephone ?? '-' }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-2">Historique des achats</h3>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Produit</th>
                                <th class="py-2">Quantité</th>
                                <th class="py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($acheteur->achats as $achat)
                                <tr class="border-b">
                                    <td class="py-2">{{ $achat->produit->nom }}</td>
                                    <td class="py-2">{{ $achat->quantite }}</td>
                                    <td class="py-2">{{ $achat->date_achat->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-500">Aucun achat enregistré.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex space-x-2">
                    @can('gerer-catalogue')
                        <a href="{{ route('acheteurs.edit', $acheteur) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                            Modifier
                        </a>
                    @endcan
                    <a href="{{ route('acheteurs.index') }}" class="px-4 py-2 rounded border">Retour</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>