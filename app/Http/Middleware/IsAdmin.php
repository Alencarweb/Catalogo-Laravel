<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            // Verifica se a requisição espera JSON (API/AJAX)
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Acesso não autorizado.'], 403);
            }

            // Se for web (HTML), redireciona
            return redirect('/')->with('error', 'Acesso não autorizado.');
        }

        return $next($request);
    }
          

}
