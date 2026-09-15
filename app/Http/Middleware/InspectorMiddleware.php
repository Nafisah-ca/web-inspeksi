<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InspectorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !in_array($request->user()->role, ['inspector', 'admin'])) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}
