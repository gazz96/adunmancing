<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basicSettings = [
            [
                'key' => 'site_name',
                'value' => 'Adun Mancing',
                'type' => 'text',
                'description' => 'Nama website/toko',
                'group' => 'general',
                'sort_order' => 1
            ],
            [
                'key' => 'site_description',
                'value' => 'Toko Peralatan Mancing Terlengkap - Joran, Senar, Reel, Kail, Umpan dan Aksesoris Mancing Berkualitas',
                'type' => 'text',
                'description' => 'Deskripsi website untuk SEO',
                'group' => 'general',
                'sort_order' => 2
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'type' => 'text',
                'description' => 'Nomor telepon kontak',
                'group' => 'contact',
                'sort_order' => 1
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@adunmancing.com',
                'type' => 'text',
                'description' => 'Email kontak',
                'group' => 'contact',
                'sort_order' => 2
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Pantai Indah No. 123, Jakarta Utara',
                'type' => 'text',
                'description' => 'Alamat toko',
                'group' => 'contact',
                'sort_order' => 3
            ],
            [
                'key' => 'store_hours',
                'value' => 'Senin - Sabtu: 08:00 - 20:00, Minggu: 09:00 - 18:00',
                'type' => 'text',
                'description' => 'Jam operasional toko',
                'group' => 'contact',
                'sort_order' => 4
            ]
        ];

        foreach ($basicSettings as $settingData) {
            Setting::updateOrCreate(
                ['key' => $settingData['key']],
                $settingData
            );
            
            $this->command->info("✅ Setting '{$settingData['key']}' created/updated: {$settingData['value']}");
        }
    }
}