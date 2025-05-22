<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactMessageSeeder extends Seeder
{
    public function run()
    {
        $messages = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '08012345678',
                'subject' => 'Property Inquiry',
                'message' => 'I am interested in your properties in Lekki. Could you provide more information?',
                'is_read' => false,
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'phone' => '08087654321',
                'subject' => 'Land Purchase',
                'message' => 'I would like to schedule a meeting to discuss land purchase options.',
                'is_read' => true,
                'read_at' => now()->subHours(5),
                'created_at' => now()->subDays(3),
            ],
            [
                'name' => 'Michael Smith',
                'email' => 'michael@example.com',
                'phone' => null,
                'subject' => 'Investment Opportunities',
                'message' => 'Looking for investment opportunities in real estate. Please contact me via email with details.',
                'is_read' => false,
                'created_at' => now()->subHours(12),
            ],
        ];

        foreach ($messages as $message) {
            ContactMessage::create($message);
        }
    }
}
