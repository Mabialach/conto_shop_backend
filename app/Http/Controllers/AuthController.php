<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'nom' => 'required|max:255',
            'prenoms' => 'nullable|max:255',
            'email' => 'required|email|unique:users',
            'mot_de_passe' => 'required',
            'telephone' => 'nullable|max:50',
            'adresse' => 'nullable|max:255',
            'photo_profil' => 'nullable|string',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenoms' => $request->prenoms,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'photo_profil' => $request->photo_profil,
            'role_id' => $request->role_id,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->mot_de_passe, $user->mot_de_passe)){
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnecté avec succès !']);
    }

    public function me(Request $request){
        return response()->json($request->user());
    }
}