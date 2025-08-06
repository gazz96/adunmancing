<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Peralatan Memancing Terbaik',
                'description' => 'Temukan koleksi lengkap peralatan memancing berkualitas tinggi untuk petualangan memancing Anda',
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'button_text' => 'Belanja Sekarang',
                'button_link' => '/shop',
                'button_secondary_text' => 'Lihat Katalog',
                'button_secondary_link' => '/shop',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Joran Pancing Premium',
                'description' => 'Joran pancing berkualitas premium untuk hasil tangkapan maksimal di berbagai kondisi perairan',
                'image' => 'https://images.unsplash.com/photo-1579952363873-27d3bfad9c0d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'button_text' => 'Lihat Produk',
                'button_link' => '/shop',
                'button_secondary_text' => 'Tutorial',
                'button_secondary_link' => '#youtube',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'Memancing di Laut Lepas',
                'description' => 'Rasakan sensasi memancing di laut lepas dengan perlengkapan khusus untuk deep sea fishing',
                'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'button_text' => 'Jelajahi',
                'button_link' => '/shop',
                'button_secondary_text' => 'Tips & Trik',
                'button_secondary_link' => '#youtube',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'title' => 'Memancing Sungai & Danau',
                'description' => 'Nikmati ketenangan memancing di sungai dan danau dengan peralatan yang tepat untuk air tawar',
                'image' => 'https://images.unsplash.com/photo-1445264718701-343916gfc36b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'button_text' => 'Lihat Koleksi',
                'button_link' => '/shop',
                'button_secondary_text' => 'Panduan',
                'button_secondary_link' => '#youtube',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'title' => 'Umpan & Kail Berkualitas',
                'description' => 'Koleksi umpan dan kail terlengkap untuk berbagai jenis ikan dan kondisi perairan',
                'image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'button_text' => 'Shop Sekarang',
                'button_link' => '/shop',
                'button_secondary_text' => 'Video Tutorial',
                'button_secondary_link' => '#youtube',
                'sort_order' => 5,
                'is_active' => true
            ]
        ];

        foreach ($sliders as $sliderData) {
            Slider::create($sliderData);
        }
    }
}