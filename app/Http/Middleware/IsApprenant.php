<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsApprenant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'apprenant') {
            abort(403, 'Accès réservé aux apprenants.');
        }

        return $next($request);
    }
}
