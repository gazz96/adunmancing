<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Adun Fishing Line AFL Premium',
                'slug' => 'adun-fishing-line-afl-premium',
                'description' => 'Senar pancing AFL Adun berkualitas tinggi dengan kekuatan tarik superior. Terbuat dari bahan premium yang tahan lama dan cocok untuk berbagai jenis ikan. Dilengkapi teknologi anti-putus dan ketahanan terhadap cuaca ekstrem.',
                'price' => 300000,
                'compare_price' => 350000,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/700x700-1-500x500.webp',
                'weight' => 200,
                'dimension' => 15,
                'manage_stock' => true,
                'stock_quantity' => 50,
                'allow_backorders' => false,
                'low_stock_threshold' => 10,
                'warranty_information' => 'Produk bergaransi resmi 1 tahun untuk kerusakan produksi pabrik. Garansi tidak berlaku untuk kerusakan akibat pemakaian yang salah atau kecelakaan. Klaim garansi dapat dilakukan dengan menunjukkan bukti pembelian.',
                'delivery_shipping' => 'Pengiriman ke seluruh Indonesia dengan estimasi 2-5 hari kerja untuk wilayah Jawa-Bali, 3-7 hari kerja wilayah lainnya. Gratis ongkir untuk pembelian di atas Rp 500.000. Barang akan dikemas dengan bubble wrap dan kardus tebal untuk keamanan.'
            ],
            [
                'name' => 'Adun Fishing Line AFL Standard',
                'slug' => 'adun-fishing-line-afl-standard',
                'description' => 'Senar pancing AFL Adun dengan kualitas standar yang handal untuk memancing sehari-hari. Memberikan daya tahan yang baik dengan harga terjangkau. Cocok untuk pemancing pemula hingga menengah.',
                'price' => 250000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/fising-line-1-500x500.webp',
                'weight' => 180,
                'dimension' => 15,
                'manage_stock' => true,
                'stock_quantity' => 75,
                'allow_backorders' => true,
                'low_stock_threshold' => 15,
                'warranty_information' => 'Produk bergaransi resmi 6 bulan untuk kerusakan produksi pabrik. Cocok untuk pemula dengan kualitas standar yang handal.',
                'delivery_shipping' => 'Pengiriman cepat 1-3 hari kerja wilayah Jabodetabek, 2-5 hari wilayah lainnya. Kemasan aman dengan bubble wrap.'
            ],
            [
                'name' => 'Adun Fishing Line AFL Economic',
                'slug' => 'adun-fishing-line-afl-economic',
                'description' => 'Senar pancing AFL Adun versi ekonomis yang tetap berkualitas. Pilihan tepat untuk memancing di air tawar dengan budget terbatas. Memberikan performa yang memuaskan dengan harga yang bersahabat.',
                'price' => 150000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/adun-fising-line-1-500x500.webp',
                'weight' => 150,
                'dimension' => 15,
                'manage_stock' => true,
                'stock_quantity' => 100,
                'allow_backorders' => true,
                'low_stock_threshold' => 20,
                'warranty_information' => 'Produk bergaransi 3 bulan. Pilihan ekonomis dengan kualitas terjamin untuk memancing air tawar.',
                'delivery_shipping' => 'Pengiriman reguler 2-4 hari kerja. Khusus wilayah tertentu bisa lebih lama. Kemasan sederhana namun aman.'
            ],
            [
                'name' => 'Joran Pancing Carbon Fiber Pro',
                'slug' => 'joran-pancing-carbon-fiber-pro',
                'description' => 'Joran pancing berbahan carbon fiber berkualitas premium dengan sensitivitas tinggi. Ringan namun kuat, cocok untuk memancing ikan besar di laut maupun air tawar. Dilengkapi dengan grip anti-slip dan ring berkualitas tinggi.',
                'price' => 450000,
                'compare_price' => 500000,
                'status' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1579952363873-27d3bfad9c0d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'weight' => 300,
                'dimension' => 180,
                'manage_stock' => true,
                'stock_quantity' => 25,
                'allow_backorders' => false,
                'low_stock_threshold' => 5,
                'warranty_information' => 'Garansi premium 2 tahun untuk material carbon fiber. Perlindungan menyeluruh terhadap cacat produksi dan keretakan.',
                'delivery_shipping' => 'Pengiriman khusus dengan asuransi dan tracking. Estimasi 1-2 hari kerja Jabodetabek, 2-4 hari wilayah lain. Kemasan premium dengan hard case.'
            ],
            [
                'name' => 'Reel Pancing Spinning 4000',
                'slug' => 'reel-pancing-spinning-4000',
                'description' => 'Reel pancing spinning berukuran 4000 dengan sistem drag yang halus dan presisi. Terbuat dari material aluminium berkualitas tinggi dengan ball bearing premium. Cocok untuk memancing ikan sedang hingga besar.',
                'price' => 350000,
                'compare_price' => 400000,
                'status' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'weight' => 400,
                'dimension' => 12,
                'manage_stock' => true,
                'stock_quantity' => 30,
                'allow_backorders' => true,
                'low_stock_threshold' => 8,
                'warranty_information' => 'Garansi 1 tahun untuk sistem drag dan ball bearing. Garansi tidak termasuk kerusakan akibat air laut atau pasir.',
                'delivery_shipping' => 'Pengiriman dengan bubble wrap berlapis. Estimasi 2-4 hari kerja ke seluruh Indonesia. Gratis ongkir untuk pembelian reel di atas 300rb.'
            ],
            [
                'name' => 'Kail Pancing Set Berbagai Ukuran',
                'slug' => 'kail-pancing-set-berbagai-ukuran',
                'description' => 'Set kail pancing lengkap berbagai ukuran dari No. 1 hingga No. 12. Terbuat dari baja karbon berkualitas tinggi dengan ketajaman yang tahan lama. Cocok untuk berbagai jenis ikan dan teknik memancing.',
                'price' => 85000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'weight' => 50,
                'dimension' => 10,
                'manage_stock' => true,
                'stock_quantity' => 200,
                'allow_backorders' => true,
                'low_stock_threshold' => 50,
                'warranty_information' => 'Garansi 6 bulan untuk ketajaman kail. Penggantian gratis jika kail patah dalam kondisi normal.',
                'delivery_shipping' => 'Pengiriman cepat 1-3 hari kerja. Kemasan compact dalam box plastik. Cocok untuk pembelian dalam jumlah banyak.'
            ],
            [
                'name' => 'Umpan Buatan Minnow Lure',
                'slug' => 'umpan-buatan-minnow-lure',
                'description' => 'Umpan buatan minnow lure dengan desain realistis dan aksi berenang yang natural. Dilengkapi kail treble berkualitas tinggi dan sistem suara rattle. Efektif untuk memancing ikan predator di air tawar maupun laut.',
                'price' => 125000,
                'compare_price' => 150000,
                'status' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1445264718701-343916fc36b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'weight' => 25,
                'dimension' => 12,
                'manage_stock' => true,
                'stock_quantity' => 80,
                'allow_backorders' => false,
                'low_stock_threshold' => 15,
                'warranty_information' => 'Garansi 3 bulan untuk sistem suara dan cat. Tidak termasuk kerusakan akibat gigitan ikan besar.',
                'delivery_shipping' => 'Pengiriman hati-hati dengan foam padding. Estimasi 2-5 hari kerja. Kemasan individual untuk setiap lure.'
            ],
            [
                'name' => 'Kotak Pancing Multifungsi',
                'slug' => 'kotak-pancing-multifungsi',
                'description' => 'Kotak pancing serbaguna dengan berbagai kompartemen untuk menyimpan peralatan memancing. Terbuat dari plastic ABS yang kuat dan tahan air. Dilengkapi dengan handle yang nyaman dan sistem kunci yang aman.',
                'price' => 185000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'weight' => 800,
                'dimension' => 35,
                'manage_stock' => true,
                'stock_quantity' => 40,
                'allow_backorders' => true,
                'low_stock_threshold' => 10,
                'warranty_information' => 'Garansi 1 tahun untuk kunci dan engsel. Garansi seumur hidup untuk bahan plastik ABS terhadap retak.',
                'delivery_shipping' => 'Pengiriman dengan kardus tebal dan bubble wrap. Estimasi 3-6 hari kerja karena ukuran besar. Asuransi pengiriman termasuk.'
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
