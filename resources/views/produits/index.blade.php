<!DOCTYPE html>
<html>
<head>
    <title>Produits</title>
</head>

<body>

<h1>Liste des produits</h1>

@if(session('success'))
    <p style="color:green">
        {{ session('success') }}
    </p>
@endif


@can('gerer-catalogue')
    <a href="{{ route('produits.create') }}">
        Ajouter un produit
    </a>
@endcan


<table border="1">

<tr>
    <th>Nom</th>
    <th>Prix</th>
    <th>Stock</th>
    <th>Catégorie</th>
    <th>Description</th>
    <th>Actions</th>
</tr>


@foreach($produits as $produit)

<tr>

    <td>
        {{ $produit->nom }}
    </td>


    <td>
        {{ $produit->prix }} FCFA
    </td>


    <td>
        {{ $produit->stock }}
    </td>


    <td>
        {{ $produit->categorie->nom }}
    </td>


    <td>
        {{ $produit->description }}
    </td>


    <td>

        <a href="{{ route('produits.show', $produit) }}">
            Voir
        </a>


        @can('gerer-catalogue')

            <a href="{{ route('produits.edit', $produit) }}">
                Modifier
            </a>


            <form action="{{ route('produits.destroy', $produit) }}" method="POST" style="display:inline">

                @csrf
                @method('DELETE')

                <button type="submit">
                    Supprimer
                </button>

            </form>

        @endcan


    </td>

</tr>

@endforeach


</table>


</body>
</html>