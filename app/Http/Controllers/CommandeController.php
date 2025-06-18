<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommandeController extends Controller
{
   public function index()
    {
        return response()->json(Commande::with(['utilisateur','lignes.produit'])->get(), 200);
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'utilisateur_id' => 'required|exists:users,id',
            'mode_paiement' => 'required|in:livraison,cheque,carte,paypal,virement',
            'adresse_livraison' => 'required|string',
            'observation' => 'nullable|string',
            'lignes' => 'required|array|min:1',
            'lignes.*.produit_id' => 'required|exists:produits,id',
            'lignes.*.quantite' => 'required|integer|min:1',
            'lignes.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($valid) {
            $commande = Commande::create([
                'utilisateur_id' => $valid['utilisateur_id'],
                'numero_commande' => 'CMD' . now()->format('YmdHis') . Str::random(4),
                'montant_total' => collect($valid['lignes'])->sum(function ($element) {
                    return $element['quantite'] * $element['prix_unitaire'];
                }),
                'mode_paiement' => $valid['mode_paiement'],
                'adresse_livraison' => $valid['adresse_livraison'],
                'observation' => $valid['observation'] ?? null,
                'date' => now(),
            ]);

            foreach ($valid['lignes'] as $ligne) {
                $commande->lignes()->create($ligne);
            }

            return response()->json($commande->load('lignes.produit'), 201);
        });
    }

    public function show($id)
    {
        $commande = Commande::with(['utilisateur','lignes.produit'])->find($id);
        if (!$commande) {
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }
        return response()->json($commande, 200);
    } 

    public function changerStatut(Request $request, $id)
{
    $commande = Commande::find($id);

    if (!$commande) {
        return response()->json(['message' => 'Commande non trouvée'], 404);
    }

    $valid = $request->validate([
        'statut' => 'required|in:en_attente,validee,en_livraison,livree,annulee',
    ]);

    try {
        $commande->changerStatut($valid['statut']);
        return response()->json([
            'message' => 'Statut mis à jour avec succès',
            'commande' => $commande->refresh(),
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur : ' . $e->getMessage()
        ], 400);
    }
} 
}
