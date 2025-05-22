<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Allow access to registration routes even when authenticated
                if ($request->is('auths/register') || $request->is('auths/register/*')) {
                    return $next($request);
                }

                // Get user role once
                $userRole = Auth::user()->role;

                // Use switch statement for better readability and performance
                switch ($userRole) {
                    case 'attendee':
                        return redirect('/attendee/dashboard')
                            ->with('message', 'Already logged in as Attendee')
                            ->with('alert-type', 'info');

                    case 'user':
                        return redirect('/user/dashboard')
                            ->with('message', 'Already logged in as User')
                            ->with('alert-type', 'info');

                    case 'admin':
                        return redirect('/admin/dashboard')
                            ->with('message', 'Already logged in as Admin')
                            ->with('alert-type', 'info');

                    // Uncomment if needed
                    // case 'doctor':
                    //     return redirect('/doctor/dashboard')
                    //         ->with('message', 'Already logged in as Doctor')
                    //         ->with('alert-type', 'info');

                    // case 'nurse':
                    //     return redirect('/nurse/dashboard')
                    //         ->with('message', 'Already logged in as Nurse')
                    //         ->with('alert-type', 'info');

                    default:
                        return redirect('/dashboard')
                            ->with('message', 'Already logged in')
                            ->with('alert-type', 'info');
                }
            }
        }

        return $next($request);
    }
}