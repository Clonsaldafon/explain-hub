<?php

namespace Users\Middleware;

use Closure;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!isset($_SESSION['user_id'])) {
            return redirect('/login');
        }

        return $next($request);
    }
}