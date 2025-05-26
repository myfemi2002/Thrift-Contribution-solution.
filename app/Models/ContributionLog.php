<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_id',
        'contribution_id',
        'user_id',
        'agent_id',
        'action',
        'old_amount',
        'new_amount',
        'metadata',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'old_amount' => 'decimal:2',
        'new_amount' => 'decimal:2',
        'metadata' => 'array'
    ];

    public function contribution()
    {
        return $this->belongsTo(DailyContribution::class, 'contribution_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function getActionBadgeAttribute()
    {
        $badges = [
            'created' => '<span class="badge bg-success">Created</span>',
            'updated' => '<span class="badge bg-info">Updated</span>',
            'deleted' => '<span class="badge bg-danger">Deleted</span>',
            'cancelled' => '<span class="badge bg-warning">Cancelled</span>'
        ];

        return $badges[$this->action] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}