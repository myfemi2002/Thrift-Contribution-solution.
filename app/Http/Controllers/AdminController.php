<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan;
use App\Models\Withdrawal;
use App\Models\DailyContribution;
use App\Models\WalletAdjustment;
use App\Models\LoanWallet;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\LoanRepayment;

class AdminController extends Controller
{
    public function index()
    {
        // Get comprehensive statistics
        $stats = $this->getComprehensiveStats();
        
        // Get monthly trends data for charts
        $monthlyTrendsData = $this->getMonthlyTrendsData();
        
        // Get loan status distribution
        $loanStatusData = $this->getLoanStatusDistribution();
        
        // Get pending items that need attention
        $pendingItems = $this->getPendingItems();
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities();
        
        // Get top contributors for this month
        $topContributors = $this->getTopContributors();
        
        // Get growth metrics
        $growthMetrics = $this->getGrowthMetrics();

        return view('admin.index', compact(
            'stats',
            'monthlyTrendsData', 
            'loanStatusData',
            'pendingItems',
            'recentActivities',
            'topContributors',
            'growthMetrics'
        ));
    }

    /**
     * Get comprehensive dashboard statistics
     */
    private function getComprehensiveStats()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        return [
            // User Statistics
            'total_users' => User::where('role', 'user')->count(),
            'active_users' => User::where('role', 'user')->where('status', 'active')->count(),
            'new_users_this_month' => User::where('role', 'user')
                ->whereMonth('created_at', $currentMonth->month)
                ->whereYear('created_at', $currentMonth->year)
                ->count(),
            'user_growth_percentage' => $this->calculateGrowthPercentage(
                User::where('role', 'user')->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count(),
                User::where('role', 'user')->whereMonth('created_at', $currentMonth->month)->whereYear('created_at', $currentMonth->year)->count()
            ),

            // Contribution Statistics
            'total_contributions_all_time' => DailyContribution::where('status', 'paid')->sum('amount'),
            'total_contributions_month' => DailyContribution::where('status', 'paid')
                ->whereMonth('contribution_date', $currentMonth->month)
                ->whereYear('contribution_date', $currentMonth->year)
                ->sum('amount'),
            'total_contributions_today' => DailyContribution::where('status', 'paid')
                ->whereDate('contribution_date', Carbon::today())
                ->sum('amount'),
            'contribution_growth_percentage' => $this->calculateContributionGrowth(),

            // Loan Statistics
            'total_loans' => Loan::count(),
            'active_loans' => Loan::whereIn('status', ['disbursed', 'active'])->count(),
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'overdue_loans' => Loan::where('status', 'overdue')->count(),
            'total_disbursed' => Loan::whereIn('status', ['disbursed', 'active', 'completed', 'overdue'])->sum('amount'),
            'total_outstanding' => Loan::whereIn('status', ['disbursed', 'active', 'overdue'])->sum('outstanding_balance'),
            'monthly_loan_disbursement' => Loan::whereMonth('disbursed_at', $currentMonth->month)
                ->whereYear('disbursed_at', $currentMonth->year)
                ->sum('amount'),

            // Wallet Statistics
            'total_wallet_balance' => Wallet::sum('balance'),
            'total_wallets' => Wallet::count(),
            'active_wallets' => Wallet::where('status', 'active')->count(),

            // Withdrawal Statistics
            'total_withdrawals' => Withdrawal::count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'total_withdrawn' => Withdrawal::where('status', 'completed')->sum('amount'),
            'monthly_withdrawals' => Withdrawal::whereMonth('created_at', $currentMonth->month)
                ->whereYear('created_at', $currentMonth->year)
                ->sum('amount'),

            // Adjustment Statistics
            'pending_adjustments' => WalletAdjustment::where('status', 'pending')->count(),
            'total_adjustments' => WalletAdjustment::where('status', 'completed')->count(),
            'monthly_adjustments' => WalletAdjustment::where('status', 'completed')
                ->whereMonth('created_at', $currentMonth->month)
                ->whereYear('created_at', $currentMonth->year)
                ->count(),

            // Financial Health Metrics
            'total_revenue' => $this->calculateTotalRevenue(),
            'platform_health_score' => $this->calculatePlatformHealthScore(),
        ];
    }

    /**
     * Get monthly trends data for charts
     */
    private function getMonthlyTrendsData()
    {
        $data = [];
        $data[] = ['Month', 'Contributions', 'Loans', 'Withdrawals'];
        
        // Get last 6 months data
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            
            $contributions = DailyContribution::where('status', 'paid')
                ->whereMonth('contribution_date', $month->month)
                ->whereYear('contribution_date', $month->year)
                ->sum('amount');
                
            $loans = Loan::whereMonth('disbursed_at', $month->month)
                ->whereYear('disbursed_at', $month->year)
                ->sum('amount');
                
            $withdrawals = Withdrawal::where('status', 'completed')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('amount');
            
            $data[] = [
                $month->format('M Y'),
                (float)$contributions,
                (float)$loans,
                (float)$withdrawals
            ];
        }
        
        return $data;
    }

    /**
     * Get loan status distribution for pie chart
     */
    private function getLoanStatusDistribution()
    {
        $data = [];
        $data[] = ['Status', 'Count'];
        
        $statuses = ['pending', 'approved', 'disbursed', 'active', 'completed', 'overdue', 'rejected'];
        
        foreach ($statuses as $status) {
            $count = Loan::where('status', $status)->count();
            if ($count > 0) {
                $data[] = [ucfirst($status), $count];
            }
        }
        
        return $data;
    }

    /**
     * Get pending items that need attention
     */
    private function getPendingItems()
    {
        return [
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'pending_adjustments' => WalletAdjustment::where('status', 'pending')->count(),
            'overdue_loans' => Loan::where('status', 'overdue')->count(),
            'high_priority_items' => $this->getHighPriorityItems(),
        ];
    }

    /**
     * Get recent activities across the platform
     */
    private function getRecentActivities()
    {
        $activities = collect();

        // Recent contributions
        $recentContributions = DailyContribution::with('user')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($contribution) {
                return [
                    'title' => 'Daily Contribution',
                    'user' => $contribution->user->name ?? 'Unknown',
                    'amount' => $contribution->amount,
                    'status' => $contribution->status,
                    'color' => $contribution->status === 'paid' ? 'success' : 'warning',
                    'icon' => 'fa-coins',
                    'time' => $contribution->created_at,
                ];
            });

        // Recent loans
        $recentLoans = Loan::with('user')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function($loan) {
                return [
                    'title' => 'Loan Application',
                    'user' => $loan->user->name ?? 'Unknown',
                    'amount' => $loan->amount,
                    'status' => $loan->status,
                    'color' => $this->getLoanStatusColor($loan->status),
                    'icon' => 'fa-money-bill',
                    'time' => $loan->created_at,
                ];
            });

        // Recent withdrawals
        $recentWithdrawals = Withdrawal::with('user')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function($withdrawal) {
                return [
                    'title' => 'Withdrawal Request',
                    'user' => $withdrawal->user->name ?? 'Unknown',
                    'amount' => $withdrawal->amount,
                    'status' => $withdrawal->status,
                    'color' => $this->getWithdrawalStatusColor($withdrawal->status),
                    'icon' => 'fa-hand-holding-usd',
                    'time' => $withdrawal->created_at,
                ];
            });

        return $activities->concat($recentContributions)
            ->concat($recentLoans)
            ->concat($recentWithdrawals)
            ->sortByDesc('time')
            ->take(10)
            ->values();
    }

    /**
     * Get top contributors for current month
     */
    private function getTopContributors()
    {
        $currentMonth = Carbon::now();
        
        return User::where('role', 'user')
            ->with(['contributions' => function($query) use ($currentMonth) {
                $query->where('status', 'paid')
                    ->whereMonth('contribution_date', $currentMonth->month)
                    ->whereYear('contribution_date', $currentMonth->year);
            }])
            ->get()
            ->map(function($user) {
                $monthlyContribution = $user->contributions->sum('amount');
                return (object)[
                    'name' => $user->name,
                    'email' => $user->email,
                    'monthly_contribution' => $monthlyContribution,
                ];
            })
            ->where('monthly_contribution', '>', 0)
            ->sortByDesc('monthly_contribution')
            ->take(10)
            ->values();
    }

    /**
     * Get growth metrics
     */
    private function getGrowthMetrics()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
        
        return [
            'user_growth' => $this->calculateGrowthPercentage(
                User::where('role', 'user')->whereMonth('created_at', $lastMonth->month)->count(),
                User::where('role', 'user')->whereMonth('created_at', $currentMonth->month)->count()
            ),
            'contribution_growth' => $this->calculateContributionGrowth(),
            'loan_growth' => $this->calculateLoanGrowth(),
            'withdrawal_growth' => $this->calculateWithdrawalGrowth(),
        ];
    }

    /**
     * Helper method to calculate growth percentage
     */
    private function calculateGrowthPercentage($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100, 2);
    }

    /**
     * Calculate contribution growth
     */
    private function calculateContributionGrowth()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
        
        $currentMonthContributions = DailyContribution::where('status', 'paid')
            ->whereMonth('contribution_date', $currentMonth->month)
            ->whereYear('contribution_date', $currentMonth->year)
            ->sum('amount');
            
        $lastMonthContributions = DailyContribution::where('status', 'paid')
            ->whereMonth('contribution_date', $lastMonth->month)
            ->whereYear('contribution_date', $lastMonth->year)
            ->sum('amount');
            
        return $this->calculateGrowthPercentage($lastMonthContributions, $currentMonthContributions);
    }

    /**
     * Calculate loan growth
     */
    private function calculateLoanGrowth()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
        
        $currentMonthLoans = Loan::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();
            
        $lastMonthLoans = Loan::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
            
        return $this->calculateGrowthPercentage($lastMonthLoans, $currentMonthLoans);
    }

    /**
     * Calculate withdrawal growth
     */
    private function calculateWithdrawalGrowth()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
        
        $currentMonthWithdrawals = Withdrawal::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->sum('amount');
            
        $lastMonthWithdrawals = Withdrawal::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('amount');
            
        return $this->calculateGrowthPercentage($lastMonthWithdrawals, $currentMonthWithdrawals);
    }

    /**
     * Calculate total platform revenue
     */
    private function calculateTotalRevenue()
    {
        // Calculate from loan repayments and withdrawal fees
        $loanRepayments = LoanRepayment::where('status', 'completed')->sum('amount');
        $withdrawalFees = Withdrawal::where('status', 'completed')->sum('fee');
        
        // Calculate interest from loans (difference between total amount and principal)
        $totalLoanAmount = Loan::whereIn('status', ['completed', 'active', 'disbursed'])->sum('total_amount');
        $principalAmount = Loan::whereIn('status', ['completed', 'active', 'disbursed'])->sum('amount');
        $estimatedInterest = $totalLoanAmount - $principalAmount;
        
        return $withdrawalFees + $estimatedInterest;
    }

    /**
     * Calculate platform health score
     */
    private function calculatePlatformHealthScore()
    {
        $totalLoans = Loan::count();
        $overdueLoans = Loan::where('status', 'overdue')->count();
        $activeUsers = User::where('role', 'user')->where('status', 'active')->count();
        $totalUsers = User::where('role', 'user')->count();
        
        $loanHealthScore = $totalLoans > 0 ? (($totalLoans - $overdueLoans) / $totalLoans) * 100 : 100;
        $userHealthScore = $totalUsers > 0 ? ($activeUsers / $totalUsers) * 100 : 100;
        
        return round(($loanHealthScore + $userHealthScore) / 2, 1);
    }

    /**
     * Get high priority items that need immediate attention
     */
    private function getHighPriorityItems()
    {
        return [
            'loans_pending_over_24h' => Loan::where('status', 'pending')
                ->where('created_at', '<', Carbon::now()->subDay())
                ->count(),
            'large_withdrawals_pending' => Withdrawal::where('status', 'pending')
                ->where('amount', '>', 100000)
                ->count(),
            'overdue_loans_over_7_days' => Loan::where('status', 'overdue')
                ->where('due_date', '<', Carbon::now()->subDays(7))
                ->count(),
        ];
    }

    /**
     * Get loan status color for UI
     */
    private function getLoanStatusColor($status)
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'info',
            'disbursed' => 'primary',
            'active' => 'success',
            'completed' => 'success',
            'overdue' => 'danger',
            'rejected' => 'secondary',
        ];
        
        return $colors[$status] ?? 'secondary';
    }

    /**
     * Get withdrawal status color for UI
     */
    private function getWithdrawalStatusColor($status)
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'info',
            'processing' => 'primary',
            'completed' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
        ];
        
        return $colors[$status] ?? 'secondary';
    }


















    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

    public function AdminDestroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = [
            'message' => 'Logout Successfully',
            'alert-type' => 'success'
        ];
        
        return redirect('/login')->with($notification);
    }
}