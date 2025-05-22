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
        
        // Get user wallet balance
        $wallet = UserWallet::where('user_id', $user->id)->with('motherWallet')->first();
        
        // Get total confirmed deposits
        $totalDeposits = CryptoDeposit::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->sum('amount');
            
        // Get pending deposits
        $pendingDeposits = CryptoDeposit::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');
            
        // Get rejected deposits
        $rejectedDeposits = CryptoDeposit::where('user_id', $user->id)
            ->where('status', 'rejected')
            ->sum('amount');
            
        // Get recent deposits with pagination
        $recentDeposits = CryptoDeposit::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        // Calculate the deposit stats by month for the chart
        $depositsByMonth = CryptoDeposit::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Format chart data
        $chartMonths = [];
        $chartValues = [];
        
        foreach ($depositsByMonth as $deposit) {
            $monthName = date('M', mktime(0, 0, 0, $deposit->month, 1));
            $chartMonths[] = $monthName . ' ' . $deposit->year;
            $chartValues[] = round($deposit->total, 2);
        }
        
        // Format the last login time
        $lastLogin = $user->last_login_at ? Carbon::parse($user->last_login_at)->diffForHumans() : 'Never';
        
        // Format the join date
        $joinDate = $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A';
        
        // Prepare the dashboard data
        $dashboardData = [
            'wallet' => $wallet,
            'balance' => $wallet ? $wallet->balance : 0,
            'walletAddress' => $wallet && $wallet->motherWallet ? $wallet->motherWallet->wallet_address : 'Not assigned',
            'totalDeposits' => $totalDeposits,
            'pendingDeposits' => $pendingDeposits,
            'rejectedDeposits' => $rejectedDeposits,
            'lastLogin' => $lastLogin,
            'joinDate' => $joinDate,
            'ipAddress' => $user->registration_ip ?? $user->last_login_ip ?? request()->ip(),
            'userAgent' => $user->user_agent ?? request()->userAgent(),
            'chartMonths' => json_encode($chartMonths),
            'chartValues' => json_encode($chartValues),
        ];
        
        return view('userend.index', compact('user', 'dashboardData', 'recentDeposits'));
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