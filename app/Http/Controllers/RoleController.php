<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Role::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'nom' => 'required|unique:roles,nom|max:255',
            'description' => 'nullable|string'
        ]);

        $role = Role::create($valid);

        return response()->json($role, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
      $role = Role::find($id); 
      if(!$role){
        return response()->json([
            'message' => 'role non trouvé'
        ], 404);
      } 
      return response()->json($role, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $role = Role::find($id); 
      if(!$role){
        return response()->json([
            'message' => 'role non trouvé'
        ], 404);
      } 
      
       $valid = $request->validate([
            'nom' => 'required|max:255|unique:roles,nom,' .$role->id,
            'description' => 'nullable|string'
        ]);

        $role->update($valid);

        return response()->json($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $role = Role::find($id); 
      if(!$role){
        return response()->json([
            'message' => 'role non trouvé'
        ], 404);
      } 
      $role->delete();
       return response()->json([
            'message' => 'role supprimé avec succès'
        ], 204);

    }
}
