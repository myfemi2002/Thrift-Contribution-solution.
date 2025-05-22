<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Role
{
    /**
     * Public routes that should bypass role checks
     */
    protected $publicRoutes = [
        'auths/register',
        'auths/register/*',
        'login',
        'logout',
        'password/reset',
        'password/email'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Allow public routes to bypass role check
        foreach ($this->publicRoutes as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Please login to access this page')
                ->with('alert-type', 'error');
        }

        // Get authenticated user
        $user = Auth::user();

        // Check if the user's role matches the expected role
        if ($user->role !== $role) {
            // Redirect based on user's role
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin/dashboard')
                        ->with('message', 'Access denied. Redirected to admin dashboard')
                        ->with('alert-type', 'error');

                case 'user':
                    return redirect('/user/dashboard')
                        ->with('message', 'Access denied. Redirected to user dashboard')
                        ->with('alert-type', 'error');

                case 'attendee':
                    return redirect('/attendee/dashboard')
                        ->with('message', 'Access denied. Redirected to attendee dashboard')
                        ->with('alert-type', 'error');

                // Uncomment if needed
                // case 'doctor':
                //     return redirect('/doctor/dashboard')
                //         ->with('message', 'Access denied. Redirected to doctor dashboard')
                //         ->with('alert-type', 'error');

                // case 'nurse':
                //     return redirect('/nurse/dashboard')
                //         ->with('message', 'Access denied. Redirected to nurse dashboard')
                //         ->with('alert-type', 'error');

                default:
                    return redirect('/dashboard')
                        ->with('message', 'Access denied. Insufficient permissions')
                        ->with('alert-type', 'error');
            }
        }

        return $next($request);
    }
}