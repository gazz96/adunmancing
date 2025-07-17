-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table adunmancing.attributes
CREATE TABLE IF NOT EXISTS `attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `values` text,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.attributes: ~0 rows (approximately)
INSERT INTO `attributes` (`id`, `name`, `created_at`, `slug`, `values`, `updated_at`) VALUES
	(1, 'Warna', '2025-07-04 17:29:03', 'warna', 'Merah|Hijau|Biru', '2025-07-08 12:36:03');

-- Dumping structure for table adunmancing.blogs
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint unsigned NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`),
  KEY `blogs_author_id_foreign` (`author_id`),
  CONSTRAINT `blogs_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.blogs: ~1 rows (approximately)
INSERT INTO `blogs` (`id`, `title`, `slug`, `content`, `featured_image`, `author_id`, `is_published`, `created_at`, `updated_at`, `views`) VALUES
	(1, 'obi Mancing: Antara Relaksasi dan Tantangan Alam', 'hobi-mancing-antara-relaksasi-dan-tantangan-alam', 'Mancing bukan sekadar aktivitas menangkap ikan—bagi banyak orang, mancing adalah hobi yang menawarkan ketenangan, tantangan, dan rasa pencapaian tersendiri. Duduk di pinggir sungai, danau, atau di atas perahu, dengan joran di tangan dan semilir angin yang menyapa, menciptakan suasana yang menenangkan pikiran dan melepaskan stres.\n\nNamun, mancing juga menuntut kesabaran dan strategi. Memilih umpan yang tepat, membaca pergerakan air, hingga menanti waktu yang pas untuk menarik pancing adalah bagian dari seni memancing. Ikan bukan hanya sekadar tangkapan, tapi simbol keberhasilan dari kesabaran dan ketelitian.\n\nDi era modern, mancing juga menjadi ajang silaturahmi dan kompetisi. Banyak komunitas mancing bermunculan, mulai dari skala lokal hingga nasional. Mereka berbagi tips, lokasi potensial, hingga teknik terbaru untuk menaklukkan ikan-ikan besar.', 'blogs/featured-images/01JZJ670YXMG0QFDHR2503PZPV.jpg', 1, 1, '2025-06-30 21:36:24', '2025-07-10 20:27:12', NULL);

-- Dumping structure for table adunmancing.blog_categories
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.blog_categories: ~2 rows (approximately)
INSERT INTO `blog_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'News', 'news', '2025-06-30 21:49:53', '2025-06-30 21:50:07'),
	(2, 'Information', 'information', '2025-06-30 21:51:29', '2025-06-30 21:51:29');

-- Dumping structure for table adunmancing.blog_post_category
CREATE TABLE IF NOT EXISTS `blog_post_category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` bigint unsigned NOT NULL,
  `blog_category_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_post_category_blog_id_foreign` (`blog_id`),
  KEY `blog_post_category_blog_category_id_foreign` (`blog_category_id`),
  CONSTRAINT `blog_post_category_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_post_category_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.blog_post_category: ~2 rows (approximately)
INSERT INTO `blog_post_category` (`id`, `blog_id`, `blog_category_id`) VALUES
	(1, 1, 1);

-- Dumping structure for table adunmancing.cart_items
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `variation` text,
  `quantity` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `product_attributes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.cart_items: ~0 rows (approximately)

-- Dumping structure for table adunmancing.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.categories: ~5 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`, `icon`) VALUES
	(1, 'Makanan', 'makanan', '2025-06-30 17:53:12', '2025-07-07 03:18:08', 'product_category_icons/01JZJ696V64YSJWG1EZ9YMYVKH.png'),
	(2, 'Alat Mancing', 'alat-mancing', '2025-07-06 20:25:46', '2025-07-07 02:58:21', 'product_category_icons/01JZJ550CRH2HHRAGTQNM0PPAN.png'),
	(3, 'Rokok Elektronik', 'rokok-elektronik', '2025-07-06 20:26:06', '2025-07-07 02:58:42', 'product_category_icons/01JZJ55MZ9DMA61R2BMQ9KS34A.png'),
	(4, 'Bubble Wrap', 'bubble-wrap', '2025-07-06 20:26:59', '2025-07-07 02:58:48', 'product_category_icons/01JZJ55T1JG1AEWFMGG47ASJW5.png'),
	(5, 'Umpan Pancing', 'umpan-pancing', '2025-07-07 03:31:11', '2025-07-07 13:48:01', 'product_category_icons/01JZJ7142QMT6T3YC5M1EWG4Z1.png');

-- Dumping structure for table adunmancing.category_product
CREATE TABLE IF NOT EXISTS `category_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_product_category_id_product_id_unique` (`category_id`,`product_id`),
  KEY `category_product_product_id_foreign` (`product_id`),
  CONSTRAINT `category_product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.category_product: ~4 rows (approximately)
INSERT INTO `category_product` (`id`, `category_id`, `product_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(5, 5, 4),
	(4, 5, 5),
	(3, 5, 6);

-- Dumping structure for table adunmancing.coupons
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `discount_percent` decimal(5,2) DEFAULT NULL,
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `usage_limit` int DEFAULT NULL,
  `usage_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.coupons: ~0 rows (approximately)
INSERT INTO `coupons` (`id`, `code`, `discount_amount`, `discount_percent`, `valid_from`, `valid_until`, `usage_limit`, `usage_count`, `created_at`, `updated_at`) VALUES
	(2, '171110100', 1000.00, 0.00, '2025-07-01', '2025-07-05', 10, 0, '2025-06-30 23:20:48', '2025-06-30 23:20:48');

-- Dumping structure for table adunmancing.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table adunmancing.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.menus: ~1 rows (approximately)
INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Main Menu', '2025-07-05 22:25:44', '2025-07-05 22:25:44');

-- Dumping structure for table adunmancing.menu_items
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int unsigned NOT NULL DEFAULT '0',
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`),
  KEY `menu_items_parent_id_foreign` (`parent_id`),
  CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.menu_items: ~5 rows (approximately)
INSERT INTO `menu_items` (`id`, `menu_id`, `label`, `url`, `order`, `parent_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Home', 'http://adunmancing.test', 1, NULL, '2025-07-05 22:32:37', '2025-07-08 12:29:15'),
	(2, 1, 'Shop', '/shop', 2, 1, '2025-07-05 22:33:09', '2025-07-08 12:29:15'),
	(3, 1, 'Contact', '/contact-us', 5, NULL, '2025-07-08 12:21:58', '2025-07-08 12:30:25'),
	(4, 1, 'Blogs', '/blogs', 3, NULL, '2025-07-08 12:24:14', '2025-07-08 12:29:15'),
	(5, 1, 'About us', '/about-us', 4, NULL, '2025-07-08 12:24:32', '2025-07-08 12:30:25');

-- Dumping structure for table adunmancing.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.migrations: ~25 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_06_30_232727_create_categories_table', 2),
	(6, '2025_06_30_232728_create_products_table', 2),
	(7, '2025_06_30_232729_create_category_product_table', 2),
	(8, '2025_06_30_232729_create_product_images_table', 2),
	(9, '2025_06_30_233153_create_product_variants_table', 2),
	(10, '2025_06_30_233153_create_variant_options_table', 2),
	(11, '2025_06_30_233154_create_product_variant_images_table', 2),
	(12, '2025_06_30_233705_create_stock_movements_table', 3),
	(13, '2025_06_30_233808_create_orders_table', 3),
	(14, '2025_06_30_233852_create_order_items_table', 3),
	(15, '2025_06_30_233930_create_payments_table', 3),
	(16, '2025_06_30_234030_create_shipping_methods_table', 3),
	(17, '2025_06_30_234107_create_order_shipping_table', 3),
	(18, '2025_06_30_234149_create_coupons_table', 3),
	(19, '2025_06_30_234232_create_order_coupons_table', 3),
	(20, '2025_06_30_234342_create_product_reviews_table', 3),
	(21, '2025_06_30_234733_create_blogs_table', 3),
	(22, '2025_06_30_234804_create_blog_categories_table', 3),
	(23, '2025_06_30_234856_create_blog_post_category_table', 3),
	(24, '2025_06_30_234917_create_menus_table', 3),
	(25, '2025_06_30_234937_create_menu_items_table', 3);

-- Dumping structure for table adunmancing.options
CREATE TABLE IF NOT EXISTS `options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `option_name` varchar(150) DEFAULT NULL,
  `option_value` text,
  `autoload` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT (now()),
  `updated_at` timestamp NULL DEFAULT (now()) ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.options: ~23 rows (approximately)
INSERT INTO `options` (`id`, `option_name`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES
	(1, 'site_name', 'Adunmancing', NULL, '2025-07-05 17:55:32', '2025-07-05 17:55:32'),
	(2, 'site_description', 'Lorem Ipsum dolor sit amet', NULL, '2025-07-05 17:55:32', '2025-07-11 04:09:06'),
	(3, 'store_name', 'ADUNMANCING', NULL, '2025-07-05 20:43:38', '2025-07-05 20:45:58'),
	(4, 'store_address_1', 'JL. ILENG TAMAN PERMATA HIJAU BLOK B', NULL, '2025-07-05 20:43:38', '2025-07-05 20:45:58'),
	(5, 'store_address_2', 'NO. 13 MEDAN - MARELAN', NULL, '2025-07-05 20:43:38', '2025-07-05 20:45:58'),
	(6, 'store_postcode', '20146', NULL, '2025-07-05 20:43:38', '2025-07-05 20:43:38'),
	(7, 'store_phone', '1234 5678 9101', NULL, '2025-07-05 20:43:38', '2025-07-05 20:43:38'),
	(8, 'store_email', 'custom@adunmancing.com', NULL, '2025-07-05 20:43:38', '2025-07-05 20:43:38'),
	(9, 'store_regency_id', '278', NULL, '2025-07-05 20:43:38', '2025-07-10 21:43:57'),
	(10, 'site_logo', 'site_logos/01JZJ6W4NNR3XCNBK0SV00TJGE.jpg', NULL, '2025-07-06 20:18:25', '2025-07-07 03:28:28'),
	(11, 'contact', '15053753082', NULL, '2025-07-06 20:18:25', '2025-07-07 03:26:33'),
	(12, 'enable_cod', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(13, 'enable_bank_transfer', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(14, 'enable_credit_card', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(15, 'enable_paypal', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(16, 'email_new_order_template', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(17, 'email_cancel_order_template', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(18, 'email_failed_order_template', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(19, 'enable_guest_checkout', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(20, 'enable_login_during_checkout', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(21, 'registration_privacy_policy', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(22, 'checkout_privacy_policy', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25'),
	(23, 'site_copyright', '© All rights reserved. Made with  by Bagas Topati', NULL, '2025-07-10 21:12:22', '2025-07-10 21:12:22');

-- Dumping structure for table adunmancing.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','completed','cancelled','shipped') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `courier` text COLLATE utf8mb4_unicode_ci,
  `courier_package` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `delivery_price` int DEFAULT NULL,
  `origin` int DEFAULT NULL,
  `destination` int DEFAULT NULL,
  `destinationType` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_weight` int DEFAULT NULL,
  `originType` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recepient_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recepient_phone_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_date` date DEFAULT NULL,
  `awb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.orders: ~1 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `order_number`, `status`, `total_amount`, `created_at`, `updated_at`, `address`, `note`, `courier`, `courier_package`, `delivery_price`, `origin`, `destination`, `destinationType`, `postal_code`, `total_weight`, `originType`, `recepient_name`, `recepient_phone_number`, `send_date`, `awb`) VALUES
	(11, 1, 'ORD-20250711-0001', 'shipped', 56000.00, '2025-07-10 23:58:19', '2025-07-11 00:03:54', 'JL. KROBOKAN', NULL, 'jne', 'jne|JTR|180000|10-14', 180000, 278, 17, 'city', '20225', 1000, 'city', 'UWAK', '087812341234', '2025-07-11', '171110100');

