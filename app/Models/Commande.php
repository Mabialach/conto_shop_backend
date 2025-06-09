<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{

    protected $table = 'commandes'; // Nom de la table associée

    protected $fillable = [
        'nom_produit',
        'quantite',
        'prix',
    ];
}
