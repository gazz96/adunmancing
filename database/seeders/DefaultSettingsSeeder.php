<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Courier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // General/Appearance Settings
        $generalSettings = [
            [
                'key' => 'site_name',
                'value' => 'Adun Mancing',
                'type' => 'text',
                'description' => 'Website name displayed in header',
                'group' => 'general',
                'sort_order' => 1,
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'description' => 'Website logo displayed in header',
                'group' => 'appearance',
                'sort_order' => 1,
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'description' => 'Website favicon (16x16 or 32x32 px)',
                'group' => 'appearance',
                'sort_order' => 2,
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@adunmancing.com',
                'type' => 'text',
                'description' => 'Contact email address',
                'group' => 'general',
                'sort_order' => 2,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'type' => 'text',
                'description' => 'Contact phone number',
                'group' => 'general',
                'sort_order' => 3,
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jakarta, Indonesia',
                'type' => 'textarea',
                'description' => 'Company address',
                'group' => 'general',
                'sort_order' => 4,
            ],
        ];

        // Payment Settings - Midtrans
        $paymentSettings = [
            [
                'key' => 'midtrans_server_key',
                'value' => null,
                'type' => 'text',
                'description' => 'Midtrans Server Key',
                'group' => 'payment',
                'sort_order' => 1,
            ],
            [
                'key' => 'midtrans_client_key',
                'value' => null,
                'type' => 'text',
                'description' => 'Midtrans Client Key',
                'group' => 'payment',
                'sort_order' => 2,
            ],
            [
                'key' => 'midtrans_is_production',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Enable production mode for Midtrans',
                'group' => 'payment',
                'sort_order' => 3,
            ],
            [
                'key' => 'midtrans_enabled',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Enable Midtrans payment gateway',
                'group' => 'payment',
                'sort_order' => 4,
            ],
            [
                'key' => 'bank_transfer_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable bank transfer payment method',
                'group' => 'payment',
                'sort_order' => 5,
            ],
        ];

        // Role-based Menu Permissions
        $permissionSettings = [
            [
                'key' => 'admin_menu_permissions',
                'value' => json_encode([
                    'administrator' => ['*'], // Full access
                    'editor' => [
                        'Products', 'Categories', 'Orders', 'Pages', 
                        'Sliders', 'YouTube Videos', 'Settings'
                    ],
                    'author' => [
                        'Products', 'Categories', 'Pages', 'Sliders', 'YouTube Videos'
                    ],
                    'subscriber' => [] // No admin access
                ]),
                'type' => 'json',
                'description' => 'Define which menu items each role can access',
                'group' => 'permissions',
                'sort_order' => 1,
            ],
        ];

        // Shipping Settings
        $shippingSettings = [
            [
                'key' => 'default_shipping_cost',
                'value' => '15000',
                'type' => 'number',
                'description' => 'Default shipping cost if API fails',
                'group' => 'shipping',
                'sort_order' => 1,
            ],
            [
                'key' => 'free_shipping_threshold',
                'value' => '500000',
                'type' => 'number',
                'description' => 'Minimum order amount for free shipping',
                'group' => 'shipping',
                'sort_order' => 2,
            ],
            [
                'key' => 'origin_city_id',
                'value' => '152', // Jakarta
                'type' => 'text',
                'description' => 'Origin city ID for shipping calculation',
                'group' => 'shipping',
                'sort_order' => 3,
            ],
        ];

        // Combine all settings
        $allSettings = array_merge(
            $generalSettings, 
            $paymentSettings, 
            $permissionSettings, 
            $shippingSettings
        );

        // Create settings
        foreach ($allSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Create default couriers
        $couriers = [
            [
                'name' => 'JNE',
                'code' => 'jne',
                'description' => 'JNE Express delivery service',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'TIKI',
                'code' => 'tiki',
                'description' => 'TIKI courier service',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'POS Indonesia',
                'code' => 'pos',
                'description' => 'POS Indonesia postal service',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'SiCepat',
                'code' => 'sicepat',
                'description' => 'SiCepat Express delivery',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'J&T Express',
                'code' => 'jnt',
                'description' => 'J&T Express courier service',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($couriers as $courierData) {
            Courier::updateOrCreate(
                ['code' => $courierData['code']],
                $courierData
            );
        }
    }
}