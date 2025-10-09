<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // WEB CONFIG:
        // WEB NAME
        // OWNER NAME
        // WEB URL
        // WEB MAIL
        // WHATSAPP
        // MOBILE
        // COPYRIGHT
        // TRIAL PERIOD
        // LOGO & FAVICON

        // DEFAULT RATES:
        // REGISTRATION FEE
        // SUBSCRIPTION FEE

        // PG CONFIG:
        // USERNAME
        // API TOKEN
        // SWITCHER

        // API CONFIG:
        // WHATSAPP API
        // EMAIL API
        // create setting seeder for the above
        $settings = [
            // WEB CONFIG
            [
                'key' => 'web_name',
                'category' => 'web_config',
                'value' => 'My Web App',
                'description' => 'The name of the web application',
            ],
            [
                'key' => 'owner_name',
                'category' => 'web_config',
                'value' => 'John Doe',
                'description' => 'The name of the website owner',
            ],
            [
                'key' => 'web_url',
                'category' => 'web_config',
                'value' => 'https://www.mywebapp.com',
                'description' => 'The URL of the web application',
            ],
            [
                'key' => 'web_mail',
                'category' => 'web_config',
                'value' => 'test@gmail.com',
                'description' => 'The contact email of the web application',
            ],
            [
                'key' => 'whatsapp',
                'category' => 'web_config',
                'value' => '+1234567890',
                'description' => 'The WhatsApp contact number',
            ],
            [
                'key' => 'mobile',
                'category' => 'web_config',
                'value' => '+1234567890',
                'description' => 'The mobile contact number',
            ],
            [
                'key' => 'copyright',
                'category' => 'web_config',
                'value' => '© 2025 My Web App. All rights reserved.',
                'description' => 'Copyright text displayed in footer',
            ],
            [
                'key' => 'trial_period',
                'category' => 'web_config',
                'value' => '30',
                'description' => 'Trial period in days',
            ],
            [
                'key' => 'logo',
                'category' => 'web_config',
                'value' => 'logo.png',
                'description' => 'Website logo filename',
            ],
            [
                'key' => 'favicon',
                'category' => 'web_config',
                'value' => 'favicon.ico',
                'description' => 'Website favicon filename',
            ],
            
            // DEFAULT RATES
            [
                'key' => 'registration_fee',
                'category' => 'rates',
                'value' => '100',
                'description' => 'Default registration fee amount',
            ],
            [
                'key' => 'subscription_fee',
                'category' => 'rates',
                'value' => '500',
                'description' => 'Default subscription fee amount',
            ],
            
            // PG CONFIG
            [
                'key' => 'pg_username',
                'category' => 'pg_config',
                'value' => 'merchant_user',
                'description' => 'Payment gateway username',
            ],
            [
                'key' => 'pg_api_token',
                'category' => 'pg_config',
                'value' => '',
                'description' => 'Payment gateway API token',
            ],
            [
                'key' => 'pg_switcher',
                'category' => 'pg_config',
                'value' => 'test',
                'description' => 'Payment gateway mode (test/live)',
            ],
            
            // API CONFIG
            [
                'key' => 'whatsapp_api',
                'category' => 'api_config',
                'value' => '',
                'description' => 'WhatsApp API endpoint or token',
            ],
            [
                'key' => 'email_api',
                'category' => 'api_config',
                'value' => '',
                'description' => 'Email API endpoint or token',
            ],
        ];

        // Insert settings into database
        foreach ($settings as $setting) {
            Settings::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'category' => $setting['category'],
                    'value' => $setting['value'],
                    'description' => $setting['description']
                ]
            );
        }
    }
}
