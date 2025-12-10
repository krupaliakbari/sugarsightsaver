<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;

class CheckDoctorStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole('doctor')) {
            $user = Auth::user();
$adminEmail = Setting::get('site_email', 'admin@sugarsightsaver.com');
            // Check if doctor is inactive
            if ($user->status === 'deactive') {
                // Logout the user
                Auth::logout();

                // Clear the session
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Redirect to login with message
                return redirect()->route('doctor.login')
                    ->with(
                        'error',
                        "Your account has been deactivated by the administrator. Please contact the administrator at {$adminEmail}."
                    );
            }
        }

        return $next($request);
    }
}
