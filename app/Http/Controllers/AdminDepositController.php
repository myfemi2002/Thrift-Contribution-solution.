<?php

namespace App\Http\Controllers;

use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Models\CryptoDeposit;
use App\Models\DepositAppeal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\DepositTransactionLog;

class AdminDepositController extends Controller
{
    /**
     * Display a listing of deposits.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = CryptoDeposit::with(['user']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $deposits = $query->latest()->paginate(15);
        
        return view('backend.deposits.index', compact('deposits', 'status'));
    }

    /**
     * Show details of a specific deposit.
     */
    public function show($id)
    {
        $deposit = CryptoDeposit::with(['user.wallet.motherWallet'])->findOrFail($id);
        
        // Get transaction info from blockchain
        $blockchainInfo = null;
        try {
            $response = Http::get("https://apilist.tronscan.org/api/transaction-info", [
                'hash' => $deposit->tx_id
            ]);
            
            if ($response->successful()) {
                $blockchainInfo = $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Error fetching blockchain data: ' . $e->getMessage());
        }
        
        // Get user's recent deposits
        $recentDeposits = CryptoDeposit::where('user_id', $deposit->user_id)
            ->where('id', '!=', $deposit->id)
            ->latest()
            ->take(5)
            ->get();
        
        return view('backend.deposits.show', compact('deposit', 'blockchainInfo', 'recentDeposits'));
    }

    /**
     * Show confirmation page for approving a deposit.
     */
    public function confirmApprove($id)
    {
        $deposit = CryptoDeposit::with(['user'])->findOrFail($id);
        
        if ($deposit->status !== 'pending') {
            return redirect()->back()
                ->with('message', 'Only pending deposits can be approved')
                ->with('alert-type', 'error');
        }
        
        return view('backend.deposits.confirm-approve', compact('deposit'));
    }
    /**
     * Approve a pending deposit.
     */
    public function approve($id)
    {
        $deposit = CryptoDeposit::findOrFail($id);
        
        // Only pending deposits can be approved
        if ($deposit->status !== 'pending') {
            return redirect()->back()
                ->with('message', 'Only pending deposits can be approved')
                ->with('alert-type', 'error');
        }
        
        // Start database transaction
        DB::beginTransaction();
        
        try {
            // Update deposit status
            $deposit->status = 'confirmed';
            $deposit->notes = isset($deposit->notes) ? $deposit->notes . "\n\nApproved by admin on " . now() : "Approved by admin on " . now();
            $deposit->save();
            
            // Credit user wallet
            $wallet = UserWallet::where('user_id', $deposit->user_id)->first();
            
            if (!$wallet) {
                throw new \Exception('User wallet not found');
            }
            
            $wallet->balance += $deposit->amount;
            $wallet->save();
            
            // Create transaction log
            DepositTransactionLog::createLog(
                $deposit->id,
                $deposit->user_id,
                'approved',
                $deposit->amount,
                0,
                $deposit->amount,
                'Deposit approved by admin',
                auth()->id()
            );
            
            // Log the transaction
            Log::info('Deposit #' . $deposit->id . ' approved for user #' . $deposit->user_id . ' - Amount: ' . $deposit->amount);
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('admin.deposits.show', $deposit->id)
                ->with('message', 'Deposit approved and user wallet credited successfully')
                ->with('alert-type', 'success');
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            
            Log::error('Failed to approve deposit: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('message', 'Failed to approve deposit: ' . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }

    /**
     * Show confirmation page for rejecting a deposit.
     */
    public function confirmReject($id)
    {
        $deposit = CryptoDeposit::with(['user'])->findOrFail($id);
        
        if ($deposit->status !== 'pending') {
            return redirect()->back()
                ->with('message', 'Only pending deposits can be rejected')
                ->with('alert-type', 'error');
        }
        
        return view('backend.deposits.confirm-reject', compact('deposit'));
    }

    /**
     * Reject a pending deposit.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);
        
        $deposit = CryptoDeposit::findOrFail($id);
        
        // Only pending deposits can be rejected
        if ($deposit->status !== 'pending') {
            return redirect()->back()
                ->with('message', 'Only pending deposits can be rejected')
                ->with('alert-type', 'error');
        }
        
        $reason = $request->get('reason');
        
        try {
            $deposit->status = 'rejected';
            $deposit->notes = isset($deposit->notes) 
                ? $deposit->notes . "\n\nRejected by admin on " . now() . "\nReason: " . $reason 
                : "Rejected by admin on " . now() . "\nReason: " . $reason;
            $deposit->save();
            
            // Create transaction log
            DepositTransactionLog::createLog(
                $deposit->id,
                $deposit->user_id,
                'rejected',
                $deposit->amount,
                0,
                0,
                'Deposit rejected by admin. Reason: ' . $reason,
                auth()->id()
            );
            
            // Log the rejection
            Log::info('Deposit #' . $deposit->id . ' rejected for user #' . $deposit->user_id . ' - Reason: ' . $reason);
            
            return redirect()->route('admin.deposits.show', $deposit->id)
                ->with('message', 'Deposit rejected successfully')
                ->with('alert-type', 'success');
        } catch (\Exception $e) {
            Log::error('Failed to reject deposit: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('message', 'Failed to reject deposit: ' . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }
    
    /**
     * Show confirmation page for verifying a deposit on blockchain.
     */
    public function confirmVerify($id)
    {
        $deposit = CryptoDeposit::with(['user'])->findOrFail($id);
        
        if ($deposit->status !== 'pending') {
            return redirect()->back()
                ->with('message', 'Only pending deposits can be verified')
                ->with('alert-type', 'error');
        }
        
        return view('backend.deposits.confirm-verify', compact('deposit'));
    }
    
    /**
     * Manual verification from blockchain.
     */
    public function verifyFromBlockchain($id)
    {
        $deposit = CryptoDeposit::with(['user.wallet.motherWallet'])->findOrFail($id);
        
        if ($deposit->status !== 'pending') {
            return redirect()->back()
                ->with('message', 'Only pending deposits can be verified')
                ->with('alert-type', 'error');
        }
        
        try {
            $txid = $deposit->tx_id;
            $response = Http::get("https://apilist.tronscan.org/api/transaction-info", [
                'hash' => $txid
            ]);
            
            if (!$response->successful()) {
                return redirect()->back()
                    ->with('message', 'Transaction not found on blockchain')
                    ->with('alert-type', 'error');
            }
            
            $data = $response->json();
            
            // Check if transaction was successful
            if ($data['contractRet'] !== 'SUCCESS') {
                $deposit->status = 'rejected';
                $deposit->notes = isset($deposit->notes) 
                    ? $deposit->notes . "\n\nTransaction failed on blockchain - Verified on " . now() 
                    : "Transaction failed on blockchain - Verified on " . now();
                $deposit->save();
                
                return redirect()->route('admin.deposits.show', $deposit->id)
                    ->with('message', 'Transaction failed on blockchain. Deposit rejected.')
                    ->with('alert-type', 'warning');
            }
            
            // Check receiver address
            $receiverAddress = $data['toAddress'] ?? '';
            $motherWallet = $deposit->user->wallet->motherWallet;
            
            if (!$motherWallet) {
                return redirect()->back()
                    ->with('message', 'User has no assigned mother wallet')
                    ->with('alert-type', 'error');
            }
            
            $yourAddress = $motherWallet->wallet_address;
            
            // Convert TRON address to hex format if it starts with 'T'
            if (substr($yourAddress, 0, 1) === 'T') {
                // In a real implementation, you'd convert from base58 to hex
                $yourAddressHex = '41' . bin2hex(substr($yourAddress, 1));
            } else {
                $yourAddressHex = $yourAddress;
            }
            
            if (strtolower($receiverAddress) !== strtolower($yourAddressHex)) {
                $deposit->status = 'rejected';
                $deposit->notes = isset($deposit->notes) 
                    ? $deposit->notes . "\n\nFunds not sent to the correct address - Verified on " . now() 
                    : "Funds not sent to the correct address - Verified on " . now();
                $deposit->save();
                
                return redirect()->route('admin.deposits.show', $deposit->id)
                    ->with('message', 'Funds not sent to the correct address. Deposit rejected.')
                    ->with('alert-type', 'warning');
            }
            
            // Start a transaction for wallet update
            DB::beginTransaction();
            
            try {
                // Get amount from blockchain
                $amountInSun = $data['contractData']['amount'] ?? 0;
                $amount = $amountInSun / 1000000;  // Convert Sun to USDT
                
                $deposit->amount = $amount;  // Update with actual amount from blockchain
                $deposit->status = 'confirmed';
                $deposit->notes = isset($deposit->notes) 
                    ? $deposit->notes . "\n\nVerified from blockchain on " . now() 
                    : "Verified from blockchain on " . now();
                $deposit->save();
                
                // Credit user wallet
                $wallet = $deposit->user->wallet;
                $wallet->balance += $amount;
                $wallet->save();
                
                // Log the verification
                Log::info('Deposit #' . $deposit->id . ' verified on blockchain for user #' . $deposit->user_id . ' - Amount: ' . $amount);
                
                // Commit transaction
                DB::commit();
                
                return redirect()->route('admin.deposits.show', $deposit->id)
                    ->with('message', 'Deposit verified and credited successfully')
                    ->with('alert-type', 'success');
            } catch (\Exception $e) {
                // Rollback transaction
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Verification error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('message', 'Verification error: ' . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }
    

    /**
     * List all deposit appeals.
     */
    public function appeals(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = DepositAppeal::with(['deposit.user']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $appeals = $query->latest()->paginate(15);
        
        return view('backend.deposits.appeals.index', compact('appeals', 'status'));
    }

    /**
     * Show details of a specific appeal.
     */
    public function showAppeal($id)
    {
        $appeal = DepositAppeal::with(['deposit.user.wallet'])->findOrFail($id);
        
        // Extract the actual amount from the blockchain based on the rejection notes
        $actualAmount = $appeal->deposit->amount; // Default
        $notes = $appeal->deposit->notes;
        
        // Try to find the actual amount in the rejection reason
        if (preg_match('/actual\s+(\d+(\.\d+)?)/i', $notes, $matches) ||
            preg_match('/actual:\s*(\d+(\.\d+)?)/i', $notes, $matches)) {
            $actualAmount = floatval($matches[1]);
        }
        
        // Recalculate fee and credited amount based on the actual blockchain amount
        $feeAmount = $actualAmount * 0.2; // 20% fee
        $creditedAmount = $actualAmount - $feeAmount;
        
        return view('backend.deposits.appeals.show', compact('appeal', 'actualAmount', 'feeAmount', 'creditedAmount'));
    }

    /**
     * Approve a deposit appeal.
     */

     public function approveAppeal(Request $request, $id)
     {
         $appeal = DepositAppeal::with(['deposit.user'])->findOrFail($id);
         
         // Only pending appeals can be approved
         if ($appeal->status !== 'pending') {
             return redirect()->back()
                 ->with('message', 'Only pending appeals can be approved')
                 ->with('alert-type', 'error');
         }
         
         // Extract the actual amount from the blockchain based on the rejection notes
         $actualAmount = $appeal->deposit->amount; // Default
         $notes = $appeal->deposit->notes;
         
         // Try to find the actual amount in the rejection reason
         if (preg_match('/actual\s+(\d+(\.\d+)?)/i', $notes, $matches) ||
             preg_match('/actual:\s*(\d+(\.\d+)?)/i', $notes, $matches)) {
             $actualAmount = floatval($matches[1]);
         }
         
         // Calculate fee and credited amount based on the actual blockchain amount
         $feeAmount = $actualAmount * 0.2; // 20% fee
         $creditedAmount = $actualAmount - $feeAmount;
         
         // Start database transaction
         DB::beginTransaction();
         
         try {
             // Update appeal status and amounts
             $appeal->status = 'approved';
             $appeal->admin_notes = $request->get('admin_notes', 'Appeal approved by admin');
             $appeal->fee_amount = $feeAmount;
             $appeal->credited_amount = $creditedAmount;
             $appeal->save();
             
             // Update deposit status
             $deposit = $appeal->deposit;
             $deposit->amount = $actualAmount; // Set the amount to the actual blockchain amount
             $deposit->status = 'confirmed';
             $deposit->appeal_status = 'approved';
             $deposit->notes = isset($deposit->notes) 
                 ? $deposit->notes . "\n\nAppeal approved by admin on " . now() . ". Amount updated to actual blockchain amount: {$actualAmount} USDT. 20% fee applied: {$feeAmount} USDT. Credited amount: {$creditedAmount} USDT."
                 : "Appeal approved by admin on " . now() . ". Amount updated to actual blockchain amount: {$actualAmount} USDT. 20% fee applied: {$feeAmount} USDT. Credited amount: {$creditedAmount} USDT.";
             $deposit->save();
             
             // Credit user wallet with the actual amount after fee
             $wallet = UserWallet::where('user_id', $deposit->user_id)->first();
             
             if (!$wallet) {
                 throw new \Exception('User wallet not found');
             }
             
             $wallet->balance += $creditedAmount;
             $wallet->save();
             
             // Log the transaction
             Log::info('Appeal #' . $appeal->id . ' approved for deposit #' . $deposit->id . ' - Actual amount: ' . $actualAmount . ' USDT - Credited amount: ' . $creditedAmount . ' USDT (20% fee: ' . $feeAmount . ' USDT)');
             
             // Commit transaction
             DB::commit();
             
             return redirect()->route('admin.deposits.appeals.show', $appeal->id)
                 ->with('message', 'Appeal approved and user wallet credited with ' . number_format($creditedAmount, 6) . ' USDT (after 20% fee on actual amount of ' . number_format($actualAmount, 6) . ' USDT)')
                 ->with('alert-type', 'success');
         } catch (\Exception $e) {
             // Rollback transaction
             DB::rollBack();
             
             Log::error('Failed to approve appeal: ' . $e->getMessage());
             
             return redirect()->back()
                 ->with('message', 'Failed to approve appeal: ' . $e->getMessage())
                 ->with('alert-type', 'error');
         }
     }

    /**
     * Reject a deposit appeal.
     */
    public function rejectAppeal(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);
        
        $appeal = DepositAppeal::with(['deposit'])->findOrFail($id);
        
        // Only pending appeals can be rejected
        if ($appeal->status !== 'pending') {
            return redirect()->back()
                ->with('message', 'Only pending appeals can be rejected')
                ->with('alert-type', 'error');
        }
        
        try {
            // Update appeal status
            $appeal->status = 'rejected';
            $appeal->admin_notes = $request->get('admin_notes');
            $appeal->save();
            
            // Update deposit appeal status
            $deposit = $appeal->deposit;
            $deposit->appeal_status = 'rejected';
            $deposit->notes = isset($deposit->notes) 
                ? $deposit->notes . "\n\nAppeal rejected by admin on " . now() . ". Reason: " . $request->get('admin_notes')
                : "Appeal rejected by admin on " . now() . ". Reason: " . $request->get('admin_notes');
            $deposit->save();
            
            Log::info('Appeal #' . $appeal->id . ' rejected for deposit #' . $deposit->id . ' - Reason: ' . $request->get('admin_notes'));
            
            return redirect()->route('admin.deposits.appeals.show', $appeal->id)
                ->with('message', 'Appeal rejected successfully')
                ->with('alert-type', 'success');
        } catch (\Exception $e) {
            Log::error('Failed to reject appeal: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('message', 'Failed to reject appeal: ' . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }
    
    /**
    * Display all deposit transaction logs.
    */
    public function transactionLogs(Request $request)
    {
        $query = DepositTransactionLog::with(['deposit', 'user', 'admin']);
        
        // Filter by user if ID provided
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by action type
        if ($request->has('action_type') && $request->action_type !== 'all') {
            $query->where('action_type', $request->action_type);
        }
        
        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $logs = $query->latest()->paginate(20);
        
        // Get list of action types for dropdown
        $actionTypes = DepositTransactionLog::select('action_type')
            ->distinct()
            ->pluck('action_type')
            ->toArray();
        
        return view('backend.deposits.transaction-logs', compact('logs', 'actionTypes'));
    }
}