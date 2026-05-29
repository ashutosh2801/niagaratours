<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized access.');
        }

        $routeName = $request->route()->getName();
        $routeName = str_replace('admin.', '', $routeName);
        $baseRoute = explode('.', $routeName)[0] ?? '';

        if ($baseRoute === 'dashboard' || $baseRoute === '') {
            if ($user->is_admin || $user->hasPermission('dashboard')) {
                return $next($request);
            }
            abort(403, 'Unauthorized access.');
        }

        if ($user->hasPermission($baseRoute)) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}
