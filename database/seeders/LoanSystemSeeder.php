<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LoanWallet;
use App\Models\Loan;
use App\Models\LoanRepayment;
use Carbon\Carbon;

class LoanSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Setting up Loan System...');

        // Get all users with role 'user'
        $users = User::where('role', 'user')->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found with role "user". Please create some users first.');
            return;
        }

        $this->command->info("Found {$users->count()} users. Creating loan wallets...");

        // Create loan wallets for all users
        foreach ($users as $user) {
            $loanWallet = LoanWallet::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'balance' => 0.00,
                    'total_borrowed' => 0.00,
                    'total_repaid' => 0.00,
                    'status' => 'active'
                ]
            );

            $this->command->line("Created loan wallet for {$user->name}");
        }

        // Create sample loans for demonstration
        $this->createSampleLoans($users);

        $this->command->info('Loan system setup completed!');
    }

    /**
     * Create sample loans for demonstration
     */
    private function createSampleLoans($users)
    {
        $this->command->info('Creating sample loans...');

        $sampleLoans = [
            [
                'amount' => 50000,
                'purpose' => 'Business expansion - need funds to purchase inventory for my retail store',
                'status' => 'completed',
                'interest_rate' => 7.5,
                'credit_rating' => 'Gold Saver'
            ],
            [
                'amount' => 25000,
                'purpose' => 'Emergency medical expenses for family member',
                'status' => 'active',
                'interest_rate' => 10.0,
                'credit_rating' => null
            ],
            [
                'amount' => 75000,
                'purpose' => 'Education fees for professional certification course',
                'status' => 'pending',
                'interest_rate' => 10.0,
                'credit_rating' => null
            ],
            [
                'amount' => 30000,
                'purpose' => 'Home repairs and maintenance work',
                'status' => 'disbursed',
                'interest_rate' => 8.5,
                'credit_rating' => 'Silver Saver'
            ],
            [
                'amount' => 100000,
                'purpose' => 'Investment opportunity in local cooperative',
                'status' => 'approved',
                'interest_rate' => 10.0,
                'credit_rating' => null
            ]
        ];

        $adminUser = User::where('role', 'admin')->first();
        if (!$adminUser) {
            $this->command->warn('No admin user found. Some loan features may not work properly.');
            return;
        }

        foreach ($users->take(5) as $index => $user) {
            if (!isset($sampleLoans[$index])) break;

            $loanData = $sampleLoans[$index];
            $loanWallet = $user->loanWallet;

            if (!$loanWallet) continue;

            // Create loan
            $loan = Loan::create([
                'user_id' => $user->id,
                'loan_wallet_id' => $loanWallet->id,
                'approved_by' => $loanData['status'] !== 'pending' ? $adminUser->id : null,
                'amount' => $loanData['amount'],
                'interest_rate' => $loanData['interest_rate'],
                'purpose' => $loanData['purpose'],
                'status' => $loanData['status'],
                'credit_rating' => $loanData['credit_rating'],
                'duration_days' => 30,
                'approved_at' => $loanData['status'] !== 'pending' ? now() : null,
                'disbursed_at' => in_array($loanData['status'], ['disbursed', 'active', 'completed']) ? now()->subDays(10) : null,
                'completed_at' => $loanData['status'] === 'completed' ? now()->subDays(2) : null
            ]);

            // Set dates based on status
            if (in_array($loanData['status'], ['disbursed', 'active', 'completed', 'overdue'])) {
                $disbursementDate = now()->subDays(rand(5, 20));
                $loan->update([
                    'disbursement_date' => $disbursementDate->toDateString(),
                    'repayment_start_date' => $disbursementDate->addWeekdays(2)->toDateString(),
                    'due_date' => $disbursementDate->addDays(30)->toDateString()
                ]);

                // Update loan wallet for disbursed loans
                $loanWallet->increment('total_borrowed', $loan->amount);
                if ($loanData['status'] === 'disbursed' || $loanData['status'] === 'active') {
                    $loanWallet->increment('balance', $loan->amount);
                }
            }

            // Create sample repayments for active/completed loans
            if (in_array($loanData['status'], ['active', 'completed'])) {
                $this->createSampleRepayments($loan, $adminUser);
            }

            $this->command->line("Created {$loanData['status']} loan for {$user->name}: ₦" . number_format($loan->amount, 2));
        }
    }

    /**
     * Create sample repayments
     */
    private function createSampleRepayments(Loan $loan, User $admin)
    {
        $totalAmount = $loan->total_amount;
        $repaymentCount = $loan->status === 'completed' ? rand(1, 3) : rand(1, 2);
        $totalPaid = 0;

        for ($i = 0; $i < $repaymentCount; $i++) {
            $isLastPayment = ($i === $repaymentCount - 1) && ($loan->status === 'completed');
            $remainingAmount = $totalAmount - $totalPaid;
            
            if ($isLastPayment) {
                $paymentAmount = $remainingAmount;
            } else {
                $paymentAmount = rand(5000, min(25000, $remainingAmount - 1000));
            }

            $outstandingBefore = $totalAmount - $totalPaid;
            $outstandingAfter = $outstandingBefore - $paymentAmount;
            $totalPaid += $paymentAmount;

            LoanRepayment::create([
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'recorded_by' => $admin->id,
                'amount' => $paymentAmount,
                'outstanding_before' => $outstandingBefore,
                'outstanding_after' => $outstandingAfter,
                'payment_method' => ['cash', 'bank_transfer', 'mobile_money'][rand(0, 2)],
                'reference_number' => 'REF' . rand(100000, 999999),
                'notes' => 'Sample repayment payment',
                'payment_date' => now()->subDays(rand(1, 15))->toDateString(),
                'status' => 'completed'
            ]);
        }

        // Update loan with payment information
        $loan->update([
            'amount_paid' => $totalPaid,
            'outstanding_balance' => $totalAmount - $totalPaid
        ]);

        // Update loan wallet
        $loan->loanWallet->increment('total_repaid', $totalPaid);

        $this->command->line("  - Created {$repaymentCount} repayments totaling ₦" . number_format($totalPaid, 2));
    }
}
