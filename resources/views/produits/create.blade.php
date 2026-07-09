<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un produit</title>
</head>
<body>

<h1>Ajouter un produit</h1>
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('produits.store') }}" method="POST">
    @csrf

    <label>Nom :</label><br>
    <input type="text" name="nom"><br><br>

    <label>Prix :</label><br>
    <input type="number" step="0.01" name="prix"><br><br>

    <label>Stock :</label><br>
    <input type="number" name="stock"><br><br>

    <label>Description :</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Catégorie :</label><br>
    <select name="categorie_id">
        @foreach($categories as $categorie)
            <option value="{{ $categorie->id }}">
                {{ $categorie->nom }}
            </option>
        @endforeach
    </select>

    <br><br>

    <button type="submit">Enregistrer</button>
</form>

</body>
</html>