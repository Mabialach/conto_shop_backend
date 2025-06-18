<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    
    protected $fillable = [
        'utilisateur_id',
        'numero_commande',
        'montant_total',
        'statut',
        'mode_paiement',
        'date',
        'adresse_livraison',
        'observation'
    ]; 

    protected $casts = [
        'date' => 'datetime',
    ]; 
    public function utilisateur()
    {
        return $this->belongsTo(User::class);
    } 

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class);
    }
    
    public function changerStatut(string $nouveauStatut)
    {
        $statutsValides = ['en_attente', 'validee', 'en_livraison', 'livree', 'annulee'];

        if (!in_array($nouveauStatut, $statutsValides)) {
            throw new \InvalidArgumentException("Statut '$nouveauStatut' invalide.");
        }

        if ($this->statut === 'annulee' || $this->statut === 'livree') {
            throw new \Exception("Impossible de changer le statut d'une commande déjà livrée ou annulée.");
        }

        $this->update([
            'statut' => $nouveauStatut
        ]);
    } 

    
}
