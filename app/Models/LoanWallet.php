<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LoanWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'total_borrowed',
        'total_repaid',
        'status'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'total_borrowed' => 'decimal:2',
        'total_repaid' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->whereIn('status', ['disbursed', 'active']);
    }

    public function getFormattedBalanceAttribute()
    {
        return '₦' . number_format($this->balance, 2);
    }

    public function getFormattedTotalBorrowedAttribute()
    {
        return '₦' . number_format($this->total_borrowed, 2);
    }

    public function getFormattedTotalRepaidAttribute()
    {
        return '₦' . number_format($this->total_repaid, 2);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="badge bg-success">Active</span>',
            'suspended' => '<span class="badge bg-warning">Suspended</span>',
            'closed' => '<span class="badge bg-danger">Closed</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getTotalOutstandingAttribute()
    {
        return $this->activeLoans()->sum('outstanding_balance');
    }

    public function canBorrow($amount = 0)
    {
        if ($this->status !== 'active') {
            return false;
        }

        // Check if user has any overdue loans
        $overdueLoans = $this->loans()->where('status', 'overdue')->count();
        if ($overdueLoans > 0) {
            return false;
        }

        // Additional eligibility checks can be added here
        return true;
    }

    public function getEligibilityStatus()
    {
        if ($this->status !== 'active') {
            return [
                'eligible' => false,
                'reason' => 'Loan wallet is not active'
            ];
        }

        $overdueLoans = $this->loans()->where('status', 'overdue')->count();
        if ($overdueLoans > 0) {
            return [
                'eligible' => false,
                'reason' => 'You have overdue loans that need to be settled'
            ];
        }

        $activeLoans = $this->activeLoans()->count();
        if ($activeLoans >= 1) { // Maximum 1 active loans
            return [
                'eligible' => false,
                'reason' => 'You have reached the maximum number of active loans'
            ];
        }

        return [
            'eligible' => true,
            'reason' => 'Eligible for loan'
        ];
    }
}