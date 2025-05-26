<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'adjustment_id',
        'user_id',
        'wallet_id',
        'admin_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'reason',
        'description',
        'reference_number',
        'reference_date',
        'metadata',
        'status',
        'approved_at',
        'approved_by',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'reference_date' => 'date',
        'approved_at' => 'datetime',
        'metadata' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->adjustment_id)) {
                $model->adjustment_id = 'ADJ-' . strtoupper(Str::random(8)) . '-' . date('YmdHis');
            }
            
            // Ensure metadata is properly formatted
            if (is_array($model->metadata)) {
                $model->metadata = json_encode($model->metadata);
            }
        });

        static::created(function ($adjustment) {
            try {
                // Create log entry
                ContributionLog::create([
                    'log_id' => 'LOG-' . strtoupper(Str::random(6)) . '-' . time(),
                    'contribution_id' => null, // No specific contribution
                    'user_id' => $adjustment->user_id,
                    'agent_id' => $adjustment->admin_id,
                    'action' => 'adjustment_' . $adjustment->type,
                    'old_amount' => $adjustment->balance_before,
                    'new_amount' => $adjustment->balance_after,
                    'metadata' => [
                        'adjustment_id' => $adjustment->adjustment_id,
                        'reason' => $adjustment->reason,
                        'description' => $adjustment->description,
                        'reference_number' => $adjustment->reference_number,
                        'status' => $adjustment->status
                    ],
                    'ip_address' => $adjustment->ip_address,
                    'user_agent' => $adjustment->user_agent
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to create contribution log for adjustment: ' . $e->getMessage());
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

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getFormattedAmountAttribute()
    {
        return ($this->type === 'debit' ? '-' : '+') . '₦' . number_format($this->amount, 2);
    }

    public function getTypeBadgeAttribute()
    {
        $badges = [
            'credit' => '<span class="badge bg-success">Credit</span>',
            'debit' => '<span class="badge bg-danger">Debit</span>'
        ];

        return $badges[$this->type] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'approved' => '<span class="badge bg-info">Approved</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            'completed' => '<span class="badge bg-success">Completed</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getReasonLabelAttribute()
    {
        $reasons = [
            'omitted_contribution' => 'Omitted Contribution',
            'correction_error' => 'Correction Error',
            'admin_adjustment' => 'Admin Adjustment',
            'system_error' => 'System Error',
            'duplicate_payment' => 'Duplicate Payment',
            'refund' => 'Refund',
            'bonus' => 'Bonus',
            'penalty' => 'Penalty',
            'other' => 'Other'
        ];

        return $reasons[$this->reason] ?? 'Unknown';
    }

    public function scopeCredits($query)
    {
        return $query->where('type', 'credit');
    }

    public function scopeDebits($query)
    {
        return $query->where('type', 'debit');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
