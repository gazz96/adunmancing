<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'excerpt' => 'Pelajari lebih lanjut tentang Adun Mancing, sejarah kami, dan komitmen kami untuk menyediakan peralatan memancing terbaik.',
                'content' => '<h2>Sejarah Adun Mancing</h2><p>Adun Mancing didirikan dengan visi untuk menyediakan peralatan memancing berkualitas tinggi bagi para pecinta memancing di Indonesia. Sejak awal, kami berkomitmen untuk memberikan produk terbaik dengan harga yang terjangkau.</p><h3>Misi Kami</h3><ul><li>Menyediakan peralatan memancing berkualitas tinggi</li><li>Memberikan pelayanan terbaik kepada pelanggan</li><li>Mendukung komunitas memancing Indonesia</li></ul><h3>Visi Kami</h3><p>Menjadi toko peralatan memancing terpercaya dan terdepan di Indonesia, yang membantu setiap pemancing mencapai pengalaman memancing yang tak terlupakan.</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
                'meta_title' => 'Tentang Kami - Adun Mancing',
                'meta_description' => 'Pelajari sejarah, misi, dan visi Adun Mancing sebagai penyedia peralatan memancing terbaik di Indonesia.'
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'excerpt' => 'Kebijakan privasi Adun Mancing menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.',
                'content' => '<h2>Informasi yang Kami Kumpulkan</h2><p>Kami mengumpulkan informasi yang Anda berikan secara langsung kepada kami, seperti ketika Anda membuat akun, melakukan pembelian, atau menghubungi kami.</p><h3>Penggunaan Informasi</h3><p>Informasi yang kami kumpulkan digunakan untuk:</p><ul><li>Memproses pesanan dan pembayaran</li><li>Mengirimkan produk yang Anda beli</li><li>Memberikan dukungan pelanggan</li><li>Mengirimkan informasi promosi (dengan persetujuan Anda)</li></ul><h3>Perlindungan Data</h3><p>Kami menggunakan langkah-langkah keamanan yang sesuai untuk melindungi informasi pribadi Anda dari akses, penggunaan, atau pengungkapan yang tidak sah.</p>',
                'featured_image' => null,
                'is_published' => true,
                'meta_title' => 'Kebijakan Privasi - Adun Mancing',
                'meta_description' => 'Pelajari bagaimana Adun Mancing melindungi dan menggunakan informasi pribadi Anda sesuai dengan kebijakan privasi kami.'
            ],
            [
                'title' => 'Syarat dan Ketentuan',
                'slug' => 'syarat-dan-ketentuan',
                'excerpt' => 'Syarat dan ketentuan penggunaan website dan layanan Adun Mancing.',
                'content' => '<h2>Penerimaan Syarat</h2><p>Dengan mengakses dan menggunakan website ini, Anda setuju untuk terikat oleh syarat dan ketentuan berikut.</p><h3>Penggunaan Website</h3><p>Website ini hanya boleh digunakan untuk tujuan yang sah dan sesuai dengan hukum yang berlaku.</p><h3>Produk dan Harga</h3><ul><li>Semua harga tercantum dalam Rupiah (IDR)</li><li>Harga dapat berubah sewaktu-waktu tanpa pemberitahuan</li><li>Ketersediaan produk tidak dijamin</li></ul><h3>Pembayaran</h3><p>Pembayaran harus dilakukan sesuai dengan metode yang tersedia di website kami.</p>',
                'featured_image' => null,
                'is_published' => true,
                'meta_title' => 'Syarat dan Ketentuan - Adun Mancing',
                'meta_description' => 'Baca syarat dan ketentuan penggunaan website dan layanan Adun Mancing sebelum melakukan pembelian.'
            ],
            [
                'title' => 'Panduan Pembelian',
                'slug' => 'panduan-pembelian',
                'excerpt' => 'Panduan lengkap cara berbelanja di Adun Mancing, mulai dari memilih produk hingga checkout.',
                'content' => '<h2>Cara Berbelanja</h2><p>Berikut adalah langkah-langkah mudah untuk berbelanja di Adun Mancing:</p><h3>1. Daftar Akun</h3><p>Buat akun terlebih dahulu untuk dapat melakukan pembelian.</p><h3>2. Pilih Produk</h3><p>Jelajahi katalog kami dan pilih produk yang Anda inginkan.</p><h3>3. Tambah ke Keranjang</h3><p>Klik tombol "Add to Cart" untuk menambahkan produk ke keranjang belanja.</p><h3>4. Checkout</h3><p>Lakukan checkout dan pilih metode pembayaran yang tersedia.</p><h3>5. Pembayaran</h3><p>Lakukan pembayaran sesuai instruksi yang diberikan.</p><h3>6. Pengiriman</h3><p>Produk akan dikirim sesuai alamat yang Anda berikan.</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
                'meta_title' => 'Panduan Pembelian - Adun Mancing',
                'meta_description' => 'Ikuti panduan lengkap cara berbelanja di Adun Mancing dengan mudah dan aman.'
            ]
        ];

        foreach ($pages as $pageData) {
            Page::create($pageData);
        }
    }
}
