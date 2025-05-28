<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\SecurityTracking;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SecurityTracking;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret', // Added for security
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'profile' => 'array',
        'last_login_at' => 'datetime',
        'last_failed_login_at' => 'datetime',
        'is_logged_in' => 'boolean',
        'two_factor_enabled' => 'boolean',
    ];

    public static function getPermissionGroups()
    {
        return Cache::remember('permission_groups', 60, function () {
            return DB::table('permissions')
                ->select('group_name')
                ->groupBy('group_name')
                ->get();
        });
    }

    public static function getPermissionByGroupName($group_name)
    {
        return Cache::remember("permissions_by_group_{$group_name}", 60, function () use ($group_name) {
            return DB::table('permissions')
                ->select('id', 'sidebar_name')
                ->where('group_name', $group_name)
                ->get();
        });
    }

    public static function roleHasPermissions($role, $permissions)
    {
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                return false;
            }
        }
        return true;
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d M Y') : 'N/A';
    }


    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($user) {
            // Auto-create wallet for new users with role 'user'
            if ($user->role === 'user') {
                Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0.00,
                    'total_contributions' => 0.00,
                    'status' => 'active'
                ]);
            }
        });
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function contributions()
    {
        return $this->hasMany(DailyContribution::class);
    }

    public function agentContributions()
    {
        return $this->hasMany(DailyContribution::class, 'agent_id');
    }

    public function contributionLogs()
    {
        return $this->hasMany(ContributionLog::class);
    }

    public function agentLogs()
    {
        return $this->hasMany(ContributionLog::class, 'agent_id');
    }

    public function hasContributionForDate($date)
    {
        return $this->contributions()
            ->whereDate('contribution_date', $date)
            ->exists();
    }

    public function getContributionForDate($date)
    {
        return $this->contributions()
            ->whereDate('contribution_date', $date)
            ->first();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
    public function walletDeposits()
    {
        return $this->hasMany(WalletDeposit::class);
    }
    
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function approvedWithdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'approved_by');
    }

    public function loanWallet()
    {
        return $this->hasOne(LoanWallet::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function loanNotifications()
    {
        return $this->hasMany(LoanNotification::class);
    }

    public function recordedRepayments()
    {
        return $this->hasMany(LoanRepayment::class, 'recorded_by');
    }

    public function approvedLoans()
    {
        return $this->hasMany(Loan::class, 'approved_by');
    }
    
    /**
     * Get user's loan interest rate based on credit rating
     */
    public function getLoanInterestRateAttribute()
    {
        $profile = $this->profile ?? [];
        return $profile['loan_interest_rate'] ?? 10.0; // Default 10%
    }

    /**
     * Get user's credit rating
     */
    public function getCreditRatingAttribute()
    {
        $profile = $this->profile ?? [];
        return $profile['credit_rating'] ?? null;
    }

    /**
     * Get user's credit rating badge HTML
     */
    public function getCreditRatingBadgeAttribute()
    {
        $creditRating = $this->credit_rating;
        
        if (!$creditRating) {
            return '<span class="badge bg-light text-dark">No Rating</span>';
        }

        $badges = [
            'Gold Saver' => '<span class="badge bg-warning text-dark">🥇 Gold Saver</span>',
            'Silver Saver' => '<span class="badge bg-secondary">🥈 Silver Saver</span>',
            'Bronze Saver' => '<span class="badge bg-dark text-light">🥉 Bronze Saver</span>'
        ];

        return $badges[$creditRating] ?? '<span class="badge bg-light text-dark">' . $creditRating . '</span>';
    }

    /**
     * Update user's loan profile (interest rate and credit rating)
     */
    public function updateLoanProfile($interestRate, $creditRating)
    {
        $profile = $this->profile ?? [];
        $profile['loan_interest_rate'] = $interestRate;
        $profile['credit_rating'] = $creditRating;
        $profile['credit_rating_updated_at'] = now()->toISOString();
        
        $this->update(['profile' => $profile]);
    }

    /**
     * Get profile field value
     */
    public function getProfileField($key, $default = null)
    {
        $profile = $this->profile ?? [];
        return $profile[$key] ?? $default;
    }

    /**
     * Set profile field value
     */
    public function setProfileField($key, $value)
    {
        $profile = $this->profile ?? [];
        $profile[$key] = $value;
        $this->update(['profile' => $profile]);
    }
}
    
