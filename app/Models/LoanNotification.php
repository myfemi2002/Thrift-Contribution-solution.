<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loan_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'is_popup',
        'popup_shown',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'is_popup' => 'boolean',
        'popup_shown' => 'boolean',
        'read_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    // Accessors
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIconAttribute()
    {
        $icons = [
            'loan_applied' => 'ni-file-text',
            'loan_approved' => 'ni-check-circle',
            'loan_rejected' => 'ni-cross-circle',
            'loan_disbursed' => 'ni-wallet-out',
            'repayment_recorded' => 'ni-money',
            'loan_completed' => 'ni-check-circle-fill',
            'loan_overdue' => 'ni-alert-circle',
            'loan_reminder' => 'ni-bell'
        ];

        return $icons[$this->type] ?? 'ni-info';
    }

    public function getColorAttribute()
    {
        $colors = [
            'loan_applied' => 'info',
            'loan_approved' => 'success',
            'loan_rejected' => 'danger',
            'loan_disbursed' => 'primary',
            'repayment_recorded' => 'success',
            'loan_completed' => 'success',
            'loan_overdue' => 'danger',
            'loan_reminder' => 'warning'
        ];

        return $colors[$this->type] ?? 'secondary';
    }

    // Methods
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }

    public function markPopupAsShown()
    {
        if ($this->is_popup && !$this->popup_shown) {
            $this->update(['popup_shown' => true]);
        }
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopePopup($query)
    {
        return $query->where('is_popup', true);
    }

    public function scopeUnshownPopups($query)
    {
        return $query->where('is_popup', true)
                    ->where('popup_shown', false);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
