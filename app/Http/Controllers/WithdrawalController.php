<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class WithdrawalController extends Controller
{
    /**
     * Display user withdrawal history
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->withdrawals()->orderBy('created_at', 'desc');
        
        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        $withdrawals = $query->paginate(15);
        
        // Get summary statistics
        $summary = [
            'total_withdrawals' => $user->withdrawals()->count(),
            'pending_withdrawals' => $user->withdrawals()->pending()->count(),
            'completed_withdrawals' => $user->withdrawals()->completed()->count(),
            'total_withdrawn' => $user->withdrawals()->completed()->sum('amount'),
            'wallet_balance' => $user->wallet->balance ?? 0
        ];

        return view('userend.withdrawals.index', compact('withdrawals', 'summary'));
    }

    /**
     * Show withdrawal request form
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->wallet) {
            return redirect()->route('user.dashboard')
                ->with('message', 'Wallet not found. Please contact support.')
                ->with('alert-type', 'error');
        }

        $availableBalance = $user->wallet->balance;
        $pendingWithdrawals = $user->withdrawals()->pending()->sum('amount');
        $effectiveBalance = $availableBalance - $pendingWithdrawals;

        return view('userend.withdrawals.create', compact(
            'availableBalance', 
            'pendingWithdrawals', 
            'effectiveBalance'
        ));
    }

    /**
     * Store withdrawal request
     */
    public function store(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('Withdrawal request received', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100', // Minimum ₦100
            'payment_method' => 'required|in:cash,bank_transfer',
            'reason' => 'required|string|max:500',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:20',
            'account_name' => 'nullable|string|max:255',
            'terms' => 'required|accepted'
        ], [
            'amount.required' => 'Withdrawal amount is required',
            'amount.min' => 'Minimum withdrawal amount is ₦100',
            'payment_method.required' => 'Payment method is required',
            'reason.required' => 'Reason for withdrawal is required',
            'terms.required' => 'You must accept the terms and conditions',
            'terms.accepted' => 'You must accept the terms and conditions'
        ]);

        // Add conditional validation for bank transfer
        if ($request->payment_method === 'bank_transfer') {
            $validator->sometimes(['bank_name', 'account_number', 'account_name'], 'required', function ($input) {
                return $input->payment_method === 'bank_transfer';
            });
        }

        if ($validator->fails()) {
            Log::warning('Withdrawal validation failed', [
                'user_id' => Auth::id(),
                'errors' => $validator->errors()->toArray()
            ]);
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Please correct the errors below')
                ->with('alert-type', 'error');
        }

        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            Log::error('Wallet not found for user', ['user_id' => $user->id]);
            
            return redirect()->back()
                ->with('message', 'Wallet not found. Please contact support.')
                ->with('alert-type', 'error');
        }

        $amount = (float) $request->amount;
        
        // Check if user has enough balance
        $pendingWithdrawals = $user->withdrawals()->pending()->sum('amount');
        $effectiveBalance = $wallet->balance - $pendingWithdrawals;

        if ($amount > $effectiveBalance) {
            Log::warning('Insufficient balance for withdrawal', [
                'user_id' => $user->id,
                'requested_amount' => $amount,
                'effective_balance' => $effectiveBalance
            ]);
            
            return redirect()->back()
                ->with('message', 'Insufficient balance. Available: ₦' . number_format($effectiveBalance, 2))
                ->with('alert-type', 'error')
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Calculate fee - Set to 0 as per your requirement
            $fee = 0; // No fees for now

            $withdrawalData = [
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'fee' => $fee,
                'payment_method' => $request->payment_method,
                'reason' => $request->reason,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'metadata' => json_encode([
                    'requested_at' => now()->toISOString(),
                    'user_agent' => $request->userAgent(),
                    'ip_address' => $request->ip(),
                    'browser_info' => $request->header('User-Agent')
                ])
            ];

            // Add bank details if bank transfer
            if ($request->payment_method === 'bank_transfer') {
                $withdrawalData['bank_name'] = $request->bank_name;
                $withdrawalData['account_number'] = $request->account_number;
                $withdrawalData['account_name'] = $request->account_name;
            }

            $withdrawal = Withdrawal::create($withdrawalData);

            DB::commit();

            Log::info('Withdrawal request created successfully', [
                'user_id' => $user->id,
                'withdrawal_id' => $withdrawal->withdrawal_id,
                'amount' => $amount
            ]);

            return redirect()->route('user.withdrawals.index')
                ->with('message', 'Withdrawal request submitted successfully. Awaiting admin approval.')
                ->with('alert-type', 'success');

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Withdrawal request failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('message', 'Failed to submit withdrawal request. Please try again. Error: ' . $e->getMessage())
                ->with('alert-type', 'error')
                ->withInput();
        }
    }

    /**
     * Show withdrawal details
     */
    public function show($id)
    {
        $user = Auth::user();
        $withdrawal = $user->withdrawals()->findOrFail($id);

        return view('userend.withdrawals.show', compact('withdrawal'));
    }

    /**
     * Cancel pending withdrawal
     */
    public function cancel($id)
    {
        $user = Auth::user();
        $withdrawal = $user->withdrawals()->findOrFail($id);

        if (!$withdrawal->isPending()) {
            return redirect()->back()
                ->with('message', 'Only pending withdrawals can be cancelled')
                ->with('alert-type', 'error');
        }

        $withdrawal->update([
            'status' => 'cancelled',
            'admin_notes' => 'Cancelled by user at ' . now()->toDateTimeString()
        ]);

        Log::info('Withdrawal cancelled by user', [
            'user_id' => $user->id,
            'withdrawal_id' => $withdrawal->withdrawal_id
        ]);

        return redirect()->route('user.withdrawals.index')
            ->with('message', 'Withdrawal request cancelled successfully')
            ->with('alert-type', 'success');
    }

    /**
     * Calculate withdrawal fee
     */
    private function calculateWithdrawalFee($amount, $paymentMethod)
    {
        // Set to 0 as per your requirement - no fees
        return 0;
        
        // Original fee structure (commented out):
        // switch ($paymentMethod) {
        //     case 'bank_transfer':
        //         return $amount * 0.01; // 1% fee
        //     case 'cash':
        //         return 50; // Fixed ₦50 fee
        //     default:
        //         return 0;
        // }
    }
}