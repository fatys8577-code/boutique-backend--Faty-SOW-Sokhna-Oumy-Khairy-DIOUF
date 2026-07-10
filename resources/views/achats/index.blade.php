<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Liste des achats
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Achats</h3>
                    <a href="{{ route('achats.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Nouvel achat
                    </a>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Produit</th>
                            <th class="py-2">Acheteur</th>
                            <th class="py-2">Quantité</th>
                            <th class="py-2">Date</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($achats as $achat)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">{{ $achat->produit->nom }}</td>
                                <td class="py-2">{{ $achat->acheteur->nom }}</td>
                                <td class="py-2">{{ $achat->quantite }}</td>
                                <td class="py-2">{{ $achat->date_achat->format('d/m/Y') }}</td>
                                <td class="py-2 space-x-2">
                                    <a href="{{ route('achats.show', $achat) }}" class="text-blue-600 hover:underline">Voir</a>
                                    <a href="{{ route('achats.edit', $achat) }}" class="text-yellow-600 hover:underline">Modifier</a>
                                    <form action="{{ route('achats.destroy', $achat) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet achat ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">Aucun achat enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>