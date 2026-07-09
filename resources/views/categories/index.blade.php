<!DOCTYPE html>
<html>
<head>
    <title>Catégories</title>
</head>
<body>

<h1>Liste des catégories</h1>

@if(session('success'))
    <p style="color:green">
        {{ session('success') }}
    </p>
@endif

<a href="{{ route('categories.create') }}">
    Ajouter une catégorie
</a>

<table border="1">
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

    @foreach($categories as $categorie)
    <tr>
        <td>{{ $categorie->nom }}</td>
        <td>{{ $categorie->description }}</td>

        <td>
            <a href="{{ route('categories.show', $categorie) }}">
                Voir
            </a>

            <a href="{{ route('categories.edit', $categorie) }}">
                Modifier
            </a>

            <form action="{{ route('categories.destroy', $categorie) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit">
                    Supprimer
                </button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

</body>
</html>