<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DailyContribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'wallet_id',
        'agent_id',
        'amount',
        'contribution_date',
        'status',
        'payment_method',
        'notes',
        'receipt_number',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'contribution_date' => 'date',
        'paid_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->transaction_id)) {
                $model->transaction_id = 'TXN-' . strtoupper(Str::random(8)) . '-' . date('YmdHis');
            }
            
            if ($model->amount > 0 && empty($model->paid_at)) {
                $model->paid_at = now();
            }
        });

        static::created(function ($contribution) {
            // Log the creation
            ContributionLog::create([
                'log_id' => 'LOG-' . strtoupper(Str::random(6)) . '-' . time(),
                'contribution_id' => $contribution->id,
                'user_id' => $contribution->user_id,
                'agent_id' => $contribution->agent_id,
                'action' => 'created',
                'new_amount' => $contribution->amount,
                'metadata' => [
                    'payment_method' => $contribution->payment_method,
                    'receipt_number' => $contribution->receipt_number
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            // Update wallet if paid
            if ($contribution->amount > 0) {
                $contribution->wallet->addContribution($contribution->amount);
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

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function logs()
    {
        return $this->hasMany(ContributionLog::class, 'contribution_id');
    }

    public function getFormattedAmountAttribute()
    {
        return '₦' . number_format($this->amount, 2);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'paid' => '<span class="badge bg-success">Paid</span>',
            'unpaid' => '<span class="badge bg-danger">Unpaid</span>',
            'pending' => '<span class="badge bg-warning">Pending</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function isPaid()
    {
        return $this->status === 'paid' && $this->amount > 0;
    }

    public function isUnpaid()
    {
        return $this->status === 'unpaid' || $this->amount == 0;
    }
}
