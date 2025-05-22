<?php

namespace Database\Seeders;

use App\Models\MotherWallet;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MotherWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $walletAddresses = [
            'TJYeasuC8xYLzqWnEGhb7o5gyH3cPCJN8p',
            'TEc9GjQypG8WeGQbLJQB7KpzECjGJsqCrQ',
            'TAJLkqnjxCJbky2xUHgT8pSPeVAWnNAhgP',
            'TGjYsQgvwMDaV432xqhSy5qYhHn9MwEihS',
            'TDJJqGNpkZpSHjXu8sTTZgJx5KSQoaBdvf',
        ];
        
        foreach ($walletAddresses as $address) {
            MotherWallet::create([
                'wallet_address' => $address,
                'is_active' => true,
            ]);
        }
    }
}
