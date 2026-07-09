<!DOCTYPE html>
<html>
<head>
    <title>Détail catégorie</title>
</head>

<body>

<h1>{{ $categorie->nom }}</h1>


<p>
    {{ $categorie->description }}
</p>


<h2>Produits de cette catégorie</h2>


@if($categorie->produits->count() > 0)

<ul>

@foreach($categorie->produits as $produit)

<li>
    {{ $produit->nom }} -
    {{ $produit->prix }} FCFA
</li>

@endforeach

</ul>


@else

<p>
    Aucun produit dans cette catégorie.
</p>

@endif


<a href="{{ route('categories.index') }}">
    Retour
</a>


</body>
</html>