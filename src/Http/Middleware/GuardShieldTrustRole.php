<?php

namespace Larakeeps\GuardShield\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuardShieldTrustRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role)
    {

        $user = $request->user();

        if(!$user)
            abort(403, "Access Unauthorized!");

        $roles = $user->roles()->whereIn('name', $role);

        if($roles->doesntExist())
            abort(403, "Access Unauthorized!");

        return $next($request);
    }
}
