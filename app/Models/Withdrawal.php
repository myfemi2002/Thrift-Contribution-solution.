<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'withdrawal_id',
        'user_id',
        'wallet_id',
        'amount',
        'fee',
        'net_amount',
        'payment_method',
        'bank_name',
        'account_number',
        'account_name',
        'status',
        'reason',
        'admin_notes',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'processed_at',
        'completed_at',
        'wallet_balance_before',
        'wallet_balance_after',
        'metadata',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'wallet_balance_before' => 'decimal:2',
        'wallet_balance_after' => 'decimal:2',
        'approved_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'metadata' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->withdrawal_id)) {
                $model->withdrawal_id = 'WTH-' . strtoupper(Str::random(8)) . '-' . date('YmdHis');
            }
            
            // Calculate net amount (amount - fee)
            $model->net_amount = $model->amount - $model->fee;
            
            // Set wallet balance before
            if ($model->wallet_id) {
                $wallet = \App\Models\Wallet::find($model->wallet_id);
                if ($wallet) {
                    $model->wallet_balance_before = $wallet->balance;
                }
            }
        });

        static::created(function ($withdrawal) {
            try {
                // Log the withdrawal creation
                Log::info('Withdrawal created', [
                    'withdrawal_id' => $withdrawal->withdrawal_id,
                    'user_id' => $withdrawal->user_id,
                    'amount' => $withdrawal->amount,
                    'status' => $withdrawal->status
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to log withdrawal creation: ' . $e->getMessage());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Status check methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    // Formatted attributes
    public function getFormattedAmountAttribute()
    {
        return '₦' . number_format($this->amount, 2);
    }

    public function getFormattedFeeAttribute()
    {
        return '₦' . number_format($this->fee, 2);
    }

    public function getFormattedNetAmountAttribute()
    {
        return '₦' . number_format($this->net_amount, 2);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'approved' => '<span class="badge bg-info">Approved</span>',
            'processing' => '<span class="badge bg-primary">Processing</span>',
            'completed' => '<span class="badge bg-success">Completed</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            'cancelled' => '<span class="badge bg-secondary">Cancelled</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getPaymentMethodLabelAttribute()
    {
        $methods = [
            'cash' => 'Cash',
            'bank_transfer' => 'Bank Transfer'
        ];

        return $methods[$this->payment_method] ?? 'Unknown';
    }

    public function getBankDetailsAttribute()
    {
        if ($this->payment_method === 'bank_transfer') {
            return [
                'bank_name' => $this->bank_name,
                'account_number' => $this->account_number,
                'account_name' => $this->account_name
            ];
        }
        return null;
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    // Action methods
    public function approve($adminId, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $adminId,
            'approved_at' => now(),
            'admin_notes' => $notes
        ]);
    }

    public function reject($adminId, $reason)
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $adminId,
            'approved_at' => now(),
            'rejection_reason' => $reason
        ]);
    }

    public function process($adminId)
    {
        $this->update([
            'status' => 'processing',
            'processed_at' => now()
        ]);
    }

    public function complete($adminId, $finalBalance = null)
    {
        $updateData = [
            'status' => 'completed',
            'completed_at' => now()
        ];

        if ($finalBalance !== null) {
            $updateData['wallet_balance_after'] = $finalBalance;
        }

        $this->update($updateData);

        // Deduct from wallet if not already done
        if ($this->wallet && $this->wallet_balance_after === null) {
            $this->wallet->decrement('balance', $this->amount);
            $this->update(['wallet_balance_after' => $this->wallet->fresh()->balance]);
        }
    }
}
