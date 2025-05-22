<?php

namespace App\Models;


use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MotherWallet extends Model
{
    use HasFactory;

    protected $fillable = ['wallet_address', 'is_active'];

    /**
     * Get the user wallets associated with this mother wallet.
     */
    public function userWallets()
    {
        return $this->hasMany(UserWallet::class);
    }

    /**
     * Get a random active mother wallet.
     */
    public static function getRandomActiveWallet()
    {
        $wallet = self::where('is_active', true)->inRandomOrder()->first();
        
        // If no active wallets, try to get any wallet
        if (!$wallet) {
            $wallet = self::inRandomOrder()->first();
            
            // If we found one, make it active
            if ($wallet) {
                $wallet->is_active = true;
                $wallet->save();
                
                Log::warning("No active mother wallets found. Activated wallet ID: {$wallet->id}");
            } else {
                Log::error("No mother wallets found in the system at all!");
            }
        }
        
        return $wallet;
    }
}