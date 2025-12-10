<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticatedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('signin');
        } else {
            $user = Auth::user();
            
            // For patients, redirect to plan creation
            if ($user->hasRole('patient')) {
                return redirect('plan/create');
            } else {
                // For admin and doctor users, check profile completion
                if (!isset($user->profile) && !$request->is('siteadmin/user/settings') && !$request->is('siteadmin/user/updateprofile') && !$request->is('siteadmin/logout')):
                    return redirect('siteadmin/user/settings');
                endif;
            }
        } 

        return $next($request);
    }
}
