<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourierDataSeeder extends Seeder
{
    public function run(): void
    {
        // Data kurir dari RajaOngkir dengan informasi lengkap
        $couriers = [
            [
                'name' => 'JNE Express',
                'code' => 'jne',
                'description' => 'JNE Express - Layanan pengiriman ekspres terpercaya di seluruh Indonesia',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'POS Indonesia',
                'code' => 'pos',
                'description' => 'POS Indonesia - Layanan pos nasional dengan jangkauan ke seluruh nusantara',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'TIKI',
                'code' => 'tiki',
                'description' => 'TIKI - Titipan Kilat dengan layanan pengiriman cepat dan aman',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'RPX Express',
                'code' => 'rpx',
                'description' => 'RPX Express - Layanan express dengan focus pada kecepatan dan keamanan',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Wahana Prestasi Logistik',
                'code' => 'wahana',
                'description' => 'Wahana - Solusi logistik terpadu dengan jaringan nasional',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'SiCepat Ekspres',
                'code' => 'sicepat',
                'description' => 'SiCepat - Layanan ekspres dengan teknologi modern dan tracking real-time',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'J&T Express',
                'code' => 'jnt',
                'description' => 'J&T Express - Layanan logistik dengan jangkauan luas dan harga kompetitif',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Pahala Kencana Express',
                'code' => 'pcp',
                'description' => 'PCP Express - Layanan pengiriman dengan komitmen ketepatan waktu',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Jalur Nugraha Ekakurir (JNE)',
                'code' => 'jne',
                'description' => 'JNE - Pelopor layanan kurir di Indonesia dengan pengalaman puluhan tahun',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Citra Van Titipan Kilat',
                'code' => 'cv',
                'description' => 'Citra Van - Layanan titipan kilat dengan fokus pada kepuasan pelanggan',
                'is_active' => false,
                'sort_order' => 10,
            ],
            [
                'name' => 'ESL Express',
                'code' => 'esl',
                'description' => 'ESL Express - Solusi pengiriman dengan teknologi terkini',
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'First Logistics',
                'code' => 'first',
                'description' => 'First Logistics - Layanan logistik terdepan dengan inovasi berkelanjutan',
                'is_active' => true,
                'sort_order' => 12,
            ],
            [
                'name' => 'NCS Express',
                'code' => 'ncs',
                'description' => 'NCS Express - Network Courier Service dengan standar internasional',
                'is_active' => true,
                'sort_order' => 13,
            ],
            [
                'name' => 'STAR Express',
                'code' => 'star',
                'description' => 'STAR Express - Layanan premium dengan jaminan keamanan tinggi',
                'is_active' => true,
                'sort_order' => 14,
            ],
            [
                'name' => 'Lion Parcel',
                'code' => 'lion',
                'description' => 'Lion Parcel - Bagian dari Lion Group dengan jaringan penerbangan',
                'is_active' => true,
                'sort_order' => 15,
            ],
            [
                'name' => 'Ninja Express',
                'code' => 'ninja',
                'description' => 'Ninja Express - Layanan express dengan fokus teknologi dan efisiensi',
                'is_active' => true,
                'sort_order' => 16,
            ],
            [
                'name' => 'ID Express',
                'code' => 'ide',
                'description' => 'ID Express - Solusi pengiriman domestik dengan layanan terpercaya',
                'is_active' => true,
                'sort_order' => 17,
            ],
            [
                'name' => 'SENTRAL CARGO',
                'code' => 'sentral',
                'description' => 'Sentral Cargo - Spesialis pengiriman cargo dengan kapasitas besar',
                'is_active' => false,
                'sort_order' => 18,
            ],
            [
                'name' => 'AnterAja',
                'code' => 'anteraja',
                'description' => 'AnterAja - Platform logistik digital dengan layanan door-to-door',
                'is_active' => true,
                'sort_order' => 19,
            ],
            [
                'name' => 'SAP Express',
                'code' => 'sap',
                'description' => 'SAP Express - Layanan pengiriman dengan sistem tracking canggih',
                'is_active' => true,
                'sort_order' => 20,
            ],
            [
                'name' => 'Jet Express',
                'code' => 'jet',
                'description' => 'Jet Express - Pengiriman kilat dengan standar penerbangan',
                'is_active' => true,
                'sort_order' => 21,
            ]
        ];

        foreach ($couriers as $courierData) {
            Courier::updateOrCreate(
                ['code' => $courierData['code']],
                $courierData
            );
        }

        // Update existing couriers if they were created with DefaultSettingsSeeder
        $this->command->info('Courier data seeded successfully!');
        $this->command->info('Total couriers: ' . count($couriers));
        $this->command->info('Active couriers: ' . collect($couriers)->where('is_active', true)->count());
    }
}