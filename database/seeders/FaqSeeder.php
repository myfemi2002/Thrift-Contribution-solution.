<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;



class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question' => 'If I make an initial deposit and decide not to proceed, can I request a refund?',
                'answer' => '<p>Yes, refunds are available; however, a 20% administrative fee will be deducted. To initiate the refund process, please contact us via our official email at <strong>customerservice@grossassetsltd.com</strong>.</p>',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'What documents will I receive upon completing my payment?',
                'answer' => '<p>Upon full payment for the land, you will receive an <strong>allocation letter</strong>. Once your building is fully completed, you will also receive a <strong>deed of assignment</strong>.</p>',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Do I earn a commission for referring a new client?',
                'answer' => '<p>Yes, you will receive a <strong>7% commission</strong> for every successful referral.</p>',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Are there additional payments aside from the cost of the land?',
                'answer' => '<p>Yes. Additional payments are required for <strong>infrastructure and development</strong>, which progress alongside the estate.</p>',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'What does development cover?',
                'answer' => '<p>Development includes <strong>plot mapping and excavation</strong> once you\'re ready to build, as well as <strong>building drawings</strong>.</p>',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'What is included in infrastructure?',
                'answer' => '<p>Infrastructure encompasses, but is not limited to: <strong>estate roads, perimeter fencing, electricity, street lighting, drainage, and security posts</strong> within the estate.</p>',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'What happens if I default on my payment plan?',
                'answer' => '<p>A <strong>3% monthly surcharge</strong> will be applied for every month of default.</p>',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'How soon will I receive my land allocation after full payment?',
                'answer' => '<p>Your <strong>allocation letter</strong> will be issued <strong>immediately upon confirmation of full payment</strong> and completion of all necessary documentation.</p>',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}

