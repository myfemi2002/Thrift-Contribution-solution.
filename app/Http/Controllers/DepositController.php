<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\UserWallet;
use App\Models\MotherWallet;
use Illuminate\Http\Request;
use App\Models\CryptoDeposit;
use App\Models\DepositAppeal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use App\Models\DepositTransactionLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DepositController extends Controller
{
    protected $imageManager;
    protected $uploadPath = 'upload/deposit_screenshots';

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
        
        try {
            if (!File::exists(public_path($this->uploadPath))) {
                File::makeDirectory(public_path($this->uploadPath), 0777, true);
            }
        } catch (\Exception $e) {
            Log::error('Failed to create upload directory: ' . $e->getMessage());
        }
    }

    /**
     * Show the deposit page with user's wallet address.
     */
    public function showDepositForm()
    {
        $user = Auth::user();
        $wallet = $user->wallet()->with('motherWallet')->first();
        
        if (!$wallet) {
            // User doesn't have a wallet, create one automatically
            $motherWallet = MotherWallet::getRandomActiveWallet();
            
            if (!$motherWallet) {
                Log::error('No active mother wallet available for user ID: ' . $user->id);
                return redirect()->route('home')
                    ->with('message', 'Unable to create wallet. Please contact support.')
                    ->with('alert-type', 'error');
            }
            
            // Create a new wallet for the user
            $wallet = UserWallet::create([
                'user_id' => $user->id,
                'mother_wallet_id' => $motherWallet->id,
                'balance' => 0,
            ]);
            
            // Reload the wallet with motherWallet relationship
            $wallet = $user->wallet()->with('motherWallet')->first();
        }
        
        if (!$wallet->motherWallet) {
            Log::error('User wallet exists but has no mother wallet assigned. User ID: ' . $user->id);
            
            // Try to assign a mother wallet
            $motherWallet = MotherWallet::getRandomActiveWallet();
            
            if ($motherWallet) {
                $wallet->mother_wallet_id = $motherWallet->id;
                $wallet->save();
                
                // Reload the wallet with motherWallet relationship
                $wallet = $user->wallet()->with('motherWallet')->first();
            } else {
                return redirect()->route('home')
                    ->with('message', 'Unable to assign wallet. Please contact support.')
                    ->with('alert-type', 'error');
            }
        }
        
        // Get wallet address (from mother wallet) and generate QR
        $walletAddress = $wallet->motherWallet->wallet_address;
        $qrCode = base64_encode(QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($walletAddress));
        
        // Get recent deposits for the user
        $recentDeposits = $user->deposits()
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Changed from take(5) to paginate(5)
        
        return view('userend.wallet.deposit', compact('walletAddress', 'qrCode', 'recentDeposits'));
    }
/**
 * Handle deposit verification request.
 */
