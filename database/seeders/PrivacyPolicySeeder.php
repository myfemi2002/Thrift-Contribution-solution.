<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrivacyPolicySeeder extends Seeder
{
    public function run()
    {
        PrivacyPolicy::create([
            'title' => 'Privacy Policy',
            'content' => '<p><strong>Effective Date:</strong> January 1, 2025</p>
            <h2><strong>Privacy Policy</strong></h2>
            <p>At <strong>Gross Assets and Properties Limited</strong>, your privacy is our priority. This Privacy Policy explains how we gather, use, and safeguard your information when you visit our website: https://grossassetsltd.com. By continuing to use our site, you consent to the practices outlined below.</p>
            <h3><strong>Information We Collect</strong></h3>
            <p>When you visit our website, we may automatically collect certain basic details such as:</p>
            <ul>
                <li>Your IP address</li>
                <li>Browser type and version</li>
                <li>The pages you visited</li>
                <li>Time and date of your visit</li>
                <li>The site that referred you</li>
            </ul>
            <p>This information helps us improve our website and services. It does not personally identify you.</p>
            <h3><strong>How We Use Cookies</strong></h3>
            <p>Cookies are small files stored on your device to help enhance your experience. We use cookies to:</p>
            <ul>
                <li>Remember your preferences</li>
                <li>Analyze browsing behavior</li>
                <li>Show personalized content where applicable</li>
            </ul>
            <p>You can disable cookies in your browser settings at any time, although some features of the website may not function properly without them.</p>
            <h3><strong>Third-Party Tools & Advertisers</strong></h3>
            <p>We may work with third-party services, such as advertisers and analytics providers, who may use cookies, web beacons, or similar technologies to collect data about your activity on our website. These tools operate under their own privacy policies, and we do not have access to or control over the information they collect.</p>
            <h3><strong>Keeping Your Information Secure</strong></h3>
            <p>We take your security seriously. While no system can be 100% secure, we implement modern security practices—including encryption, firewalls, and secure servers—to help protect your data from unauthorized access. We also encourage you to follow best practices when browsing the internet.</p>
            <h3><strong>Policy Updates</strong></h3>
            <p>We may revise this Privacy Policy from time to time. Any updates will take effect immediately upon being posted to this page. If the changes are significant, we will notify you through email or a notification on our website. Please check back periodically to stay informed.</p>
            <h3><strong>Need Help or Have Questions?</strong></h3>
            <p>We\'re here for you. Reach out anytime using the contact details below:</p>
            <p>📧 <strong>Email:</strong> customerservice@grossassetsltd.com</p>
            <p>📍 <strong>Office Address:</strong> 24 Bamishile Street, Allen, Ikeja 101233, Lagos</p>
            <p>📞 <strong>Phone:</strong> 0816 522 5574</p>',
            'effective_date' => '2025-01-01',
            'is_active' => true,
        ]);
    }
}
