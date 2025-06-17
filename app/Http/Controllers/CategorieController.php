<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Categorie::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'nom' => 'required|unique:categories,nom|max:255',
            'description' => 'nullable|string'
        ]);

        $categorie = Categorie::create($valid);

        return response()->json($categorie, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $categorie = Categorie::find($id); 
      if(!$categorie){
        return response()->json([
            'message' => 'categorie non trouvée'
        ], 404);
      } 
      return response()->json($categorie, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $categorie = Categorie::find($id); 
        if(!$categorie){
        return response()->json([
            'message' => 'categorie non trouvée'
        ], 404);
        }
      $valid = $request->validate([
            'nom' => 'required|max:255|unique:categories,nom,' .$categorie->id,
            'description' => 'nullable|string'
        ]);

        $categorie->update($valid);

        return response()->json($categorie, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $categorie = Categorie::find($id); 
      if(!$categorie){
        return response()->json([
            'message' => 'categorie non trouvée'
        ], 404);
      } 
      $categorie->delete();
       return response()->json([
            'message' => 'categorie supprimée avec succès'
        ], 204);
    }
}
