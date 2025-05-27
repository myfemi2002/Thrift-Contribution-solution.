<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminWithdrawalController extends Controller
{
    /**
     * Display all withdrawal requests
     */
    public function index(Request $request)
    {
        $query = Withdrawal::with(['user', 'wallet', 'approvedBy']);
        
        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $withdrawals = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get statistics
        $stats = [
            'total_requests' => Withdrawal::count(),
            'pending_requests' => Withdrawal::pending()->count(),
            'total_amount_pending' => Withdrawal::pending()->sum('amount'),
            'total_completed' => Withdrawal::completed()->sum('amount'),
            'total_rejected' => Withdrawal::rejected()->count()
        ];

        return view('backend.withdrawals.index', compact('withdrawals', 'stats'));
    }

    /**
     * Show withdrawal details
     */
    // public function show($id)
    // {
    //     $withdrawal = Withdrawal::with(['user', 'wallet', 'approvedBy'])->findOrFail($id);
        
    //     return view('backend.withdrawals.show', compact('withdrawal'));
    // }

    /**
     * Show withdrawal details (returns HTML for AJAX modal)
     */
    /**
     * Show withdrawal details
     */
    public function show($id)
    {
        try {
            $withdrawal = Withdrawal::with(['user', 'wallet', 'approvedBy'])
                ->findOrFail($id);
            
            // If this is an AJAX request (for modal), return partial view
            if (request()->ajax()) {
                return view('backend.withdrawals.show-modal', compact('withdrawal'))->render();
            }
            
            // Otherwise return full page view
            return view('backend.withdrawals.show', compact('withdrawal'));
            
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'error' => 'Withdrawal not found',
                    'message' => $e->getMessage()
                ], 404);
            }
            
            return redirect()->route('admin.withdrawals.index')
                ->with('message', 'Withdrawal not found')
                ->with('alert-type', 'error');
        }
    }

    /**
     * Approve withdrawal request
     */
    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $withdrawal = Withdrawal::findOrFail($id);
        
        if (!$withdrawal->isPending()) {
            return response()->json(['error' => 'Only pending withdrawals can be approved'], 400);
        }

        // Check if user still has sufficient balance
        $currentBalance = $withdrawal->wallet->balance;
        if ($withdrawal->amount > $currentBalance) {
            return response()->json([
                'error' => 'Insufficient wallet balance. Current: ₦' . number_format($currentBalance, 2) . 
                          ', Requested: ₦' . number_format($withdrawal->amount, 2)
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Approve the withdrawal
            $withdrawal->approve(Auth::id(), $request->admin_notes);

            // Deduct amount from wallet immediately upon approval
            $withdrawal->wallet->decrement('balance', $withdrawal->amount);
            $withdrawal->update(['wallet_balance_after' => $withdrawal->wallet->fresh()->balance]);

            DB::commit();

            Log::info('Withdrawal approved', [
                'withdrawal_id' => $withdrawal->withdrawal_id,
                'admin_id' => Auth::id(),
                'amount' => $withdrawal->amount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal approved successfully. Amount deducted from user wallet.',
                'new_status' => 'approved'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to approve withdrawal: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to approve withdrawal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject withdrawal request
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $withdrawal = Withdrawal::findOrFail($id);
        
        if (!$withdrawal->isPending()) {
            return response()->json(['error' => 'Only pending withdrawals can be rejected'], 400);
        }

        try {
            $withdrawal->reject(Auth::id(), $request->rejection_reason);

            Log::info('Withdrawal rejected', [
                'withdrawal_id' => $withdrawal->withdrawal_id,
                'admin_id' => Auth::id(),
                'reason' => $request->rejection_reason
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal rejected successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to reject withdrawal: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to reject withdrawal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark withdrawal as processing
     */
    public function process($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        
        if (!$withdrawal->isApproved()) {
            return response()->json(['error' => 'Only approved withdrawals can be marked as processing'], 400);
        }

        try {
            $withdrawal->process(Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal marked as processing'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update withdrawal status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark withdrawal as completed
     */
    public function complete($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        
        if (!$withdrawal->isApproved() && !$withdrawal->isProcessing()) {
            return response()->json(['error' => 'Only approved or processing withdrawals can be completed'], 400);
        }

        try {
            $withdrawal->complete(Auth::id());

            Log::info('Withdrawal completed', [
                'withdrawal_id' => $withdrawal->withdrawal_id,
                'admin_id' => Auth::id(),
                'amount' => $withdrawal->amount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal marked as completed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to complete withdrawal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pending withdrawals count for notifications
     */
    public function pendingCount()
    {
        $count = Withdrawal::pending()->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Export withdrawals report
     */
    public function export(Request $request)
    {
        $query = Withdrawal::with(['user', 'approvedBy']);
        
        // Apply same filters as index
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $withdrawals = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'data' => $withdrawals,
            'summary' => [
                'total_withdrawals' => $withdrawals->count(),
                'total_amount' => $withdrawals->sum('amount'),
                'total_fees' => $withdrawals->sum('fee'),
                'pending_count' => $withdrawals->where('status', 'pending')->count(),
                'completed_count' => $withdrawals->where('status', 'completed')->count(),
                'export_date' => now()->toDateTimeString()
            ]
        ]);
    }
}
