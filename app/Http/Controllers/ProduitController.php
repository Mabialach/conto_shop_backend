<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Produit::with('categorie')->get();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $valid = $request->validate([
            'nom' => 'required|unique:produits,nom|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'prix' => 'numeric|min:0',
            'quantite' => 'integer|min:0',
            'taille' => 'nullable|string',
            'couleur' => 'nullable|string',
            'compression' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        $produit = Produit::create($valid);

        return response()->json($produit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
     $produit = Produit::with('categorie')->find($id); 
      if(!$produit){
        return response()->json([
            'message' => 'produit non trouvé'
        ], 404);
      } 
      return response()->json($produit, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $produit = Produit::with('categorie')->find($id); 
        if(!$produit){
        return response()->json([
            'message' => 'produit non trouvé'
        ], 404);
        }
      $valid = $request->validate([
            'nom' => 'required|max:255|unique:produits,nom,' .$produit->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'prix' => 'numeric|min:0',
            'quantite' => 'integer|min:0',
            'taille' => 'nullable|string',
            'couleur' => 'nullable|string',
            'compression' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        $produit->update($valid);

        return response()->json($produit, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $produit = Produit::find($id); 
       if(!$produit){
        return response()->json([
            'message' => 'produit non trouvé'
        ], 404);
       } 
      $produit->delete();
       return response()->json([
            'message' => 'produit supprimé avec succès'
        ], 204);
    }
}
