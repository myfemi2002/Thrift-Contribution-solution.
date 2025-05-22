<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tx_id',
        'amount',
        'status',
        'appeal_status',
        'screenshot_path',
        'notes'
    ];

    /**
     * Get the user that owns the deposit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the appeal for the deposit.
     */
    public function appeal()
    {
        return $this->hasOne(DepositAppeal::class, 'deposit_id');
    }
    
    /**
     * Check if deposit is eligible for appeal.
     */
    // public function isEligibleForAppeal()
    // {
    //     // Eligible if rejected and no appeal submitted yet and reason contains "Amount mismatch"
    //     return $this->status === 'rejected' && 
    //            $this->appeal_status === null && 
    //            strpos($this->notes, 'Amount mismatch') !== false;
    // }

    public function isEligibleForAppeal()
    {
        // Eligible if:
        // 1. Status is 'rejected'
        // 2. No appeal has been submitted yet (appeal_status is null)
        // 3. Rejection reason contains amount discrepancy indicators
        $amountKeywords = ['amount mismatch', 'actual amount', 'claimed', 'actual', 'different amount'];
        
        if ($this->status !== 'rejected' || !empty($this->appeal_status)) {
            return false;
        }
        
        // Check if any of the keywords are in the notes
        foreach ($amountKeywords as $keyword) {
            if (stripos($this->notes, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }

}