-- Dumping structure for table adunmancing.order_coupons
CREATE TABLE IF NOT EXISTS `order_coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `coupon_id` bigint unsigned NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_coupons_order_id_foreign` (`order_id`),
  KEY `order_coupons_coupon_id_foreign` (`coupon_id`),
  CONSTRAINT `order_coupons_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_coupons_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.order_coupons: ~0 rows (approximately)

-- Dumping structure for table adunmancing.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_variant_id` bigint unsigned DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `product_attributes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.order_items: ~4 rows (approximately)
INSERT INTO `order_items` (`id`, `order_id`, `product_variant_id`, `quantity`, `price`, `created_at`, `updated_at`, `product_id`, `weight`, `product_attributes`) VALUES
	(14, 11, NULL, 1, 10000.00, '2025-07-10 23:58:19', '2025-07-10 23:58:19', 5, NULL, NULL),
	(15, 11, NULL, 2, 23000.00, '2025-07-10 23:58:19', '2025-07-10 23:58:19', 4, NULL, NULL);

-- Dumping structure for table adunmancing.order_shipping
CREATE TABLE IF NOT EXISTS `order_shipping` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `shipping_method_id` bigint unsigned NOT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_shipping_order_id_foreign` (`order_id`),
  KEY `order_shipping_shipping_method_id_foreign` (`shipping_method_id`),
  CONSTRAINT `order_shipping_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_shipping_shipping_method_id_foreign` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_methods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.order_shipping: ~0 rows (approximately)

-- Dumping structure for table adunmancing.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table adunmancing.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.payments: ~0 rows (approximately)

-- Dumping structure for table adunmancing.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table adunmancing.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `has_variants` int DEFAULT NULL,
  `featured_image` text COLLATE utf8mb4_unicode_ci,
  `views` int DEFAULT NULL,
  `sales_count` int DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `dimension` double DEFAULT NULL,
  `dimension_w` double DEFAULT NULL,
  `dimension_h` double DEFAULT NULL,
  `product_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.products: ~5 rows (approximately)
INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `status`, `created_at`, `updated_at`, `compare_price`, `has_variants`, `featured_image`, `views`, `sales_count`, `weight`, `dimension`, `dimension_w`, `dimension_h`, `product_id`) VALUES
	(1, 'Umpan Lele Siap Pakai Pala Ayam Premium 250gram', 'umpan-lele-siap-pakai-pala-ayam-premium-250gram', '<p>Pala Ayam Premium</p><p>- Merupakan produk umpan yang dikemas secara praktis dan siap pakai. Terbuat dari 100% kepala ayam pilihan.</p><p>- Beraroma amis yang kuat dan khas membuat ikan menjadi lebih cepat kumpul.</p><p>- Sangat cocok dipakai untuk memancing ikan lele, di antaranya :</p><p>1. Galatama Ikan Lele</p><p>2. Lomba Harian Ikan Lele</p><p>3. Galapung Ikan Lele</p><p>4. Harian Ikan Lele</p><p><br><br></p><p>Netto : 250gram/cup</p><p><br><br></p><p>Tata Cara Pemakaian :</p><p>* Ketika paket sampai simpan BAM PALA AYAM PREMIUM dilemari es bagian bawah/frezeer. Pada saat ingin dipakai, keluarkan BAM PALA AYAM PREMIUM dari lemari es kemudian diamkan selama 10-30 menit sampai kondisi suhu normal. Lalu tambahkan ESSEN OPLOSAN ADUN MANCING 35 tetes s/d 1 tutup botol essen oplosan (aduk sampai tercampur rata). Tambahkan BAM PENGERAS secukupnya apabila tekstur belum sesuai dengan yang di inginkan. Aduk sampai semua bahan tercampur rata dan umpan siap digunakan.</p><p><br><br></p><p>* MASA SIMPAN :&nbsp;</p><p>- BAM PALA AYAM PREMIUM diluar frezeer/pendingin tahan 5 s/d 7 hari.&nbsp;</p><p>- BAM PALA AYAM PREMIUM didalam chiller tahan 6 bulan.</p><p>- BAM PALA AYAM PREMIUM didalam frezeer tahan 1 tahun&nbsp;</p>', 11900.00, 1, '2025-06-30 18:09:23', '2025-07-10 23:13:19', 15000.00, NULL, 'product/01JZJ7VNE1PSBETJ3VR16AZDJ1.webp', 57, NULL, 500, NULL, NULL, NULL, NULL),
	(2, 'Non Variant', 'non-variant', '<p>ini barang non variant</p>', 1000000.00, 1, '2025-07-04 16:48:06', '2025-07-07 03:48:25', 1500000.00, NULL, 'product/01JZJ80NS93HFAWYYWV008JC55.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(4, 'Umpan Lele Siap Pakai Peren Premium 250grm', 'umpan-lele-siap-pakai-peren-premium-250grm', '<p>- Merupakan produk umpan yang dikemas secara praktis dan siap pakai. Terbuat dari 100% Telor Muda pilihan.</p><p>- Beraroma amis Asam yang kuat dan khas membuat ikan menjadi lebih cepat kumpul.</p><p>- Sangat cocok dipakai untuk memancing ikan lele, di antaranya :</p><p>1. Galatama Ikan Lele</p><p>2. Lomba Harian Ikan Lele</p><p>3. Galapung Ikan Lele</p><p>4. Harian Ikan Lele</p><p><br><br></p><p>Netto : 250gram/cup</p><p><br><br></p><p>Tata Cara Pemakaian :</p><p>* Ketika paket sampai simpan BAM PEREN PREMIUM dilemari es bagian bawah/frezeer. Pada saat ingin dipakai, keluarkan BAM PEREN PREMIUM dari lemari es kemudian diamkan selama 10-30 menit sampai kondisi suhu normal. Lalu tambahkan ESSEN OPLOSAN ADUN MANCING 35 tetes s/d 1 tutup botol essen oplosan (aduk sampai tercampur rata). Tambahkan BAM PENGERAS secukupnya apabila tekstur belum sesuai dengan yang di inginkan. Aduk sampai semua bahan tercampur rata dan umpan siap digunakan.</p><p><br><br></p><p>* MASA SIMPAN :&nbsp;</p><p>- BAM PEREN PREMIUM diluar frezeer/pendingin tahan 5 s/d 7 hari.&nbsp;</p><p>- BAM PEREN PREMIUM didalam chiller tahan 6 bulan.</p><p>- BAM PEREN PREMIUM didalam frezeer tahan 1 tahun.</p>', 23000.00, 1, '2025-07-04 16:50:05', '2025-07-07 14:18:24', NULL, NULL, 'product/01JZJ83SDN680BFN2ZZKQD85JC.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 'Essen Oplosan Brajamusti Wangi asem melati Cocok untuk Galatama / Harian Ikan Lele', 'essen-oplosan-brajamusti-wangi-asem-melati-cocok-untuk-galatama-harian-ikan-lele', '<p>Cara menggunakan sangat mudah, Campurkan Essen ke media yang sering kalian gunakan, Aduk sampai adonan tercampur dengan rata &amp; Media siap di gunakan&nbsp;</p>', 10000.00, 1, '2025-07-04 17:49:17', '2025-07-08 17:32:11', 65000.00, NULL, 'product/01JZKBA463NCX5P2G0SQ489DDW.webp', 1, NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 'Lemak Kuda Premium Adun Mancing', 'lemak-kuda-premium-adun-mancing', '<p>Berpungsi Sebagai Campuran Umpan Olahan Maupun Umpan Alam Galatama Dan Harian Lele&nbsp;</p><p>Dan Berhasiat Sebagai Perangsang Agar Ikan Lebih Cepat Kumpul</p>', 45000.00, 1, '2025-07-07 13:47:51', '2025-07-08 12:30:49', NULL, NULL, 'product/01JZKAA8VHANYFJ7E5AG3HTMCH.webp', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- Dumping structure for table adunmancing.product_attributes
CREATE TABLE IF NOT EXISTS `product_attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `attribute_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `attribute_name` text,
  `attribute_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `show_in_product` int DEFAULT NULL,
  `use_as_variation` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.product_attributes: ~1 rows (approximately)
INSERT INTO `product_attributes` (`id`, `product_id`, `attribute_id`, `created_at`, `attribute_name`, `attribute_value`, `show_in_product`, `use_as_variation`, `updated_at`) VALUES
	(1, 1, 1, '2025-07-07 20:04:36', NULL, NULL, 1, 1, '2025-07-10 23:13:19');

-- Dumping structure for table adunmancing.product_attribute_values
CREATE TABLE IF NOT EXISTS `product_attribute_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_attribute_id` bigint unsigned NOT NULL,
  `value` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_attribute_id` (`product_attribute_id`),
  CONSTRAINT `product_attribute_values_ibfk_1` FOREIGN KEY (`product_attribute_id`) REFERENCES `product_attributes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.product_attribute_values: ~0 rows (approximately)

