<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\log;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WalletAdjustmentController extends Controller
{
    /**
     * Display adjustments dashboard
     */
    public function index(Request $request)
    {
        $query = WalletAdjustment::with(['user', 'admin', 'wallet']);
        
        // Apply filters
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('reason') && $request->reason) {
            $query->where('reason', $request->reason);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $adjustments = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get statistics
        $stats = [
            'total_adjustments' => WalletAdjustment::count(),
            'pending_adjustments' => WalletAdjustment::where('status', 'pending')->count(),
            'total_credits' => WalletAdjustment::where('type', 'credit')->where('status', 'completed')->sum('amount'),
            'total_debits' => WalletAdjustment::where('type', 'debit')->where('status', 'completed')->sum('amount'),
        ];

        return view('backend.wallet-adjustments.index', compact('adjustments', 'stats'));
    }

    /**
     * Show create adjustment form
     */
    public function create()
    {
        return view('backend.wallet-adjustments.create');
    }

    /**
     * Search for user to adjust wallet
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
            ->with(['wallet', 'contributions' => function($q) {
                $q->orderBy('contribution_date', 'desc')->take(5);
            }])
            ->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get recent adjustments
        $recentAdjustments = WalletAdjustment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'user' => $user,
            'recent_adjustments' => $recentAdjustments
        ]);
    }

    /**
     * Store wallet adjustment
     */
    public function store(Request $request)
    {
        // Debug: Log the incoming request
        log::info('Wallet Adjustment Request:', $request->all());

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|in:omitted_contribution,correction_error,admin_adjustment,system_error,duplicate_payment,refund,bonus,penalty,other',
            'description' => 'required|string|max:500',
            'reference_number' => 'nullable|string|max:255',
            'reference_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::findOrFail($request->user_id);
            
            // Ensure user has wallet
            $wallet = $user->wallet;
            if (!$wallet) {
                log::info('Creating wallet for user: ' . $user->id);
                $wallet = Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0.00,
                    'total_contributions' => 0.00,
                    'status' => 'active'
                ]);
            }

            // Check if debit amount exceeds balance
            if ($request->type === 'debit' && $request->amount > $wallet->balance) {
                return response()->json([
                    'error' => 'Debit amount (₦' . number_format($request->amount, 2) . ') exceeds wallet balance (₦' . number_format($wallet->balance, 2) . ')'
                ], 400);
            }

            DB::beginTransaction();

            $balanceBefore = (float) $wallet->balance;
            $amount = (float) $request->amount;
            $balanceAfter = $request->type === 'credit' 
                ? $balanceBefore + $amount 
                : $balanceBefore - $amount;

            // Prepare reference date
            $referenceDate = null;
            if ($request->reference_date) {
                try {
                    $referenceDate = Carbon::parse($request->reference_date);
                } catch (\Exception $e) {
                    log::error('Invalid reference date: ' . $request->reference_date);
                    $referenceDate = null;
                }
            }

            // Create adjustment record - ALWAYS requiring approval
            $adjustmentData = [
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'admin_id' => Auth::id(),
                'type' => $request->type,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'reason' => $request->reason,
                'description' => $request->description,
                'reference_number' => $request->reference_number,
                'reference_date' => $referenceDate,
                'status' => 'pending',
                'approved_at' => null,
                'approved_by' => null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'metadata' => json_encode([
                    'created_by_admin' => Auth::user()->name,
                    'created_by_email' => Auth::user()->email,
                    'requires_approval' => true,
                    'auto_created' => true,
                    'created_at_formatted' => now()->toDateTimeString()
                ])
            ];

            log::info('Creating adjustment with data:', $adjustmentData);

            $adjustment = WalletAdjustment::create($adjustmentData);

            log::info('Adjustment created successfully:', ['id' => $adjustment->id, 'adjustment_id' => $adjustment->adjustment_id]);

            // Note: Wallet balance is NOT updated until approval

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Adjustment submitted successfully and is pending approval from another admin',
                'adjustment' => $adjustment->load(['user', 'admin']),
                'requires_approval' => true,
                'adjustment_id' => $adjustment->adjustment_id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            log::error('Failed to process adjustment:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'error' => 'Failed to process adjustment: ' . $e->getMessage(),
                'debug_info' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }

    /**
     * Approve pending adjustment
     */
    // public function approve($id)
    // {
    //     $adjustment = WalletAdjustment::findOrFail($id);
        
    //     if ($adjustment->status !== 'pending') {
    //         return response()->json(['error' => 'Only pending adjustments can be approved'], 400);
    //     }

    //     // // Prevent self-approval for security
    //     // if ($adjustment->admin_id === Auth::id()) {
    //     //     return response()->json(['error' => 'You cannot approve your own adjustment. Another admin must approve it.'], 400);
    //     // }

    //     try {
    //         DB::beginTransaction();

    //         // Update wallet balance
    //         $wallet = $adjustment->wallet;
    //         $newBalance = $adjustment->type === 'credit' 
    //             ? $wallet->balance + $adjustment->amount 
    //             : $wallet->balance - $adjustment->amount;

    //         // Check if debit would create negative balance
    //         if ($adjustment->type === 'debit' && $newBalance < 0) {
    //             return response()->json([
    //                 'error' => 'Cannot approve: Debit would create negative balance (Current: ₦' . 
    //                           number_format($wallet->balance, 2) . ', After debit: ₦' . 
    //                           number_format($newBalance, 2) . ')'
    //             ], 400);
    //         }

    //         $wallet->update(['balance' => $newBalance]);
            
    //         // Update total contributions for credits from omitted contributions
    //         if ($adjustment->type === 'credit' && $adjustment->reason === 'omitted_contribution') {
    //             $wallet->increment('total_contributions', $adjustment->amount);
    //         }

    //         // Handle metadata properly - decode if it's a string, use as array if already array
    //         $existingMetadata = $adjustment->metadata;
    //         if (is_string($existingMetadata)) {
    //             $existingMetadata = json_decode($existingMetadata, true) ?? [];
    //         } elseif (!is_array($existingMetadata)) {
    //             $existingMetadata = [];
    //         }

    //         // Prepare new metadata
    //         $newMetadata = array_merge($existingMetadata, [
    //             'approved_by_admin' => Auth::user()->name,
    //             'approved_by_email' => Auth::user()->email,
    //             'approval_notes' => 'Approved via admin interface',
    //             'approval_date' => now()->toISOString(),
    //             'approver_ip' => request()->ip(),
    //             'approval_timestamp' => now()->timestamp
    //         ]);

    //         // Update adjustment status
    //         $adjustment->update([
    //             'status' => 'completed',
    //             'approved_at' => now(),
    //             'approved_by' => Auth::id(),
    //             'balance_after' => $newBalance,
    //             'metadata' => json_encode($newMetadata)
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Adjustment approved successfully. User wallet updated.',
    //             'new_balance' => '₦' . number_format($newBalance, 2),
    //             'adjustment_id' => $adjustment->adjustment_id
    //         ]);

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         log::error('Failed to approve adjustment:', [
    //             'adjustment_id' => $id,
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
            
    //         return response()->json([
    //             'error' => 'Failed to approve adjustment: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Approve pending adjustment
     */
    public function approve($id)
    {
        $adjustment = WalletAdjustment::findOrFail($id);
        
        if ($adjustment->status !== 'pending') {
            return response()->json(['error' => 'Only pending adjustments can be approved'], 400);
        }

        try {
            DB::beginTransaction();

            // Get wallet
            $wallet = $adjustment->wallet;
            
            // Check if debit would create negative balance
            if ($adjustment->type === 'debit' && $adjustment->amount > $wallet->balance) {
                return response()->json([
                    'error' => 'Cannot approve: Debit would create negative balance (Current: ₦' . 
                              number_format($wallet->balance, 2) . ', After debit: ₦' . 
                              number_format($wallet->balance - $adjustment->amount, 2) . ')'
                ], 400);
            }

            // Apply the adjustment using the new method
            $wallet->applyAdjustment($adjustment->type, $adjustment->amount, $adjustment->reason);

            // Update the balance_after field to reflect actual final balance
            $newBalance = $wallet->fresh()->balance;

            // Handle metadata properly - decode if it's a string, use as array if already array
            $existingMetadata = $adjustment->metadata;
            if (is_string($existingMetadata)) {
                $existingMetadata = json_decode($existingMetadata, true) ?? [];
            } elseif (!is_array($existingMetadata)) {
                $existingMetadata = [];
            }

            // Prepare new metadata
            $newMetadata = array_merge($existingMetadata, [
                'approved_by_admin' => Auth::user()->name,
                'approved_by_email' => Auth::user()->email,
                'approval_notes' => 'Approved via admin interface',
                'approval_date' => now()->toISOString(),
                'approver_ip' => request()->ip(),
                'approval_timestamp' => now()->timestamp,
                'balance_after_approval' => $newBalance,
                'adjustment_logic' => [
                    'type' => $adjustment->type,
                    'reason' => $adjustment->reason,
                    'affects_total_contributions' => in_array($adjustment->reason, [
                        'omitted_contribution', 'correction_error', 'refund', 'penalty', 'duplicate_payment'
                    ]),
                    'total_contributions_before' => $wallet->total_contributions,
                    'total_contributions_after' => $wallet->fresh()->total_contributions
                ]
            ]);

            // Update adjustment status
            $adjustment->update([
                'status' => 'completed',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'balance_after' => $newBalance,
                'metadata' => json_encode($newMetadata)
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Adjustment approved successfully. User wallet updated.',
                'new_balance' => '₦' . number_format($newBalance, 2),
                'adjustment_id' => $adjustment->adjustment_id,
                'total_contributions' => '₦' . number_format($wallet->fresh()->total_contributions, 2)
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            log::error('Failed to approve adjustment:', [
                'adjustment_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to approve adjustment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject pending adjustment
     */
    public function reject(Request $request, $id)
    {
        $adjustment = WalletAdjustment::findOrFail($id);
        
        if ($adjustment->status !== 'pending') {
            return response()->json(['error' => 'Only pending adjustments can be rejected'], 400);
        }

        // // Prevent self-rejection for accountability
        // if ($adjustment->admin_id === Auth::id()) {
        //     return response()->json(['error' => 'You cannot reject your own adjustment. Another admin must review it.'], 400);
        // }

        try {
            // Handle metadata properly - decode if it's a string, use as array if already array
            $existingMetadata = $adjustment->metadata;
            if (is_string($existingMetadata)) {
                $existingMetadata = json_decode($existingMetadata, true) ?? [];
            } elseif (!is_array($existingMetadata)) {
                $existingMetadata = [];
            }

            // Prepare new metadata
            $newMetadata = array_merge($existingMetadata, [
                'rejection_reason' => $request->input('reason', 'No reason provided'),
                'rejected_at' => now()->toISOString(),
                'rejected_by_admin' => Auth::user()->name,
                'rejected_by_email' => Auth::user()->email,
                'rejector_ip' => request()->ip(),
                'rejection_timestamp' => now()->timestamp
            ]);

            $adjustment->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
                'metadata' => json_encode($newMetadata)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Adjustment rejected successfully'
            ]);

        } catch (\Exception $e) {
            log::error('Failed to reject adjustment:', [
                'adjustment_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to reject adjustment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show adjustment details
     */
    public function show($id)
    {
        $adjustment = WalletAdjustment::with(['user', 'admin', 'wallet', 'approvedBy'])
            ->findOrFail($id);

        return view('backend.wallet-adjustments.show', compact('adjustment'));
    }

    /**
     * Get user adjustment history
     */
    public function userHistory($userId)
    {
        $user = User::with('wallet')->findOrFail($userId);
        
        $adjustments = WalletAdjustment::where('user_id', $userId)
            ->with(['admin', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('backend.wallet-adjustments.user-history', compact('user', 'adjustments'));
    }

    /**
     * Export adjustments report
     */
    public function export(Request $request)
    {
        $query = WalletAdjustment::with(['user', 'admin']);
        
        // Apply same filters as index
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $adjustments = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'data' => $adjustments,
            'summary' => [
                'total_adjustments' => $adjustments->count(),
                'total_credits' => $adjustments->where('type', 'credit')->sum('amount'),
                'total_debits' => $adjustments->where('type', 'debit')->sum('amount'),
                'pending_count' => $adjustments->where('status', 'pending')->count(),
                'export_date' => now()->toDateTimeString()
            ]
        ]);
    }

    /**
     * Get pending adjustments count (for AJAX updates)
     */
    public function pendingCount()
    {
        $count = WalletAdjustment::where('status', 'pending')->count();
        
        return response()->json(['count' => $count]);
    }
}
