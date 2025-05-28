<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'user_id',
        'loan_wallet_id',
        'approved_by',
        'amount',
        'interest_rate',
        'interest_amount',
        'total_amount',
        'amount_paid',
        'outstanding_balance',
        'status',
        'purpose',
        'admin_notes',
        'rejection_reason',
        'disbursement_date',
        'due_date',
        'repayment_start_date',
        'duration_days',
        'credit_rating',
        'custom_interest_rate',
        'interest_overridden',
        'metadata',
        'approved_at',
        'disbursed_at',
        'completed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'interest_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'custom_interest_rate' => 'decimal:2',
        'interest_overridden' => 'boolean',
        'metadata' => 'array',
        'disbursement_date' => 'date',
        'due_date' => 'date',
        'repayment_start_date' => 'date',
        'approved_at' => 'datetime',
        'disbursed_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    // protected static function boot()
    // {
    //     parent::boot();
        
    //     static::creating(function ($model) {
    //         if (empty($model->loan_id)) {
    //             $model->loan_id = 'LOAN-' . strtoupper(Str::random(8)) . '-' . date('YmdHis');
    //         }
            
    //         // Calculate interest and total amount
    //         $model->calculateLoanAmounts();
    //     });

    //     static::created(function ($loan) {
    //         // Create notification for loan application
    //         LoanNotification::create([
    //             'user_id' => $loan->user_id,
    //             'loan_id' => $loan->id,
    //             'type' => 'loan_applied',
    //             'title' => 'Loan Application Submitted',
    //             'message' => "Your loan application for ₦" . number_format($loan->amount, 2) . " has been submitted and is under review.",
    //             'data' => [
    //                 'loan_id' => $loan->loan_id,
    //                 'amount' => $loan->amount,
    //                 'status' => $loan->status
    //             ]
    //         ]);
    //     });
    // }

    
    // Also update the boot method to use user's interest rate

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->loan_id)) {
                $model->loan_id = 'LOAN-' . strtoupper(Str::random(8)) . '-' . date('YmdHis');
            }
            
            // Use user's credit rating interest rate if available
            if (!$model->interest_overridden && !$model->custom_interest_rate) {
                $user = User::find($model->user_id);
                if ($user && $user->loan_interest_rate) {
                    $model->interest_rate = $user->loan_interest_rate;
                }
            }
            
            // Calculate interest and total amount
            $model->calculateLoanAmounts();
        });

        static::created(function ($loan) {
            // Create notification for loan application
            LoanNotification::create([
                'user_id' => $loan->user_id,
                'loan_id' => $loan->id,
                'type' => 'loan_applied',
                'title' => 'Loan Application Submitted',
                'message' => "Your loan application for ₦" . number_format($loan->amount, 2) . " has been submitted and is under review.",
                'data' => [
                    'loan_id' => $loan->loan_id,
                    'amount' => $loan->amount,
                    'status' => $loan->status,
                    'interest_rate' => $loan->interest_rate
                ]
            ]);
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanWallet()
    {
        return $this->belongsTo(LoanWallet::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    public function notifications()
    {
        return $this->hasMany(LoanNotification::class);
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        return '₦' . number_format($this->amount, 2);
    }

    public function getFormattedTotalAmountAttribute()
    {
        return '₦' . number_format($this->total_amount, 2);
    }

    public function getFormattedOutstandingBalanceAttribute()
    {
        return '₦' . number_format($this->outstanding_balance, 2);
    }

    public function getFormattedAmountPaidAttribute()
    {
        return '₦' . number_format($this->amount_paid, 2);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'approved' => '<span class="badge bg-info">Approved</span>',
            'disbursed' => '<span class="badge bg-primary">Disbursed</span>',
            'active' => '<span class="badge bg-success">Active</span>',
            'completed' => '<span class="badge bg-success">Completed</span>',
            'overdue' => '<span class="badge bg-danger">Overdue</span>',
            'defaulted' => '<span class="badge bg-dark">Defaulted</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getCreditRatingBadgeAttribute()
    {
        $badges = [
            'Gold Saver' => '<span class="badge bg-warning text-dark">🥇 Gold Saver</span>',
            'Silver Saver' => '<span class="badge bg-secondary">🥈 Silver Saver</span>',
            'Bronze Saver' => '<span class="badge bg-dark">🥉 Bronze Saver</span>'
        ];

        return $badges[$this->credit_rating] ?? '<span class="badge bg-light text-dark">No Rating</span>';
    }

    public function getDaysUntilDueAttribute()
    {
        if (!$this->due_date || $this->status === 'completed') {
            return null;
        }

        return Carbon::now()->diffInDays($this->due_date, false);
    }

    public function getIsOverdueAttribute()
    {
        if (!$this->due_date || $this->status === 'completed') {
            return false;
        }

        return Carbon::now()->isAfter($this->due_date);
    }

    public function getRepaymentProgressAttribute()
    {
        if ($this->total_amount <= 0) {
            return 0;
        }

        return ($this->amount_paid / $this->total_amount) * 100;
    }

    // Methods
    public function calculateLoanAmounts()
    {
        $interestRate = $this->interest_overridden && $this->custom_interest_rate 
            ? $this->custom_interest_rate 
            : $this->interest_rate;

        $this->interest_amount = ($this->amount * $interestRate) / 100;
        $this->total_amount = $this->amount + $this->interest_amount;
        $this->outstanding_balance = $this->total_amount - $this->amount_paid;
    }

    public function approve($adminId, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $adminId,
            'admin_notes' => $notes,
            'approved_at' => now()
        ]);

        // Create notification
        LoanNotification::create([
            'user_id' => $this->user_id,
            'loan_id' => $this->id,
            'type' => 'loan_approved',
            'title' => 'Loan Approved! 🎉',
            'message' => "Great news! Your loan application for {$this->formatted_amount} has been approved. Disbursement will happen shortly.",
            'is_popup' => true,
            'data' => [
                'loan_id' => $this->loan_id,
                'amount' => $this->amount,
                'total_amount' => $this->total_amount,
                'approved_by' => $this->approvedBy->name ?? 'Admin'
            ]
        ]);

        Log::info('Loan approved', ['loan_id' => $this->loan_id, 'admin_id' => $adminId]);
    }

    public function reject($adminId, $reason)
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $adminId,
            'rejection_reason' => $reason,
            'approved_at' => now()
        ]);

        // Create notification
        LoanNotification::create([
            'user_id' => $this->user_id,
            'loan_id' => $this->id,
            'type' => 'loan_rejected',
            'title' => 'Loan Application Update',
            'message' => "Your loan application for {$this->formatted_amount} has been reviewed. Please check your loan details for more information.",
            'data' => [
                'loan_id' => $this->loan_id,
                'amount' => $this->amount,
                'reason' => $reason
            ]
        ]);

        Log::info('Loan rejected', ['loan_id' => $this->loan_id, 'admin_id' => $adminId, 'reason' => $reason]);
    }

    public function disburse($adminId)
    {
        if ($this->status !== 'approved') {
            throw new \Exception('Only approved loans can be disbursed');
        }

        // Calculate repayment dates
        $disbursementDate = now()->toDateString();
        $repaymentStartDate = now()->addWeekdays(2)->toDateString(); // 2 working days later
        $dueDate = now()->addDays($this->duration_days)->toDateString();

        $this->update([
            'status' => 'disbursed',
            'disbursement_date' => $disbursementDate,
            'repayment_start_date' => $repaymentStartDate,
            'due_date' => $dueDate,
            'disbursed_at' => now()
        ]);

        // Credit loan wallet
        $this->loanWallet->increment('balance', $this->amount);
        $this->loanWallet->increment('total_borrowed', $this->amount);

        // Create notification
        LoanNotification::create([
            'user_id' => $this->user_id,
            'loan_id' => $this->id,
            'type' => 'loan_disbursed',
            'title' => 'Loan Disbursed! 💰',
            'message' => "Your loan of {$this->formatted_amount} has been disbursed to your loan wallet. Repayment starts on " . Carbon::parse($repaymentStartDate)->format('M d, Y'),
            'is_popup' => true,
            'data' => [
                'loan_id' => $this->loan_id,
                'amount' => $this->amount,
                'repayment_start_date' => $repaymentStartDate,
                'due_date' => $dueDate
            ]
        ]);

        Log::info('Loan disbursed', ['loan_id' => $this->loan_id, 'admin_id' => $adminId]);

        // Update status to active
        $this->update(['status' => 'active']);
    }

    public function recordRepayment($adminId, $amount, $paymentMethod = 'cash', $referenceNumber = null, $notes = null)
    {
        if ($this->status !== 'active' && $this->status !== 'disbursed') {
            throw new \Exception('Can only record repayments for active loans');
        }

        $outstandingBefore = $this->outstanding_balance;
        $outstandingAfter = max(0, $outstandingBefore - $amount);

        // Create repayment record
        $repayment = LoanRepayment::create([
            'loan_id' => $this->id,
            'user_id' => $this->user_id,
            'recorded_by' => $adminId,
            'amount' => $amount,
            'outstanding_before' => $outstandingBefore,
            'outstanding_after' => $outstandingAfter,
            'payment_method' => $paymentMethod,
            'reference_number' => $referenceNumber,
            'notes' => $notes,
            'payment_date' => now()->toDateString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // Update loan
        $this->increment('amount_paid', $amount);
        $this->update(['outstanding_balance' => $outstandingAfter]);

        // Update loan wallet
        $this->loanWallet->increment('total_repaid', $amount);

        // Check if loan is completed
        if ($outstandingAfter <= 0) {
            $this->completeLoan();
        }

        // Create notification
        LoanNotification::create([
            'user_id' => $this->user_id,
            'loan_id' => $this->id,
            'type' => 'repayment_recorded',
            'title' => 'Payment Received! 💳',
            'message' => "Your payment of ₦" . number_format($amount, 2) . " has been recorded. Outstanding balance: ₦" . number_format($outstandingAfter, 2),
            'is_popup' => true,
            'data' => [
                'loan_id' => $this->loan_id,
                'amount_paid' => $amount,
                'outstanding_balance' => $outstandingAfter,
                'repayment_id' => $repayment->repayment_id
            ]
        ]);

        Log::info('Loan repayment recorded', [
            'loan_id' => $this->loan_id,
            'amount' => $amount,
            'outstanding_after' => $outstandingAfter,
            'admin_id' => $adminId
        ]);

        return $repayment;
    }

    // public function completeLoan()
    // {
    //     // Calculate credit rating based on repayment timeline
    //     $daysToComplete = Carbon::parse($this->disbursement_date)->diffInDays(now());
        
    //     if ($daysToComplete <= 15) {
    //         $creditRating = 'Gold Saver';
    //         $newInterestRate = 7.5;
    //     } elseif ($daysToComplete <= 25) {
    //         $creditRating = 'Silver Saver';
    //         $newInterestRate = 8.5;
    //     } else {
    //         $creditRating = 'Bronze Saver';
    //         $newInterestRate = 10.0;
    //     }

    //     $this->update([
    //         'status' => 'completed',
    //         'credit_rating' => $creditRating,
    //         'completed_at' => now()
    //     ]);

    //     // Update user's default interest rate for future loans (store in metadata or user profile)
    //     $user = $this->user;
    //     $profile = $user->profile ?? [];
    //     $profile['loan_interest_rate'] = $newInterestRate;
    //     $profile['credit_rating'] = $creditRating;
    //     // Assuming you have a profile field or metadata field in users table

    //     // Create completion notification
    //     LoanNotification::create([
    //         'user_id' => $this->user_id,
    //         'loan_id' => $this->id,
    //         'type' => 'loan_completed',
    //         'title' => 'Loan Completed! 🎉✨',
    //         'message' => "Congratulations! You've successfully completed your loan. You've earned the '{$creditRating}' badge and qualify for {$newInterestRate}% interest rate on future loans!",
    //         'is_popup' => true,
    //         'data' => [
    //             'loan_id' => $this->loan_id,
    //             'credit_rating' => $creditRating,
    //             'new_interest_rate' => $newInterestRate,
    //             'completion_date' => now()->toDateString()
    //         ]
    //     ]);

    //     Log::info('Loan completed', [
    //         'loan_id' => $this->loan_id,
    //         'credit_rating' => $creditRating,
    //         'days_to_complete' => $daysToComplete
    //     ]);
    // }

    public function checkOverdue()
    {
        if ($this->status === 'active' && $this->is_overdue && $this->status !== 'overdue') {
            $this->update(['status' => 'overdue']);

            // Create overdue notification
            LoanNotification::create([
                'user_id' => $this->user_id,
                'loan_id' => $this->id,
                'type' => 'loan_overdue',
                'title' => 'Loan Overdue ⚠️',
                'message' => "Your loan payment is overdue. Please make a payment as soon as possible to avoid additional charges.",
                'is_popup' => true,
                'data' => [
                    'loan_id' => $this->loan_id,
                    'outstanding_balance' => $this->outstanding_balance,
                    'days_overdue' => abs($this->days_until_due)
                ]
            ]);

            Log::warning('Loan marked as overdue', ['loan_id' => $this->loan_id]);
        }
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['disbursed', 'active']);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

        public function completeLoan()
    {
        // Calculate credit rating based on repayment timeline
        $daysToComplete = Carbon::parse($this->disbursement_date)->diffInDays(now());
        
        if ($daysToComplete <= 15) {
            $creditRating = 'Gold Saver';
            $newInterestRate = 7.5;
        } elseif ($daysToComplete <= 25) {
            $creditRating = 'Silver Saver';
            $newInterestRate = 8.5;
        } else {
            $creditRating = 'Bronze Saver';
            $newInterestRate = 10.0;
        }

        $this->update([
            'status' => 'completed',
            'credit_rating' => $creditRating,
            'completed_at' => now()
        ]);

        // Update user's profile with new interest rate and credit rating
        $user = $this->user;
        $user->updateLoanProfile($newInterestRate, $creditRating);

        // Create completion notification
        LoanNotification::create([
            'user_id' => $this->user_id,
            'loan_id' => $this->id,
            'type' => 'loan_completed',
            'title' => 'Loan Completed! 🎉✨',
            'message' => "Congratulations! You've successfully completed your loan. You've earned the '{$creditRating}' badge and qualify for {$newInterestRate}% interest rate on future loans!",
            'is_popup' => true,
            'data' => [
                'loan_id' => $this->loan_id,
                'credit_rating' => $creditRating,
                'new_interest_rate' => $newInterestRate,
                'completion_date' => now()->toDateString(),
                'days_to_complete' => $daysToComplete
            ]
        ]);

        Log::info('Loan completed', [
            'loan_id' => $this->loan_id,
            'credit_rating' => $creditRating,
            'days_to_complete' => $daysToComplete,
            'new_interest_rate' => $newInterestRate
        ]);
    }

}
