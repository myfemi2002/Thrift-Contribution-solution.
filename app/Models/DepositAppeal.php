<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositAppeal extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'deposit_id',
        'reason',
        'status',
        'admin_notes',
        'fee_amount',
        'credited_amount'
    ];

    /**
     * Get the deposit that owns the appeal.
     */
    public function deposit()
    {
        return $this->belongsTo(CryptoDeposit::class, 'deposit_id');
    }
    
    /**
     * Calculate the fee amount based on the deposit amount.
     * 
     * @param float $depositAmount
     * @return float
     */
    public static function calculateFee($depositAmount)
    {
        // 20% fee
        return $depositAmount * 0.2;
    }
    
    /**
     * Calculate the credited amount after fee deduction.
     * 
     * @param float $depositAmount
     * @return float
     */
    public static function calculateCreditedAmount($depositAmount)
    {
        $fee = self::calculateFee($depositAmount);
        return $depositAmount - $fee;
    }



    /**
     * Calculate the fee amount based on the deposit rejection notes.
     * 
     * @param CryptoDeposit $deposit
     * @return float
     */
    public static function calculateActualFee($deposit)
    {
        $actualAmount = self::getActualAmount($deposit);
        return $actualAmount * 0.2; // 20% fee
    }

    /**
     * Calculate the credited amount after fee deduction based on actual amount.
     * 
     * @param CryptoDeposit $deposit
     * @return float
     */
    public static function calculateActualCreditedAmount($deposit)
    {
        $actualAmount = self::getActualAmount($deposit);
        $fee = $actualAmount * 0.2;
        return $actualAmount - $fee;
    }

    /**
     * Extract the actual amount from the deposit notes.
     * 
     * @param CryptoDeposit $deposit
     * @return float
     */
    public static function getActualAmount($deposit)
    {
        $notes = $deposit->notes;
        
        // Default to the claimed amount
        $actualAmount = $deposit->amount;
        
        // Try to extract the actual amount from notes
        if (preg_match('/actual\s+(\d+(\.\d+)?)/i', $notes, $matches) ||
            preg_match('/actual:\s*(\d+(\.\d+)?)/i', $notes, $matches)) {
            $actualAmount = floatval($matches[1]);
        }
        
        return $actualAmount;
    }


}
