<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserWallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'mother_wallet_id', 'balance'];

    /**
     * Get the user that owns the wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the mother wallet associated with this user wallet.
     */
    public function motherWallet()
    {
        return $this->belongsTo(MotherWallet::class);
    }

    /**
     * Get deposits for this user wallet.
     */
    public function deposits()
    {
        return $this->hasMany(CryptoDeposit::class, 'user_id', 'user_id');
    }
}
