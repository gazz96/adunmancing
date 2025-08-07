<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Berapa lama waktu pengiriman?',
                'answer' => 'Waktu pengiriman bervariasi berdasarkan lokasi dan metode pengiriman yang dipilih. Umumnya, pengiriman standar kami membutuhkan waktu hingga 5 hari, sementara Express Delivery memastikan pesanan Anda tiba dalam 1 hari. Harap dicatat bahwa waktu ini dapat berubah karena keadaan yang tidak terduga, tetapi kami melakukan yang terbaik untuk memenuhi perkiraan ini.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Metode pembayaran apa saja yang diterima?',
                'answer' => 'Kami menerima berbagai metode pembayaran yang aman termasuk transfer bank, kartu kredit/debit utama, dan gateway pembayaran online lainnya. Anda dapat melihat daftar lengkap metode pembayaran yang diterima selama proses checkout.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah saya perlu membuat akun untuk berbelanja?',
                'answer' => 'Meskipun checkout sebagai tamu tersedia untuk kenyamanan Anda, membuat akun akan meningkatkan pengalaman berbelanja Anda secara keseluruhan. Dengan akun, Anda dapat dengan mudah melacak status pesanan, menyimpan beberapa alamat pengiriman, dan menikmati proses checkout yang lebih efisien. Selain itu, pemegang akun mendapat akses awal ke promosi dan penawaran eksklusif.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara melacak pesanan saya?',
                'answer' => 'Setelah pesanan Anda dikirim, Anda akan menerima email konfirmasi yang berisi nomor pelacakan unik. Anda dapat menggunakan nomor pelacakan ini di website kami untuk memantau status pengiriman secara real-time. Selain itu, masuk ke akun Anda akan memberikan akses ke riwayat pesanan yang komprehensif, termasuk informasi pelacakan.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Apa kondisi pengembalian produk?',
                'answer' => 'Kebijakan pengembalian kami dirancang untuk memastikan kepuasan pelanggan. Kami menerima pengembalian dalam 7 hari setelah menerima produk, asalkan dalam kondisi asli dengan semua label dan kemasan masih utuh. Pengembalian uang akan diproses segera setelah barang yang dikembalikan diperiksa dan disetujui.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada minimum pembelian untuk gratis ongkos kirim?',
                'answer' => 'Ya, kami menawarkan gratis ongkos kirim untuk pesanan di atas Rp 500.000. Pesanan di bawah ambang ini akan dikenakan biaya pengiriman standar, yang akan ditampilkan selama proses checkout.',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah produk fishing yang dijual original?',
                'answer' => 'Semua produk pancing yang kami jual adalah 100% original dan bergaransi resmi. Kami bekerja sama langsung dengan distributor resmi dan brand-brand terkemuka di dunia fishing. Setiap produk dilengkapi dengan sertifikat keaslian dan garansi sesuai dengan ketentuan dari masing-masing brand.',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana jika produk yang diterima tidak sesuai atau rusak?',
                'answer' => 'Jika produk yang Anda terima tidak sesuai pesanan atau mengalami kerusakan, segera hubungi customer service kami maksimal 1x24 jam setelah barang diterima. Kami akan membantu proses penukaran atau pengembalian dana sesuai dengan kondisi dan kebijakan yang berlaku. Pastikan untuk menyertakan foto produk dan kemasan sebagai bukti.',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            \App\Models\Faq::create($faq);
        }
    }
}
