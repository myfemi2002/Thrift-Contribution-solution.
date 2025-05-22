<?php

namespace Database\Seeders;

use App\Models\Counter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing counters
        Counter::truncate();
        
        // Create default counters
        $counters = [
            [
                'icon' => 'flaticon-select',
                'count_number' => 560,
                'count_suffix' => '+',
                'title' => 'Total Area Sq',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'icon' => 'flaticon-office',
                'count_number' => 197,
                'count_suffix' => 'K+',
                'title' => 'Apartments Sold',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'icon' => 'flaticon-excavator',
                'count_number' => 268,
                'count_suffix' => '+',
                'title' => 'Total Constructions',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'icon' => 'flaticon-armchair',
                'count_number' => 340,
                'count_suffix' => '+',
                'title' => 'Apartio Rooms',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];
        
        // Insert counters
        foreach ($counters as $counter) {
            Counter::create($counter);
        }
    }
}
