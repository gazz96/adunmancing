<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaFooterSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Social Media Settings
        $socialMediaSettings = [
            [
                'key' => 'social_facebook_url',
                'value' => 'https://facebook.com/adunmancing',
                'type' => 'text',
                'description' => 'Facebook page URL',
                'group' => 'social_media',
                'sort_order' => 1,
            ],
            [
                'key' => 'social_instagram_url',
                'value' => 'https://instagram.com/adunmancing',
                'type' => 'text',
                'description' => 'Instagram profile URL',
                'group' => 'social_media',
                'sort_order' => 2,
            ],
            [
                'key' => 'social_twitter_url',
                'value' => 'https://twitter.com/adunmancing',
                'type' => 'text',
                'description' => 'Twitter profile URL',
                'group' => 'social_media',
                'sort_order' => 3,
            ],
            [
                'key' => 'social_youtube_url',
                'value' => 'https://youtube.com/@adunmancing',
                'type' => 'text',
                'description' => 'YouTube channel URL',
                'group' => 'social_media',
                'sort_order' => 4,
            ],
            [
                'key' => 'social_tiktok_url',
                'value' => 'https://tiktok.com/@adunmancing',
                'type' => 'text',
                'description' => 'TikTok profile URL',
                'group' => 'social_media',
                'sort_order' => 5,
            ],
            [
                'key' => 'social_linkedin_url',
                'value' => '',
                'type' => 'text',
                'description' => 'LinkedIn profile URL',
                'group' => 'social_media',
                'sort_order' => 6,
            ],
            [
                'key' => 'social_whatsapp_number',
                'value' => '+6281234567890',
                'type' => 'text',
                'description' => 'WhatsApp number with country code (e.g., +6281234567890)',
                'group' => 'social_media',
                'sort_order' => 7,
            ],
            [
                'key' => 'social_telegram_url',
                'value' => '',
                'type' => 'text',
                'description' => 'Telegram channel/group URL',
                'group' => 'social_media',
                'sort_order' => 8,
            ],
        ];

        // Footer Menu Settings
        $footerMenuSettings = [
            [
                'key' => 'footer_about_title',
                'value' => 'Tentang Adun Mancing',
                'type' => 'text',
                'description' => 'Footer about section title',
                'group' => 'footer',
                'sort_order' => 1,
            ],
            [
                'key' => 'footer_about_description',
                'value' => 'Adun Mancing adalah toko online terpercaya yang menyediakan berbagai peralatan memancing berkualitas tinggi dengan harga terjangkau. Kami melayani pecinta mancing di seluruh Indonesia.',
                'type' => 'textarea',
                'description' => 'Footer about section description',
                'group' => 'footer',
                'sort_order' => 2,
            ],
            [
                'key' => 'footer_quick_links',
                'value' => json_encode([
                    ['name' => 'Beranda', 'url' => '/'],
                    ['name' => 'Produk', 'url' => '/shop'],
                    ['name' => 'Kategori', 'url' => '/categories'],
                    ['name' => 'Blog', 'url' => '/blog'],
                    ['name' => 'Kontak', 'url' => '/contact'],
                ]),
                'type' => 'json',
                'description' => 'Footer quick links menu items (JSON format: [{"name": "Link Name", "url": "/path"}])',
                'group' => 'footer',
                'sort_order' => 3,
            ],
            [
                'key' => 'footer_customer_service',
                'value' => json_encode([
                    ['name' => 'Bantuan', 'url' => '/help'],
                    ['name' => 'FAQ', 'url' => '/faq'],
                    ['name' => 'Cara Belanja', 'url' => '/panduan-pembelian'],
                    ['name' => 'Kebijakan Privasi', 'url' => '/kebijakan-privasi'],
                    ['name' => 'Syarat & Ketentuan', 'url' => '/syarat-dan-ketentuan'],
                ]),
                'type' => 'json',
                'description' => 'Footer customer service menu items (JSON format)',
                'group' => 'footer',
                'sort_order' => 4,
            ],
            [
                'key' => 'footer_categories',
                'value' => json_encode([
                    ['name' => 'Joran Pancing', 'url' => '/category/joran-pancing'],
                    ['name' => 'Reel Pancing', 'url' => '/category/reel-pancing'],
                    ['name' => 'Senar Pancing', 'url' => '/category/senar-pancing'],
                    ['name' => 'Umpan Pancing', 'url' => '/category/umpan-pancing'],
                    ['name' => 'Aksesoris', 'url' => '/category/aksesoris'],
                ]),
                'type' => 'json',
                'description' => 'Footer popular categories menu items (JSON format)',
                'group' => 'footer',
                'sort_order' => 5,
            ],
            [
                'key' => 'footer_contact_address',
                'value' => 'Jl. Mancing No. 123, Jakarta Selatan, DKI Jakarta 12345',
                'type' => 'textarea',
                'description' => 'Footer contact address',
                'group' => 'footer',
                'sort_order' => 6,
            ],
            [
                'key' => 'footer_contact_phone',
                'value' => '+62 21-1234-5678',
                'type' => 'text',
                'description' => 'Footer contact phone number',
                'group' => 'footer',
                'sort_order' => 7,
            ],
            [
                'key' => 'footer_contact_email',
                'value' => 'info@adunmancing.com',
                'type' => 'text',
                'description' => 'Footer contact email',
                'group' => 'footer',
                'sort_order' => 8,
            ],
            [
                'key' => 'footer_business_hours',
                'value' => 'Senin - Jumat: 08:00 - 17:00 WIB\nSabtu: 08:00 - 15:00 WIB\nMinggu: Tutup',
                'type' => 'textarea',
                'description' => 'Footer business hours',
                'group' => 'footer',
                'sort_order' => 9,
            ],
            [
                'key' => 'footer_copyright_text',
                'value' => '© 2024 Adun Mancing. All rights reserved.',
                'type' => 'text',
                'description' => 'Footer copyright text',
                'group' => 'footer',
                'sort_order' => 10,
            ],
            [
                'key' => 'footer_show_newsletter',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Show newsletter subscription in footer',
                'group' => 'footer',
                'sort_order' => 11,
            ],
            [
                'key' => 'footer_newsletter_title',
                'value' => 'Berlangganan Newsletter',
                'type' => 'text',
                'description' => 'Footer newsletter section title',
                'group' => 'footer',
                'sort_order' => 12,
            ],
            [
                'key' => 'footer_newsletter_description',
                'value' => 'Dapatkan informasi produk terbaru dan penawaran menarik langsung di email Anda.',
                'type' => 'textarea',
                'description' => 'Footer newsletter description',
                'group' => 'footer',
                'sort_order' => 13,
            ],
        ];

        // Combine all settings
        $allSettings = array_merge($socialMediaSettings, $footerMenuSettings);

        // Create or update settings
        foreach ($allSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Social Media & Footer settings seeded successfully!');
        $this->command->info('Social Media settings: ' . count($socialMediaSettings));
        $this->command->info('Footer settings: ' . count($footerMenuSettings));
    }
}