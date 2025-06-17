<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string|string[] $roles Ex: 'superadmin' ou 'admin,superadmin'
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if(!$user || !in_array($user->role->nom ?? '', $roles)){
            return response()->json(['message' => 'Accès Non Autorisé !'], 403);
        }

        return $next($request);
    }
}
