<!DOCTYPE html>
<html>
<head>
    <title>Modifier catégorie</title>
</head>

<body>

<h1>Modifier catégorie</h1>


<form action="{{ route('categories.update', $categorie) }}" method="POST">

@csrf
@method('PUT')


<label>Nom :</label>

<input type="text" 
       name="nom" 
       value="{{ $categorie->nom }}">


<br>


<label>Description :</label>

<textarea name="description">{{ $categorie->description }}</textarea>


<br>


<button type="submit">
    Modifier
</button>


</form>


</body>
</html>