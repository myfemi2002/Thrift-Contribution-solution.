<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        // Authenticate the user
        $request->authenticate();
    
        // Get the authenticated user
        $user = $request->user();
    
        // Update last login information
        $user->last_login_at = now();
        $user->last_login_ip = $request->ip();
        $user->last_login_browser = $this->getBrowser($request->header('User-Agent'));
        $user->last_login_device = $this->getDevice($request->header('User-Agent'));
        $user->last_login_os = $this->getOS($request->header('User-Agent'));
        $user->last_login_location = $this->getLocation($request->ip());
        $user->is_logged_in = 1;
        $user->failed_login_attempts = 0; // Reset failed attempts on successful login
        $user->save();
    
        // Regenerate the session after authentication
        $request->session()->regenerate();
    
        // Define roles and their corresponding dashboard URLs
        $roles = [
            'admin' => 'admin/dashboard',
            'user' => 'user/dashboard', 
        ];
    
        // Retrieve the user's role
        $userRole = $user->role;
    
        // Determine the dashboard URL based on the user's role
        $url = $roles[$userRole] ?? '';
    
        // Notification message for successful login
        $notification = [
            'message' => 'Login Successfully',
            'alert-type' => 'success',
        ];
    
        // Redirect to the intended URL with the notification
        return redirect()->intended($url)->with($notification);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Get the user before logging out
        $user = Auth::user();
        
        // Perform logout
        Auth::guard('web')->logout();
        
        // Update user login status if user exists
        if ($user) {
            $user->is_logged_in = 0;
            $user->save();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    /**
     * Extract browser information from User Agent
     */
    private function getBrowser($userAgent)
    {
        $browser = 'Unknown';
        
        if (preg_match('/MSIE/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Edge';
        }
        
        return $browser;
    }

    /**
     * Extract device type from User Agent
     */
    private function getDevice($userAgent)
    {
        $device = 'Desktop';
        
        if (preg_match('/mobile|android|touch|iphone|ipad|tablet|samsung/i', $userAgent)) {
            $device = 'Mobile';
            
            if (preg_match('/tablet|ipad/i', $userAgent)) {
                $device = 'Tablet';
            }
        }
        
        return $device;
    }

    /**
     * Extract operating system from User Agent
     */
    private function getOS($userAgent)
    {
        $os = 'Unknown';
        
        if (preg_match('/windows|win32|win64/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $os = 'Mac OS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iphone|ipad/i', $userAgent)) {
            $os = 'iOS';
        }
        
        return $os;
    }

    /**
     * Get location information from IP (basic implementation)
     * For more accurate geolocation, consider using a third-party service
     */
    private function getLocation($ip)
    {
        // For local development
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'Local Development';
        }
        
        // Basic implementation - for a full solution, consider using:
        // - ip-api.com
        // - ipinfo.io
        // - maxmind.com GeoIP database
        try {
            // You may want to implement a proper IP geolocation service here
            // For now, we'll just return the IP address
            return $ip;
            
            // Example with a third-party service (would require additional setup):
            // $response = Http::get("https://ipinfo.io/{$ip}/json");
            // $data = $response->json();
            // return $data['city'] . ', ' . $data['region'] . ', ' . $data['country'];
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
}