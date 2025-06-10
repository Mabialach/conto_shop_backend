<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    
    protected $fillable = ['nom', 'description', 'image', 'prix', 'quantite', 'taille', 'couleur', 'compression', 'visibilite', 'categorie_id'];

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
}
