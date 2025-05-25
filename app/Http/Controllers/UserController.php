<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Models\CryptoDeposit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display user dashboard with dynamic data
     */
    public function userDashboard()
    {
        // Get the authenticated user with related data
        $user = Auth::user();
                
        return view('userend.index', compact('user'));
    }
    
    /**
     * Log out the user
     */
    public function userDestroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'success'
        );
        return redirect('/login')->with($notification);
    }
    
    /**
     * Display user details
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.admin.users.show', compact('user'));
    }
}