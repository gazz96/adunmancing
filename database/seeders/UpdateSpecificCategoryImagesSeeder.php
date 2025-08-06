<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateSpecificCategoryImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update kategori spesifik dengan gambar bertema laut dari Unsplash
        $categoryUpdates = [
            // Mencari berdasarkan nama kategori yang mirip
            'Aksesoris Memancing' => [
                'image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Fishing accessories with ocean view
                'alt_names' => ['aksesoris memancing', 'aksesoris-memancing']
            ],
            'Alat Mancing' => [
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Fishing tools with ocean background
                'alt_names' => ['alat mancing', 'alat-mancing']
            ],
            'Bubble Wrap' => [
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Ocean packaging/protection theme
                'alt_names' => ['bubble wrap', 'bubble-wrap']
            ]
        ];

        foreach ($categoryUpdates as $categoryName => $data) {
            // Coba cari berdasarkan nama yang tepat
            $category = Category::where('name', 'LIKE', "%{$categoryName}%")->first();
            
            // Jika tidak ditemukan, coba cari berdasarkan alternatif nama
            if (!$category) {
                foreach ($data['alt_names'] as $altName) {
                    $category = Category::where('name', 'LIKE', "%{$altName}%")
                                     ->orWhere('slug', 'LIKE', "%{$altName}%")
                                     ->first();
                    if ($category) {
                        break;
                    }
                }
            }
            
            if ($category) {
                $category->update(['icon' => $data['image']]);
                $this->command->info("✅ Updated category: {$category->name} with ocean-themed image");
            } else {
                $this->command->warn("⚠️  Category not found: {$categoryName}");
            }
        }
        
        // Tampilkan semua kategori yang ada untuk referensi
        $this->command->info("\n📋 All existing categories:");
        $allCategories = Category::all(['name', 'slug']);
        foreach ($allCategories as $cat) {
            $this->command->line("   - {$cat->name} (slug: {$cat->slug})");
        }
    }
}