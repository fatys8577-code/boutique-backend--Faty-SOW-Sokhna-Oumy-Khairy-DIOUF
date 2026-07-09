<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    use HasFactory;

    protected $fillable = ['quantite', 'date_achat', 'produit_id', 'acheeteur_id'];
    protected $casts = [
        'date_achat' => 'date',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function acheteur()
    {
        return $this->belongsTo(Acheteur::class);
    }

}
