<?php

namespace App\Http\Controllers;


use App\Models\WalletDeposit;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WalletDepositController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentGatewayService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $user = Auth::user();
        $deposits = $user->walletDeposits()->orderBy('created_at', 'desc')->paginate(15);
        
        return view('userend.wallet.deposit.index', compact('deposits'));
    }

    public function create()
    {
        return view('userend.wallet.deposit.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100|max:1000000',
            'payment_gateway' => 'required|in:paystack,flutterwave'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $amount = $request->amount;
        
        // Calculate fees (you can adjust these)
        $feeRate = $request->payment_gateway === 'paystack' ? 0.015 : 0.014; // 1.5% or 1.4%
        $feeAmount = $amount * $feeRate;
        $creditedAmount = $amount - $feeAmount;

        $deposit = WalletDeposit::create([
            'user_id' => $user->id,
            'wallet_id' => $user->wallet->id,
            'amount' => $amount,
            'fee_amount' => $feeAmount,
            'credited_amount' => $creditedAmount,
            'payment_gateway' => $request->payment_gateway,
            'gateway_reference' => 'REF-' . strtoupper(Str::random(12)) . '-' . time(),
            'customer_email' => $user->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Initialize payment with selected gateway
        if ($request->payment_gateway === 'paystack') {
            $result = $this->paymentService->initiatePaystackPayment($deposit);
        } else {
            $result = $this->paymentService->initiateFlutterwavePayment($deposit);
        }

        if ($result['success']) {
            $deposit->update(['status' => 'processing']);
            
            return response()->json([
                'success' => true,
                'payment_url' => $result['authorization_url'] ?? $result['payment_link'],
                'deposit_id' => $deposit->deposit_id
            ]);
        }

        $deposit->update(['status' => 'failed']);
        return response()->json(['success' => false, 'message' => $result['message']], 400);
    }

    public function paystackCallback(Request $request)
    {
        $reference = $request->reference;
        
        if (!$reference) {
            return redirect()->route('user.wallet.deposit.index')
                ->with('error', 'Invalid payment reference');
        }

        $deposit = WalletDeposit::where('gateway_reference', $reference)->first();
        
        if (!$deposit) {
            return redirect()->route('user.wallet.deposit.index')
                ->with('error', 'Deposit not found');
        }

        $verification = $this->paymentService->verifyPaystackPayment($reference);
        
        if ($verification && $verification['data']['status'] === 'success') {
            $deposit->update([
                'status' => 'completed',
                'paid_at' => now(),
                'gateway_response' => $verification['data']
            ]);
            
            return redirect()->route('user.wallet.deposit.index')
                ->with('success', 'Deposit successful! ₦' . number_format($deposit->credited_amount, 2) . ' has been added to your wallet.');
        }

        $deposit->update(['status' => 'failed', 'gateway_response' => $verification]);
        return redirect()->route('user.wallet.deposit.index')
            ->with('error', 'Payment verification failed');
    }

    public function flutterwaveCallback(Request $request)
    {
        $txRef = $request->tx_ref;
        $transactionId = $request->transaction_id;
        
        if (!$txRef || !$transactionId) {
            return redirect()->route('user.wallet.deposit.index')
                ->with('error', 'Invalid payment reference');
        }

        $deposit = WalletDeposit::where('gateway_reference', $txRef)->first();
        
        if (!$deposit) {
            return redirect()->route('user.wallet.deposit.index')
                ->with('error', 'Deposit not found');
        }

        $verification = $this->paymentService->verifyFlutterwavePayment($transactionId);
        
        if ($verification && $verification['data']['status'] === 'successful') {
            $deposit->update([
                'status' => 'completed',
                'paid_at' => now(),
                'gateway_response' => $verification['data']
            ]);
            
            return redirect()->route('user.wallet.deposit.index')
                ->with('success', 'Deposit successful! ₦' . number_format($deposit->credited_amount, 2) . ' has been added to your wallet.');
        }

        $deposit->update(['status' => 'failed', 'gateway_response' => $verification]);
        return redirect()->route('user.wallet.deposit.index')
            ->with('error', 'Payment verification failed');
    }
}
