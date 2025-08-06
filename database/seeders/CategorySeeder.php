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
                'icon' => 'https://images.unsplash.com/photo-1579952363873-27d3bfad9c0d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80'
            ],
            [
                'name' => 'Senar Pancing',
                'slug' => 'senar-pancing', 
                'icon' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80'
            ],
            [
                'name' => 'Reel Pancing',
                'slug' => 'reel-pancing',
                'icon' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80'
            ],
            [
                'name' => 'Kail & Mata Kail',
                'slug' => 'kail-mata-kail',
                'icon' => 'https://images.unsplash.com/photo-1445264718701-343916fc36b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80'
            ],
            [
                'name' => 'Umpan & Lure',
                'slug' => 'umpan-lure',
                'icon' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80'
            ],
            [
                'name' => 'Aksesoris Memancing',
                'slug' => 'aksesoris-memancing',
                'icon' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80'
            ],
            [
                'name' => 'Kotak & Tas Pancing',
                'slug' => 'kotak-tas-pancing',
                'icon' => null // This will use placeholder
            ],
            [
                'name' => 'Peralatan Boat Fishing',
                'slug' => 'peralatan-boat-fishing',
                'icon' => null // This will use placeholder
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}
