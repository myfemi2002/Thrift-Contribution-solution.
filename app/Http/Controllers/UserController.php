<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DailyContribution;
use App\Models\WalletAdjustment;
use Illuminate\Http\Request;
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
        $user = Auth::user();
        
        // Ensure user has a wallet
        if (!$user->wallet) {
            \App\Models\Wallet::create([
                'user_id' => $user->id,
                'balance' => 0.00,
                'total_contributions' => 0.00,
                'status' => 'active'
            ]);
            $user->refresh();
        }

        // Get recent transaction history (contributions + adjustments)
        $recentTransactions = $this->getRecentTransactions($user);

        // Get corrected monthly statistics
        $monthlyStats = $this->getCorrectedMonthlyStats($user);

        // Get calendar data for current month
        $currentMonth = now()->format('Y-m');
        $calendarData = $this->getCalendarData($user, $currentMonth);

        // Get recent notifications
        $notifications = $this->getRecentNotifications($user);

        // Get corrected wallet summary
        $walletSummary = [
            'current_balance' => $user->wallet->balance,
            'total_contributions' => $user->wallet->getActualTotalContributions(), // Use corrected total
            'this_month_contributions' => $monthlyStats['total_amount'], // Use corrected monthly amount
            'completion_rate' => $this->getCompletionRate($user)
        ];

        return view('userend.index', compact(
            'user',
            'recentTransactions',
            'monthlyStats',
            'calendarData',
            'notifications',
            'walletSummary'
        ));
    }

    /**
     * Get corrected monthly statistics (fixed version)
     */
    // private function getCorrectedMonthlyStats($user)
    // {
    //     $currentMonth = now();
        
    //     // Get actual contributions for this month
    //     $monthlyContributions = $user->contributions()
    //         ->whereMonth('contribution_date', $currentMonth->month)
    //         ->whereYear('contribution_date', $currentMonth->year)
    //         ->get();

    //     // Get monthly adjustments that affect contribution totals
    //     $monthlyAdjustments = $user->wallet->adjustments()
    //         ->whereMonth('created_at', $currentMonth->month)
    //         ->whereYear('created_at', $currentMonth->year)
    //         ->where('status', 'completed')
    //         ->get();

    //     // Calculate actual monthly total (excluding wrong adjustments)
    //     $contributionsAmount = $monthlyContributions->where('status', 'paid')->sum('amount');
        
    //     // Add legitimate omitted contributions
    //     $omittedContributions = $monthlyAdjustments
    //         ->where('type', 'credit')
    //         ->where('reason', 'omitted_contribution')
    //         ->sum('amount');
        
    //     // Subtract corrections that shouldn't count as contributions
    //     $corrections = $monthlyAdjustments
    //         ->where('type', 'debit')
    //         ->whereIn('reason', ['correction_error', 'refund', 'penalty', 'duplicate_payment'])
    //         ->sum('amount');

    //     $actualMonthlyTotal = $contributionsAmount + $omittedContributions - $corrections;
    //     $paidDaysCount = $monthlyContributions->where('status', 'paid')->where('amount', '>', 0)->count();
    //     $unpaidDaysCount = $monthlyContributions->where('status', 'unpaid')->count() + 
    //                       $monthlyContributions->where('amount', '<=', 0)->count();

    //     return [
    //         'total_days' => $monthlyContributions->count(),
    //         'paid_days' => $paidDaysCount,
    //         'unpaid_days' => $unpaidDaysCount,
    //         'total_amount' => $actualMonthlyTotal, // Corrected amount
    //         'average_daily' => $paidDaysCount > 0 ? ($actualMonthlyTotal / $paidDaysCount) : 0,
    //         'completion_rate' => $monthlyContributions->count() > 0 
    //             ? ($paidDaysCount / $monthlyContributions->count()) * 100 
    //             : 0,
    //         'month_name' => $currentMonth->format('F Y'),
    //         'breakdown' => [
    //             'raw_contributions' => $contributionsAmount,
    //             'omitted_additions' => $omittedContributions,
    //             'corrections_subtracted' => $corrections,
    //             'net_adjustments' => $omittedContributions - $corrections
    //         ]
    //     ];
    // }

    /**
     * Get recent transactions (contributions + adjustments)
     */
    // private function getRecentTransactions($user, $limit = 10)
    // {
    //     $transactions = collect();

    //     // Get recent contributions
    //     $contributions = $user->contributions()
    //         ->orderBy('created_at', 'desc')
    //         ->take($limit)
    //         ->get()
    //         ->map(function($contribution) {
    //             return [
    //                 'id' => $contribution->transaction_id,
    //                 'type' => 'contribution',
    //                 'title' => 'Daily Contribution',
    //                 'description' => 'Contribution for ' . $contribution->contribution_date->format('M d, Y'),
    //                 'amount' => $contribution->amount,
    //                 'status' => $contribution->status,
    //                 'date' => $contribution->created_at,
    //                 'icon' => $contribution->amount > 0 ? 'ni-plus-circle' : 'ni-minus-circle',
    //                 'color' => $contribution->amount > 0 ? 'success' : 'warning',
    //                 'reference' => $contribution->transaction_id
    //             ];
    //         });

    //     // Get recent wallet adjustments
    //     $adjustments = WalletAdjustment::where('user_id', $user->id)
    //         ->where('status', 'completed')
    //         ->orderBy('created_at', 'desc')
    //         ->take($limit)
    //         ->get()
    //         ->map(function($adjustment) {
    //             return [
    //                 'id' => $adjustment->adjustment_id,
    //                 'type' => 'adjustment_' . $adjustment->type,
    //                 'title' => ucfirst(str_replace('_', ' ', $adjustment->reason)),
    //                 'description' => $adjustment->description,
    //                 'amount' => $adjustment->type === 'credit' ? $adjustment->amount : -$adjustment->amount,
    //                 'status' => $adjustment->status,
    //                 'date' => $adjustment->created_at,
    //                 'icon' => $adjustment->type === 'credit' ? 'ni-arrow-up' : 'ni-arrow-down',
    //                 'color' => $adjustment->type === 'credit' ? 'info' : 'danger',
    //                 'reference' => $adjustment->adjustment_id
    //             ];
    //         });

    //     // Combine and sort by date
    //     return $transactions->concat($contributions)
    //         ->concat($adjustments)
    //         ->sortByDesc('date')
    //         ->take($limit)
    //         ->values();
    // }

