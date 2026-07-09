<!DOCTYPE html>
<html>
<head>
    <title>Ajouter catégorie</title>
</head>

<body>

<h1>Ajouter une catégorie</h1>

<form action="{{ route('categories.store') }}" method="POST">

@csrf

<label>Nom :</label>
<input type="text" name="nom">

<br>

<label>Description :</label>
<textarea name="description"></textarea>

<br>

<button type="submit">
    Enregistrer
</button>

</form>

</body>
</html>