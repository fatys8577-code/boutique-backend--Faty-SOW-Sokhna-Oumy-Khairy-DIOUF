<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le produit
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('produits.update', $produit) }}" method="POST">

                    @csrf
                    @method('PUT')


                    <div class="mb-4">
                        <label class="block font-medium">
                            Nom du produit
                        </label>

                        <input 
                            type="text"
                            name="nom"
                            value="{{ old('nom', $produit->nom) }}"
                            class="border rounded w-full p-2"
                        >

                        @error('nom')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="mb-4">
                        <label class="block font-medium">
                            Prix
                        </label>

                        <input 
                            type="number"
                            step="0.01"
                            name="prix"
                            value="{{ old('prix', $produit->prix) }}"
                            class="border rounded w-full p-2"
                        >

                        @error('prix')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="mb-4">
                        <label class="block font-medium">
                            Stock
                        </label>

                        <input 
                            type="number"
                            name="stock"
                            value="{{ old('stock', $produit->stock) }}"
                            class="border rounded w-full p-2"
                        >

                        @error('stock')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="mb-4">
                        <label class="block font-medium">
                            Catégorie
                        </label>

                        <select name="categorie_id" class="border rounded w-full p-2">

                            @foreach($categories as $categorie)

                                <option 
                                    value="{{ $categorie->id }}"
                                    {{ old('categorie_id', $produit->categorie_id) == $categorie->id ? 'selected' : '' }}
                                >
                                    {{ $categorie->nom }}
                                </option>

                            @endforeach

                        </select>

                        @error('categorie_id')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror

                    </div>




                    <div class="mb-4">
                        <label class="block font-medium">
                            Description
                        </label>

                        <textarea 
                            name="description"
                            class="border rounded w-full p-2"
                        >{{ old('description', $produit->description) }}</textarea>

                        @error('description')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror

                    </div>




                    <div class="flex gap-2">

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Modifier
                        </button>


                        <a href="{{ route('produits.index') }}" class="border px-4 py-2 rounded">
                            Annuler
                        </a>

                    </div>


                </form>

            </div>

        </div>
    </div>

</x-app-layout>