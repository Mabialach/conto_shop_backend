<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::with('role')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'nom' => 'required|max:255',
            'prenoms' => 'nullable|max:255',
            'email' => 'required|email|unique:users',
            'mot_de_passe' => 'required',
            'telephone' => 'nullable|max:50',
            'adresse' => 'nullable|max:255',
            'photo_profil' => 'nullable|string',
            'role_id' => 'required|exists:roles,id'
        ]);

        $valid['mot_de_passe'] = Hash::make($valid['mot_de_passe']);

        $user = User::create($valid);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
          $user = User::with('user')->find($id); 
      if(!$user){
        return response()->json([
            'message' => 'user non trouvé'
        ], 404);
      } 
      return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $user = User::with('categorie')->find($id); 
        if(!$user){
        return response()->json([
            'message' => 'user non trouvé'
        ], 404);
        }
      $valid = $request->validate([
            'nom' => 'required|max:255' .$user->id,
            'prenoms' => 'nullable|max:255',
            'email' => 'required|email|unique:users',
            'mot_de_passe' => 'required',
            'telephone' => 'nullable|max:50',
            'adresse' => 'nullable|max:255',
            'photo_profil' => 'nullable|string',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user->update($valid);

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
              $user = User::find($id); 
       if(!$user){
        return response()->json([
            'message' => 'user non trouvé'
        ], 404);
       } 
      $user->delete();
       return response()->json([
            'message' => 'user supprimé avec succès'
        ], 204);
    }
}
