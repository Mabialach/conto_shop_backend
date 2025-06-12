<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
      protected $fillable = ['ancienPrix', 'nouveauPrix', 'dateDebut', 'dateFin', 'produit_id'];

    public function produit(){
        return $this->belongsTo(Produit::class);
    }
}