public function verifyDeposit(Request $request)
{
    $validator = Validator::make($request->all(), [
        'tx_id' => 'required|string|unique:crypto_deposits,tx_id',
        'amount' => 'required|numeric|min:0.000001',
        'screenshot' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('message', 'Invalid deposit details')
            ->with('alert-type', 'error');
    }

    $user = Auth::user();
    $txid = $request->tx_id;
    $amount = $request->amount;
    
    // Check for duplicate transaction
    if (CryptoDeposit::where('tx_id', $txid)->exists()) {
        return redirect()->back()
            ->with('message', 'This transaction has already been processed')
            ->with('alert-type', 'warning');
    }
    
    // Process screenshot if provided
    $screenshotPath = null;
    if ($request->hasFile('screenshot')) {
        $uploadedFile = $request->file('screenshot');
        $filename = time() . '_' . $user->id . '.' . $uploadedFile->getClientOriginalExtension();
        
        // Use Intervention to resize and save the image
        $img = $this->imageManager->read($uploadedFile);
        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $img->save(public_path($this->uploadPath . '/' . $filename));
        $screenshotPath = $this->uploadPath . '/' . $filename;
    }
    
    // Start database transaction
    DB::beginTransaction();
    
    try {
        // Create a pending deposit record
        $deposit = CryptoDeposit::create([
            'user_id' => $user->id,
            'tx_id' => $txid,
            'amount' => $amount,
            'status' => 'pending',
            'screenshot_path' => $screenshotPath,
        ]);
        
        // Create a transaction log for the new deposit
        DepositTransactionLog::createLog(
            $deposit->id,
            $user->id,
            'created',
            $amount,
            0, // No fee yet
            0, // No credited amount yet
            'Deposit submitted for verification',
            null // Performed by the user themselves
        );
        
        // Commit transaction
        DB::commit();
        
        // Try to verify via API
        try {
            $verificationResult = $this->verifyTransactionOnBlockchain($txid, $user->id, $amount);
            
            if ($verificationResult['success']) {
                // If the verification was successful, create another log for the verification
                $actualAmount = $verificationResult['actual_amount'] ?? $amount;
                
                DepositTransactionLog::createLog(
                    $deposit->id,
                    $user->id,
                    'verified',
                    $actualAmount,
                    0, // No fee for verification
                    $actualAmount, // Full amount credited
                    'Deposit automatically verified on blockchain',
                    null // System verification
                );
                
                return redirect()->back()
                    ->with('message', $verificationResult['message'])
                    ->with('alert-type', 'success');
            } else {
                // If verification failed but we have a record of the attempt
                if (isset($verificationResult['verification_attempted']) && $verificationResult['verification_attempted']) {
                    DepositTransactionLog::createLog(
                        $deposit->id,
                        $user->id,
                        'verification_failed',
                        $amount,
                        0, // No fee
                        0, // No credited amount
                        'Automatic verification failed: ' . ($verificationResult['message'] ?? 'Unknown reason'),
                        null // System verification
                    );
                }
                
                return redirect()->back()
                    ->with('message', $verificationResult['message'])
                    ->with('alert-type', 'warning');
            }
        } catch (\Exception $e) {
            Log::error('Deposit verification error: ' . $e->getMessage());
            
            // Log the verification error
            DepositTransactionLog::createLog(
                $deposit->id,
                $user->id,
                'verification_error',
                $amount,
                0, // No fee
                0, // No credited amount
                'Verification error: ' . $e->getMessage(),
                null // System verification
            );
            
            return redirect()->back()
                ->with('message', 'Your deposit has been submitted and will be verified soon')
                ->with('alert-type', 'info');
        }
    } catch (\Exception $e) {
        // Rollback transaction if any error occurs
        DB::rollBack();
        
        Log::error('Error creating deposit: ' . $e->getMessage());
        
        return redirect()->back()
            ->with('message', 'An error occurred while processing your deposit. Please try again.')
            ->with('alert-type', 'error');
    }
}

    /**
     * Verify transaction on the blockchain.
     */
    private function verifyTransactionOnBlockchain($txid, $userId, $claimedAmount)
    {
        $user = User::findOrFail($userId);
        $wallet = $user->wallet()->with('motherWallet')->first();
        
        if (!$wallet || !$wallet->motherWallet) {
            return [
                'success' => false,
                'verification_attempted' => true,
                'message' => 'User wallet not found'
            ];
        }
        
        $userMotherWalletAddress = $wallet->motherWallet->wallet_address;
        
        // Call TRON API to verify the transaction
        try {
            $response = Http::get("https://apilist.tronscan.org/api/transaction-info", [
                'hash' => $txid
            ]);
            
            if (!$response->successful()) {
                // Update deposit status to pending for manual review
                $this->updateDepositStatus($txid, 'pending', 'API call failed, manual verification required');
                
                return [
                    'success' => false,
                    'verification_attempted' => true,
                    'message' => 'Transaction not found or network error. Your deposit will be verified manually.'
                ];
            }
            
            $data = $response->json();
            
            // Check if transaction was successful
            if (!isset($data['contractRet']) || $data['contractRet'] !== 'SUCCESS') {
                $this->updateDepositStatus($txid, 'rejected', 'Transaction failed on blockchain');
                
                return [
                    'success' => false,
                    'verification_attempted' => true,
                    'message' => 'Transaction failed on blockchain'
                ];
            }
            
            // For TRC20 tokens like USDT, we need to check the token transfer info
            if (isset($data['tokenTransferInfo']) || isset($data['trc20TransferInfo'])) {
                // Use trc20TransferInfo if available, otherwise use tokenTransferInfo
                $transferInfo = isset($data['trc20TransferInfo']) ? $data['trc20TransferInfo'][0] : $data['tokenTransferInfo'];
                
                // Check if it's a USDT transfer
                if ($transferInfo['symbol'] !== 'USDT') {
                    $this->updateDepositStatus($txid, 'rejected', 'Not a USDT transfer. Token: ' . $transferInfo['symbol']);
                    
                    return [
                        'success' => false,
                        'verification_attempted' => true,
                        'message' => 'Not a USDT transfer. Please make sure to send USDT (TRC20).'
                    ];
                }
                
                // Check if the receiving address matches our mother wallet address
                $receivingAddress = $transferInfo['to_address'];
                
                // Debug log to see addresses
                Log::debug("Comparing addresses", [
                    'receivingAddress' => $receivingAddress,
                    'userMotherWalletAddress' => $userMotherWalletAddress
                ]);
                
                // Compare addresses - important to check if the user's mother wallet received the funds
                if ($receivingAddress !== $userMotherWalletAddress) {
                    // Let's log the mismatch but also check if it's one of our mother wallets
                    $isOurWallet = MotherWallet::where('wallet_address', $receivingAddress)->exists();
                    
                    if ($isOurWallet) {
                        // It's our wallet but not the one assigned to the user - can still proceed
                        Log::warning("Deposit sent to different mother wallet than assigned to user", [
                            'userID' => $userId,
                            'assignedWallet' => $userMotherWalletAddress,
                            'actualReceivingWallet' => $receivingAddress
                        ]);
                        
                        // Continue verification but make a note
                        $notes = "Funds sent to different mother wallet ({$receivingAddress}) than assigned to user ({$userMotherWalletAddress})";
                    } else {
                        // Not our wallet at all - reject
                        $this->updateDepositStatus(
                            $txid, 
                            'rejected', 
                            'Funds not sent to any of our wallet addresses. Received by: ' . $receivingAddress
                        );
                        
                        return [
                            'success' => false,
                            'verification_attempted' => true,
                            'message' => 'Funds not sent to the correct address'
                        ];
                    }
                }
                
                // Check amount 
                $decimals = $transferInfo['decimals'] ?? 6; // Default to 6 for USDT if not specified
                $amountInTokenUnits = $transferInfo['amount_str'];
                $actualAmount = $amountInTokenUnits / (10 ** $decimals);
                
                Log::debug("Amount verification", [
                    'claimedAmount' => $claimedAmount,
                    'actualAmount' => $actualAmount,
                    'amountInTokenUnits' => $amountInTokenUnits,
                    'decimals' => $decimals
                ]);
                
                // Allow small discrepancy (0.01 or 1%) for rounding
                $discrepancyAllowed = max(0.01, $claimedAmount * 0.01);
                
                if (abs($actualAmount - $claimedAmount) > $discrepancyAllowed) {
                    $this->updateDepositStatus(
                        $txid, 
                        'pending', 
                        'Amount mismatch: Claimed ' . $claimedAmount . ', actual ' . $actualAmount
                    );
                    
                    return [
                        'success' => false,
                        'verification_attempted' => true,
                        'actual_amount' => $actualAmount,
                        'message' => 'Amount mismatch. Your deposit will be verified manually.'
                    ];
                }
                
                // All checks passed, credit the user's wallet with the actual amount from blockchain
                $this->creditUserWallet($userId, $txid, $actualAmount, $notes ?? null);
                
                return [
                    'success' => true,
                    'actual_amount' => $actualAmount,
                    'message' => 'Deposit of ' . $actualAmount . ' USDT verified and credited to your wallet!'
                ];
            } else {
                // No token transfer info found
                $this->updateDepositStatus($txid, 'pending', 'No token transfer information found in transaction');
                
                return [
                    'success' => false,
                    'verification_attempted' => true,
                    'message' => 'Invalid transaction type. Your deposit will be verified manually.'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Error verifying transaction: ' . $e->getMessage());
            
            $this->updateDepositStatus($txid, 'pending', 'Verification error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'verification_attempted' => true,
                'message' => 'Error verifying transaction. Your deposit will be verified manually.'
            ];
        }
    }

    /**
     * Update deposit status.
     */
    private function updateDepositStatus($txid, $status, $notes = null)
    {
        $deposit = CryptoDeposit::where('tx_id', $txid)->first();
        
        if ($deposit) {
            $deposit->status = $status;
            if ($notes) {
                $deposit->notes = $notes;
            }
            $deposit->save();
            
            // Log the status update
            DepositTransactionLog::createLog(
                $deposit->id,
                $deposit->user_id,
                'status_updated_to_' . $status,
                $deposit->amount,
                0, // No fee yet
                0, // No credited amount yet
                $notes ?? 'Status updated to ' . $status,
                null // System action
            );
        }
    }

    /**
     * Credit user wallet.
     */
    private function creditUserWallet($userId, $txid, $amount, $notes = null)
    {
        // Start database transaction
        DB::beginTransaction();
        
        try {
            $deposit = CryptoDeposit::where('tx_id', $txid)->first();
            
            if (!$deposit) {
                throw new \Exception('Deposit record not found');
            }
            
            // Update deposit status
            $deposit->status = 'confirmed';
            $deposit->amount = $amount; // Update with actual amount from blockchain
            if ($notes) {
                $deposit->notes = $notes;
            }
            $deposit->save();
            
            // Update user wallet balance
            $wallet = UserWallet::where('user_id', $userId)->first();
            
            if (!$wallet) {
                throw new \Exception('User wallet not found');
            }
            
            $wallet->balance += $amount;
            $wallet->save();
            
            // Log the wallet credit
            DepositTransactionLog::createLog(
                $deposit->id,
                $userId,
                'wallet_credited',
                $amount,
                0, // No fee for direct verification
                $amount, // Full amount credited
                'Wallet credited with verified amount from blockchain',
                null // System action
            );
            
            // Commit transaction
            DB::commit();
            
            // Log the successful deposit
            Log::info('User ID ' . $userId . ' deposit of ' . $amount . ' USDT confirmed. TXID: ' . $txid);
            
            return true;
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            
            Log::error('Failed to credit user wallet: ' . $e->getMessage());
            
            return false;
        }
    }


    /**
     * Show the deposit appeal form.
     */
    // public function showAppealForm($id)
    // {
    //     $user = Auth::user();
    //     $deposit = CryptoDeposit::where('user_id', $user->id)
    //         ->where('id', $id)
    //         ->firstOrFail();
        
    //     if (!$deposit->isEligibleForAppeal()) {
    //         return redirect()->route('user.wallet.deposit')
    //             ->with('message', 'This deposit is not eligible for appeal')
    //             ->with('alert-type', 'error');
    //     }
        
    //     // Calculate the fee and credited amount
    //     $feeAmount = DepositAppeal::calculateFee($deposit->amount);
    //     $creditedAmount = DepositAppeal::calculateCreditedAmount($deposit->amount);
        
    //     return view('userend.wallet.deposit-appeal', compact('deposit', 'feeAmount', 'creditedAmount'));
    // }

    public function showAppealForm($id)
    {
        $user = Auth::user();
        $deposit = CryptoDeposit::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
        
        if (!$deposit->isEligibleForAppeal()) {
            return redirect()->route('user.wallet.deposit')
                ->with('message', 'This deposit is not eligible for appeal')
                ->with('alert-type', 'error');
        }
        
        // Extract the actual amount from the blockchain if available in notes
        $actualAmount = $deposit->amount; // Default to claimed amount
        $notes = $deposit->notes;
        
        // Try to find the actual amount in the rejection reason
        if (preg_match('/actual\s+(\d+(\.\d+)?)/i', $notes, $matches) ||
            preg_match('/actual:\s*(\d+(\.\d+)?)/i', $notes, $matches)) {
            $actualAmount = floatval($matches[1]);
        }
        
        // Calculate the fee and credited amount based on the actual blockchain amount
        $feeAmount = DepositAppeal::calculateFee($actualAmount);
        $creditedAmount = DepositAppeal::calculateCreditedAmount($actualAmount);
        
        return view('userend.wallet.deposit-appeal', compact('deposit', 'feeAmount', 'creditedAmount', 'actualAmount'));
    }



    /**
     * Submit a deposit appeal.
     */
    public function submitAppeal(Request $request, $id)
    {
        $user = Auth::user();
        $deposit = CryptoDeposit::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
        
        if (!$deposit->isEligibleForAppeal()) {
            return redirect()->route('user.wallet.deposit')
                ->with('message', 'This deposit is not eligible for appeal')
                ->with('alert-type', 'error');
        }
        
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|min:10|max:500',
            'acknowledge_fee' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Please provide a valid reason and acknowledge the fee')
                ->with('alert-type', 'error');
        }
        
        // Calculate fee and credited amount
        $feeAmount = DepositAppeal::calculateFee($deposit->amount);
        $creditedAmount = DepositAppeal::calculateCreditedAmount($deposit->amount);
        
        // Create appeal record
        $appeal = DepositAppeal::create([
            'deposit_id' => $deposit->id,
            'reason' => $request->reason,
            'status' => 'pending',
            'fee_amount' => $feeAmount,
            'credited_amount' => $creditedAmount
        ]);
        
        // Update deposit appeal status
        $deposit->appeal_status = 'pending';
        $deposit->save();
        
        return redirect()->route('user.wallet.deposit')
            ->with('message', 'Your appeal has been submitted and is under review. A 20% fee will be charged if approved.')
            ->with('alert-type', 'success');
    }

    /**
     * View details of an appeal.
     */
    public function viewAppeal($id)
    {
        $user = Auth::user();
        $deposit = CryptoDeposit::where('user_id', $user->id)
            ->where('id', $id)
            ->with('appeal')
            ->firstOrFail();
        
        if (!$deposit->appeal) {
            return redirect()->route('user.wallet.deposit')
                ->with('message', 'No appeal found for this deposit')
                ->with('alert-type', 'error');
        }
        
        return view('userend.wallet.appeal-details', compact('deposit'));
    }

    /**
     * Display user's deposit transaction logs.
     */
    public function depositTransactionLogs(Request $request)
    {
        $user = Auth::user();
        
        $query = DepositTransactionLog::with(['deposit'])
            ->where('user_id', $user->id);
        
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
        
        $logs = $query->latest()->paginate(10);
        
        // Get list of action types for dropdown
        $actionTypes = DepositTransactionLog::where('user_id', $user->id)
            ->select('action_type')
            ->distinct()
            ->pluck('action_type')
            ->toArray();
        
        return view('userend.wallet.transaction-logs', compact('logs', 'actionTypes'));
    }


}