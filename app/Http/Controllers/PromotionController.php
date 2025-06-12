<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return Promotion::with('produit')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
         $valid = $request->validate([
            'ancienPrix' => 'required|numeric|min:0',
            'nouveauPrix' => 'required|numeric|min:0',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'produit_id' => 'required|exists:produits,id'
        ]);

        $promotion = Promotion::create($valid);

        return response()->json($promotion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $promotion = Promotion::with('produit')->find($id); 
      if(!$promotion){
        return response()->json([
            'message' => 'promotion non trouvée'
        ], 404);
      } 
      return response()->json($promotion, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $promotion = Promotion::with('produit')->find($id); 
        if(!$promotion){
        return response()->json([
            'message' => 'promotion non trouvée'
        ], 404);
        }
      $valid = $request->validate([
            'ancienPrix' => 'required|numeric|min:0',
            'nouveauPrix' => 'required|numeric|min:0',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'produit_id' => 'required|exists:produits,id'
        ]);

        $promotion->update($valid);

        return response()->json($promotion, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
         $promotion = Promotion::find($id); 
      if(!$promotion){
        return response()->json([
            'message' => 'promotion non trouvée'
        ], 404);
      } 
      $promotion->delete();
       return response()->json([
            'message' => 'promotion supprimée avec succès'
        ], 204);
    }
}
