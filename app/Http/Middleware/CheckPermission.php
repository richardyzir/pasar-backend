<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $module, $action = 'view')
    {
        $user = $request->user();

        if ($user->role === 'master') return $next($request);

        $perm = $user->permissions()->where('module', $module)->first();

        if ($perm && $perm->{'can_' . $action}) {
            return $next($request);
        }

        return response()->json(['error' => 'Forbidden'], 403);
    }
}