-- Dumping structure for table adunmancing.product_images
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.product_images: ~3 rows (approximately)
INSERT INTO `product_images` (`id`, `product_id`, `path`, `is_main`, `created_at`, `updated_at`) VALUES
	(3, 1, 'product-images/id-11134207-7r98o-luyq7gek814h3b@resize_w450_nl.webp', 0, '2025-06-30 18:27:40', '2025-06-30 18:37:13'),
	(5, 1, 'product-images/id-11134207-7r991-lzppndk9gtm092.webp', 0, '2025-07-07 19:04:26', '2025-07-07 19:04:26');

-- Dumping structure for table adunmancing.product_reviews
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `rating` tinyint unsigned NOT NULL DEFAULT '5',
  `review` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_reviews_product_id_foreign` (`product_id`),
  KEY `product_reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.product_reviews: ~0 rows (approximately)

-- Dumping structure for table adunmancing.product_variants
CREATE TABLE IF NOT EXISTS `product_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_variants_sku_unique` (`sku`),
  KEY `product_variants_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.product_variants: ~4 rows (approximately)
INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `price`, `status`, `created_at`, `updated_at`) VALUES
	(2, 1, 'UMPAN-LELE-SIAP-PAKAI-PALA-AYAM-PREMIUM-250GRAM', 17500.00, 1, '2025-06-30 22:19:38', '2025-06-30 22:23:48'),
	(3, 1, 'UMPAN-LELE-SIAP-PAKAI-PALA-AYAM-PREMIUM-250GRAM-1', 20000.00, 1, '2025-06-30 22:20:17', '2025-06-30 22:23:48'),
	(4, 2, 'NON-VARIANT', NULL, 1, '2025-07-04 16:48:06', '2025-07-04 16:48:06'),
	(5, 4, 'NON-VARIANT-2', NULL, 1, '2025-07-04 16:50:05', '2025-07-04 16:50:05');

-- Dumping structure for table adunmancing.product_variant_images
CREATE TABLE IF NOT EXISTS `product_variant_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variant_images_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `product_variant_images_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.product_variant_images: ~0 rows (approximately)

-- Dumping structure for table adunmancing.provinces
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `alt_name` varchar(255) NOT NULL,
  `latitude` double NOT NULL DEFAULT '0',
  `longitude` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.provinces: ~34 rows (approximately)
INSERT INTO `provinces` (`id`, `name`, `alt_name`, `latitude`, `longitude`) VALUES
	(1, 'Bali', 'bali', 0, 0),
	(2, 'Bangka Belitung', 'bangka-belitung', 0, 0),
	(3, 'Banten', 'banten', 0, 0),
	(4, 'Bengkulu', 'bengkulu', 0, 0),
	(5, 'DI Yogyakarta', 'di-yogyakarta', 0, 0),
	(6, 'DKI Jakarta', 'dki-jakarta', 0, 0),
	(7, 'Gorontalo', 'gorontalo', 0, 0),
	(8, 'Jambi', 'jambi', 0, 0),
	(9, 'Jawa Barat', 'jawa-barat', 0, 0),
	(10, 'Jawa Tengah', 'jawa-tengah', 0, 0),
	(11, 'Jawa Timur', 'jawa-timur', 0, 0),
	(12, 'Kalimantan Barat', 'kalimantan-barat', 0, 0),
	(13, 'Kalimantan Selatan', 'kalimantan-selatan', 0, 0),
	(14, 'Kalimantan Tengah', 'kalimantan-tengah', 0, 0),
	(15, 'Kalimantan Timur', 'kalimantan-timur', 0, 0),
	(16, 'Kalimantan Utara', 'kalimantan-utara', 0, 0),
	(17, 'Kepulauan Riau', 'kepulauan-riau', 0, 0),
	(18, 'Lampung', 'lampung', 0, 0),
	(19, 'Maluku', 'maluku', 0, 0),
	(20, 'Maluku Utara', 'maluku-utara', 0, 0),
	(21, 'Nanggroe Aceh Darussalam (NAD)', 'nanggroe-aceh-darussalam-nad', 0, 0),
	(22, 'Nusa Tenggara Barat (NTB)', 'nusa-tenggara-barat-ntb', 0, 0),
	(23, 'Nusa Tenggara Timur (NTT)', 'nusa-tenggara-timur-ntt', 0, 0),
	(24, 'Papua', 'papua', 0, 0),
	(25, 'Papua Barat', 'papua-barat', 0, 0),
	(26, 'Riau', 'riau', 0, 0),
	(27, 'Sulawesi Barat', 'sulawesi-barat', 0, 0),
	(28, 'Sulawesi Selatan', 'sulawesi-selatan', 0, 0),
	(29, 'Sulawesi Tengah', 'sulawesi-tengah', 0, 0),
	(30, 'Sulawesi Tenggara', 'sulawesi-tenggara', 0, 0),
	(31, 'Sulawesi Utara', 'sulawesi-utara', 0, 0),
	(32, 'Sumatera Barat', 'sumatera-barat', 0, 0),
	(33, 'Sumatera Selatan', 'sumatera-selatan', 0, 0),
	(34, 'Sumatera Utara', 'sumatera-utara', 0, 0);

-- Dumping structure for table adunmancing.regencies
CREATE TABLE IF NOT EXISTS `regencies` (
  `id` bigint NOT NULL,
  `province_id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `latitude` double DEFAULT '0',
  `longitude` double DEFAULT '0',
  `destination_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regencies_province_id_foreign` (`province_id`),
  CONSTRAINT `regencies_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.regencies: ~514 rows (approximately)
INSERT INTO `regencies` (`id`, `province_id`, `name`, `alt_name`, `latitude`, `longitude`, `destination_type`) VALUES
	(1, 21, 'Aceh Barat', 'Aceh Barat', NULL, NULL, 'Kabupaten'),
	(2, 21, 'Aceh Barat Daya', 'Aceh Barat Daya', NULL, NULL, 'Kabupaten'),
	(3, 21, 'Aceh Besar', 'Aceh Besar', NULL, NULL, 'Kabupaten'),
	(4, 21, 'Aceh Jaya', 'Aceh Jaya', NULL, NULL, 'Kabupaten'),
	(5, 21, 'Aceh Selatan', 'Aceh Selatan', NULL, NULL, 'Kabupaten'),
	(6, 21, 'Aceh Singkil', 'Aceh Singkil', NULL, NULL, 'Kabupaten'),
	(7, 21, 'Aceh Tamiang', 'Aceh Tamiang', NULL, NULL, 'Kabupaten'),
	(8, 21, 'Aceh Tengah', 'Aceh Tengah', NULL, NULL, 'Kabupaten'),
	(9, 21, 'Aceh Tenggara', 'Aceh Tenggara', NULL, NULL, 'Kabupaten'),
	(10, 21, 'Aceh Timur', 'Aceh Timur', NULL, NULL, 'Kabupaten'),
	(11, 21, 'Aceh Utara', 'Aceh Utara', NULL, NULL, 'Kabupaten'),
	(12, 32, 'Agam', 'Agam', NULL, NULL, 'Kabupaten'),
	(13, 23, 'Alor', 'Alor', NULL, NULL, 'Kabupaten'),
	(14, 19, 'Ambon', 'Ambon', NULL, NULL, 'Kota'),
	(15, 34, 'Asahan', 'Asahan', NULL, NULL, 'Kabupaten'),
	(16, 24, 'Asmat', 'Asmat', NULL, NULL, 'Kabupaten'),
	(17, 1, 'Badung', 'Badung', NULL, NULL, 'Kabupaten'),
	(18, 13, 'Balangan', 'Balangan', NULL, NULL, 'Kabupaten'),
	(19, 15, 'Balikpapan', 'Balikpapan', NULL, NULL, 'Kota'),
	(20, 21, 'Banda Aceh', 'Banda Aceh', NULL, NULL, 'Kota'),
	(21, 18, 'Bandar Lampung', 'Bandar Lampung', NULL, NULL, 'Kota'),
	(22, 9, 'Bandung', 'Bandung', NULL, NULL, 'Kabupaten'),
	(23, 9, 'Bandung', 'Bandung', NULL, NULL, 'Kota'),
	(24, 9, 'Bandung Barat', 'Bandung Barat', NULL, NULL, 'Kabupaten'),
	(25, 29, 'Banggai', 'Banggai', NULL, NULL, 'Kabupaten'),
	(26, 29, 'Banggai Kepulauan', 'Banggai Kepulauan', NULL, NULL, 'Kabupaten'),
	(27, 2, 'Bangka', 'Bangka', NULL, NULL, 'Kabupaten'),
	(28, 2, 'Bangka Barat', 'Bangka Barat', NULL, NULL, 'Kabupaten'),
	(29, 2, 'Bangka Selatan', 'Bangka Selatan', NULL, NULL, 'Kabupaten'),
	(30, 2, 'Bangka Tengah', 'Bangka Tengah', NULL, NULL, 'Kabupaten'),
	(31, 11, 'Bangkalan', 'Bangkalan', NULL, NULL, 'Kabupaten'),
	(32, 1, 'Bangli', 'Bangli', NULL, NULL, 'Kabupaten'),
	(33, 13, 'Banjar', 'Banjar', NULL, NULL, 'Kabupaten'),
	(34, 9, 'Banjar', 'Banjar', NULL, NULL, 'Kota'),
	(35, 13, 'Banjarbaru', 'Banjarbaru', NULL, NULL, 'Kota'),
	(36, 13, 'Banjarmasin', 'Banjarmasin', NULL, NULL, 'Kota'),
	(37, 10, 'Banjarnegara', 'Banjarnegara', NULL, NULL, 'Kabupaten'),
	(38, 28, 'Bantaeng', 'Bantaeng', NULL, NULL, 'Kabupaten'),
	(39, 5, 'Bantul', 'Bantul', NULL, NULL, 'Kabupaten'),
	(40, 33, 'Banyuasin', 'Banyuasin', NULL, NULL, 'Kabupaten'),
	(41, 10, 'Banyumas', 'Banyumas', NULL, NULL, 'Kabupaten'),
	(42, 11, 'Banyuwangi', 'Banyuwangi', NULL, NULL, 'Kabupaten'),
	(43, 13, 'Barito Kuala', 'Barito Kuala', NULL, NULL, 'Kabupaten'),
	(44, 14, 'Barito Selatan', 'Barito Selatan', NULL, NULL, 'Kabupaten'),
	(45, 14, 'Barito Timur', 'Barito Timur', NULL, NULL, 'Kabupaten'),
	(46, 14, 'Barito Utara', 'Barito Utara', NULL, NULL, 'Kabupaten'),
	(47, 28, 'Barru', 'Barru', NULL, NULL, 'Kabupaten'),
	(48, 17, 'Batam', 'Batam', NULL, NULL, 'Kota'),
	(49, 10, 'Batang', 'Batang', NULL, NULL, 'Kabupaten'),
	(50, 8, 'Batang Hari', 'Batang Hari', NULL, NULL, 'Kabupaten'),
	(51, 11, 'Batu', 'Batu', NULL, NULL, 'Kota'),
	(52, 34, 'Batu Bara', 'Batu Bara', NULL, NULL, 'Kabupaten'),
	(53, 30, 'Bau-Bau', 'Bau-Bau', NULL, NULL, 'Kota'),
	(54, 9, 'Bekasi', 'Bekasi', NULL, NULL, 'Kabupaten'),
	(55, 9, 'Bekasi', 'Bekasi', NULL, NULL, 'Kota'),
	(56, 2, 'Belitung', 'Belitung', NULL, NULL, 'Kabupaten'),
	(57, 2, 'Belitung Timur', 'Belitung Timur', NULL, NULL, 'Kabupaten'),
	(58, 23, 'Belu', 'Belu', NULL, NULL, 'Kabupaten'),
	(59, 21, 'Bener Meriah', 'Bener Meriah', NULL, NULL, 'Kabupaten'),
	(60, 26, 'Bengkalis', 'Bengkalis', NULL, NULL, 'Kabupaten'),
	(61, 12, 'Bengkayang', 'Bengkayang', NULL, NULL, 'Kabupaten'),
	(62, 4, 'Bengkulu', 'Bengkulu', NULL, NULL, 'Kota'),
	(63, 4, 'Bengkulu Selatan', 'Bengkulu Selatan', NULL, NULL, 'Kabupaten'),
	(64, 4, 'Bengkulu Tengah', 'Bengkulu Tengah', NULL, NULL, 'Kabupaten'),
	(65, 4, 'Bengkulu Utara', 'Bengkulu Utara', NULL, NULL, 'Kabupaten'),
	(66, 15, 'Berau', 'Berau', NULL, NULL, 'Kabupaten'),
	(67, 24, 'Biak Numfor', 'Biak Numfor', NULL, NULL, 'Kabupaten'),
	(68, 22, 'Bima', 'Bima', NULL, NULL, 'Kabupaten'),
	(69, 22, 'Bima', 'Bima', NULL, NULL, 'Kota'),
	(70, 34, 'Binjai', 'Binjai', NULL, NULL, 'Kota'),
	(71, 17, 'Bintan', 'Bintan', NULL, NULL, 'Kabupaten'),
	(72, 21, 'Bireuen', 'Bireuen', NULL, NULL, 'Kabupaten'),
	(73, 31, 'Bitung', 'Bitung', NULL, NULL, 'Kota'),
	(74, 11, 'Blitar', 'Blitar', NULL, NULL, 'Kabupaten'),
	(75, 11, 'Blitar', 'Blitar', NULL, NULL, 'Kota'),
	(76, 10, 'Blora', 'Blora', NULL, NULL, 'Kabupaten'),
	(77, 7, 'Boalemo', 'Boalemo', NULL, NULL, 'Kabupaten'),
	(78, 9, 'Bogor', 'Bogor', NULL, NULL, 'Kabupaten'),
	(79, 9, 'Bogor', 'Bogor', NULL, NULL, 'Kota'),
	(80, 11, 'Bojonegoro', 'Bojonegoro', NULL, NULL, 'Kabupaten'),
	(81, 31, 'Bolaang Mongondow (Bolmong)', 'Bolaang Mongondow (Bolmong)', NULL, NULL, 'Kabupaten'),
	(82, 31, 'Bolaang Mongondow Selatan', 'Bolaang Mongondow Selatan', NULL, NULL, 'Kabupaten'),
	(83, 31, 'Bolaang Mongondow Timur', 'Bolaang Mongondow Timur', NULL, NULL, 'Kabupaten'),
	(84, 31, 'Bolaang Mongondow Utara', 'Bolaang Mongondow Utara', NULL, NULL, 'Kabupaten'),
	(85, 30, 'Bombana', 'Bombana', NULL, NULL, 'Kabupaten'),
	(86, 11, 'Bondowoso', 'Bondowoso', NULL, NULL, 'Kabupaten'),
	(87, 28, 'Bone', 'Bone', NULL, NULL, 'Kabupaten'),
	(88, 7, 'Bone Bolango', 'Bone Bolango', NULL, NULL, 'Kabupaten'),
	(89, 15, 'Bontang', 'Bontang', NULL, NULL, 'Kota'),
	(90, 24, 'Boven Digoel', 'Boven Digoel', NULL, NULL, 'Kabupaten'),
	(91, 10, 'Boyolali', 'Boyolali', NULL, NULL, 'Kabupaten'),
	(92, 10, 'Brebes', 'Brebes', NULL, NULL, 'Kabupaten'),
	(93, 32, 'Bukittinggi', 'Bukittinggi', NULL, NULL, 'Kota'),
	(94, 1, 'Buleleng', 'Buleleng', NULL, NULL, 'Kabupaten'),
	(95, 28, 'Bulukumba', 'Bulukumba', NULL, NULL, 'Kabupaten'),
	(96, 16, 'Bulungan (Bulongan)', 'Bulungan (Bulongan)', NULL, NULL, 'Kabupaten'),
	(97, 8, 'Bungo', 'Bungo', NULL, NULL, 'Kabupaten'),
	(98, 29, 'Buol', 'Buol', NULL, NULL, 'Kabupaten'),
	(99, 19, 'Buru', 'Buru', NULL, NULL, 'Kabupaten'),
	(100, 19, 'Buru Selatan', 'Buru Selatan', NULL, NULL, 'Kabupaten'),
	(101, 30, 'Buton', 'Buton', NULL, NULL, 'Kabupaten'),
	(102, 30, 'Buton Utara', 'Buton Utara', NULL, NULL, 'Kabupaten'),
	(103, 9, 'Ciamis', 'Ciamis', NULL, NULL, 'Kabupaten'),
	(104, 9, 'Cianjur', 'Cianjur', NULL, NULL, 'Kabupaten'),
	(105, 10, 'Cilacap', 'Cilacap', NULL, NULL, 'Kabupaten'),
	(106, 3, 'Cilegon', 'Cilegon', NULL, NULL, 'Kota'),
	(107, 9, 'Cimahi', 'Cimahi', NULL, NULL, 'Kota'),
	(108, 9, 'Cirebon', 'Cirebon', NULL, NULL, 'Kabupaten'),
	(109, 9, 'Cirebon', 'Cirebon', NULL, NULL, 'Kota'),
	(110, 34, 'Dairi', 'Dairi', NULL, NULL, 'Kabupaten'),
	(111, 24, 'Deiyai (Deliyai)', 'Deiyai (Deliyai)', NULL, NULL, 'Kabupaten'),
	(112, 34, 'Deli Serdang', 'Deli Serdang', NULL, NULL, 'Kabupaten'),
	(113, 10, 'Demak', 'Demak', NULL, NULL, 'Kabupaten'),
	(114, 1, 'Denpasar', 'Denpasar', NULL, NULL, 'Kota'),
	(115, 9, 'Depok', 'Depok', NULL, NULL, 'Kota'),
	(116, 32, 'Dharmasraya', 'Dharmasraya', NULL, NULL, 'Kabupaten'),
	(117, 24, 'Dogiyai', 'Dogiyai', NULL, NULL, 'Kabupaten'),
	(118, 22, 'Dompu', 'Dompu', NULL, NULL, 'Kabupaten'),
	(119, 29, 'Donggala', 'Donggala', NULL, NULL, 'Kabupaten'),
	(120, 26, 'Dumai', 'Dumai', NULL, NULL, 'Kota'),
	(121, 33, 'Empat Lawang', 'Empat Lawang', NULL, NULL, 'Kabupaten'),
	(122, 23, 'Ende', 'Ende', NULL, NULL, 'Kabupaten'),
	(123, 28, 'Enrekang', 'Enrekang', NULL, NULL, 'Kabupaten'),
	(124, 25, 'Fakfak', 'Fakfak', NULL, NULL, 'Kabupaten'),
	(125, 23, 'Flores Timur', 'Flores Timur', NULL, NULL, 'Kabupaten'),
	(126, 9, 'Garut', 'Garut', NULL, NULL, 'Kabupaten'),
	(127, 21, 'Gayo Lues', 'Gayo Lues', NULL, NULL, 'Kabupaten'),
	(128, 1, 'Gianyar', 'Gianyar', NULL, NULL, 'Kabupaten'),
	(129, 7, 'Gorontalo', 'Gorontalo', NULL, NULL, 'Kabupaten'),
	(130, 7, 'Gorontalo', 'Gorontalo', NULL, NULL, 'Kota'),
	(131, 7, 'Gorontalo Utara', 'Gorontalo Utara', NULL, NULL, 'Kabupaten'),
	(132, 28, 'Gowa', 'Gowa', NULL, NULL, 'Kabupaten'),
	(133, 11, 'Gresik', 'Gresik', NULL, NULL, 'Kabupaten'),
	(134, 10, 'Grobogan', 'Grobogan', NULL, NULL, 'Kabupaten'),
	(135, 5, 'Gunung Kidul', 'Gunung Kidul', NULL, NULL, 'Kabupaten'),
	(136, 14, 'Gunung Mas', 'Gunung Mas', NULL, NULL, 'Kabupaten'),
	(137, 34, 'Gunungsitoli', 'Gunungsitoli', NULL, NULL, 'Kota'),
	(138, 20, 'Halmahera Barat', 'Halmahera Barat', NULL, NULL, 'Kabupaten'),
	(139, 20, 'Halmahera Selatan', 'Halmahera Selatan', NULL, NULL, 'Kabupaten'),
	(140, 20, 'Halmahera Tengah', 'Halmahera Tengah', NULL, NULL, 'Kabupaten'),
	(141, 20, 'Halmahera Timur', 'Halmahera Timur', NULL, NULL, 'Kabupaten'),
	(142, 20, 'Halmahera Utara', 'Halmahera Utara', NULL, NULL, 'Kabupaten'),
	(143, 13, 'Hulu Sungai Selatan', 'Hulu Sungai Selatan', NULL, NULL, 'Kabupaten'),
	(144, 13, 'Hulu Sungai Tengah', 'Hulu Sungai Tengah', NULL, NULL, 'Kabupaten'),
	(145, 13, 'Hulu Sungai Utara', 'Hulu Sungai Utara', NULL, NULL, 'Kabupaten'),
	(146, 34, 'Humbang Hasundutan', 'Humbang Hasundutan', NULL, NULL, 'Kabupaten'),
	(147, 26, 'Indragiri Hilir', 'Indragiri Hilir', NULL, NULL, 'Kabupaten'),
	(148, 26, 'Indragiri Hulu', 'Indragiri Hulu', NULL, NULL, 'Kabupaten'),
	(149, 9, 'Indramayu', 'Indramayu', NULL, NULL, 'Kabupaten'),
	(150, 24, 'Intan Jaya', 'Intan Jaya', NULL, NULL, 'Kabupaten'),
	(151, 6, 'Jakarta Barat', 'Jakarta Barat', NULL, NULL, 'Kota'),
	(152, 6, 'Jakarta Pusat', 'Jakarta Pusat', NULL, NULL, 'Kota'),
	(153, 6, 'Jakarta Selatan', 'Jakarta Selatan', NULL, NULL, 'Kota'),
	(154, 6, 'Jakarta Timur', 'Jakarta Timur', NULL, NULL, 'Kota'),
	(155, 6, 'Jakarta Utara', 'Jakarta Utara', NULL, NULL, 'Kota'),
	(156, 8, 'Jambi', 'Jambi', NULL, NULL, 'Kota'),
	(157, 24, 'Jayapura', 'Jayapura', NULL, NULL, 'Kabupaten'),
	(158, 24, 'Jayapura', 'Jayapura', NULL, NULL, 'Kota'),
	(159, 24, 'Jayawijaya', 'Jayawijaya', NULL, NULL, 'Kabupaten'),
	(160, 11, 'Jember', 'Jember', NULL, NULL, 'Kabupaten'),
	(161, 1, 'Jembrana', 'Jembrana', NULL, NULL, 'Kabupaten'),
	(162, 28, 'Jeneponto', 'Jeneponto', NULL, NULL, 'Kabupaten'),
	(163, 10, 'Jepara', 'Jepara', NULL, NULL, 'Kabupaten'),
	(164, 11, 'Jombang', 'Jombang', NULL, NULL, 'Kabupaten'),
	(165, 25, 'Kaimana', 'Kaimana', NULL, NULL, 'Kabupaten'),
	(166, 26, 'Kampar', 'Kampar', NULL, NULL, 'Kabupaten'),
	(167, 14, 'Kapuas', 'Kapuas', NULL, NULL, 'Kabupaten'),
	(168, 12, 'Kapuas Hulu', 'Kapuas Hulu', NULL, NULL, 'Kabupaten'),
	(169, 10, 'Karanganyar', 'Karanganyar', NULL, NULL, 'Kabupaten'),
	(170, 1, 'Karangasem', 'Karangasem', NULL, NULL, 'Kabupaten'),
	(171, 9, 'Karawang', 'Karawang', NULL, NULL, 'Kabupaten'),
	(172, 17, 'Karimun', 'Karimun', NULL, NULL, 'Kabupaten'),
	(173, 34, 'Karo', 'Karo', NULL, NULL, 'Kabupaten'),
	(174, 14, 'Katingan', 'Katingan', NULL, NULL, 'Kabupaten'),
	(175, 4, 'Kaur', 'Kaur', NULL, NULL, 'Kabupaten'),
	(176, 12, 'Kayong Utara', 'Kayong Utara', NULL, NULL, 'Kabupaten'),
	(177, 10, 'Kebumen', 'Kebumen', NULL, NULL, 'Kabupaten'),
	(178, 11, 'Kediri', 'Kediri', NULL, NULL, 'Kabupaten'),
	(179, 11, 'Kediri', 'Kediri', NULL, NULL, 'Kota'),
	(180, 24, 'Keerom', 'Keerom', NULL, NULL, 'Kabupaten'),
	(181, 10, 'Kendal', 'Kendal', NULL, NULL, 'Kabupaten'),
	(182, 30, 'Kendari', 'Kendari', NULL, NULL, 'Kota'),
	(183, 4, 'Kepahiang', 'Kepahiang', NULL, NULL, 'Kabupaten'),
	(184, 17, 'Kepulauan Anambas', 'Kepulauan Anambas', NULL, NULL, 'Kabupaten'),
	(185, 19, 'Kepulauan Aru', 'Kepulauan Aru', NULL, NULL, 'Kabupaten'),
	(186, 32, 'Kepulauan Mentawai', 'Kepulauan Mentawai', NULL, NULL, 'Kabupaten'),
	(187, 26, 'Kepulauan Meranti', 'Kepulauan Meranti', NULL, NULL, 'Kabupaten'),
	(188, 31, 'Kepulauan Sangihe', 'Kepulauan Sangihe', NULL, NULL, 'Kabupaten'),
	(189, 6, 'Kepulauan Seribu', 'Kepulauan Seribu', NULL, NULL, 'Kabupaten'),
	(190, 31, 'Kepulauan Siau Tagulandang Biaro (Sitaro)', 'Kepulauan Siau Tagulandang Biaro (Sitaro)', NULL, NULL, 'Kabupaten'),
	(191, 20, 'Kepulauan Sula', 'Kepulauan Sula', NULL, NULL, 'Kabupaten'),
	(192, 31, 'Kepulauan Talaud', 'Kepulauan Talaud', NULL, NULL, 'Kabupaten'),
	(193, 24, 'Kepulauan Yapen (Yapen Waropen)', 'Kepulauan Yapen (Yapen Waropen)', NULL, NULL, 'Kabupaten'),
	(194, 8, 'Kerinci', 'Kerinci', NULL, NULL, 'Kabupaten'),
	(195, 12, 'Ketapang', 'Ketapang', NULL, NULL, 'Kabupaten'),
	(196, 10, 'Klaten', 'Klaten', NULL, NULL, 'Kabupaten'),
	(197, 1, 'Klungkung', 'Klungkung', NULL, NULL, 'Kabupaten'),
	(198, 30, 'Kolaka', 'Kolaka', NULL, NULL, 'Kabupaten'),
	(199, 30, 'Kolaka Utara', 'Kolaka Utara', NULL, NULL, 'Kabupaten'),
	(200, 30, 'Konawe', 'Konawe', NULL, NULL, 'Kabupaten'),
	(201, 30, 'Konawe Selatan', 'Konawe Selatan', NULL, NULL, 'Kabupaten'),
	(202, 30, 'Konawe Utara', 'Konawe Utara', NULL, NULL, 'Kabupaten'),
	(203, 13, 'Kotabaru', 'Kotabaru', NULL, NULL, 'Kabupaten'),
	(204, 31, 'Kotamobagu', 'Kotamobagu', NULL, NULL, 'Kota'),
	(205, 14, 'Kotawaringin Barat', 'Kotawaringin Barat', NULL, NULL, 'Kabupaten'),
	(206, 14, 'Kotawaringin Timur', 'Kotawaringin Timur', NULL, NULL, 'Kabupaten'),
	(207, 26, 'Kuantan Singingi', 'Kuantan Singingi', NULL, NULL, 'Kabupaten'),
	(208, 12, 'Kubu Raya', 'Kubu Raya', NULL, NULL, 'Kabupaten'),
	(209, 10, 'Kudus', 'Kudus', NULL, NULL, 'Kabupaten'),
	(210, 5, 'Kulon Progo', 'Kulon Progo', NULL, NULL, 'Kabupaten'),
	(211, 9, 'Kuningan', 'Kuningan', NULL, NULL, 'Kabupaten'),
	(212, 23, 'Kupang', 'Kupang', NULL, NULL, 'Kabupaten'),
	(213, 23, 'Kupang', 'Kupang', NULL, NULL, 'Kota'),
	(214, 15, 'Kutai Barat', 'Kutai Barat', NULL, NULL, 'Kabupaten'),
	(215, 15, 'Kutai Kartanegara', 'Kutai Kartanegara', NULL, NULL, 'Kabupaten'),
	(216, 15, 'Kutai Timur', 'Kutai Timur', NULL, NULL, 'Kabupaten'),
	(217, 34, 'Labuhan Batu', 'Labuhan Batu', NULL, NULL, 'Kabupaten'),
	(218, 34, 'Labuhan Batu Selatan', 'Labuhan Batu Selatan', NULL, NULL, 'Kabupaten'),
	(219, 34, 'Labuhan Batu Utara', 'Labuhan Batu Utara', NULL, NULL, 'Kabupaten'),
	(220, 33, 'Lahat', 'Lahat', NULL, NULL, 'Kabupaten'),
	(221, 14, 'Lamandau', 'Lamandau', NULL, NULL, 'Kabupaten'),
	(222, 11, 'Lamongan', 'Lamongan', NULL, NULL, 'Kabupaten'),
	(223, 18, 'Lampung Barat', 'Lampung Barat', NULL, NULL, 'Kabupaten'),
	(224, 18, 'Lampung Selatan', 'Lampung Selatan', NULL, NULL, 'Kabupaten'),
	(225, 18, 'Lampung Tengah', 'Lampung Tengah', NULL, NULL, 'Kabupaten'),
	(226, 18, 'Lampung Timur', 'Lampung Timur', NULL, NULL, 'Kabupaten'),
	(227, 18, 'Lampung Utara', 'Lampung Utara', NULL, NULL, 'Kabupaten'),
	(228, 12, 'Landak', 'Landak', NULL, NULL, 'Kabupaten'),
	(229, 34, 'Langkat', 'Langkat', NULL, NULL, 'Kabupaten'),
	(230, 21, 'Langsa', 'Langsa', NULL, NULL, 'Kota'),
	(231, 24, 'Lanny Jaya', 'Lanny Jaya', NULL, NULL, 'Kabupaten'),
	(232, 3, 'Lebak', 'Lebak', NULL, NULL, 'Kabupaten'),
	(233, 4, 'Lebong', 'Lebong', NULL, NULL, 'Kabupaten'),
	(234, 23, 'Lembata', 'Lembata', NULL, NULL, 'Kabupaten'),
	(235, 21, 'Lhokseumawe', 'Lhokseumawe', NULL, NULL, 'Kota'),
	(236, 32, 'Lima Puluh Koto/Kota', 'Lima Puluh Koto/Kota', NULL, NULL, 'Kabupaten'),
	(237, 17, 'Lingga', 'Lingga', NULL, NULL, 'Kabupaten'),
	(238, 22, 'Lombok Barat', 'Lombok Barat', NULL, NULL, 'Kabupaten'),
	(239, 22, 'Lombok Tengah', 'Lombok Tengah', NULL, NULL, 'Kabupaten'),
	(240, 22, 'Lombok Timur', 'Lombok Timur', NULL, NULL, 'Kabupaten'),
	(241, 22, 'Lombok Utara', 'Lombok Utara', NULL, NULL, 'Kabupaten'),
	(242, 33, 'Lubuk Linggau', 'Lubuk Linggau', NULL, NULL, 'Kota'),
	(243, 11, 'Lumajang', 'Lumajang', NULL, NULL, 'Kabupaten'),
	(244, 28, 'Luwu', 'Luwu', NULL, NULL, 'Kabupaten'),
	(245, 28, 'Luwu Timur', 'Luwu Timur', NULL, NULL, 'Kabupaten'),
	(246, 28, 'Luwu Utara', 'Luwu Utara', NULL, NULL, 'Kabupaten'),
	(247, 11, 'Madiun', 'Madiun', NULL, NULL, 'Kabupaten'),
	(248, 11, 'Madiun', 'Madiun', NULL, NULL, 'Kota'),
	(249, 10, 'Magelang', 'Magelang', NULL, NULL, 'Kabupaten'),
	(250, 10, 'Magelang', 'Magelang', NULL, NULL, 'Kota'),
	(251, 11, 'Magetan', 'Magetan', NULL, NULL, 'Kabupaten'),
	(252, 9, 'Majalengka', 'Majalengka', NULL, NULL, 'Kabupaten'),
	(253, 27, 'Majene', 'Majene', NULL, NULL, 'Kabupaten'),
	(254, 28, 'Makassar', 'Makassar', NULL, NULL, 'Kota'),
	(255, 11, 'Malang', 'Malang', NULL, NULL, 'Kabupaten'),
	(256, 11, 'Malang', 'Malang', NULL, NULL, 'Kota'),
	(257, 16, 'Malinau', 'Malinau', NULL, NULL, 'Kabupaten'),
	(258, 19, 'Maluku Barat Daya', 'Maluku Barat Daya', NULL, NULL, 'Kabupaten'),
	(259, 19, 'Maluku Tengah', 'Maluku Tengah', NULL, NULL, 'Kabupaten'),
	(260, 19, 'Maluku Tenggara', 'Maluku Tenggara', NULL, NULL, 'Kabupaten'),
	(261, 19, 'Maluku Tenggara Barat', 'Maluku Tenggara Barat', NULL, NULL, 'Kabupaten'),
	(262, 27, 'Mamasa', 'Mamasa', NULL, NULL, 'Kabupaten'),
	(263, 24, 'Mamberamo Raya', 'Mamberamo Raya', NULL, NULL, 'Kabupaten'),
	(264, 24, 'Mamberamo Tengah', 'Mamberamo Tengah', NULL, NULL, 'Kabupaten'),
	(265, 27, 'Mamuju', 'Mamuju', NULL, NULL, 'Kabupaten'),
	(266, 27, 'Mamuju Utara', 'Mamuju Utara', NULL, NULL, 'Kabupaten'),
	(267, 31, 'Manado', 'Manado', NULL, NULL, 'Kota'),
	(268, 34, 'Mandailing Natal', 'Mandailing Natal', NULL, NULL, 'Kabupaten'),
	(269, 23, 'Manggarai', 'Manggarai', NULL, NULL, 'Kabupaten'),
	(270, 23, 'Manggarai Barat', 'Manggarai Barat', NULL, NULL, 'Kabupaten'),
	(271, 23, 'Manggarai Timur', 'Manggarai Timur', NULL, NULL, 'Kabupaten'),
	(272, 25, 'Manokwari', 'Manokwari', NULL, NULL, 'Kabupaten'),
	(273, 25, 'Manokwari Selatan', 'Manokwari Selatan', NULL, NULL, 'Kabupaten'),
	(274, 24, 'Mappi', 'Mappi', NULL, NULL, 'Kabupaten'),
	(275, 28, 'Maros', 'Maros', NULL, NULL, 'Kabupaten'),
	(276, 22, 'Mataram', 'Mataram', NULL, NULL, 'Kota'),
	(277, 25, 'Maybrat', 'Maybrat', NULL, NULL, 'Kabupaten'),
	(278, 34, 'Medan', 'Medan', NULL, NULL, 'Kota'),
	(279, 12, 'Melawi', 'Melawi', NULL, NULL, 'Kabupaten'),
	(280, 8, 'Merangin', 'Merangin', NULL, NULL, 'Kabupaten'),
	(281, 24, 'Merauke', 'Merauke', NULL, NULL, 'Kabupaten'),
	(282, 18, 'Mesuji', 'Mesuji', NULL, NULL, 'Kabupaten'),
	(283, 18, 'Metro', 'Metro', NULL, NULL, 'Kota'),
	(284, 24, 'Mimika', 'Mimika', NULL, NULL, 'Kabupaten'),
	(285, 31, 'Minahasa', 'Minahasa', NULL, NULL, 'Kabupaten'),
	(286, 31, 'Minahasa Selatan', 'Minahasa Selatan', NULL, NULL, 'Kabupaten'),
	(287, 31, 'Minahasa Tenggara', 'Minahasa Tenggara', NULL, NULL, 'Kabupaten'),
	(288, 31, 'Minahasa Utara', 'Minahasa Utara', NULL, NULL, 'Kabupaten'),
	(289, 11, 'Mojokerto', 'Mojokerto', NULL, NULL, 'Kabupaten'),
	(290, 11, 'Mojokerto', 'Mojokerto', NULL, NULL, 'Kota'),
	(291, 29, 'Morowali', 'Morowali', NULL, NULL, 'Kabupaten'),
	(292, 33, 'Muara Enim', 'Muara Enim', NULL, NULL, 'Kabupaten'),
	(293, 8, 'Muaro Jambi', 'Muaro Jambi', NULL, NULL, 'Kabupaten'),
	(294, 4, 'Muko Muko', 'Muko Muko', NULL, NULL, 'Kabupaten'),
	(295, 30, 'Muna', 'Muna', NULL, NULL, 'Kabupaten'),
	(296, 14, 'Murung Raya', 'Murung Raya', NULL, NULL, 'Kabupaten'),
	(297, 33, 'Musi Banyuasin', 'Musi Banyuasin', NULL, NULL, 'Kabupaten'),
	(298, 33, 'Musi Rawas', 'Musi Rawas', NULL, NULL, 'Kabupaten'),
	(299, 24, 'Nabire', 'Nabire', NULL, NULL, 'Kabupaten'),
	(300, 21, 'Nagan Raya', 'Nagan Raya', NULL, NULL, 'Kabupaten'),
	(301, 23, 'Nagekeo', 'Nagekeo', NULL, NULL, 'Kabupaten'),
	(302, 17, 'Natuna', 'Natuna', NULL, NULL, 'Kabupaten'),
	(303, 24, 'Nduga', 'Nduga', NULL, NULL, 'Kabupaten'),
	(304, 23, 'Ngada', 'Ngada', NULL, NULL, 'Kabupaten'),
	(305, 11, 'Nganjuk', 'Nganjuk', NULL, NULL, 'Kabupaten'),
	(306, 11, 'Ngawi', 'Ngawi', NULL, NULL, 'Kabupaten'),
	(307, 34, 'Nias', 'Nias', NULL, NULL, 'Kabupaten'),
	(308, 34, 'Nias Barat', 'Nias Barat', NULL, NULL, 'Kabupaten'),
	(309, 34, 'Nias Selatan', 'Nias Selatan', NULL, NULL, 'Kabupaten'),
	(310, 34, 'Nias Utara', 'Nias Utara', NULL, NULL, 'Kabupaten'),
	(311, 16, 'Nunukan', 'Nunukan', NULL, NULL, 'Kabupaten'),
	(312, 33, 'Ogan Ilir', 'Ogan Ilir', NULL, NULL, 'Kabupaten'),
	(313, 33, 'Ogan Komering Ilir', 'Ogan Komering Ilir', NULL, NULL, 'Kabupaten'),
	(314, 33, 'Ogan Komering Ulu', 'Ogan Komering Ulu', NULL, NULL, 'Kabupaten'),
	(315, 33, 'Ogan Komering Ulu Selatan', 'Ogan Komering Ulu Selatan', NULL, NULL, 'Kabupaten'),
	(316, 33, 'Ogan Komering Ulu Timur', 'Ogan Komering Ulu Timur', NULL, NULL, 'Kabupaten'),
	(317, 11, 'Pacitan', 'Pacitan', NULL, NULL, 'Kabupaten'),
	(318, 32, 'Padang', 'Padang', NULL, NULL, 'Kota'),
	(319, 34, 'Padang Lawas', 'Padang Lawas', NULL, NULL, 'Kabupaten'),
	(320, 34, 'Padang Lawas Utara', 'Padang Lawas Utara', NULL, NULL, 'Kabupaten'),
	(321, 32, 'Padang Panjang', 'Padang Panjang', NULL, NULL, 'Kota'),
	(322, 32, 'Padang Pariaman', 'Padang Pariaman', NULL, NULL, 'Kabupaten'),
	(323, 34, 'Padang Sidempuan', 'Padang Sidempuan', NULL, NULL, 'Kota'),
	(324, 33, 'Pagar Alam', 'Pagar Alam', NULL, NULL, 'Kota'),
	(325, 34, 'Pakpak Bharat', 'Pakpak Bharat', NULL, NULL, 'Kabupaten'),
	(326, 14, 'Palangka Raya', 'Palangka Raya', NULL, NULL, 'Kota'),
	(327, 33, 'Palembang', 'Palembang', NULL, NULL, 'Kota'),
	(328, 28, 'Palopo', 'Palopo', NULL, NULL, 'Kota'),
	(329, 29, 'Palu', 'Palu', NULL, NULL, 'Kota'),
	(330, 11, 'Pamekasan', 'Pamekasan', NULL, NULL, 'Kabupaten'),
	(331, 3, 'Pandeglang', 'Pandeglang', NULL, NULL, 'Kabupaten'),
	(332, 9, 'Pangandaran', 'Pangandaran', NULL, NULL, 'Kabupaten'),
	(333, 28, 'Pangkajene Kepulauan', 'Pangkajene Kepulauan', NULL, NULL, 'Kabupaten'),
	(334, 2, 'Pangkal Pinang', 'Pangkal Pinang', NULL, NULL, 'Kota'),
	(335, 24, 'Paniai', 'Paniai', NULL, NULL, 'Kabupaten'),
	(336, 28, 'Parepare', 'Parepare', NULL, NULL, 'Kota'),
	(337, 32, 'Pariaman', 'Pariaman', NULL, NULL, 'Kota'),
	(338, 29, 'Parigi Moutong', 'Parigi Moutong', NULL, NULL, 'Kabupaten'),
	(339, 32, 'Pasaman', 'Pasaman', NULL, NULL, 'Kabupaten'),
	(340, 32, 'Pasaman Barat', 'Pasaman Barat', NULL, NULL, 'Kabupaten'),
	(341, 15, 'Paser', 'Paser', NULL, NULL, 'Kabupaten'),
	(342, 11, 'Pasuruan', 'Pasuruan', NULL, NULL, 'Kabupaten'),
	(343, 11, 'Pasuruan', 'Pasuruan', NULL, NULL, 'Kota'),
	(344, 10, 'Pati', 'Pati', NULL, NULL, 'Kabupaten'),
	(345, 32, 'Payakumbuh', 'Payakumbuh', NULL, NULL, 'Kota'),
	(346, 25, 'Pegunungan Arfak', 'Pegunungan Arfak', NULL, NULL, 'Kabupaten'),
	(347, 24, 'Pegunungan Bintang', 'Pegunungan Bintang', NULL, NULL, 'Kabupaten'),
	(348, 10, 'Pekalongan', 'Pekalongan', NULL, NULL, 'Kabupaten'),
	(349, 10, 'Pekalongan', 'Pekalongan', NULL, NULL, 'Kota'),
	(350, 26, 'Pekanbaru', 'Pekanbaru', NULL, NULL, 'Kota'),
	(351, 26, 'Pelalawan', 'Pelalawan', NULL, NULL, 'Kabupaten'),
	(352, 10, 'Pemalang', 'Pemalang', NULL, NULL, 'Kabupaten'),
	(353, 34, 'Pematang Siantar', 'Pematang Siantar', NULL, NULL, 'Kota'),
	(354, 15, 'Penajam Paser Utara', 'Penajam Paser Utara', NULL, NULL, 'Kabupaten'),
	(355, 18, 'Pesawaran', 'Pesawaran', NULL, NULL, 'Kabupaten'),
	(356, 18, 'Pesisir Barat', 'Pesisir Barat', NULL, NULL, 'Kabupaten'),
	(357, 32, 'Pesisir Selatan', 'Pesisir Selatan', NULL, NULL, 'Kabupaten'),
	(358, 21, 'Pidie', 'Pidie', NULL, NULL, 'Kabupaten'),
	(359, 21, 'Pidie Jaya', 'Pidie Jaya', NULL, NULL, 'Kabupaten'),
	(360, 28, 'Pinrang', 'Pinrang', NULL, NULL, 'Kabupaten'),
	(361, 7, 'Pohuwato', 'Pohuwato', NULL, NULL, 'Kabupaten'),
	(362, 27, 'Polewali Mandar', 'Polewali Mandar', NULL, NULL, 'Kabupaten'),
	(363, 11, 'Ponorogo', 'Ponorogo', NULL, NULL, 'Kabupaten'),
	(364, 12, 'Pontianak', 'Pontianak', NULL, NULL, 'Kabupaten'),
	(365, 12, 'Pontianak', 'Pontianak', NULL, NULL, 'Kota'),
	(366, 29, 'Poso', 'Poso', NULL, NULL, 'Kabupaten'),
	(367, 33, 'Prabumulih', 'Prabumulih', NULL, NULL, 'Kota'),
	(368, 18, 'Pringsewu', 'Pringsewu', NULL, NULL, 'Kabupaten'),
	(369, 11, 'Probolinggo', 'Probolinggo', NULL, NULL, 'Kabupaten'),
	(370, 11, 'Probolinggo', 'Probolinggo', NULL, NULL, 'Kota'),
	(371, 14, 'Pulang Pisau', 'Pulang Pisau', NULL, NULL, 'Kabupaten'),
	(372, 20, 'Pulau Morotai', 'Pulau Morotai', NULL, NULL, 'Kabupaten'),
	(373, 24, 'Puncak', 'Puncak', NULL, NULL, 'Kabupaten'),
	(374, 24, 'Puncak Jaya', 'Puncak Jaya', NULL, NULL, 'Kabupaten'),
	(375, 10, 'Purbalingga', 'Purbalingga', NULL, NULL, 'Kabupaten'),
	(376, 9, 'Purwakarta', 'Purwakarta', NULL, NULL, 'Kabupaten'),
	(377, 10, 'Purworejo', 'Purworejo', NULL, NULL, 'Kabupaten'),
	(378, 25, 'Raja Ampat', 'Raja Ampat', NULL, NULL, 'Kabupaten'),
	(379, 4, 'Rejang Lebong', 'Rejang Lebong', NULL, NULL, 'Kabupaten'),
	(380, 10, 'Rembang', 'Rembang', NULL, NULL, 'Kabupaten'),
	(381, 26, 'Rokan Hilir', 'Rokan Hilir', NULL, NULL, 'Kabupaten'),
	(382, 26, 'Rokan Hulu', 'Rokan Hulu', NULL, NULL, 'Kabupaten'),
	(383, 23, 'Rote Ndao', 'Rote Ndao', NULL, NULL, 'Kabupaten'),
	(384, 21, 'Sabang', 'Sabang', NULL, NULL, 'Kota'),
	(385, 23, 'Sabu Raijua', 'Sabu Raijua', NULL, NULL, 'Kabupaten'),
	(386, 10, 'Salatiga', 'Salatiga', NULL, NULL, 'Kota'),
	(387, 15, 'Samarinda', 'Samarinda', NULL, NULL, 'Kota'),
	(388, 12, 'Sambas', 'Sambas', NULL, NULL, 'Kabupaten'),
	(389, 34, 'Samosir', 'Samosir', NULL, NULL, 'Kabupaten'),
	(390, 11, 'Sampang', 'Sampang', NULL, NULL, 'Kabupaten'),
	(391, 12, 'Sanggau', 'Sanggau', NULL, NULL, 'Kabupaten'),
	(392, 24, 'Sarmi', 'Sarmi', NULL, NULL, 'Kabupaten'),
	(393, 8, 'Sarolangun', 'Sarolangun', NULL, NULL, 'Kabupaten'),
	(394, 32, 'Sawah Lunto', 'Sawah Lunto', NULL, NULL, 'Kota'),
	(395, 12, 'Sekadau', 'Sekadau', NULL, NULL, 'Kabupaten'),
	(396, 28, 'Selayar (Kepulauan Selayar)', 'Selayar (Kepulauan Selayar)', NULL, NULL, 'Kabupaten'),
	(397, 4, 'Seluma', 'Seluma', NULL, NULL, 'Kabupaten'),
	(398, 10, 'Semarang', 'Semarang', NULL, NULL, 'Kabupaten'),
	(399, 10, 'Semarang', 'Semarang', NULL, NULL, 'Kota'),
	(400, 19, 'Seram Bagian Barat', 'Seram Bagian Barat', NULL, NULL, 'Kabupaten'),
	(401, 19, 'Seram Bagian Timur', 'Seram Bagian Timur', NULL, NULL, 'Kabupaten'),
	(402, 3, 'Serang', 'Serang', NULL, NULL, 'Kabupaten'),
	(403, 3, 'Serang', 'Serang', NULL, NULL, 'Kota'),
	(404, 34, 'Serdang Bedagai', 'Serdang Bedagai', NULL, NULL, 'Kabupaten'),
	(405, 14, 'Seruyan', 'Seruyan', NULL, NULL, 'Kabupaten'),
	(406, 26, 'Siak', 'Siak', NULL, NULL, 'Kabupaten'),
	(407, 34, 'Sibolga', 'Sibolga', NULL, NULL, 'Kota'),
	(408, 28, 'Sidenreng Rappang/Rapang', 'Sidenreng Rappang/Rapang', NULL, NULL, 'Kabupaten'),
	(409, 11, 'Sidoarjo', 'Sidoarjo', NULL, NULL, 'Kabupaten'),
	(410, 29, 'Sigi', 'Sigi', NULL, NULL, 'Kabupaten'),
	(411, 32, 'Sijunjung (Sawah Lunto Sijunjung)', 'Sijunjung (Sawah Lunto Sijunjung)', NULL, NULL, 'Kabupaten'),
	(412, 23, 'Sikka', 'Sikka', NULL, NULL, 'Kabupaten'),
	(413, 34, 'Simalungun', 'Simalungun', NULL, NULL, 'Kabupaten'),
	(414, 21, 'Simeulue', 'Simeulue', NULL, NULL, 'Kabupaten'),
	(415, 12, 'Singkawang', 'Singkawang', NULL, NULL, 'Kota'),
	(416, 28, 'Sinjai', 'Sinjai', NULL, NULL, 'Kabupaten'),
	(417, 12, 'Sintang', 'Sintang', NULL, NULL, 'Kabupaten'),
	(418, 11, 'Situbondo', 'Situbondo', NULL, NULL, 'Kabupaten'),
	(419, 5, 'Sleman', 'Sleman', NULL, NULL, 'Kabupaten'),
	(420, 32, 'Solok', 'Solok', NULL, NULL, 'Kabupaten'),
	(421, 32, 'Solok', 'Solok', NULL, NULL, 'Kota'),
	(422, 32, 'Solok Selatan', 'Solok Selatan', NULL, NULL, 'Kabupaten'),
	(423, 28, 'Soppeng', 'Soppeng', NULL, NULL, 'Kabupaten'),
	(424, 25, 'Sorong', 'Sorong', NULL, NULL, 'Kabupaten'),
	(425, 25, 'Sorong', 'Sorong', NULL, NULL, 'Kota'),
	(426, 25, 'Sorong Selatan', 'Sorong Selatan', NULL, NULL, 'Kabupaten'),
	(427, 10, 'Sragen', 'Sragen', NULL, NULL, 'Kabupaten'),
	(428, 9, 'Subang', 'Subang', NULL, NULL, 'Kabupaten'),
	(429, 21, 'Subulussalam', 'Subulussalam', NULL, NULL, 'Kota'),
	(430, 9, 'Sukabumi', 'Sukabumi', NULL, NULL, 'Kabupaten'),
	(431, 9, 'Sukabumi', 'Sukabumi', NULL, NULL, 'Kota'),
	(432, 14, 'Sukamara', 'Sukamara', NULL, NULL, 'Kabupaten'),
	(433, 10, 'Sukoharjo', 'Sukoharjo', NULL, NULL, 'Kabupaten'),
	(434, 23, 'Sumba Barat', 'Sumba Barat', NULL, NULL, 'Kabupaten'),
	(435, 23, 'Sumba Barat Daya', 'Sumba Barat Daya', NULL, NULL, 'Kabupaten'),
	(436, 23, 'Sumba Tengah', 'Sumba Tengah', NULL, NULL, 'Kabupaten'),
	(437, 23, 'Sumba Timur', 'Sumba Timur', NULL, NULL, 'Kabupaten'),
	(438, 22, 'Sumbawa', 'Sumbawa', NULL, NULL, 'Kabupaten'),
	(439, 22, 'Sumbawa Barat', 'Sumbawa Barat', NULL, NULL, 'Kabupaten'),
	(440, 9, 'Sumedang', 'Sumedang', NULL, NULL, 'Kabupaten'),
	(441, 11, 'Sumenep', 'Sumenep', NULL, NULL, 'Kabupaten'),
	(442, 8, 'Sungaipenuh', 'Sungaipenuh', NULL, NULL, 'Kota'),
	(443, 24, 'Supiori', 'Supiori', NULL, NULL, 'Kabupaten'),
	(444, 11, 'Surabaya', 'Surabaya', NULL, NULL, 'Kota'),
	(445, 10, 'Surakarta (Solo)', 'Surakarta (Solo)', NULL, NULL, 'Kota'),
	(446, 13, 'Tabalong', 'Tabalong', NULL, NULL, 'Kabupaten'),
	(447, 1, 'Tabanan', 'Tabanan', NULL, NULL, 'Kabupaten'),
	(448, 28, 'Takalar', 'Takalar', NULL, NULL, 'Kabupaten'),
	(449, 25, 'Tambrauw', 'Tambrauw', NULL, NULL, 'Kabupaten'),
	(450, 16, 'Tana Tidung', 'Tana Tidung', NULL, NULL, 'Kabupaten'),
	(451, 28, 'Tana Toraja', 'Tana Toraja', NULL, NULL, 'Kabupaten'),
	(452, 13, 'Tanah Bumbu', 'Tanah Bumbu', NULL, NULL, 'Kabupaten'),
	(453, 32, 'Tanah Datar', 'Tanah Datar', NULL, NULL, 'Kabupaten'),
	(454, 13, 'Tanah Laut', 'Tanah Laut', NULL, NULL, 'Kabupaten'),
	(455, 3, 'Tangerang', 'Tangerang', NULL, NULL, 'Kabupaten'),
	(456, 3, 'Tangerang', 'Tangerang', NULL, NULL, 'Kota'),
	(457, 3, 'Tangerang Selatan', 'Tangerang Selatan', NULL, NULL, 'Kota'),
	(458, 18, 'Tanggamus', 'Tanggamus', NULL, NULL, 'Kabupaten'),
	(459, 34, 'Tanjung Balai', 'Tanjung Balai', NULL, NULL, 'Kota'),
	(460, 8, 'Tanjung Jabung Barat', 'Tanjung Jabung Barat', NULL, NULL, 'Kabupaten'),
	(461, 8, 'Tanjung Jabung Timur', 'Tanjung Jabung Timur', NULL, NULL, 'Kabupaten'),
	(462, 17, 'Tanjung Pinang', 'Tanjung Pinang', NULL, NULL, 'Kota'),
	(463, 34, 'Tapanuli Selatan', 'Tapanuli Selatan', NULL, NULL, 'Kabupaten'),
	(464, 34, 'Tapanuli Tengah', 'Tapanuli Tengah', NULL, NULL, 'Kabupaten'),
	(465, 34, 'Tapanuli Utara', 'Tapanuli Utara', NULL, NULL, 'Kabupaten'),
	(466, 13, 'Tapin', 'Tapin', NULL, NULL, 'Kabupaten'),
	(467, 16, 'Tarakan', 'Tarakan', NULL, NULL, 'Kota'),
	(468, 9, 'Tasikmalaya', 'Tasikmalaya', NULL, NULL, 'Kabupaten'),
	(469, 9, 'Tasikmalaya', 'Tasikmalaya', NULL, NULL, 'Kota'),
	(470, 34, 'Tebing Tinggi', 'Tebing Tinggi', NULL, NULL, 'Kota'),
	(471, 8, 'Tebo', 'Tebo', NULL, NULL, 'Kabupaten'),
	(472, 10, 'Tegal', 'Tegal', NULL, NULL, 'Kabupaten'),
	(473, 10, 'Tegal', 'Tegal', NULL, NULL, 'Kota'),
	(474, 25, 'Teluk Bintuni', 'Teluk Bintuni', NULL, NULL, 'Kabupaten'),
	(475, 25, 'Teluk Wondama', 'Teluk Wondama', NULL, NULL, 'Kabupaten'),
	(476, 10, 'Temanggung', 'Temanggung', NULL, NULL, 'Kabupaten'),
	(477, 20, 'Ternate', 'Ternate', NULL, NULL, 'Kota'),
	(478, 20, 'Tidore Kepulauan', 'Tidore Kepulauan', NULL, NULL, 'Kota'),
	(479, 23, 'Timor Tengah Selatan', 'Timor Tengah Selatan', NULL, NULL, 'Kabupaten'),
	(480, 23, 'Timor Tengah Utara', 'Timor Tengah Utara', NULL, NULL, 'Kabupaten'),
	(481, 34, 'Toba Samosir', 'Toba Samosir', NULL, NULL, 'Kabupaten'),
	(482, 29, 'Tojo Una-Una', 'Tojo Una-Una', NULL, NULL, 'Kabupaten'),
	(483, 29, 'Toli-Toli', 'Toli-Toli', NULL, NULL, 'Kabupaten'),
	(484, 24, 'Tolikara', 'Tolikara', NULL, NULL, 'Kabupaten'),
	(485, 31, 'Tomohon', 'Tomohon', NULL, NULL, 'Kota'),
	(486, 28, 'Toraja Utara', 'Toraja Utara', NULL, NULL, 'Kabupaten'),
	(487, 11, 'Trenggalek', 'Trenggalek', NULL, NULL, 'Kabupaten'),
	(488, 19, 'Tual', 'Tual', NULL, NULL, 'Kota'),
	(489, 11, 'Tuban', 'Tuban', NULL, NULL, 'Kabupaten'),
	(490, 18, 'Tulang Bawang', 'Tulang Bawang', NULL, NULL, 'Kabupaten'),
	(491, 18, 'Tulang Bawang Barat', 'Tulang Bawang Barat', NULL, NULL, 'Kabupaten'),
	(492, 11, 'Tulungagung', 'Tulungagung', NULL, NULL, 'Kabupaten'),
	(493, 28, 'Wajo', 'Wajo', NULL, NULL, 'Kabupaten'),
	(494, 30, 'Wakatobi', 'Wakatobi', NULL, NULL, 'Kabupaten'),
	(495, 24, 'Waropen', 'Waropen', NULL, NULL, 'Kabupaten'),
	(496, 18, 'Way Kanan', 'Way Kanan', NULL, NULL, 'Kabupaten'),
	(497, 10, 'Wonogiri', 'Wonogiri', NULL, NULL, 'Kabupaten'),
	(498, 10, 'Wonosobo', 'Wonosobo', NULL, NULL, 'Kabupaten'),
	(499, 24, 'Yahukimo', 'Yahukimo', NULL, NULL, 'Kabupaten'),
	(500, 24, 'Yalimo', 'Yalimo', NULL, NULL, 'Kabupaten'),
	(501, 5, 'Yogyakarta', 'Yogyakarta', NULL, NULL, 'Kota');

-- Dumping structure for table adunmancing.shipping_methods
CREATE TABLE IF NOT EXISTS `shipping_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.shipping_methods: ~0 rows (approximately)

