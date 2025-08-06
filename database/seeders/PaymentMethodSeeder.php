<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'BCA',
                'type' => 'bank_transfer',
                'account_number' => '1234567890',
                'account_name' => 'PT Adun Mancing',
                'instructions' => 'Transfer ke rekening BCA berikut dan upload bukti transfer',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Mandiri',
                'type' => 'bank_transfer',
                'account_number' => '0987654321',
                'account_name' => 'PT Adun Mancing',
                'instructions' => 'Transfer ke rekening Mandiri berikut dan upload bukti transfer',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'BNI',
                'type' => 'bank_transfer',
                'account_number' => '5432167890',
                'account_name' => 'PT Adun Mancing',
                'instructions' => 'Transfer ke rekening BNI berikut dan upload bukti transfer',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'BRI',
                'type' => 'bank_transfer',
                'account_number' => '1357902468',
                'account_name' => 'PT Adun Mancing',
                'instructions' => 'Transfer ke rekening BRI berikut dan upload bukti transfer',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Midtrans',
                'type' => 'midtrans',
                'account_number' => null,
                'account_name' => null,
                'instructions' => 'Pembayaran melalui berbagai metode dengan Midtrans',
                'is_active' => false, // Will be enabled later
                'sort_order' => 5
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}