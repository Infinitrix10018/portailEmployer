<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventBackHistory
{
    public function handle(Request $request, Closure $next)
    {

        if (!Auth::guard('sanctum')->check()) {
            return redirect()->route('ConnexionEmployer');
        }


        $response = $next($request);

        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }
}