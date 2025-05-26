<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'total_contributions',
        'status'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'total_contributions' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contributions()
    {
        return $this->hasMany(DailyContribution::class);
    }

    public function adjustments()
    {
        return $this->hasMany(WalletAdjustment::class);
    }

    /**
     * Add a regular contribution (increases both balance and total_contributions)
     */
    public function addContribution($amount)
    {
        $this->increment('balance', $amount);
        $this->increment('total_contributions', $amount);
    }

    /**
     * Apply wallet adjustment based on type and reason
     */
    public function applyAdjustment($type, $amount, $reason)
    {
        if ($type === 'credit') {
            // Credit always increases balance
            $this->increment('balance', $amount);
            
            // Only increase total_contributions for omitted contributions
            if ($reason === 'omitted_contribution') {
                $this->increment('total_contributions', $amount);
            }
        } else {
            // Debit always decreases balance
            $this->decrement('balance', $amount);
            
            // Decrease total_contributions for over-credit corrections, refunds, penalties
            if (in_array($reason, ['correction_error', 'refund', 'penalty', 'duplicate_payment'])) {
                $this->decrement('total_contributions', $amount);
            }
        }
    }

    /**
     * Get the actual total contributions (excluding adjustments that shouldn't count)
     */
    public function getActualTotalContributions()
    {
        // Calculate from actual paid contributions
        $contributionsTotal = $this->contributions()
            ->where('status', 'paid')
            ->where('amount', '>', 0)
            ->sum('amount');

        // Add only omitted contribution adjustments
        $omittedContributions = $this->adjustments()
            ->where('type', 'credit')
            ->where('reason', 'omitted_contribution')
            ->where('status', 'completed')
            ->sum('amount');

        // Subtract correction errors, refunds, penalties that were incorrectly counted
        $deductions = $this->adjustments()
            ->where('type', 'debit')
            ->whereIn('reason', ['correction_error', 'refund', 'penalty', 'duplicate_payment'])
            ->where('status', 'completed')
            ->sum('amount');

        return $contributionsTotal + $omittedContributions - $deductions;
    }

    /**
     * Recalculate and fix total_contributions
     */
    public function recalculateTotalContributions()
    {
        $actualTotal = $this->getActualTotalContributions();
        $this->update(['total_contributions' => $actualTotal]);
        return $actualTotal;
    }

    public function getFormattedBalanceAttribute()
    {
        return '₦' . number_format($this->balance, 2);
    }

    public function getFormattedTotalContributionsAttribute()
    {
        return '₦' . number_format($this->total_contributions, 2);
    }

    public function getFormattedActualTotalContributionsAttribute()
    {
        return '₦' . number_format($this->getActualTotalContributions(), 2);
    }
}
