<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanWallet;
use App\Models\LoanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserLoanController extends Controller
{
    /**
     * Display user loan dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure user has loan wallet
        $loanWallet = LoanWallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'balance' => 0.00,
                'total_borrowed' => 0.00,
                'total_repaid' => 0.00,
                'status' => 'active'
            ]
        );

        // Get loan statistics
        $loanStats = [
            'active_loans' => $loanWallet->activeLoans()->count(),
            'total_borrowed' => $loanWallet->total_borrowed,
            'total_repaid' => $loanWallet->total_repaid,
            'current_balance' => $loanWallet->balance,
            'total_outstanding' => $loanWallet->total_outstanding
        ];

        // Get recent loans
        $recentLoans = $loanWallet->loans()
            ->with(['approvedBy', 'repayments'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get eligibility status
        $eligibility = $loanWallet->getEligibilityStatus();

        // Get notifications
        $notifications = LoanNotification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('userend.loans.index', compact(
            'loanWallet',
            'loanStats',
            'recentLoans',
            'eligibility',
            'notifications'
        ));
    }

    /**
     * Show loan application form
     */
    // public function create()
    // {
    //     $user = Auth::user();
    //     $loanWallet = LoanWallet::firstOrCreate(
    //         ['user_id' => $user->id],
    //         ['status' => 'active']
    //     );

    //     $eligibility = $loanWallet->getEligibilityStatus();

    //     if (!$eligibility['eligible']) {
    //         return redirect()->route('user.loans.index')
    //             ->with('message', $eligibility['reason'])
    //             ->with('alert-type', 'error');
    //     }

    //     // Get user's credit rating for interest rate
    //     $profile = $user->profile ?? [];
    //     $interestRate = $profile['loan_interest_rate'] ?? 10.0;
    //     $creditRating = $profile['credit_rating'] ?? null;

    //     return view('userend.loans.create', compact('loanWallet', 'interestRate', 'creditRating'));
    // }

    /**
     * Store loan application
     */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'amount' => 'required|numeric|min:1000|max:500000',
    //         'purpose' => 'required|string|max:500'
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $user = Auth::user();
    //     $loanWallet = LoanWallet::where('user_id', $user->id)->first();

    //     if (!$loanWallet) {
    //         return redirect()->back()
    //             ->with('message', 'Loan wallet not found')
    //             ->with('alert-type', 'error');
    //     }

    //     $eligibility = $loanWallet->getEligibilityStatus();
    //     if (!$eligibility['eligible']) {
    //         return redirect()->back()
    //             ->with('message', $eligibility['reason'])
    //             ->with('alert-type', 'error');
    //     }

    //     try {
    //         // Get user's interest rate
    //         $profile = $user->profile ?? [];
    //         $interestRate = $profile['loan_interest_rate'] ?? 10.0;

    //         $loan = Loan::create([
    //             'user_id' => $user->id,
    //             'loan_wallet_id' => $loanWallet->id,
    //             'amount' => $request->amount,
    //             'interest_rate' => $interestRate,
    //             'purpose' => $request->purpose,
    //             'duration_days' => 30
    //         ]);

    //         return redirect()->route('user.loans.show', $loan->id)
    //             ->with('message', 'Loan application submitted successfully!')
    //             ->with('alert-type', 'success');

    //     } catch (\Exception $e) {
    //         return redirect()->back()
    //             ->with('message', 'Failed to submit loan application: ' . $e->getMessage())
    //             ->with('alert-type', 'error');
    //     }
    // }

    /**
     * Show specific loan details
     */
    public function show($id)
    {
        try {
            $loan = Loan::with(['user', 'loanWallet', 'approvedBy', 'repayments.recordedBy'])
                ->where('user_id', Auth::id())
                ->findOrFail($id);

            return view('userend.loans.show', compact('loan'));
            
        } catch (\Exception $e) {
            return redirect()->route('user.loans.index')
                ->with('message', 'Loan not found or you do not have permission to view it')
                ->with('alert-type', 'error');
        }
    }

    /**
     * Show loan history
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $loanWallet = LoanWallet::where('user_id', $user->id)->first();

        if (!$loanWallet) {
            // Create loan wallet if it doesn't exist
            $loanWallet = LoanWallet::create([
                'user_id' => $user->id,
                'balance' => 0.00,
                'total_borrowed' => 0.00,
                'total_repaid' => 0.00,
                'status' => 'active'
            ]);
            $loans = collect();
        } else {
            $query = $loanWallet->loans()->with(['approvedBy', 'repayments']);

            // Filter by status
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // Filter by date range
            if ($request->has('date_from') && $request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to') && $request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $loans = $query->orderBy('created_at', 'desc')->paginate(15);
        }

        return view('userend.loans.history', compact('loans', 'loanWallet'));
    }

    /**
     * Calculate loan details (AJAX)
     */
    // public function calculateLoan(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'amount' => 'required|numeric|min:1000'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $user = Auth::user();
    //     $profile = $user->profile ?? [];
    //     $interestRate = $profile['loan_interest_rate'] ?? 10.0;
        
    //     $amount = $request->amount;
    //     $interestAmount = ($amount * $interestRate) / 100;
    //     $totalAmount = $amount + $interestAmount;

    //     // Calculate repayment dates
    //     $disbursementDate = now()->addWeekday();
    //     $repaymentStartDate = $disbursementDate->copy()->addWeekdays(2);
    //     $dueDate = $disbursementDate->copy()->addDays(30);

    //     return response()->json([
    //         'success' => true,
    //         'calculation' => [
    //             'principal_amount' => $amount,
    //             'interest_rate' => $interestRate,
    //             'interest_amount' => $interestAmount,
    //             'total_amount' => $totalAmount,
    //             'disbursement_date' => $disbursementDate->format('M d, Y'),
    //             'repayment_start_date' => $repaymentStartDate->format('M d, Y'),
    //             'due_date' => $dueDate->format('M d, Y'),
    //             'duration_days' => 30
    //         ]
    //     ]);
    // }

    /**
     * Get user notifications (AJAX)
     */
    public function getNotifications()
    {
        $notifications = LoanNotification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    /**
     * Get popup notifications (AJAX)
     */
    public function getPopupNotifications()
    {
        $popupNotifications = LoanNotification::where('user_id', Auth::id())
            ->unshownPopups()
            ->orderBy('created_at', 'desc')
            ->get();

        // Mark as shown
        LoanNotification::where('user_id', Auth::id())
            ->unshownPopups()
            ->update(['popup_shown' => true]);

        return response()->json([
            'success' => true,
            'notifications' => $popupNotifications
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markNotificationAsRead($id)
    {
        $notification = LoanNotification::where('user_id', Auth::id())
            ->findOrFail($id);
        
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead()
    {
        LoanNotification::where('user_id', Auth::id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json(['success' => true]);
    }


    

/**
 * Show loan application form
 */
public function create()
{
    $user = Auth::user();
    $loanWallet = LoanWallet::firstOrCreate(
        ['user_id' => $user->id],
        ['status' => 'active']
    );

    $eligibility = $loanWallet->getEligibilityStatus();

    if (!$eligibility['eligible']) {
        return redirect()->route('user.loans.index')
            ->with('message', $eligibility['reason'])
            ->with('alert-type', 'error');
    }

    // Get user's credit rating for interest rate from profile
    $interestRate = $user->loan_interest_rate; // Uses the accessor from User model
    $creditRating = $user->credit_rating; // Uses the accessor from User model

    return view('userend.loans.create', compact('loanWallet', 'interestRate', 'creditRating'));
}

    /**
     * Store loan application
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1000|max:500000',
            'purpose' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $loanWallet = LoanWallet::where('user_id', $user->id)->first();

        if (!$loanWallet) {
            return redirect()->back()
                ->with('message', 'Loan wallet not found')
                ->with('alert-type', 'error');
        }

        $eligibility = $loanWallet->getEligibilityStatus();
        if (!$eligibility['eligible']) {
            return redirect()->back()
                ->with('message', $eligibility['reason'])
                ->with('alert-type', 'error');
        }

        try {
            // Get user's interest rate from profile
            $interestRate = $user->loan_interest_rate; // Uses the accessor

            $loan = Loan::create([
                'user_id' => $user->id,
                'loan_wallet_id' => $loanWallet->id,
                'amount' => $request->amount,
                'interest_rate' => $interestRate,
                'purpose' => $request->purpose,
                'duration_days' => 30
            ]);

            return redirect()->route('user.loans.show', $loan->id)
                ->with('message', 'Loan application submitted successfully!')
                ->with('alert-type', 'success');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('message', 'Failed to submit loan application: ' . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }

    /**
     * Calculate loan details (AJAX) - Updated to use user's profile
     */
    public function calculateLoan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $interestRate = $user->loan_interest_rate; // Uses the accessor from User model
        
        $amount = $request->amount;
        $interestAmount = ($amount * $interestRate) / 100;
        $totalAmount = $amount + $interestAmount;

        // Calculate repayment dates
        $disbursementDate = now()->addWeekday();
        $repaymentStartDate = $disbursementDate->copy()->addWeekdays(2);
        $dueDate = $disbursementDate->copy()->addDays(30);

        return response()->json([
            'success' => true,
            'calculation' => [
                'principal_amount' => $amount,
                'interest_rate' => $interestRate,
                'interest_amount' => $interestAmount,
                'total_amount' => $totalAmount,
                'disbursement_date' => $disbursementDate->format('M d, Y'),
                'repayment_start_date' => $repaymentStartDate->format('M d, Y'),
                'due_date' => $dueDate->format('M d, Y'),
                'duration_days' => 30,
                'credit_rating' => $user->credit_rating
            ]
        ]);
    }
}