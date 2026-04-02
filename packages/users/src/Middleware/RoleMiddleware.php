<?php

namespace Users\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!isset($_SESSION['user_role'])) {
          return redirect('/login');
        }

        $userRole = $_SESSION['user_role'];
        if (!in_array($userRole, $roles)) {
            abort(403, "Permission denied");
        }

        return $next($request);
    }
}