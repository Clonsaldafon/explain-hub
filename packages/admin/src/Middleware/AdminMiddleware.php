<?php

namespace Admin\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // checkout auth
        if (!isset($_SESSION['user_id'])) {
            return redirect('/login');
        }

        // not admin brooo
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            abort(403, 'Доступ запрещен');
        }

        return $next($request);
    }
}