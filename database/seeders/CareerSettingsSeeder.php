<?php

namespace Database\Seeders;

use App\Models\CareerContact;
use App\Models\CareerSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CareerSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run()
     {
         // Benefits
         $benefits = [
             'Competitive Compensation',
             'Comprehensive Health Benefits',
             'Professional Development Programs',
             'Innovative Work Environment',
             'Global Project Opportunities',
             'Cutting-Edge Technology Access'
         ];
 
         foreach ($benefits as $index => $benefit) {
             CareerSetting::create([
                 'type' => 'benefits',
                 'value' => $benefit,
                 'sort_order' => $index + 1,
                 'is_active' => true
             ]);
         }
 
         // Application Tips
         $tips = [
             'Include the job title in the email subject',
             'Attach a detailed CV/Resume',
             'Include a brief cover letter',
             'Provide contact references'
         ];
 
         foreach ($tips as $index => $tip) {
             CareerSetting::create([
                 'type' => 'application_tips',
                 'value' => $tip,
                 'sort_order' => $index + 1,
                 'is_active' => true
             ]);
         }
 
         // Contact Information
         CareerContact::create([
             'email' => 'careers@boldtouch.com',
             'phone' => '+1-345-5678-77'
         ]);
     }
}
