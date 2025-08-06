<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdnCorporateProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Aksesoris Mancing 2',
                'slug' => 'aksesoris-mancing-2',
                'description' => 'Aksesoris mancing berkualitas tinggi dari ADN Corporate. Dilengkapi dengan berbagai komponen penting untuk meningkatkan pengalaman memancing Anda. Terbuat dari bahan premium yang tahan lama dan cocok untuk berbagai kondisi memancing.',
                'price' => 125000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/Aksesoris-adun-2-500x500.webp',
                'weight' => 300,
                'dimension' => 20,
                'manage_stock' => true,
                'stock_quantity' => 50,
                'allow_backorders' => false,
                'low_stock_threshold' => 10,
                'warranty_information' => 'Produk bergaransi resmi 6 bulan untuk kerusakan produksi pabrik. Garansi tidak berlaku untuk kerusakan akibat pemakaian yang salah atau kecelakaan. Klaim garansi dapat dilakukan dengan menunjukkan bukti pembelian.',
                'delivery_shipping' => 'Pengiriman ke seluruh Indonesia dengan estimasi 2-5 hari kerja untuk wilayah Jawa-Bali, 3-7 hari kerja wilayah lainnya. Barang akan dikemas dengan bubble wrap dan kardus tebal untuk keamanan.',
                'category_ids' => ['aksesoris-memancing']
            ],
            [
                'name' => 'Adun Fishing Line 3 (AFL Line 3)',
                'slug' => 'adun-fishing-line-3-afl-line-3',
                'description' => 'Senar pancing AFL Line 3 dari ADN Corporate dengan teknologi terdepan. Memberikan kekuatan tarik superior dan ketahanan yang luar biasa. Cocok untuk memancing ikan berukuran sedang hingga besar di berbagai kondisi perairan.',
                'price' => 150000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/adun-fising-line-1-500x500.webp',
                'weight' => 200,
                'dimension' => 15,
                'manage_stock' => true,
                'stock_quantity' => 75,
                'allow_backorders' => true,
                'low_stock_threshold' => 15,
                'warranty_information' => 'Produk bergaransi resmi 1 tahun untuk kerusakan produksi pabrik. Senar AFL Line 3 telah teruji kualitasnya untuk penggunaan jangka panjang.',
                'delivery_shipping' => 'Pengiriman cepat 1-3 hari kerja wilayah Jabodetabek, 2-5 hari wilayah lainnya. Kemasan aman dengan bubble wrap untuk melindungi produk selama pengiriman.',
                'category_ids' => ['senar-pancing']
            ],
            [
                'name' => 'BAM Amis Putih Premium',
                'slug' => 'bam-amis-putih-premium',
                'description' => 'BAM Amis Putih Premium - umpan ikan berkualitas tinggi khusus untuk ikan mas dan ikan air tawar lainnya. Formula khusus dengan aroma amis yang kuat dan daya tarik tinggi. Terbuat dari bahan-bahan alami berkualitas premium yang aman dan efektif.',
                'price' => 80000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/BAM-AMIS-PUTIH-PREMIUM-rvs-500x500.webp',
                'weight' => 500,
                'dimension' => 10,
                'manage_stock' => true,
                'stock_quantity' => 100,
                'allow_backorders' => true,
                'low_stock_threshold' => 20,
                'warranty_information' => 'Produk memiliki masa kadaluarsa 12 bulan dari tanggal produksi. Kualitas dan kesegaran umpan terjamin selama masa berlaku.',
                'delivery_shipping' => 'Pengiriman khusus dengan pendingin untuk menjaga kualitas umpan. Estimasi 1-4 hari kerja tergantung lokasi. Kemasan kedap udara untuk menjaga kesegaran.',
                'category_ids' => ['umpan-lure']
            ],
            [
                'name' => 'Oplosan Adun 1',
                'slug' => 'oplosan-adun-1',
                'description' => 'Oplosan Adun 1 - ramuan umpan spesial dengan formula rahasia ADN Corporate. Sangat efektif untuk menarik berbagai jenis ikan air tawar. Terbuat dari bahan-bahan pilihan dengan komposisi yang telah teruji untuk memberikan hasil maksimal saat memancing.',
                'price' => 50000,
                'compare_price' => 200000,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/oplosan-adun-mancing-1-500x500.webp',
                'weight' => 250,
                'dimension' => 8,
                'manage_stock' => true,
                'stock_quantity' => 80,
                'allow_backorders' => true,
                'low_stock_threshold' => 15,
                'warranty_information' => 'Produk memiliki masa kadaluarsa 6 bulan dari tanggal produksi. Simpan di tempat kering dan sejuk untuk menjaga kualitas.',
                'delivery_shipping' => 'Pengiriman reguler dengan kemasan anti lembab. Estimasi 2-5 hari kerja ke seluruh Indonesia. Khusus untuk pembelian dalam jumlah banyak tersedia diskon ongkir.',
                'category_ids' => ['umpan-lure']
            ],
            [
                'name' => 'BAM Amis Kuning Premium',
                'slug' => 'bam-amis-kuning-premium',
                'description' => 'BAM Amis Kuning Premium - varian kuning dari seri BAM Premium dengan formula khusus untuk ikan mas dan ikan air tawar. Mengandung protein tinggi dan aroma yang sangat menarik untuk ikan. Cocok untuk berbagai teknik memancing di kolam, sungai, dan danau.',
                'price' => 80000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/BAM-AMIS-PUTIH-PREMIUM-rvs-500x500.webp',
                'weight' => 500,
                'dimension' => 10,
                'manage_stock' => true,
                'stock_quantity' => 85,
                'allow_backorders' => true,
                'low_stock_threshold' => 20,
                'warranty_information' => 'Produk memiliki masa kadaluarsa 12 bulan dari tanggal produksi. Kualitas dan kesegaran umpan terjamin selama masa berlaku.',
                'delivery_shipping' => 'Pengiriman khusus dengan pendingin untuk menjaga kualitas umpan. Estimasi 1-4 hari kerja tergantung lokasi. Kemasan kedap udara untuk menjaga kesegaran.',
                'category_ids' => ['umpan-lure']
            ],
            [
                'name' => 'BAM Jagung New',
                'slug' => 'bam-jagung-new',
                'description' => 'BAM Jagung New - umpan ikan berbasis jagung dengan formula terbaru yang lebih efektif. Sangat disukai oleh ikan mas, nila, dan ikan herbivora lainnya. Aroma jagung manis yang kuat dan tekstur yang sempurna untuk berbagai kondisi memancing.',
                'price' => 80000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/BAM-AMIS-PUTIH-PREMIUM-rvs-500x500.webp',
                'weight' => 500,
                'dimension' => 10,
                'manage_stock' => true,
                'stock_quantity' => 90,
                'allow_backorders' => true,
                'low_stock_threshold' => 25,
                'warranty_information' => 'Produk memiliki masa kadaluarsa 12 bulan dari tanggal produksi. Formula baru dengan daya tahan yang lebih baik.',
                'delivery_shipping' => 'Pengiriman dengan kemasan khusus anti lembab. Estimasi 1-4 hari kerja. Gratis ongkir untuk pembelian 3 pcs atau lebih.',
                'category_ids' => ['umpan-lure']
            ],
            [
                'name' => 'BAM Coconut',
                'slug' => 'bam-coconut',
                'description' => 'BAM Coconut - umpan ikan dengan aroma kelapa yang unik dan menarik. Cocok untuk ikan mas, bawal, dan berbagai jenis ikan air tawar lainnya. Formula khusus dengan campuran kelapa murni yang memberikan daya tarik ekstra untuk ikan.',
                'price' => 80000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/BAM-AMIS-PUTIH-PREMIUM-rvs-500x500.webp',
                'weight' => 500,
                'dimension' => 10,
                'manage_stock' => true,
                'stock_quantity' => 70,
                'allow_backorders' => true,
                'low_stock_threshold' => 20,
                'warranty_information' => 'Produk memiliki masa kadaluarsa 12 bulan dari tanggal produksi. Aroma kelapa tahan lama dan tidak mudah hilang.',
                'delivery_shipping' => 'Pengiriman dengan kemasan kedap udara untuk menjaga aroma kelapa. Estimasi 1-4 hari kerja ke seluruh Indonesia.',
                'category_ids' => ['umpan-lure']
            ],
            [
                'name' => 'Oplosan Adun 2',
                'slug' => 'oplosan-adun-2',
                'description' => 'Oplosan Adun 2 - varian kedua dari seri Oplosan dengan formula yang disempurnakan. Kombinasi bahan-bahan pilihan yang telah teruji efektivitasnya untuk berbagai jenis ikan air tawar. Sangat populer di kalangan pemancing berpengalaman.',
                'price' => 80000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/oplosan-adun-mancing-1-500x500.webp',
                'weight' => 250,
                'dimension' => 8,
                'manage_stock' => true,
                'stock_quantity' => 60,
                'allow_backorders' => true,
                'low_stock_threshold' => 12,
                'warranty_information' => 'Produk memiliki masa kadaluarsa 6 bulan dari tanggal produksi. Formula yang disempurnakan dengan daya tahan lebih baik.',
                'delivery_shipping' => 'Pengiriman reguler dengan kemasan anti lembab. Estimasi 2-5 hari kerja. Tersedia paket bundle dengan harga lebih hemat.',
                'category_ids' => ['umpan-lure']
            ],
            [
                'name' => 'Oplosan Adun 3',
                'slug' => 'oplosan-adun-3',
                'description' => 'Oplosan Adun 3 - varian premium dari seri Oplosan dengan komposisi terlengkap. Mengandung berbagai bahan aktif yang sangat efektif untuk menarik ikan besar. Formula rahasia yang telah dikembangkan selama bertahun-tahun oleh ADN Corporate.',
                'price' => 90000,
                'compare_price' => null,
                'status' => true,
                'featured_image' => 'https://www.adncorporate.co.id/wp-content/uploads/2025/03/oplosan-adun-mancing-1-500x500.webp',
                'weight' => 300,
                'dimension' => 10,
                'manage_stock' => true,
                'stock_quantity' => 45,
                'allow_backorders' => false,
                'low_stock_threshold' => 10,
                'warranty_information' => 'Produk memiliki masa kadaluarsa 8 bulan dari tanggal produksi. Varian premium dengan formula terlengkap dan efektivitas tertinggi.',
                'delivery_shipping' => 'Pengiriman premium dengan kemasan khusus. Estimasi 1-3 hari kerja wilayah Jawa-Bali, 2-5 hari wilayah lainnya. Gratis asuransi pengiriman.',
                'category_ids' => ['umpan-lure']
            ]
        ];

        // Create products and assign categories
        foreach ($products as $productData) {
            // Extract category slugs
            $categoryIds = $productData['category_ids'];
            unset($productData['category_ids']);
            
            // Create the product
            $product = Product::create($productData);
            
            // Assign categories
            foreach ($categoryIds as $categorySlug) {
                $category = Category::where('slug', $categorySlug)->first();
                if ($category) {
                    $product->categories()->attach($category->id);
                }
            }
        }
    }
}