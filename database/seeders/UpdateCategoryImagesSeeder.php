<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateCategoryImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update kategori dengan gambar laut dari Unsplash
        $categoryImages = [
            'joran-pancing' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Fishing rod with ocean background
            'senar-pancing' => 'https://images.unsplash.com/photo-1498654077810-12c21d4d6dc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Fishing line over ocean water
            'reel-pancing' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Fishing reel with sea view
            'kail-mata-kail' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Fishing hooks with ocean background
            'umpan-lure' => 'https://images.unsplash.com/photo-1527199820404-7b9b3a2dd7db?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Colorful fishing lures with sea background
            'aksesoris-memancing' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Fishing accessories with ocean view
            'kotak-tas-pancing' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Fishing tackle box on seaside
            'peralatan-boat-fishing' => 'https://images.unsplash.com/photo-1445264718701-343916fc36b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Boat fishing equipment with ocean
        ];

        foreach ($categoryImages as $slug => $imageUrl) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $category->update(['icon' => $imageUrl]);
                $this->command->info("Updated category: {$category->name} with ocean image");
            }
        }
    }
}