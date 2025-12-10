<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            // Check if the request is for admin area
            if ($request->is('siteadmin/*') || $request->is('siteadmin')) {
                return redirect('/siteadmin/login');
            }

            // Check if the request is for doctor area
            if ($request->is('doctor/*') || $request->is('doctor')) {
                return redirect('/doctor/login');
            }

            // Default redirect to doctor login
            return redirect('/doctor/login');
        } else {
            $user = Auth::user();
            
            // Check if user has any of the required roles
            if (!$user->hasAnyRole($roles)) {
                // For frontend users (patients), redirect to plan creation
                if ($user->hasRole('patient')) {
                    return redirect('plan/create');
                } else {
                    return redirect('siteadmin');
                }
            }
        }

        return $next($request);
    }
}
