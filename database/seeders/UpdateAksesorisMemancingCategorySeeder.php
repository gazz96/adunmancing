<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateAksesorisMemancingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update kategori Aksesoris Memancing dengan gambar orang sedang mancing dari Unsplash
        $fishingPersonImages = [
            // Gambar orang sedang mancing dengan kualitas tinggi dan tema laut
            'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Person fishing at sunrise
            'https://images.unsplash.com/photo-1498654077810-12c21d4d6dc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Silhouette of person fishing
            'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Person with fishing gear by ocean
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Fisherman with tools and ocean background
            'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Person fishing with accessories visible
        ];
        
        // Pilih gambar terbaik untuk kategori Aksesoris Memancing
        $selectedImage = 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'; // Person fishing at sunrise - paling representatif
        
        $categoryUpdates = [
            'aksesoris-memancing' => $selectedImage,
            'aksesoris memancing' => $selectedImage,
        ];

        $updated = false;
        
        foreach ($categoryUpdates as $identifier => $imageUrl) {
            // Cari berdasarkan slug
            $category = Category::where('slug', $identifier)
                             ->orWhere('slug', 'LIKE', "%{$identifier}%")
                             ->first();
            
            // Jika tidak ditemukan, coba cari berdasarkan nama
            if (!$category) {
                $category = Category::where('name', 'LIKE', "%Aksesoris%")
                                 ->where('name', 'LIKE', "%Memancing%")
                                 ->first();
            }
            
            if ($category && !$updated) {
                $oldImage = $category->icon;
                $category->update(['icon' => $imageUrl]);
                $updated = true;
                
                $this->command->info("✅ Updated category: '{$category->name}'");
                $this->command->info("   📸 New image: {$imageUrl}");
                $this->command->info("   🔄 Old image: " . ($oldImage ?: 'No image'));
                
                break; // Hanya update satu kali
            }
        }
        
        if (!$updated) {
            $this->command->warn("⚠️  Category 'Aksesoris Memancing' not found!");
            $this->command->info("📋 Available categories:");
            
            $categories = Category::all(['name', 'slug']);
            foreach ($categories as $cat) {
                $this->command->line("   - {$cat->name} (slug: {$cat->slug})");
            }
        }
    }
}
