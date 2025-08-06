<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Joran Pancing',
                'slug' => 'joran-pancing',
                'icon' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' // Fishing rod with ocean background
            ],
            [
                'name' => 'Senar Pancing',
                'slug' => 'senar-pancing', 
                'icon' => 'https://images.unsplash.com/photo-1498654077810-12c21d4d6dc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' // Fishing line over ocean water
            ],
            [
                'name' => 'Reel Pancing',
                'slug' => 'reel-pancing',
                'icon' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' // Fishing reel with sea view
            ],
            [
                'name' => 'Kail & Mata Kail',
                'slug' => 'kail-mata-kail',
                'icon' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' // Fishing hooks with ocean background
            ],
            [
                'name' => 'Umpan & Lure',
                'slug' => 'umpan-lure',
                'icon' => 'https://images.unsplash.com/photo-1527199820404-7b9b3a2dd7db?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' // Colorful fishing lures with sea background
            ],
            [
                'name' => 'Aksesoris Memancing',
                'slug' => 'aksesoris-memancing',
                'icon' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' // Fishing accessories with ocean view
            ],
            [
                'name' => 'Kotak & Tas Pancing',
                'slug' => 'kotak-tas-pancing',
                'icon' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' // Fishing tackle box on seaside
            ],
            [
                'name' => 'Peralatan Boat Fishing',
                'slug' => 'peralatan-boat-fishing',
                'icon' => 'https://images.unsplash.com/photo-1445264718701-343916fc36b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' // Boat fishing equipment with ocean
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}
