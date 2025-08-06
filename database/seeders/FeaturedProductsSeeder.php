<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeaturedProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mark some existing products as featured across different categories
        $this->command->info('🔥 Setting up featured products...');
        
        // Get products from different categories and mark them as featured
        $categories = \App\Models\Category::with('products')->get();
        
        foreach ($categories as $category) {
            if ($category->products && $category->products->count() > 0) {
                // Mark first 2-3 products in each category as featured
                $productsToFeature = $category->products->take(rand(2, 3));
                
                foreach ($productsToFeature as $product) {
                    $product->update(['is_featured' => true]);
                    $this->command->info("✅ Featured: {$product->name} (Category: {$category->name})");
                }
            }
        }
        
        // Also mark some random products as featured if we don't have enough from categories
        $allProducts = Product::where('is_featured', false)->inRandomOrder()->take(5)->get();
        
        foreach ($allProducts as $product) {
            $product->update(['is_featured' => true]);
            $this->command->info("✅ Featured (Random): {$product->name}");
        }
        
        $totalFeatured = Product::featured()->count();
        $this->command->info("🎉 Total featured products: {$totalFeatured}");
    }
}