/**
     * Get corrected monthly statistics for dashboard
     */
    private function getMonthlyStats($user)
    {
        $currentMonth = now();
        
        // Get actual contributions for this month
        $monthlyContributions = $user->contributions()
            ->whereMonth('contribution_date', $currentMonth->month)
            ->whereYear('contribution_date', $currentMonth->year)
            ->get();

        // Get monthly adjustments that affect contribution totals
        $monthlyAdjustments = $user->wallet->adjustments()
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->where('status', 'completed')
            ->get();

        // Calculate actual monthly total (excluding wrong adjustments)
        $contributionsAmount = $monthlyContributions->where('status', 'paid')->sum('amount');
        
        // Add legitimate omitted contributions
        $omittedContributions = $monthlyAdjustments
            ->where('type', 'credit')
            ->where('reason', 'omitted_contribution')
            ->sum('amount');
        
        // Subtract corrections that shouldn't count as contributions
        $corrections = $monthlyAdjustments
            ->where('type', 'debit')
            ->whereIn('reason', ['correction_error', 'refund', 'penalty', 'duplicate_payment'])
            ->sum('amount');

        $actualMonthlyTotal = $contributionsAmount + $omittedContributions - $corrections;
        $paidDaysCount = $monthlyContributions->where('status', 'paid')->where('amount', '>', 0)->count();
        $unpaidDaysCount = $monthlyContributions->where('status', 'unpaid')->count() + 
                          $monthlyContributions->where('amount', '<=', 0)->count();

        return [
            'total_days' => $monthlyContributions->count(),
            'paid_days' => $paidDaysCount,
            'unpaid_days' => $unpaidDaysCount,
            'total_amount' => $actualMonthlyTotal, // Corrected amount
            'average_daily' => $paidDaysCount > 0 ? ($actualMonthlyTotal / $paidDaysCount) : 0,
            'completion_rate' => $monthlyContributions->count() > 0 
                ? ($paidDaysCount / $monthlyContributions->count()) * 100 
                : 0,
            'month_name' => $currentMonth->format('F Y'),
            'breakdown' => [
                'raw_contributions' => $contributionsAmount,
                'omitted_additions' => $omittedContributions,
                'corrections_subtracted' => $corrections
            ]
        ];
    }

    /**
     * Get calendar data for current month
     */
    private function getCalendarData($user, $month)
    {
        $monthDate = Carbon::parse($month);
        $startDate = $monthDate->copy()->startOfMonth();
        $endDate = $monthDate->copy()->endOfMonth();
        
        $contributions = $user->contributions()
            ->whereBetween('contribution_date', [$startDate, $endDate])
            ->get()
            ->keyBy(function($item) {
                return $item->contribution_date->format('Y-m-d');
            });

        $calendarData = [];
        
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dateKey = $date->format('Y-m-d');
            $contribution = $contributions->get($dateKey);
            
            $calendarData[$dateKey] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->day,
                'has_contribution' => !is_null($contribution),
                'amount' => $contribution ? (float)$contribution->amount : 0,
                'status' => $contribution ? $contribution->status : 'no-record',
                'is_weekend' => $date->isWeekend(),
                'is_today' => $date->isToday(),
                'is_future' => $date->isFuture(),
                'contribution_id' => $contribution ? $contribution->id : null,
                'transaction_id' => $contribution ? $contribution->transaction_id : null
            ];
        }
        
        return $calendarData;
    }

    /**
     * Get recent notifications
     */
    // private function getRecentNotifications($user)
    // {
    //     $notifications = collect();

    //     // Recent contributions (last 7 days)
    //     $recentContributions = $user->contributions()
    //         ->where('created_at', '>=', now()->subDays(7))
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     foreach ($recentContributions as $contribution) {
    //         $notifications->push([
    //             'type' => $contribution->amount > 0 ? 'contribution_paid' : 'contribution_missed',
    //             'title' => $contribution->amount > 0 ? 'Contribution Recorded' : 'Contribution Missed',
    //             'message' => $contribution->amount > 0 
    //                 ? "Daily contribution of ₦" . number_format($contribution->amount, 2) . " recorded"
    //                 : "Missed daily contribution for " . $contribution->contribution_date->format('M d'),
    //             'icon' => $contribution->amount > 0 ? 'ni-check-circle' : 'ni-alert-circle',
    //             'color' => $contribution->amount > 0 ? 'success' : 'warning',
    //             'date' => $contribution->created_at,
    //             'time_ago' => $contribution->created_at->diffForHumans()
    //         ]);
    //     }

    //     // Recent adjustments (last 7 days)
    //     $recentAdjustments = WalletAdjustment::where('user_id', $user->id)
    //         ->where('created_at', '>=', now()->subDays(7))
    //         ->where('status', 'completed')
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     foreach ($recentAdjustments as $adjustment) {
    //         $notifications->push([
    //             'type' => 'wallet_adjustment',
    //             'title' => 'Wallet Adjustment',
    //             'message' => ucfirst(str_replace('_', ' ', $adjustment->reason)) . " - " . 
    //                        ($adjustment->type === 'credit' ? '+' : '-') . 
    //                        "₦" . number_format($adjustment->amount, 2),
    //             'icon' => $adjustment->type === 'credit' ? 'ni-arrow-up' : 'ni-arrow-down',
    //             'color' => $adjustment->type === 'credit' ? 'info' : 'danger',
    //             'date' => $adjustment->created_at,
    //             'time_ago' => $adjustment->created_at->diffForHumans()
    //         ]);
    //     }

    //     return $notifications->sortByDesc('date')->take(10)->values();
    // }

    /**
     * Get completion rate for current month
     */
    private function getCompletionRate($user)
    {
        $currentMonth = now();
        $contributions = $user->contributions()
            ->whereMonth('contribution_date', $currentMonth->month)
            ->whereYear('contribution_date', $currentMonth->year)
            ->get();

        if ($contributions->count() === 0) {
            return 0;
        }

        return ($contributions->where('status', 'paid')->count() / $contributions->count()) * 100;
    }

 /**
     * Get wallet balance for AJAX updates (updated to include corrected amounts)
     */
    public function getWalletBalance()
    {
        $user = Auth::user();
        
        if (!$user->wallet) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet not found'
            ], 404);
        }

        // Get corrected monthly contributions
        $currentMonth = now();
        $monthlyContributions = $user->contributions()
            ->whereMonth('contribution_date', $currentMonth->month)
            ->whereYear('contribution_date', $currentMonth->year)
            ->get();

        $monthlyAdjustments = $user->wallet->adjustments()
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->where('status', 'completed')
            ->get();

        // Calculate corrected monthly total
        $rawMonthContributions = $monthlyContributions->where('status', 'paid')->sum('amount');
        $omittedContributions = $monthlyAdjustments
            ->where('type', 'credit')
            ->where('reason', 'omitted_contribution')
            ->sum('amount');
        $corrections = $monthlyAdjustments
            ->where('type', 'debit')
            ->whereIn('reason', ['correction_error', 'refund', 'penalty', 'duplicate_payment'])
            ->sum('amount');

        $correctedMonthContributions = $rawMonthContributions + $omittedContributions - $corrections;

        return response()->json([
            'success' => true,
            'balance' => $user->wallet->balance,
            'total_contributions' => $user->wallet->total_contributions, // Legacy field for compatibility
            'actual_total_contributions' => $user->wallet->getActualTotalContributions(), // Correct total
            'month_contributions' => $correctedMonthContributions, // Corrected monthly amount
            'month_breakdown' => [
                'raw_contributions' => $rawMonthContributions,
                'omitted_additions' => $omittedContributions,
                'corrections_subtracted' => $corrections,
                'net_adjustments' => $omittedContributions - $corrections
            ],
            'explanation' => [
                'note' => 'Use actual_total_contributions and month_contributions for accurate display',
                'legacy_total' => $user->wallet->total_contributions,
                'corrected_total' => $user->wallet->getActualTotalContributions(),
                'difference' => $user->wallet->getActualTotalContributions() - $user->wallet->total_contributions,
                'monthly_raw' => $rawMonthContributions,
                'monthly_corrected' => $correctedMonthContributions
            ]
        ]);
    }

    /**
     * Show user contribution calendar
     */
    public function contributionCalendar(Request $request)
    {
        $user = Auth::user();
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        
        $calendarData = $this->getCalendarData($user, $selectedMonth);
        $monthlyStats = $this->getMonthlyStats($user);

        return view('userend.contributions.calendar', compact(
            'user',
            'calendarData',
            'selectedMonth',
            'monthlyStats'
        ));
    }

