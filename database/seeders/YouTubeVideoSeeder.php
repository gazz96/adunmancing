<?php

namespace Database\Seeders;

use App\Models\YouTubeVideo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YouTubeVideoSeeder extends Seeder
{
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Tutorial Memancing Ikan Kakap di Laut Dalam',
                'description' => 'Pelajari teknik memancing ikan kakap di laut dalam dengan menggunakan peralatan yang tepat dan teknik yang benar',
                'youtube_id' => 'dQw4w9WgXcQ', // Example YouTube ID
                'views_count' => 12500,
                'published_date' => Carbon::now()->subDays(1),
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'title' => 'Tips Memilih Joran Pancing yang Tepat',
                'description' => 'Panduan lengkap untuk memilih joran pancing sesuai dengan jenis ikan dan kondisi perairan',
                'youtube_id' => 'dQw4w9WgXcQ',
                'views_count' => 8200,
                'published_date' => Carbon::now()->subDays(2),
                'sort_order' => 2,
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'title' => 'Teknik Memasang Umpan untuk Ikan Tenggiri',
                'description' => 'Cara memasang umpan yang efektif untuk menangkap ikan tenggiri dengan hasil maksimal',
                'youtube_id' => 'dQw4w9WgXcQ',
                'views_count' => 15700,
                'published_date' => Carbon::now()->subDays(3),
                'sort_order' => 3,
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'title' => 'Memancing Ikan Kerapu: Strategi dan Tips',
                'description' => 'Strategi jitu untuk memancing ikan kerapu di berbagai lokasi dengan tingkat keberhasilan tinggi',
                'youtube_id' => 'dQw4w9WgXcQ',
                'views_count' => 9400,
                'published_date' => Carbon::now()->subDays(4),
                'sort_order' => 4,
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'title' => 'Perawatan Alat Pancing agar Awet',
                'description' => 'Tips merawat peralatan pancing agar tetap dalam kondisi prima dan tahan lama',
                'youtube_id' => 'dQw4w9WgXcQ',
                'views_count' => 6800,
                'published_date' => Carbon::now()->subDays(7),
                'sort_order' => 5,
                'is_featured' => false,
                'is_active' => true
            ]
        ];

        foreach ($videos as $videoData) {
            YouTubeVideo::create($videoData);
        }
    }
}