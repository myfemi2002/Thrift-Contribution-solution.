<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanRepayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'repayment_id',
        'loan_id',
        'user_id',
        'recorded_by',
        'amount',
        'outstanding_before',
        'outstanding_after',
        'payment_method',
        'reference_number',
        'notes',
        'payment_date',
        'status',
        'metadata',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'outstanding_before' => 'decimal:2',
        'outstanding_after' => 'decimal:2',
        'payment_date' => 'date',
        'metadata' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->repayment_id)) {
                $model->repayment_id = 'REP-' . strtoupper(Str::random(8)) . '-' . date('YmdHis');
            }
        });
    }

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        return '₦' . number_format($this->amount, 2);
    }

    public function getFormattedOutstandingBeforeAttribute()
    {
        return '₦' . number_format($this->outstanding_before, 2);
    }

    public function getFormattedOutstandingAfterAttribute()
    {
        return '₦' . number_format($this->outstanding_after, 2);
    }

    public function getPaymentMethodDisplayAttribute()
    {
        $methods = [
            'cash' => 'Cash',
            'bank_transfer' => 'Bank Transfer',
            'mobile_money' => 'Mobile Money',
            'card' => 'Card Payment',
            'deduction' => 'Wallet Deduction',
            'other' => 'Other'
        ];

        return $methods[$this->payment_method] ?? 'Unknown';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'completed' => '<span class="badge bg-success">Completed</span>',
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'failed' => '<span class="badge bg-danger">Failed</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
        
 }