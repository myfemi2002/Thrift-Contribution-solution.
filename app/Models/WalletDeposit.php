<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WalletDeposit extends Model
{
    protected $fillable = [
        'deposit_id',
        'user_id',
        'wallet_id',
        'amount',
        'fee_amount',
        'credited_amount',
        'payment_gateway',
        'gateway_reference',
        'status',
        'payment_method',
        'gateway_response',
        'paid_at',
        'customer_email',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'credited_amount' => 'decimal:2',
        'gateway_response' => 'array',
        'paid_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->deposit_id)) {
                $model->deposit_id = 'DEP-' . strtoupper(Str::random(8)) . '-' . date('YmdHis');
            }
        });

        static::updated(function ($deposit) {
            // When deposit is completed, credit wallet
            if ($deposit->wasChanged('status') && $deposit->status === 'completed') {
                $deposit->wallet->increment('balance', $deposit->credited_amount);
                
                // Log the deposit
                ContributionLog::create([
                    'log_id' => 'LOG-' . strtoupper(Str::random(6)) . '-' . time(),
                    'contribution_id' => null,
                    'user_id' => $deposit->user_id,
                    'agent_id' => $deposit->user_id, // Self-deposit
                    'action' => 'wallet_deposit',
                    'old_amount' => $deposit->wallet->balance - $deposit->credited_amount,
                    'new_amount' => $deposit->wallet->balance,
                    'metadata' => [
                        'deposit_id' => $deposit->deposit_id,
                        'gateway' => $deposit->payment_gateway,
                        'gateway_reference' => $deposit->gateway_reference,
                        'amount' => $deposit->amount,
                        'fee' => $deposit->fee_amount,
                        'credited' => $deposit->credited_amount
                    ],
                    'ip_address' => $deposit->ip_address,
                    'user_agent' => $deposit->user_agent
                ]);
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

    public function getFormattedAmountAttribute()
    {
        return '₦' . number_format($this->amount, 2);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'processing' => '<span class="badge bg-info">Processing</span>',
            'completed' => '<span class="badge bg-success">Completed</span>',
            'failed' => '<span class="badge bg-danger">Failed</span>',
            'cancelled' => '<span class="badge bg-secondary">Cancelled</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}
