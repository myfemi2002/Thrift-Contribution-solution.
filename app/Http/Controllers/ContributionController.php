<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Wallet;
use App\Models\DailyContribution;
use App\Models\ContributionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ContributionController extends Controller
{
    /**
     * Display contribution dashboard
     */
    public function index(Request $request)
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $selectedMonth = $request->get('month', $currentMonth);
        
        // Get monthly statistics
        $monthlyStats = $this->getMonthlyStats($selectedMonth);
        
        // Get recent contributions
        $recentContributions = DailyContribution::with(['user', 'agent'])
            ->whereMonth('contribution_date', Carbon::parse($selectedMonth)->month)
            ->whereYear('contribution_date', Carbon::parse($selectedMonth)->year)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backend.contributions.index', compact(
            'monthlyStats', 
            'recentContributions', 
            'selectedMonth'
        ));
    }

    /**
     * Show daily contribution recording form
     */
    public function create()
    {
        return view('backend.contributions.create');
    }

    /**
     * Search for user to record contribution
     */
    public function searchUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_query' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Search query is required'], 400);
        }

        $query = $request->search_query;
        
        $user = User::where('role', 'user')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('email', 'like', '%' . $query . '%')
                  ->orWhere('phone', 'like', '%' . $query . '%')
                  ->orWhere('username', 'like', '%' . $query . '%');
            })
            ->with('wallet')
            ->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if user already has contribution for today
        $today = Carbon::today();
        $existingContribution = $user->getContributionForDate($today);

        return response()->json([
            'user' => $user,
            'existing_contribution' => $existingContribution
        ]);
    }

    /**
     * Store daily contribution
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'contribution_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,card',
            'receipt_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($request->user_id);
        $contributionDate = Carbon::parse($request->contribution_date);

        // Check if user already has contribution for this date
        if ($user->hasContributionForDate($contributionDate)) {
            $existingContribution = $user->getContributionForDate($contributionDate);
            return response()->json([
                'error' => 'User already has a contribution record for this date',
                'existing_contribution' => $existingContribution
            ], 400);
        }

        // Ensure user has wallet
        $wallet = $user->wallet;
        if (!$wallet) {
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0.00,
                'total_contributions' => 0.00,
                'status' => 'active'
            ]);
        }

        try {
            DB::beginTransaction();

            $contribution = DailyContribution::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'agent_id' => Auth::id(),
                'amount' => $request->amount,
                'contribution_date' => $contributionDate,
                'status' => $request->amount > 0 ? 'paid' : 'unpaid',
                'payment_method' => $request->payment_method,
                'receipt_number' => $request->receipt_number,
                'notes' => $request->notes
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Contribution recorded successfully',
                'contribution' => $contribution->load(['user', 'agent'])
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to record contribution'], 500);
        }
    }

 
/**
     * Show user contribution calendar
     */
    public function contributionCalendar(Request $request)
    {
        $user = Auth::user();
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        
        $calendarData = $this->getCalendarData($user, $selectedMonth);
        $monthlyStats = $this->getCorrectedCalendarMonthlyStats($user, $selectedMonth);

        return view('userend.contributions.calendar', compact(
            'user',
            'calendarData',
            'selectedMonth',
            'monthlyStats'
        ));
    }

    /**
     * Get corrected monthly statistics for calendar
     */
    private function getCorrectedCalendarMonthlyStats($user, $selectedMonth)
    {
        $monthDate = Carbon::parse($selectedMonth);
        
        // Get actual contributions for selected month
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

        // Calculate corrected monthly total
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
        $totalDays = $monthlyContributions->count();

        return [
            'total_days' => $totalDays,
            'paid_days' => $paidDaysCount,
            'unpaid_days' => $unpaidDaysCount,
            'total_amount' => $actualMonthlyTotal, // Corrected amount
            'average_daily' => $paidDaysCount > 0 ? ($actualMonthlyTotal / $paidDaysCount) : 0,
            'completion_rate' => $totalDays > 0 ? ($paidDaysCount / $totalDays) * 100 : 0,
            'month_name' => $monthDate->format('F Y'),
            'breakdown' => [
                'raw_contributions' => $contributionsAmount,
                'omitted_additions' => $omittedContributions,
                'corrections_subtracted' => $corrections,
                'net_adjustments' => $omittedContributions - $corrections
            ]
        ];
    }

    /**
     * Show calendar view for specific user
     */
    public function calendar(Request $request)
    {
        $users = User::where('role', 'user')->with('wallet')->get();
        $selectedUserId = $request->get('user_id');
        $selectedMonth = $request->get('month', Carbon::now()->format('Y-m'));
        
        $calendarData = [];
        
        if ($selectedUserId) {
            $user = User::findOrFail($selectedUserId);
            $calendarData = $this->getCalendarData($user, $selectedMonth);
            
            // Debug: Log the contributions for this user and month
            $monthDate = Carbon::parse($selectedMonth);
            $contributions = $user->contributions()
                ->whereMonth('contribution_date', $monthDate->month)
                ->whereYear('contribution_date', $monthDate->year)
                ->get();
            
            \Log::info('Calendar Debug', [
                'user_id' => $selectedUserId,
                'month' => $selectedMonth,
                'contributions_count' => $contributions->count(),
                'contributions' => $contributions->toArray(),
                'calendar_data_sample' => collect($calendarData)->take(5)->toArray()
            ]);
        }

        return view('backend.contributions.calendar', compact(
            'users', 
            'selectedUserId', 
            'selectedMonth', 
            'calendarData'
        ));
    }

    /**
     * Show transaction logs
     */
    public function logs(Request $request)
    {
        $query = ContributionLog::with(['user', 'agent', 'contribution'])
            ->orderBy('created_at', 'desc');

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by agent
        if ($request->has('agent_id') && $request->agent_id) {
            $query->where('agent_id', $request->agent_id);
        }

        $logs = $query->paginate(20);
        $agents = User::where('role', 'admin')->get();

        return view('backend.contributions.logs', compact('logs', 'agents'));
    }

    /**
     * Get user wallet details
     */
    public function wallet($userId)
    {
        $user = User::with(['wallet', 'contributions' => function($q) {
            $q->orderBy('contribution_date', 'desc')->take(10);
        }])->findOrFail($userId);

        return view('backend.contributions.wallet', compact('user'));
    }

    /**
     * Debug API endpoint to check contribution data
     */
    public function debugContributions(Request $request)
    {
        $userId = $request->get('user_id');
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        
        if (!$userId) {
            return response()->json(['error' => 'User ID required'], 400);
        }
        
        $user = User::with('wallet')->findOrFail($userId);
        $monthDate = Carbon::parse($month);
        
        $contributions = $user->contributions()
            ->whereMonth('contribution_date', $monthDate->month)
            ->whereYear('contribution_date', $monthDate->year)
            ->orderBy('contribution_date')
            ->get();
        
        $totalAmount = $contributions->sum('amount');
        $paidCount = $contributions->where('status', 'paid')->where('amount', '>', 0)->count();
        $unpaidCount = $contributions->where('amount', '<=', 0)->count();
        
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ],
            'month' => $month,
            'wallet_balance' => $user->wallet ? $user->wallet->balance : 0,
            'total_contributions' => $user->wallet ? $user->wallet->total_contributions : 0,
            'monthly_stats' => [
                'total_amount' => $totalAmount,
                'paid_days' => $paidCount,
                'unpaid_days' => $unpaidCount,
                'total_records' => $contributions->count()
            ],
            'contributions' => $contributions->map(function($contrib) {
                return [
                    'id' => $contrib->id,
                    'transaction_id' => $contrib->transaction_id,
                    'date' => $contrib->contribution_date->format('Y-m-d'),
                    'amount' => (float)$contrib->amount,
                    'status' => $contrib->status,
                    'payment_method' => $contrib->payment_method
                ];
            })
        ]);
    }
    public function export(Request $request)
    {
        $format = $request->get('format', 'pdf'); // pdf or excel
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $userId = $request->get('user_id');

        // Implementation for PDF/Excel export would go here
        // For now, return JSON data that could be used for export
        
        $query = DailyContribution::with(['user', 'agent'])
            ->whereMonth('contribution_date', Carbon::parse($month)->month)
            ->whereYear('contribution_date', Carbon::parse($month)->year);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $contributions = $query->orderBy('contribution_date', 'desc')->get();
        
        return response()->json([
            'data' => $contributions,
            'summary' => [
                'total_amount' => $contributions->sum('amount'),
                'paid_count' => $contributions->where('status', 'paid')->count(),
                'unpaid_count' => $contributions->where('status', 'unpaid')->count(),
                'month' => $month
            ]
        ]);
    }

    /**
     * Get monthly statistics
     */
    private function getMonthlyStats($month)
    {
        $monthDate = Carbon::parse($month);
        
        $contributions = DailyContribution::whereMonth('contribution_date', $monthDate->month)
            ->whereYear('contribution_date', $monthDate->year)
            ->get();

        return [
            'total_contributions' => $contributions->count(),
            'total_amount' => $contributions->sum('amount'),
            'paid_contributions' => $contributions->where('status', 'paid')->count(),
            'unpaid_contributions' => $contributions->where('status', 'unpaid')->count(),
            'unique_contributors' => $contributions->pluck('user_id')->unique()->count(),
            'average_daily_amount' => $contributions->count() > 0 ? $contributions->sum('amount') / $contributions->count() : 0
        ];
    }

    /**
     * Get calendar data for user
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
                'transaction_id' => $contribution ? $contribution->transaction_id : null,
                'payment_method' => $contribution ? $contribution->payment_method : null
            ];
        }
        
        return $calendarData;
    }
}