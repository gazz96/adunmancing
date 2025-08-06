<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'FISHING20',
                'name' => 'Diskon 20% Semua Produk',
                'description' => 'Dapatkan diskon 20% untuk semua produk peralatan memancing',
                'discount_type' => 'percentage',
                'discount_amount' => null,
                'discount_percent' => 20.00,
                'minimum_amount' => 200000.00,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(3),
                'usage_limit' => 100,
                'usage_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'NEWBIE50',
                'name' => 'Cashback 50K Member Baru',
                'description' => 'Khusus member baru, dapatkan cashback Rp 50.000 untuk pembelian pertama',
                'discount_type' => 'fixed',
                'discount_amount' => 50000.00,
                'discount_percent' => null,
                'minimum_amount' => 300000.00,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(6),
                'usage_limit' => 50,
                'usage_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'PREMIUM10',
                'name' => 'Extra 10% Produk Premium',
                'description' => 'Diskon tambahan 10% khusus untuk produk-produk premium',
                'discount_type' => 'percentage',
                'discount_amount' => null,
                'discount_percent' => 10.00,
                'minimum_amount' => 500000.00,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(2),
                'usage_limit' => 200,
                'usage_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'FREESHIP',
                'name' => 'Gratis Ongkos Kirim',
                'description' => 'Gratis ongkos kirim ke seluruh Indonesia untuk pembelian minimal Rp 150.000',
                'discount_type' => 'fixed',
                'discount_amount' => 25000.00,
                'discount_percent' => null,
                'minimum_amount' => 150000.00,
                'valid_from' => now(),
                'valid_until' => now()->addMonth(),
                'usage_limit' => null, // unlimited
                'usage_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'WEEKEND15',
                'name' => 'Weekend Special 15%',
                'description' => 'Diskon spesial 15% untuk pembelian di akhir pekan',
                'discount_type' => 'percentage',
                'discount_amount' => null,
                'discount_percent' => 15.00,
                'minimum_amount' => 100000.00,
                'valid_from' => now(),
                'valid_until' => now()->addWeeks(4),
                'usage_limit' => 500,
                'usage_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'BULK100',
                'name' => 'Diskon Pembelian Banyak',
                'description' => 'Hemat Rp 100.000 untuk pembelian grosir minimal 1 juta',
                'discount_type' => 'fixed',
                'discount_amount' => 100000.00,
                'discount_percent' => null,
                'minimum_amount' => 1000000.00,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(2),
                'usage_limit' => 30,
                'usage_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'EXPIRED',
                'name' => 'Kupon Kadaluarsa (Test)',
                'description' => 'Kupon ini sudah kadaluarsa untuk testing',
                'discount_type' => 'percentage',
                'discount_amount' => null,
                'discount_percent' => 50.00,
                'minimum_amount' => 0,
                'valid_from' => now()->subDays(30),
                'valid_until' => now()->subDays(1),
                'usage_limit' => 10,
                'usage_count' => 0,
                'is_active' => false,
            ]
        ];

        foreach ($coupons as $couponData) {
            Coupon::create($couponData);
            $this->command->info("✅ Created coupon: {$couponData['code']} - {$couponData['name']}");
        }

        $this->command->info("🎉 Created " . count($coupons) . " coupons successfully!");
    }
}