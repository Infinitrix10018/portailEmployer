<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        //Log::info(Auth::user());

        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }
        
        return redirect()->route('ConnexionEmployer')->with('erreur', 'Role Non Autorisé');
    }
}
