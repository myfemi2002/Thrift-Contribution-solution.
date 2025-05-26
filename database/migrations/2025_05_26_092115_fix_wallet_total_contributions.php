<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Wallet;
use App\Models\WalletAdjustment;
use App\Models\DailyContribution;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix existing wallet total_contributions to reflect actual contributions only
        
        $wallets = Wallet::with(['user', 'contributions', 'adjustments'])->get();
        
        foreach ($wallets as $wallet) {
            // Calculate actual contributions from daily_contributions table
            $actualContributions = $wallet->contributions()
                ->where('status', 'paid')
                ->where('amount', '>', 0)
                ->sum('amount');
            
            // Add omitted contribution adjustments (these are legitimate contributions)
            $omittedContributions = $wallet->adjustments()
                ->where('type', 'credit')
                ->where('reason', 'omitted_contribution')
                ->where('status', 'completed')
                ->sum('amount');
            
            // Subtract amounts that were incorrectly credited and later corrected
            $corrections = $wallet->adjustments()
                ->where('type', 'debit')
                ->whereIn('reason', ['correction_error', 'refund', 'penalty', 'duplicate_payment'])
                ->where('status', 'completed')
                ->sum('amount');
            
            $correctTotalContributions = $actualContributions + $omittedContributions - $corrections;
            
            // Update the wallet with correct total_contributions
            $wallet->update([
                'total_contributions' => $correctTotalContributions
            ]);
            
            echo "Fixed wallet for user {$wallet->user->name}: Total contributions corrected to ₦" . number_format($correctTotalContributions, 2) . "\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be easily reversed as it fixes data inconsistencies
        // If needed, you would need to recalculate based on the original flawed logic
    }
};