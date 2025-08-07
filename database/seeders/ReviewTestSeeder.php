<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Hash;

class ReviewTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user
        $testUser = User::firstOrCreate([
            'email' => 'reviewer@test.com'
        ], [
            'name' => 'Test Reviewer',
            'password' => Hash::make('password123'),
            'birth_date' => '1990-01-01',
            'phone_number' => '081234567890'
        ]);

        // Get the first product
        $product = Product::first();
        
        if (!$product) {
            $this->command->error('No products found. Please create a product first.');
            return;
        }

        // Create a completed order for the test user
        $order = Order::create([
            'user_id' => $testUser->id,
            'address' => 'Jalan Test No. 123, Jakarta',
            'subtotal' => $product->price,
            'total_amount' => $product->price + 10000, // + delivery
            'status' => 'completed', // This is important for review eligibility
            'payment_status' => 'paid',
            'delivery_price' => 10000,
            'total_weight' => $product->weight ?? 1000,
            'recepient_name' => 'Test Reviewer',
            'recepient_phone_number' => '081234567890',
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
            'weight' => $product->weight ?? 1000,
        ]);

        $this->command->info('Test case created successfully!');
        $this->command->info('Test User Credentials:');
        $this->command->info('Email: reviewer@test.com');
        $this->command->info('Password: password123');
        $this->command->info('');
        $this->command->info('This user now has a completed order for: ' . $product->name);
        $this->command->info('You can now log in and review this product.');
    }
}