/**
     * Show contribution history
     */
    public function contributionHistory(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->contributions()->with('agent');
        
        // Apply filters
        if ($request->has('month') && $request->month) {
            $monthDate = Carbon::parse($request->month);
            $query->whereMonth('contribution_date', $monthDate->month)
                  ->whereYear('contribution_date', $monthDate->year);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $contributions = $query->orderBy('contribution_date', 'desc')->paginate(20);
        
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        $monthDate = Carbon::parse($selectedMonth);
        
        // Get corrected monthly summary
        $monthlyContributions = $user->contributions()
            ->whereMonth('contribution_date', $monthDate->month)
            ->whereYear('contribution_date', $monthDate->year)
            ->get();

        // Get monthly adjustments for the selected month
        $monthlyAdjustments = $user->wallet->adjustments()
            ->whereMonth('created_at', $monthDate->month)
            ->whereYear('created_at', $monthDate->year)
            ->where('status', 'completed')
            ->get();

        // Calculate corrected totals
        $rawContributions = $monthlyContributions->where('status', 'paid')->sum('amount');
        $omittedContributions = $monthlyAdjustments
            ->where('type', 'credit')
            ->where('reason', 'omitted_contribution')
            ->sum('amount');
        $corrections = $monthlyAdjustments
            ->where('type', 'debit')
            ->whereIn('reason', ['correction_error', 'refund', 'penalty', 'duplicate_payment'])
            ->sum('amount');

        $monthlySummary = [
            'total_amount' => $rawContributions + $omittedContributions - $corrections,
            'raw_contributions' => $rawContributions,
            'adjustments' => [
                'omitted' => $omittedContributions,
                'corrections' => $corrections,
                'net' => $omittedContributions - $corrections
            ],
            'paid_days' => $monthlyContributions->where('status', 'paid')->where('amount', '>', 0)->count(),
            'unpaid_days' => $monthlyContributions->where('status', 'unpaid')->count() + 
                           $monthlyContributions->where('amount', '<=', 0)->count()
        ];

        return view('userend.contributions.history', compact(
            'contributions',
            'monthlySummary',
            'selectedMonth'
        ));
    }

    /**
     * Show user wallet details
     */
    // public function walletDetails()
    // {
    //     $user = Auth::user();
        
    //     if (!$user->wallet) {
    //         return redirect()->route('user.dashboard')->with('error', 'Wallet not found');
    //     }

    //     $recentTransactions = $this->getRecentTransactions($user, 20);
    //     $monthlyStats = $this->getMonthlyStats($user);

    //     return view('userend.wallet.details', compact(
    //         'user',
    //         'recentTransactions',
    //         'monthlyStats'
    //     ));
    // }

    /**
     * Show user wallet details
     */
    public function walletDetails()
    {
        $user = Auth::user();
        
        if (!$user->wallet) {
            return redirect()->route('user.dashboard')->with('error', 'Wallet not found');
        }

        $recentTransactions = $this->getRecentTransactions($user, 20);
        
        // Get corrected monthly statistics
        $monthlyStats = $this->getCorrectedMonthlyStats($user);

        return view('userend.wallet.details', compact(
            'user',
            'recentTransactions',
            'monthlyStats'
        ));
    }

    /**
     * Get corrected monthly statistics that exclude wrong adjustments
     */
    private function getCorrectedMonthlyStats($user)
    {
        $currentMonth = now();
        
        // Get actual contributions for this month
        $monthlyContributions = $user->contributions()
            ->whereMonth('contribution_date', $currentMonth->month)
            ->whereYear('contribution_date', $currentMonth->year)
            ->get();

        // Get monthly adjustments (only those that should count toward contributions)
        $monthlyAdjustments = $user->wallet->adjustments()
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->where('status', 'completed')
            ->get();

        // Calculate actual monthly total
        $contributionsAmount = $monthlyContributions->where('status', 'paid')->sum('amount');
        
        // Add omitted contributions for this month
        $omittedContributions = $monthlyAdjustments
            ->where('type', 'credit')
            ->where('reason', 'omitted_contribution')
            ->sum('amount');
        
        // Subtract corrections/refunds for this month
        $corrections = $monthlyAdjustments
            ->where('type', 'debit')
            ->whereIn('reason', ['correction_error', 'refund', 'penalty', 'duplicate_payment'])
            ->sum('amount');

        $actualMonthlyTotal = $contributionsAmount + $omittedContributions - $corrections;

        return [
            'total_days' => $monthlyContributions->count(),
            'paid_days' => $monthlyContributions->where('status', 'paid')->where('amount', '>', 0)->count(),
            'unpaid_days' => $monthlyContributions->where('status', 'unpaid')->count() + 
                           $monthlyContributions->where('amount', '<=', 0)->count(),
            'total_amount' => $actualMonthlyTotal, // This is the corrected amount
            'raw_contributions' => $contributionsAmount,
            'monthly_adjustments' => [
                'omitted_contributions' => $omittedContributions,
                'corrections' => $corrections,
                'net_adjustments' => $omittedContributions - $corrections
            ],
            'average_daily' => $monthlyContributions->where('status', 'paid')->where('amount', '>', 0)->avg('amount') ?? 0,
            'completion_rate' => $monthlyContributions->count() > 0 
                ? ($monthlyContributions->where('status', 'paid')->where('amount', '>', 0)->count() / $monthlyContributions->count()) * 100 
                : 0,
            'month_name' => $currentMonth->format('F Y')
        ];
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
     * Get recent transactions (contributions + adjustments + withdrawals)
     */
    private function getRecentTransactions($user, $limit = 10)
    {
        $transactions = collect();

        // Get recent contributions
        $contributions = $user->contributions()
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->map(function($contribution) {
                return [
                    'id' => $contribution->transaction_id,
                    'type' => 'contribution',
                    'title' => 'Daily Contribution',
                    'description' => 'Contribution for ' . $contribution->contribution_date->format('M d, Y'),
                    'amount' => $contribution->amount,
                    'status' => $contribution->status,
                    'date' => $contribution->created_at,
                    'icon' => $contribution->amount > 0 ? 'ni-plus-circle' : 'ni-minus-circle',
                    'color' => $contribution->amount > 0 ? 'success' : 'warning',
                    'reference' => $contribution->transaction_id
                ];
            });

        // Get recent wallet adjustments
        $adjustments = WalletAdjustment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->map(function($adjustment) {
                return [
                    'id' => $adjustment->adjustment_id,
                    'type' => 'adjustment_' . $adjustment->type,
                    'title' => ucfirst(str_replace('_', ' ', $adjustment->reason)),
                    'description' => $adjustment->description,
                    'amount' => $adjustment->type === 'credit' ? $adjustment->amount : -$adjustment->amount,
                    'status' => $adjustment->status,
                    'date' => $adjustment->created_at,
                    'icon' => $adjustment->type === 'credit' ? 'ni-arrow-up' : 'ni-arrow-down',
                    'color' => $adjustment->type === 'credit' ? 'info' : 'danger',
                    'reference' => $adjustment->adjustment_id
                ];
            });

        // Get recent withdrawals
        $withdrawals = $user->withdrawals()
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->map(function($withdrawal) {
                return [
                    'id' => $withdrawal->withdrawal_id,
                    'type' => 'withdrawal',
                    'title' => 'Withdrawal Request',
                    'description' => 'Withdrawal via ' . $withdrawal->payment_method_label . ' - ' . ucfirst($withdrawal->status),
                    'amount' => -$withdrawal->amount, // Negative because it's money going out
                    'status' => $withdrawal->status,
                    'date' => $withdrawal->created_at,
                    'icon' => 'ni-send',
                    'color' => $this->getWithdrawalColor($withdrawal->status),
                    'reference' => $withdrawal->withdrawal_id
                ];
            });

        // Combine and sort by date
        return $transactions->concat($contributions)
            ->concat($adjustments)
            ->concat($withdrawals)
            ->sortByDesc('date')
            ->take($limit)
            ->values();
    }

    /**
     * Get recent notifications including withdrawals
     */
   /**
     * Get recent notifications (limited and organized)
     */
    private function getRecentNotifications($user, $limit = 5)
    {
        $notifications = collect();

        // Recent contributions (last 7 days) - limit to 3 most recent
        $recentContributions = $user->contributions()
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($recentContributions as $contribution) {
            $notifications->push([
                'type' => $contribution->amount > 0 ? 'contribution_paid' : 'contribution_missed',
                'title' => $contribution->amount > 0 ? 'Contribution Recorded' : 'Contribution Missed',
                'message' => $contribution->amount > 0 
                    ? "Daily contribution of ₦" . number_format($contribution->amount, 2) . " recorded"
                    : "Missed daily contribution for " . $contribution->contribution_date->format('M d'),
                'icon' => $contribution->amount > 0 ? 'ni-check-circle' : 'ni-alert-circle',
                'color' => $contribution->amount > 0 ? 'success' : 'warning',
                'date' => $contribution->created_at,
                'time_ago' => $contribution->created_at->diffForHumans(),
                'reference' => $contribution->transaction_id
            ]);
        }

        // Recent adjustments (last 7 days) - limit to 2 most recent
        $recentAdjustments = WalletAdjustment::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($recentAdjustments as $adjustment) {
            $notifications->push([
                'type' => 'adjustment_' . $adjustment->type,
                'title' => 'Wallet Adjustment',
                'message' => ucfirst(str_replace('_', ' ', $adjustment->reason)) . " - " . 
                           ($adjustment->type === 'credit' ? '+' : '-') . 
                           "₦" . number_format($adjustment->amount, 2),
                'icon' => $adjustment->type === 'credit' ? 'ni-arrow-up' : 'ni-arrow-down',
                'color' => $adjustment->type === 'credit' ? 'info' : 'danger',
                'date' => $adjustment->created_at,
                'time_ago' => $adjustment->created_at->diffForHumans(),
                'reference' => $adjustment->adjustment_id
            ]);
        }

        // Mock withdrawal notifications (replace with actual withdrawal model when available)
        // This is just for demonstration - remove when you implement actual withdrawals
        if (rand(1, 10) > 7) { // Random chance for demo
            $notifications->push([
                'type' => 'withdrawal_pending',
                'title' => 'Withdrawal Request',
                'message' => 'Your withdrawal request of ₦' . number_format(25000, 2) . ' is pending approval',
                'icon' => 'ni-wallet-out',
                'color' => 'warning',
                'date' => now()->subHours(2),
                'time_ago' => now()->subHours(2)->diffForHumans(),
                'reference' => 'WTH-' . strtoupper(uniqid()),
                'withdrawal_id' => 'WTH-' . strtoupper(uniqid())
            ]);
        }

        return $notifications->sortByDesc('date')->take($limit);
    }

    /**
     * Get withdrawal status color
     */
    private function getWithdrawalColor($status)
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'info',
            'processing' => 'primary',
            'completed' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary'
        ];

        return $colors[$status] ?? 'secondary';
    }

    /**
     * Get withdrawal notification title
     */
    private function getWithdrawalNotificationTitle($status)
    {
        $titles = [
            'pending' => 'Withdrawal Pending',
            'approved' => 'Withdrawal Approved',
            'processing' => 'Withdrawal Processing',
            'completed' => 'Withdrawal Completed',
            'rejected' => 'Withdrawal Rejected',
            'cancelled' => 'Withdrawal Cancelled'
        ];

        return $titles[$status] ?? 'Withdrawal Update';
    }

    /**
     * Get withdrawal notification message
     */
    private function getWithdrawalNotificationMessage($withdrawal)
    {
        $amount = "₦" . number_format($withdrawal->amount, 2);
        
        switch ($withdrawal->status) {
            case 'pending':
                return "Your withdrawal request of {$amount} is awaiting admin approval";
            case 'approved':
                return "Your withdrawal of {$amount} has been approved and deducted from your wallet";
            case 'processing':
                return "Your withdrawal of {$amount} is being processed for payment";
            case 'completed':
                return "Your withdrawal of {$amount} has been completed successfully";
            case 'rejected':
                return "Your withdrawal request of {$amount} was rejected";
            case 'cancelled':
                return "Your withdrawal request of {$amount} was cancelled";
            default:
                return "Withdrawal status updated: {$amount}";
        }
    }

    /**
     * Get withdrawal notification icon
     */
    private function getWithdrawalNotificationIcon($status)
    {
        $icons = [
            'pending' => 'ni-clock',
            'approved' => 'ni-check-circle',
            'processing' => 'ni-loader',
            'completed' => 'ni-check-double',
            'rejected' => 'ni-cross-circle',
            'cancelled' => 'ni-na'
        ];

        return $icons[$status] ?? 'ni-send';
    }
    
}