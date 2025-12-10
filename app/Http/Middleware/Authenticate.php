<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Check if the request is for admin area
            if ($request->is('siteadmin/*') || $request->is('siteadmin')) {
                return route('admin-login');
            }

            // Check if the request is for doctor area
            if ($request->is('doctor/*') || $request->is('doctor')) {
                return route('doctor.login');
            }

            // Default redirect to doctor login
            return route('doctor.login');
        }
    }
}
