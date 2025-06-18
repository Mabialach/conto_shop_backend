<?php

namespace App\Http\Controllers;

use App\Models\Avi;
use Illuminate\Http\Request;

class AviController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return Avi::with('user')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $valid = $request->validate([
            'message' => 'required|string',
            'visibilite' => 'required|boolean',
            'user_id' => 'required|exists:users,id'
        ]);

        $avi = Avi::create($valid);

        return response()->json($avi, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $avi = Avi::with('user')->find($id); 
      if(!$avi){
        return response()->json([
            'message' => 'avis non trouvé'
        ], 404);
      } 
      return response()->json($avi, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $avi = Avi::with('user')->find($id); 
        if(!$avi){
        return response()->json([
            'message' => 'avis non trouvé'
        ], 404);
        }
      $valid = $request->validate([
            'message' => 'required|string' .$avi->id,
            'visibilite' => 'required|boolean',
            'user_id' => 'required|exists:users,id'
        ]);

        $avi->update($valid);

        return response()->json($avi, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $avi = Avi::find($id); 
       if(!$avi){
        return response()->json([
            'message' => 'avis non trouvé'
        ], 404);
       } 
      $avi->delete();
       return response()->json([
            'message' => 'avis supprimé avec succès'
        ], 204);
    }
}
