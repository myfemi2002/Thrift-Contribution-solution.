<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanWallet;
use App\Models\LoanRepayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminLoanController extends Controller
{
    /**
     * Display loans dashboard
     */
    public function index(Request $request)
    {
        $query = Loan::with(['user', 'loanWallet', 'approvedBy']);

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            })->orWhere('loan_id', 'like', '%' . $search . '%');
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get statistics
        $stats = [
            'total_loans' => Loan::count(),
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'active_loans' => Loan::whereIn('status', ['disbursed', 'active'])->count(),
            'overdue_loans' => Loan::where('status', 'overdue')->count(),
            'total_disbursed' => Loan::whereIn('status', ['disbursed', 'active', 'completed', 'overdue'])
                                    ->sum('amount'),
            'total_outstanding' => Loan::whereIn('status', ['disbursed', 'active', 'overdue'])
                                     ->sum('outstanding_balance')
        ];

        return view('backend.loans.index', compact('loans', 'stats'));
    }

    /**
     * Show loan details
     */
    public function show($id)
    {
        $loan = Loan::with(['user', 'loanWallet', 'approvedBy', 'repayments.recordedBy'])
            ->findOrFail($id);

        return view('backend.loans.show', compact('loan'));
    }

    /**
     * Approve loan
     */
    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_notes' => 'nullable|string|max:500',
            'custom_interest_rate' => 'nullable|numeric|min:0|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'pending') {
            return response()->json(['error' => 'Only pending loans can be approved'], 400);
        }

        try {
            DB::beginTransaction();

            // Update custom interest rate if provided
            if ($request->custom_interest_rate) {
                $loan->update([
                    'custom_interest_rate' => $request->custom_interest_rate,
                    'interest_overridden' => true
                ]);
                $loan->calculateLoanAmounts();
                $loan->save();
            }

            $loan->approve(Auth::id(), $request->admin_notes);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Loan approved successfully',
                'loan' => $loan->fresh(['user', 'approvedBy'])
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Failed to approve loan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject loan
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'pending') {
            return response()->json(['error' => 'Only pending loans can be rejected'], 400);
        }

        try {
            $loan->reject(Auth::id(), $request->rejection_reason);

            return response()->json([
                'success' => true,
                'message' => 'Loan rejected successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to reject loan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Disburse loan
     */
    public function disburse($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'approved') {
            return response()->json(['error' => 'Only approved loans can be disbursed'], 400);
        }

        try {
            DB::beginTransaction();

            $loan->disburse(Auth::id());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Loan disbursed successfully',
                'loan' => $loan->fresh(['user', 'loanWallet'])
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Failed to disburse loan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show repayment form
     */
    public function showRepaymentForm($id)
    {
        $loan = Loan::with(['user', 'loanWallet', 'repayments'])
            ->findOrFail($id);

        if (!in_array($loan->status, ['disbursed', 'active', 'overdue'])) {
            return redirect()->route('admin.loans.show', $id)
                ->with('message', 'Cannot record repayment for this loan status')
                ->with('alert-type', 'error');
        }

        return view('backend.loans.repayment', compact('loan'));
    }

    /**
     * Record loan repayment
     */
    public function recordRepayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,card,deduction,other',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
            'payment_date' => 'required|date|before_or_equal:today'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loan = Loan::findOrFail($id);

        if (!in_array($loan->status, ['disbursed', 'active', 'overdue'])) {
            return response()->json(['error' => 'Cannot record repayment for this loan status'], 400);
        }

        if ($request->amount > $loan->outstanding_balance) {
            return response()->json([
                'error' => 'Repayment amount (₦' . number_format($request->amount, 2) . 
                          ') exceeds outstanding balance (₦' . number_format($loan->outstanding_balance, 2) . ')'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $repayment = $loan->recordRepayment(
                Auth::id(),
                $request->amount,
                $request->payment_method,
                $request->reference_number,
                $request->notes
            );

            // Update payment date if different from today
            if ($request->payment_date !== now()->toDateString()) {
                $repayment->update(['payment_date' => $request->payment_date]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Repayment recorded successfully',
                'repayment' => $repayment->load(['user', 'recordedBy']),
                'loan' => $loan->fresh()
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Failed to record repayment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search user for loan assignment
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
            ->with(['wallet', 'loanWallet.activeLoans'])
            ->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get or create loan wallet
        $loanWallet = LoanWallet::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 'active']
        );

        // Get recent loans
        $recentLoans = $loanWallet->loans()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'user' => $user,
            'loan_wallet' => $loanWallet,
            'recent_loans' => $recentLoans,
            'eligibility' => $loanWallet->getEligibilityStatus()
        ]);
    }

    /**
     * Update loan interest rate
     */
    public function updateInterestRate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'interest_rate' => 'required|numeric|min:0|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'pending' && $loan->status !== 'approved') {
            return response()->json(['error' => 'Can only update interest rate for pending or approved loans'], 400);
        }

        try {
            $loan->update([
                'custom_interest_rate' => $request->interest_rate,
                'interest_overridden' => true
            ]);

            $loan->calculateLoanAmounts();
            $loan->save();

            return response()->json([
                'success' => true,
                'message' => 'Interest rate updated successfully',
                'loan' => $loan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update interest rate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get loan statistics
     */
    public function getStats()
    {
        $stats = [
            'total_loans' => Loan::count(),
            'pending_approvals' => Loan::where('status', 'pending')->count(),
            'active_loans' => Loan::whereIn('status', ['disbursed', 'active'])->count(),
            'overdue_loans' => Loan::where('status', 'overdue')->count(),
            'completed_loans' => Loan::where('status', 'completed')->count(),
            'total_disbursed' => Loan::whereIn('status', ['disbursed', 'active', 'completed', 'overdue'])
                                    ->sum('amount'),
            'total_outstanding' => Loan::whereIn('status', ['disbursed', 'active', 'overdue'])
                                     ->sum('outstanding_balance'),
            'total_repaid' => LoanRepayment::where('status', 'completed')->sum('amount'),
            'today_repayments' => LoanRepayment::whereDate('created_at', today())->sum('amount'),
            'this_month_disbursed' => Loan::whereMonth('disbursed_at', now()->month)
                                         ->whereYear('disbursed_at', now()->year)
                                         ->sum('amount')
        ];

        return response()->json(['success' => true, 'stats' => $stats]);
    }

    /**
     * Check and update overdue loans
     */
    public function checkOverdueLoans()
    {
        $activeLoans = Loan::whereIn('status', ['disbursed', 'active'])
            ->where('due_date', '<', now())
            ->get();

        $updatedCount = 0;
        foreach ($activeLoans as $loan) {
            $loan->checkOverdue();
            $updatedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => "Checked {$updatedCount} loans for overdue status"
        ]);
    }

    /**
     * Export loans report
     */
    public function export(Request $request)
    {
        $query = Loan::with(['user', 'loanWallet', 'approvedBy']);
        
        // Apply same filters as index
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $loans = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'data' => $loans,
            'summary' => [
                'total_loans' => $loans->count(),
                'total_amount' => $loans->sum('amount'),
                'total_outstanding' => $loans->sum('outstanding_balance'),
                'export_date' => now()->toDateTimeString()
            ]
        ]);
    }

    /**
     * Get pending loans count (for notifications)
     */
    public function getPendingCount()
    {
        $count = Loan::where('status', 'pending')->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Bulk approve loans
     */
    public function bulkApprove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_ids' => 'required|array',
            'loan_ids.*' => 'exists:loans,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $approvedCount = 0;
            $loans = Loan::whereIn('id', $request->loan_ids)
                        ->where('status', 'pending')
                        ->get();

            foreach ($loans as $loan) {
                $loan->approve(Auth::id(), 'Bulk approved');
                $approvedCount++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully approved {$approvedCount} loans"
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Failed to bulk approve loans: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show loan wallet details
     */
    public function showLoanWallet($userId)
    {
        $user = User::findOrFail($userId);
        $loanWallet = LoanWallet::where('user_id', $userId)->first();

        if (!$loanWallet) {
            $loanWallet = LoanWallet::create([
                'user_id' => $userId,
                'status' => 'active'
            ]);
        }

        $loans = $loanWallet->loans()
            ->with(['approvedBy', 'repayments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backend.loans.wallet', compact('user', 'loanWallet', 'loans'));
    }
}
