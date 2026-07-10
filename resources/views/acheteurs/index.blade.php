<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Liste des acheteurs
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
                    <h3 class="text-lg font-semibold">Acheteurs</h3>
                    @can('gerer-catalogue')
                        <a href="{{ route('acheteurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            + Nouvel acheteur
                        </a>
                    @endcan
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Nom</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Téléphone</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($acheteurs as $acheteur)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">{{ $acheteur->nom }}</td>
                                <td class="py-2">{{ $acheteur->email }}</td>
                                <td class="py-2">{{ $acheteur->telephone ?? '-' }}</td>
                                <td class="py-2 space-x-2">
                                    <a href="{{ route('acheteurs.show', $acheteur) }}" class="text-blue-600 hover:underline">Voir</a>

                                    @can('gerer-catalogue')
                                        <a href="{{ route('acheteurs.edit', $acheteur) }}" class="text-yellow-600 hover:underline">
                                            Modifier
                                        </a>
                                    @endcan
                                    <form action="{{ route('acheteurs.destroy', $acheteur) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet acheteur ?')">
                                        @csrf
                                        @method('DELETE')

                                        @can('gerer-catalogue')
                                            <button type="submit" class="text-red-600 hover:underline">
                                                Supprimer
                                            </button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">Aucun acheteur enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>