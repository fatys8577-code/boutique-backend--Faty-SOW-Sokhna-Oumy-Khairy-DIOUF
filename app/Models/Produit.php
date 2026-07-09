<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prix',
        'stock',
        'description',
        'categorie_id',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function achats()
    {
        return $this->hasMany(Achat::class);
    }
}