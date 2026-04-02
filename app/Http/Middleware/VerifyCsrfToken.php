<?php

namespace App\Http\Middleware;

use Closure;

class VerifyCsrfToken
{
    public function handle($request, Closure $next)
    {
        if (in_array($request->method(), ['HEAD', 'GET', 'OPTIONS'])) {
            return $next($request);
        }

        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
        if (!hash_equals($_SESSION['_csrf_token'], $token)) {
            abort(419, 'CSRF token mismatch.');
        }

        return $next($request);
    }
}