-- Dumping structure for table adunmancing.stock_movements
CREATE TABLE IF NOT EXISTS `stock_movements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_movements_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `stock_movements_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.stock_movements: ~0 rows (approximately)

-- Dumping structure for table adunmancing.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `role_id`, `birth_date`, `email`, `email_verified_at`, `password`, `remember_token`, `phone_number`, `created_at`, `updated_at`) VALUES
	(1, 'Bagas', NULL, '2025-07-11', 'bagas.topati@gmail.com', NULL, '$2y$12$uk1Op6mj2Wi9gzkPfRbnPem0BvhQ9T4R.aey3owTo7XkngfHlsk4u', '9IOJ2Nm7ZJSFKrApAoPJTSNDI9iNp4OpeOWcXeDy0y4msOpv50ByPRKezH2d', '0895611508388', '2025-06-29 21:26:05', '2025-07-10 19:25:34');

-- Dumping structure for table adunmancing.user_addresses
CREATE TABLE IF NOT EXISTS `user_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(150) NOT NULL DEFAULT '',
  `recipient_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `province_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `province_name` varchar(100) NOT NULL,
  `city_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `district_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `postal_code` varchar(10) NOT NULL,
  `destination_type` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `est_date` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.user_addresses: ~1 rows (approximately)
INSERT INTO `user_addresses` (`id`, `user_id`, `name`, `recipient_name`, `phone_number`, `province_id`, `province_name`, `city_id`, `city_name`, `district_id`, `postal_code`, `destination_type`, `address`, `is_default`, `created_at`, `updated_at`, `est_date`) VALUES
	(1, 1, 'Home', 'Bagas', '0895611508388', '34', 'Sumatera Utara', '278', 'Medan', NULL, '20225', '', 'JL. ILENG TAMAN PERMATA HIJAU BLOK B. NO. 13', 0, '2025-07-09 00:04:42', '2025-07-10 18:32:58', NULL),
	(2, 1, 'Kantor', 'Firman', '088123412345', '19', 'Maluku', '14', 'Ambon', NULL, '20255', '', 'JL. AMBON KELURAHAN MALUKU', 0, '2025-07-10 18:29:06', '2025-07-10 18:32:58', NULL),
	(3, 1, 'RUMAH UWAK', 'UWAK', '087812341234', '1', 'Bali', '17', 'Badung', NULL, '20225', '', 'JL. KROBOKAN', 1, '2025-07-10 18:32:58', '2025-07-10 18:32:58', NULL);

-- Dumping structure for table adunmancing.variant_options
CREATE TABLE IF NOT EXISTS `variant_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint unsigned NOT NULL,
  `option_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `variant_options_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `variant_options_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.variant_options: ~2 rows (approximately)
INSERT INTO `variant_options` (`id`, `product_variant_id`, `option_name`, `option_value`, `created_at`, `updated_at`) VALUES
	(4, 2, 'Size', 'XL', '2025-06-30 22:19:38', '2025-06-30 22:23:11'),
	(5, 3, 'Size', 'XXL', '2025-06-30 22:20:17', '2025-06-30 22:23:11');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
