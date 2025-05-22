<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositTransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_id',
        'user_id',
        'action_type',
        'amount',
        'fee_amount',
        'credited_amount',
        'notes',
        'performed_by'
    ];

    /**
     * Get the deposit that owns the log.
     */
    public function deposit()
    {
        return $this->belongsTo(CryptoDeposit::class, 'deposit_id');
    }

    /**
     * Get the user that owns the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who performed the action.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
    
    /**
     * Get a formatted action name for display.
     */
    public function getFormattedActionAttribute()
    {
        $actions = [
            'created' => 'Deposit Created',
            'approved' => 'Deposit Approved',
            'rejected' => 'Deposit Rejected',
            'verified' => 'Verified on Blockchain',
            'appealed' => 'Appeal Submitted',
            'appeal_approved' => 'Appeal Approved',
            'appeal_rejected' => 'Appeal Rejected'
        ];
        
        return $actions[$this->action_type] ?? ucfirst(str_replace('_', ' ', $this->action_type));
    }
    
    /**
     * Create a transaction log entry.
     */
    public static function createLog($depositId, $userId, $actionType, $amount = 0, $feeAmount = 0, $creditedAmount = 0, $notes = null, $performedBy = null)
    {
        return self::create([
            'deposit_id' => $depositId,
            'user_id' => $userId,
            'action_type' => $actionType,
            'amount' => $amount,
            'fee_amount' => $feeAmount,
            'credited_amount' => $creditedAmount,
            'notes' => $notes,
            'performed_by' => $performedBy
        ]);
    }
}
