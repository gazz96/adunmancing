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
	(1, 'Warna', '2025-07-04 17:29:03', 'warna', 'Merah,Hijau,Biru', '2025-07-04 17:29:03');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`),
  KEY `blogs_author_id_foreign` (`author_id`),
  CONSTRAINT `blogs_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.blogs: ~0 rows (approximately)
INSERT INTO `blogs` (`id`, `title`, `slug`, `content`, `featured_image`, `author_id`, `is_published`, `created_at`, `updated_at`) VALUES
	(1, 'testing', 'testing', '<p>testing</p>', 'blogs/featured-images/01JZJ670YXMG0QFDHR2503PZPV.jpg', 1, 1, '2025-06-30 21:36:24', '2025-07-07 03:17:38');

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
	(1, 1, 1),
	(2, 1, 2);

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

-- Dumping data for table adunmancing.categories: ~0 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`, `icon`) VALUES
	(1, 'Makanan', 'makanan', '2025-06-30 17:53:12', '2025-07-07 03:18:08', 'product_category_icons/01JZJ696V64YSJWG1EZ9YMYVKH.png'),
	(2, 'Alat Mancing', 'alat-mancing', '2025-07-06 20:25:46', '2025-07-07 02:58:21', 'product_category_icons/01JZJ550CRH2HHRAGTQNM0PPAN.png'),
	(3, 'Rokok Elektronik', 'rokok-elektronik', '2025-07-06 20:26:06', '2025-07-07 02:58:42', 'product_category_icons/01JZJ55MZ9DMA61R2BMQ9KS34A.png'),
	(4, 'Bubble Wrap', 'bubble-wrap', '2025-07-06 20:26:59', '2025-07-07 02:58:48', 'product_category_icons/01JZJ55T1JG1AEWFMGG47ASJW5.png'),
	(5, 'Parfume', 'parfume', '2025-07-07 03:31:11', '2025-07-07 03:31:11', 'product_category_icons/01JZJ7142QMT6T3YC5M1EWG4Z1.png');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.category_product: ~0 rows (approximately)
INSERT INTO `category_product` (`id`, `category_id`, `product_id`) VALUES
	(1, 1, 1),
	(2, 1, 2);

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

-- Dumping data for table adunmancing.menus: ~0 rows (approximately)
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.menu_items: ~2 rows (approximately)
INSERT INTO `menu_items` (`id`, `menu_id`, `label`, `url`, `order`, `parent_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Home', 'https://adunmancing.test', 0, NULL, '2025-07-05 22:32:37', '2025-07-05 22:33:09'),
	(2, 1, 'Contact', 'https://adunmancing.test/contact', 0, 1, '2025-07-05 22:33:09', '2025-07-05 22:33:33');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.options: ~9 rows (approximately)
INSERT INTO `options` (`id`, `option_name`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES
	(1, 'site_name', 'Adunmancing', NULL, '2025-07-05 17:55:32', '2025-07-05 17:55:32'),
	(2, 'site_description', 'Website jualan umpan', NULL, '2025-07-05 17:55:32', '2025-07-05 17:55:32'),
	(3, 'store_name', 'ADUNMANCING', NULL, '2025-07-05 20:43:38', '2025-07-05 20:45:58'),
	(4, 'store_address_1', 'JL. ILENG TAMAN PERMATA HIJAU BLOK B', NULL, '2025-07-05 20:43:38', '2025-07-05 20:45:58'),
	(5, 'store_address_2', 'NO. 13 MEDAN - MARELAN', NULL, '2025-07-05 20:43:38', '2025-07-05 20:45:58'),
	(6, 'store_postcode', '20146', NULL, '2025-07-05 20:43:38', '2025-07-05 20:43:38'),
	(7, 'store_phone', '1234 5678 9101', NULL, '2025-07-05 20:43:38', '2025-07-05 20:43:38'),
	(8, 'store_email', 'custom@adunmancing.com', NULL, '2025-07-05 20:43:38', '2025-07-05 20:43:38'),
	(9, 'store_regency_id', '1275', NULL, '2025-07-05 20:43:38', '2025-07-05 20:45:30'),
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
	(22, 'checkout_privacy_policy', NULL, NULL, '2025-07-06 20:18:25', '2025-07-06 20:18:25');

-- Dumping structure for table adunmancing.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.orders: ~0 rows (approximately)

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
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.order_items: ~0 rows (approximately)

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
  `attributes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `featured_image` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.products: ~4 rows (approximately)
INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `status`, `created_at`, `updated_at`, `compare_price`, `has_variants`, `attributes`, `featured_image`) VALUES
	(1, 'Umpan Lele Siap Pakai Pala Ayam Premium 250gram', 'umpan-lele-siap-pakai-pala-ayam-premium-250gram', '<p>Pala Ayam Premium</p><p>- Merupakan produk umpan yang dikemas secara praktis dan siap pakai. Terbuat dari 100% kepala ayam pilihan.</p><p>- Beraroma amis yang kuat dan khas membuat ikan menjadi lebih cepat kumpul.</p><p>- Sangat cocok dipakai untuk memancing ikan lele, di antaranya :</p><p>1. Galatama Ikan Lele</p><p>2. Lomba Harian Ikan Lele</p><p>3. Galapung Ikan Lele</p><p>4. Harian Ikan Lele</p><p><br><br></p><p>Netto : 250gram/cup</p><p><br><br></p><p>Tata Cara Pemakaian :</p><p>* Ketika paket sampai simpan BAM PALA AYAM PREMIUM dilemari es bagian bawah/frezeer. Pada saat ingin dipakai, keluarkan BAM PALA AYAM PREMIUM dari lemari es kemudian diamkan selama 10-30 menit sampai kondisi suhu normal. Lalu tambahkan ESSEN OPLOSAN ADUN MANCING 35 tetes s/d 1 tutup botol essen oplosan (aduk sampai tercampur rata). Tambahkan BAM PENGERAS secukupnya apabila tekstur belum sesuai dengan yang di inginkan. Aduk sampai semua bahan tercampur rata dan umpan siap digunakan.</p><p><br><br></p><p>* MASA SIMPAN :&nbsp;</p><p>- BAM PALA AYAM PREMIUM diluar frezeer/pendingin tahan 5 s/d 7 hari.&nbsp;</p><p>- BAM PALA AYAM PREMIUM didalam chiller tahan 6 bulan.</p><p>- BAM PALA AYAM PREMIUM didalam frezeer tahan 1 tahun&nbsp;</p>', 11900.00, 1, '2025-06-30 18:09:23', '2025-07-07 03:45:41', 15000.00, NULL, '{"warna":null}', 'product/01JZJ7VNE1PSBETJ3VR16AZDJ1.webp'),
	(2, 'Non Variant', 'non-variant', '<p>ini barang non variant</p>', 1000000.00, 1, '2025-07-04 16:48:06', '2025-07-07 03:48:25', 1500000.00, NULL, '{"warna":null}', 'product/01JZJ80NS93HFAWYYWV008JC55.webp'),
	(4, 'Non variant 2', 'non-variant-2', '<p>tseting</p>', 1000000.00, 1, '2025-07-04 16:50:05', '2025-07-07 03:50:07', NULL, NULL, '{"warna":null}', 'product/01JZJ83SDN680BFN2ZZKQD85JC.webp'),
	(5, 'product', 'product', '<p>testing</p>', 10000.00, 0, '2025-07-04 17:49:17', '2025-07-04 18:51:17', NULL, NULL, '{"warna":"Hijau"}', NULL);

-- Dumping structure for table adunmancing.product_attributes
CREATE TABLE IF NOT EXISTS `product_attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.product_attributes: ~0 rows (approximately)

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.product_images: ~0 rows (approximately)
INSERT INTO `product_images` (`id`, `product_id`, `path`, `is_main`, `created_at`, `updated_at`) VALUES
	(3, 1, 'product-images/id-11134207-7r98o-luyq7gek814h3b@resize_w450_nl.webp', 0, '2025-06-30 18:27:40', '2025-06-30 18:37:13');

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
	(11, 'ACEH', 'ACEH', 4.36855, 97.0253),
	(12, 'SUMATERA UTARA', 'SUMATERA UTARA', 2.19235, 99.38122),
	(13, 'SUMATERA BARAT', 'SUMATERA BARAT', -1.34225, 100.0761),
	(14, 'RIAU', 'RIAU', 0.50041, 101.54758),
	(15, 'JAMBI', 'JAMBI', -1.61157, 102.7797),
	(16, 'SUMATERA SELATAN', 'SUMATERA SELATAN', -3.12668, 104.09306),
	(17, 'BENGKULU', 'BENGKULU', -3.51868, 102.53598),
	(18, 'LAMPUNG', 'LAMPUNG', -4.8555, 105.0273),
	(19, 'KEPULAUAN BANGKA BELITUNG', 'KEPULAUAN BANGKA BELITUNG', -2.75775, 107.58394),
	(21, 'KEPULAUAN RIAU', 'KEPULAUAN RIAU', -0.15478, 104.58037),
	(31, 'DKI JAKARTA', 'DKI JAKARTA', 6.1745, 106.8227),
	(32, 'JAWA BARAT', 'JAWA BARAT', -6.88917, 107.64047),
	(33, 'JAWA TENGAH', 'JAWA TENGAH', -7.30324, 110.00441),
	(34, 'DI YOGYAKARTA', 'DI YOGYAKARTA', 7.7956, 110.3695),
	(35, 'JAWA TIMUR', 'JAWA TIMUR', -6.96851, 113.98005),
	(36, 'BANTEN', 'BANTEN', -6.44538, 106.13756),
	(51, 'BALI', 'BALI', -8.23566, 115.12239),
	(52, 'NUSA TENGGARA BARAT', 'NUSA TENGGARA BARAT', -8.12179, 117.63696),
	(53, 'NUSA TENGGARA TIMUR', 'NUSA TENGGARA TIMUR', -8.56568, 120.69786),
	(61, 'KALIMANTAN BARAT', 'KALIMANTAN BARAT', -0.13224, 111.09689),
	(62, 'KALIMANTAN TENGAH', 'KALIMANTAN TENGAH', -1.49958, 113.29033),
	(63, 'KALIMANTAN SELATAN', 'KALIMANTAN SELATAN', -2.94348, 115.37565),
	(64, 'KALIMANTAN TIMUR', 'KALIMANTAN TIMUR', 0.78844, 116.242),
	(65, 'KALIMANTAN UTARA', 'KALIMANTAN UTARA', 2.72594, 116.911),
	(71, 'SULAWESI UTARA', 'SULAWESI UTARA', 0.65557, 124.09015),
	(72, 'SULAWESI TENGAH', 'SULAWESI TENGAH', -1.69378, 120.80886),
	(73, 'SULAWESI SELATAN', 'SULAWESI SELATAN', -3.64467, 119.94719),
	(74, 'SULAWESI TENGGARA', 'SULAWESI TENGGARA', -3.54912, 121.72796),
	(75, 'GORONTALO', 'GORONTALO', 0.71862, 122.45559),
	(76, 'SULAWESI BARAT', 'SULAWESI BARAT', -2.49745, 119.3919),
	(81, 'MALUKU', 'MALUKU', -3.11884, 129.42078),
	(82, 'MALUKU UTARA', 'MALUKU UTARA', 0.63012, 127.97202),
	(91, 'PAPUA BARAT', 'PAPUA BARAT', -1.38424, 132.90253),
	(94, 'PAPUA', 'PAPUA', -3.98857, 138.34853);

-- Dumping structure for table adunmancing.regencies
CREATE TABLE IF NOT EXISTS `regencies` (
  `id` bigint NOT NULL,
  `province_id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `alt_name` varchar(255) NOT NULL DEFAULT '',
  `latitude` double NOT NULL DEFAULT '0',
  `longitude` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `regencies_province_id_foreign` (`province_id`),
  CONSTRAINT `regencies_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table adunmancing.regencies: ~514 rows (approximately)
INSERT INTO `regencies` (`id`, `province_id`, `name`, `alt_name`, `latitude`, `longitude`) VALUES
	(1101, 11, 'KABUPATEN SIMEULUE', 'KABUPATEN SIMEULUE', 2.61667, 96.08333),
	(1102, 11, 'KABUPATEN ACEH SINGKIL', 'KABUPATEN ACEH SINGKIL', 2.41667, 97.91667),
	(1103, 11, 'KABUPATEN ACEH SELATAN', 'KABUPATEN ACEH SELATAN', 3.16667, 97.41667),
	(1104, 11, 'KABUPATEN ACEH TENGGARA', 'KABUPATEN ACEH TENGGARA', 3.36667, 97.7),
	(1105, 11, 'KABUPATEN ACEH TIMUR', 'KABUPATEN ACEH TIMUR', 4.63333, 97.63333),
	(1106, 11, 'KABUPATEN ACEH TENGAH', 'KABUPATEN ACEH TENGAH', 4.51, 96.855),
	(1107, 11, 'KABUPATEN ACEH BARAT', 'KABUPATEN ACEH BARAT', 4.45, 96.16667),
	(1108, 11, 'KABUPATEN ACEH BESAR', 'KABUPATEN ACEH BESAR', 5.38333, 95.51667),
	(1109, 11, 'KABUPATEN PIDIE', 'KABUPATEN PIDIE', 5.08, 96.11),
	(1110, 11, 'KABUPATEN BIREUEN', 'KABUPATEN BIREUEN', 5.08333, 96.58333),
	(1111, 11, 'KABUPATEN ACEH UTARA', 'KABUPATEN ACEH UTARA', 4.97, 97.14),
	(1112, 11, 'KABUPATEN ACEH BARAT DAYA', 'KABUPATEN ACEH BARAT DAYA', 3.83333, 96.88333),
	(1113, 11, 'KABUPATEN GAYO LUES', 'KABUPATEN GAYO LUES', 3.95, 97.39),
	(1114, 11, 'KABUPATEN ACEH TAMIANG', 'KABUPATEN ACEH TAMIANG', 4.25, 97.96667),
	(1115, 11, 'KABUPATEN NAGAN RAYA', 'KABUPATEN NAGAN RAYA', 4.16667, 96.51667),
	(1116, 11, 'KABUPATEN ACEH JAYA', 'KABUPATEN ACEH JAYA', 4.86, 95.64),
	(1117, 11, 'KABUPATEN BENER MERIAH', 'KABUPATEN BENER MERIAH', 4.73015, 96.86156),
	(1118, 11, 'KABUPATEN PIDIE JAYA', 'KABUPATEN PIDIE JAYA', 5.15, 96.21667),
	(1171, 11, 'KOTA BANDA ACEH', 'KOTA BANDA ACEH', 5.54167, 95.33333),
	(1172, 11, 'KOTA SABANG', 'KOTA SABANG', 5.82164, 95.31086),
	(1173, 11, 'KOTA LANGSA', 'KOTA LANGSA', 4.47, 97.93),
	(1174, 11, 'KOTA LHOKSEUMAWE', 'KOTA LHOKSEUMAWE', 5.13333, 97.06667),
	(1175, 11, 'KOTA SUBULUSSALAM', 'KOTA SUBULUSSALAM', 2.75, 97.93333),
	(1201, 12, 'KABUPATEN NIAS', 'KABUPATEN NIAS', 1.03333, 97.76667),
	(1202, 12, 'KABUPATEN MANDAILING NATAL', 'KABUPATEN MANDAILING NATAL', 0.78378, 99.25495),
	(1203, 12, 'KABUPATEN TAPANULI SELATAN', 'KABUPATEN TAPANULI SELATAN', 1.51667, 99.25),
	(1204, 12, 'KABUPATEN TAPANULI TENGAH', 'KABUPATEN TAPANULI TENGAH', 1.9, 98.66667),
	(1205, 12, 'KABUPATEN TAPANULI UTARA', 'KABUPATEN TAPANULI UTARA', 2.0028, 99.0707),
	(1206, 12, 'KABUPATEN TOBA SAMOSIR', 'KABUPATEN TOBA SAMOSIR', 2.39793, 99.21678),
	(1207, 12, 'KABUPATEN LABUHAN BATU', 'KABUPATEN LABUHAN BATU', 2.26667, 100.1),
	(1208, 12, 'KABUPATEN ASAHAN', 'KABUPATEN ASAHAN', 2.78333, 99.55),
	(1209, 12, 'KABUPATEN SIMALUNGUN', 'KABUPATEN SIMALUNGUN', 2.9, 99),
	(1210, 12, 'KABUPATEN DAIRI', 'KABUPATEN DAIRI', 2.86667, 98.23333),
	(1211, 12, 'KABUPATEN KARO', 'KABUPATEN KARO', 3.11667, 98.3),
	(1212, 12, 'KABUPATEN DELI SERDANG', 'KABUPATEN DELI SERDANG', 3.41667, 98.66667),
	(1213, 12, 'KABUPATEN LANGKAT', 'KABUPATEN LANGKAT', 3.71667, 98.21667),
	(1214, 12, 'KABUPATEN NIAS SELATAN', 'KABUPATEN NIAS SELATAN', 0.77, 97.75),
	(1215, 12, 'KABUPATEN HUMBANG HASUNDUTAN', 'KABUPATEN HUMBANG HASUNDUTAN', 2.26551, 98.50376),
	(1216, 12, 'KABUPATEN PAKPAK BHARAT', 'KABUPATEN PAKPAK BHARAT', 2.56667, 98.28333),
	(1217, 12, 'KABUPATEN SAMOSIR', 'KABUPATEN SAMOSIR', 2.64025, 98.71525),
	(1218, 12, 'KABUPATEN SERDANG BEDAGAI', 'KABUPATEN SERDANG BEDAGAI', 3.36667, 99.03333),
	(1219, 12, 'KABUPATEN BATU BARA', 'KABUPATEN BATU BARA', 3.16166, 99.52652),
	(1220, 12, 'KABUPATEN PADANG LAWAS UTARA', 'KABUPATEN PADANG LAWAS UTARA', 1.46011, 99.67346),
	(1221, 12, 'KABUPATEN PADANG LAWAS', 'KABUPATEN PADANG LAWAS', 1.44684, 99.99207),
	(1222, 12, 'KABUPATEN LABUHAN BATU SELATAN', 'KABUPATEN LABUHAN BATU SELATAN', 1.983, 100.0976),
	(1223, 12, 'KABUPATEN LABUHAN BATU UTARA', 'KABUPATEN LABUHAN BATU UTARA', 2.33349, 99.63776),
	(1224, 12, 'KABUPATEN NIAS UTARA', 'KABUPATEN NIAS UTARA', 1.33037, 97.31964),
	(1225, 12, 'KABUPATEN NIAS BARAT', 'KABUPATEN NIAS BARAT', 1.05966, 97.58606),
	(1271, 12, 'KOTA SIBOLGA', 'KOTA SIBOLGA', 1.73333, 98.8),
	(1272, 12, 'KOTA TANJUNG BALAI', 'KOTA TANJUNG BALAI', 2.95833, 99.79167),
	(1273, 12, 'KOTA PEMATANG SIANTAR', 'KOTA PEMATANG SIANTAR', 2.96667, 99.05),
	(1274, 12, 'KOTA TEBING TINGGI', 'KOTA TEBING TINGGI', 3.325, 99.14167),
	(1275, 12, 'KOTA MEDAN', 'KOTA MEDAN', 3.65, 98.66667),
	(1276, 12, 'KOTA BINJAI', 'KOTA BINJAI', 3.8, 108.23333),
	(1277, 12, 'KOTA PADANG SIDEMPUAN', 'KOTA PADANG SIDEMPUAN', 1.37375, 99.26843),
	(1278, 12, 'KOTA GUNUNGSITOLI', 'KOTA GUNUNGSITOLI', 1.32731, 97.55018),
	(1301, 13, 'KABUPATEN KEPULAUAN MENTAWAI', 'KABUPATEN KEPULAUAN MENTAWAI', 1.98917, 99.51889),
	(1302, 13, 'KABUPATEN PESISIR SELATAN', 'KABUPATEN PESISIR SELATAN', -1.58333, 100.85),
	(1303, 13, 'KABUPATEN SOLOK', 'KABUPATEN SOLOK', -0.96667, 100.81667),
	(1304, 13, 'KABUPATEN SIJUNJUNG', 'KABUPATEN SIJUNJUNG', -1.1827, 101.6056),
	(1305, 13, 'KABUPATEN TANAH DATAR', 'KABUPATEN TANAH DATAR', -0.4555, 100.5771),
	(1306, 13, 'KABUPATEN PADANG PARIAMAN', 'KABUPATEN PADANG PARIAMAN', -0.6, 100.28333),
	(1307, 13, 'KABUPATEN AGAM', 'KABUPATEN AGAM', -0.25, 100.16667),
	(1308, 13, 'KABUPATEN LIMA PULUH KOTA', 'KABUPATEN LIMA PULUH KOTA', -0.0168, 100.5872),
	(1309, 13, 'KABUPATEN PASAMAN', 'KABUPATEN PASAMAN', 0.42503, 99.94606),
	(1310, 13, 'KABUPATEN SOLOK SELATAN', 'KABUPATEN SOLOK SELATAN', -1.23333, 101.417),
	(1311, 13, 'KABUPATEN DHARMASRAYA', 'KABUPATEN DHARMASRAYA', -1.05, 101.367),
	(1312, 13, 'KABUPATEN PASAMAN BARAT', 'KABUPATEN PASAMAN BARAT', 0.28152, 99.51965),
	(1371, 13, 'KOTA PADANG', 'KOTA PADANG', -0.98333, 100.45),
	(1372, 13, 'KOTA SOLOK', 'KOTA SOLOK', -0.76667, 100.61667),
	(1373, 13, 'KOTA SAWAH LUNTO', 'KOTA SAWAH LUNTO', -0.6, 100.75),
	(1374, 13, 'KOTA PADANG PANJANG', 'KOTA PADANG PANJANG', -0.45, 100.43333),
	(1375, 13, 'KOTA BUKITTINGGI', 'KOTA BUKITTINGGI', -0.275, 100.375),
	(1376, 13, 'KOTA PAYAKUMBUH', 'KOTA PAYAKUMBUH', -0.23333, 100.63333),
	(1377, 13, 'KOTA PARIAMAN', 'KOTA PARIAMAN', -0.62682, 100.12047),
	(1401, 14, 'KABUPATEN KUANTAN SINGINGI', 'KABUPATEN KUANTAN SINGINGI', -0.47532, 101.45857),
	(1402, 14, 'KABUPATEN INDRAGIRI HULU', 'KABUPATEN INDRAGIRI HULU', -0.55, 102.31667),
	(1403, 14, 'KABUPATEN INDRAGIRI HILIR', 'KABUPATEN INDRAGIRI HILIR', -0.33333, 103.16667),
	(1404, 14, 'KABUPATEN PELALAWAN', 'KABUPATEN PELALAWAN', 0.20822, 102.18607),
	(1405, 14, 'KABUPATEN SIAK', 'KABUPATEN SIAK', 0.97453, 102.01355),
	(1406, 14, 'KABUPATEN KAMPAR', 'KABUPATEN KAMPAR', 0.2344, 101.2131),
	(1407, 14, 'KABUPATEN ROKAN HULU', 'KABUPATEN ROKAN HULU', 0.88333, 100.48333),
	(1408, 14, 'KABUPATEN BENGKALIS', 'KABUPATEN BENGKALIS', 0.9838, 102.5096),
	(1409, 14, 'KABUPATEN ROKAN HILIR', 'KABUPATEN ROKAN HILIR', 2.16599, 100.82514),
	(1410, 14, 'KABUPATEN KEPULAUAN MERANTI', 'KABUPATEN KEPULAUAN MERANTI', 0.97488, 102.69539),
	(1471, 14, 'KOTA PEKANBARU', 'KOTA PEKANBARU', 0.53333, 101.46667),
	(1473, 14, 'KOTA DUMAI', 'KOTA DUMAI', 1.61592, 101.4917),
	(1501, 15, 'KABUPATEN KERINCI', 'KABUPATEN KERINCI', -2.03333, 101.53333),
	(1502, 15, 'KABUPATEN MERANGIN', 'KABUPATEN MERANGIN', -2.06933, 102.13303),
	(1503, 15, 'KABUPATEN SAROLANGUN', 'KABUPATEN SAROLANGUN', -2.3, 102.65),
	(1504, 15, 'KABUPATEN BATANG HARI', 'KABUPATEN BATANG HARI', -1.75, 103.11667),
	(1505, 15, 'KABUPATEN MUARO JAMBI', 'KABUPATEN MUARO JAMBI', -1.55214, 103.82163),
	(1506, 15, 'KABUPATEN TANJUNG JABUNG TIMUR', 'KABUPATEN TANJUNG JABUNG TIMUR', -1.13198, 103.61755),
	(1507, 15, 'KABUPATEN TANJUNG JABUNG BARAT', 'KABUPATEN TANJUNG JABUNG BARAT', -1.1544, 103.24402),
	(1508, 15, 'KABUPATEN TEBO', 'KABUPATEN TEBO', -1.45576, 102.37473),
	(1509, 15, 'KABUPATEN BUNGO', 'KABUPATEN BUNGO', -1.50222, 101.96),
	(1571, 15, 'KOTA JAMBI', 'KOTA JAMBI', -1.61667, 103.65),
	(1572, 15, 'KOTA SUNGAI PENUH', 'KOTA SUNGAI PENUH', -2.10896, 101.32175),
	(1601, 16, 'KABUPATEN OGAN KOMERING ULU', 'KABUPATEN OGAN KOMERING ULU', -4.13333, 104.03333),
	(1602, 16, 'KABUPATEN OGAN KOMERING ILIR', 'KABUPATEN OGAN KOMERING ILIR', -3.36667, 105.36667),
	(1603, 16, 'KABUPATEN MUARA ENIM', 'KABUPATEN MUARA ENIM', -4.2327, 103.6141),
	(1604, 16, 'KABUPATEN LAHAT', 'KABUPATEN LAHAT', -3.7864, 103.5428),
	(1605, 16, 'KABUPATEN MUSI RAWAS', 'KABUPATEN MUSI RAWAS', -3.08333, 103.2),
	(1606, 16, 'KABUPATEN MUSI BANYU ASIN', 'KABUPATEN MUSI BANYU ASIN', -2.41667, 103.75),
	(1607, 16, 'KABUPATEN BANYU ASIN', 'KABUPATEN BANYU ASIN', -2.88333, 104.38306),
	(1608, 16, 'KABUPATEN OGAN KOMERING ULU SELATAN', 'KABUPATEN OGAN KOMERING ULU SELATAN', -4.65728, 104.00659),
	(1609, 16, 'KABUPATEN OGAN KOMERING ULU TIMUR', 'KABUPATEN OGAN KOMERING ULU TIMUR', -3.85679, 104.75209),
	(1610, 16, 'KABUPATEN OGAN ILIR', 'KABUPATEN OGAN ILIR', -3.43186, 104.62727),
	(1611, 16, 'KABUPATEN EMPAT LAWANG', 'KABUPATEN EMPAT LAWANG', 3.22667, 99.09256),
	(1612, 16, 'KABUPATEN PENUKAL ABAB LEMATANG ILIR', 'KABUPATEN PENUKAL ABAB LEMATANG ILIR', -3.21342, 104.08722),
	(1613, 16, 'KABUPATEN MUSI RAWAS UTARA', 'KABUPATEN MUSI RAWAS UTARA', -2.48533, 103.29346),
	(1671, 16, 'KOTA PALEMBANG', 'KOTA PALEMBANG', -3, 104.71667),
	(1672, 16, 'KOTA PRABUMULIH', 'KOTA PRABUMULIH', -3.46202, 104.2229),
	(1673, 16, 'KOTA PAGAR ALAM', 'KOTA PAGAR ALAM', -4.13055, 103.26822),
	(1674, 16, 'KOTA LUBUK LINGGAU', 'KOTA LUBUK LINGGAU', -3.29308, 102.85503),
	(1701, 17, 'KABUPATEN BENGKULU SELATAN', 'KABUPATEN BENGKULU SELATAN', -4.35, 103.03333),
	(1702, 17, 'KABUPATEN REJANG LEBONG', 'KABUPATEN REJANG LEBONG', -3.43333, 102.71667),
	(1703, 17, 'KABUPATEN BENGKULU UTARA', 'KABUPATEN BENGKULU UTARA', -3.33333, 102.05),
	(1704, 17, 'KABUPATEN KAUR', 'KABUPATEN KAUR', -4.78179, 103.36109),
	(1705, 17, 'KABUPATEN SELUMA', 'KABUPATEN SELUMA', -3.96644, 102.47429),
	(1706, 17, 'KABUPATEN MUKOMUKO', 'KABUPATEN MUKOMUKO', -3.07438, 101.54766),
	(1707, 17, 'KABUPATEN LEBONG', 'KABUPATEN LEBONG', -3.24278, 102.3349),
	(1708, 17, 'KABUPATEN KEPAHIANG', 'KABUPATEN KEPAHIANG', -3.60194, 102.56424),
	(1709, 17, 'KABUPATEN BENGKULU TENGAH', 'KABUPATEN BENGKULU TENGAH', -3.20679, 102.12616),
	(1771, 17, 'KOTA BENGKULU', 'KOTA BENGKULU', -3.81667, 102.31667),
	(1801, 18, 'KABUPATEN LAMPUNG BARAT', 'KABUPATEN LAMPUNG BARAT', -5.14904, 104.19309),
	(1802, 18, 'KABUPATEN TANGGAMUS', 'KABUPATEN TANGGAMUS', -5.38508, 104.62349),
	(1803, 18, 'KABUPATEN LAMPUNG SELATAN', 'KABUPATEN LAMPUNG SELATAN', -5.4531, 104.9877),
	(1804, 18, 'KABUPATEN LAMPUNG TIMUR', 'KABUPATEN LAMPUNG TIMUR', -5.10273, 105.68003),
	(1805, 18, 'KABUPATEN LAMPUNG TENGAH', 'KABUPATEN LAMPUNG TENGAH', -4.86667, 105.26667),
	(1806, 18, 'KABUPATEN LAMPUNG UTARA', 'KABUPATEN LAMPUNG UTARA', -4.81667, 104.8),
	(1807, 18, 'KABUPATEN WAY KANAN', 'KABUPATEN WAY KANAN', -4.44705, 104.52753),
	(1808, 18, 'KABUPATEN TULANGBAWANG', 'KABUPATEN TULANGBAWANG', -4.20604, 105.57999),
	(1809, 18, 'KABUPATEN PESAWARAN', 'KABUPATEN PESAWARAN', -5.4298, 105.17899),
	(1810, 18, 'KABUPATEN PRINGSEWU', 'KABUPATEN PRINGSEWU', -5.42211, 104.93454),
	(1811, 18, 'KABUPATEN MESUJI', 'KABUPATEN MESUJI', -4.0439, 105.4013),
	(1812, 18, 'KABUPATEN TULANG BAWANG BARAT', 'KABUPATEN TULANG BAWANG BARAT', -4.43975, 105.0444),
	(1813, 18, 'KABUPATEN PESISIR BARAT', 'KABUPATEN PESISIR BARAT', -5.19323, 103.93976),
	(1871, 18, 'KOTA BANDAR LAMPUNG', 'KOTA BANDAR LAMPUNG', -5.41667, 105.25),
	(1872, 18, 'KOTA METRO', 'KOTA METRO', -5.11856, 105.29949),
	(1901, 19, 'KABUPATEN BANGKA', 'KABUPATEN BANGKA', -1.91667, 105.93333),
	(1902, 19, 'KABUPATEN BELITUNG', 'KABUPATEN BELITUNG', -2.86667, 107.7),
	(1903, 19, 'KABUPATEN BANGKA BARAT', 'KABUPATEN BANGKA BARAT', -1.95839, 105.53741),
	(1904, 19, 'KABUPATEN BANGKA TENGAH', 'KABUPATEN BANGKA TENGAH', -2.33989, 106.1142),
	(1905, 19, 'KABUPATEN BANGKA SELATAN', 'KABUPATEN BANGKA SELATAN', -2.66803, 106.01257),
	(1906, 19, 'KABUPATEN BELITUNG TIMUR', 'KABUPATEN BELITUNG TIMUR', -2.9627, 108.15216),
	(1971, 19, 'KOTA PANGKAL PINANG', 'KOTA PANGKAL PINANG', -2.13333, 106.13333),
	(2101, 21, 'KABUPATEN KARIMUN', 'KABUPATEN KARIMUN', 0.80764, 103.41911),
	(2102, 21, 'KABUPATEN BINTAN', 'KABUPATEN BINTAN', 0.95, 104.61944),
	(2103, 21, 'KABUPATEN NATUNA', 'KABUPATEN NATUNA', 4.71417, 107.97639),
	(2104, 21, 'KABUPATEN LINGGA', 'KABUPATEN LINGGA', 0.2, 104.61667),
	(2105, 21, 'KABUPATEN KEPULAUAN ANAMBAS', 'KABUPATEN KEPULAUAN ANAMBAS', 3, 106),
	(2171, 21, 'KOTA BATAM', 'KOTA BATAM', 1.05211, 104.02851),
	(2172, 21, 'KOTA TANJUNG PINANG', 'KOTA TANJUNG PINANG', 0.91683, 104.44329),
	(3101, 31, 'KABUPATEN KEPULAUAN SERIBU', 'KABUPATEN KEPULAUAN SERIBU', -5.5985, 106.55271),
	(3171, 31, 'KOTA JAKARTA SELATAN', 'KOTA JAKARTA SELATAN', -6.266, 106.8135),
	(3172, 31, 'KOTA JAKARTA TIMUR', 'KOTA JAKARTA TIMUR', -6.2521, 106.884),
	(3173, 31, 'KOTA JAKARTA PUSAT', 'KOTA JAKARTA PUSAT', -6.1777, 106.8403),
	(3174, 31, 'KOTA JAKARTA BARAT', 'KOTA JAKARTA BARAT', -6.1676, 106.7673),
	(3175, 31, 'KOTA JAKARTA UTARA', 'KOTA JAKARTA UTARA', -6.1339, 106.8823),
	(3201, 32, 'KABUPATEN BOGOR', 'KABUPATEN BOGOR', -6.58333, 106.71667),
	(3202, 32, 'KABUPATEN SUKABUMI', 'KABUPATEN SUKABUMI', -7.06667, 106.7),
	(3203, 32, 'KABUPATEN CIANJUR', 'KABUPATEN CIANJUR', -6.7725, 107.08306),
	(3204, 32, 'KABUPATEN BANDUNG', 'KABUPATEN BANDUNG', -7.1, 107.6),
	(3205, 32, 'KABUPATEN GARUT', 'KABUPATEN GARUT', -7.38333, 107.76667),
	(3206, 32, 'KABUPATEN TASIKMALAYA', 'KABUPATEN TASIKMALAYA', -7.5, 108.13333),
	(3207, 32, 'KABUPATEN CIAMIS', 'KABUPATEN CIAMIS', -7.28333, 108.41667),
	(3208, 32, 'KABUPATEN KUNINGAN', 'KABUPATEN KUNINGAN', -7, 108.55),
	(3209, 32, 'KABUPATEN CIREBON', 'KABUPATEN CIREBON', -6.8, 108.56667),
	(3210, 32, 'KABUPATEN MAJALENGKA', 'KABUPATEN MAJALENGKA', -6.81667, 108.28333),
	(3211, 32, 'KABUPATEN SUMEDANG', 'KABUPATEN SUMEDANG', -6.81667, 107.98333),
	(3212, 32, 'KABUPATEN INDRAMAYU', 'KABUPATEN INDRAMAYU', -6.45, 108.16667),
	(3213, 32, 'KABUPATEN SUBANG', 'KABUPATEN SUBANG', -6.50833, 107.7025),
	(3214, 32, 'KABUPATEN PURWAKARTA', 'KABUPATEN PURWAKARTA', -6.58333, 107.45),
	(3215, 32, 'KABUPATEN KARAWANG', 'KABUPATEN KARAWANG', -6.26667, 107.41667),
	(3216, 32, 'KABUPATEN BEKASI', 'KABUPATEN BEKASI', -6.24667, 107.10833),
	(3217, 32, 'KABUPATEN BANDUNG BARAT', 'KABUPATEN BANDUNG BARAT', -6.83333, 107.48333),
	(3218, 32, 'KABUPATEN PANGANDARAN', 'KABUPATEN PANGANDARAN', -7.6673, 108.64037),
	(3271, 32, 'KOTA BOGOR', 'KOTA BOGOR', -6.59167, 106.8),
	(3272, 32, 'KOTA SUKABUMI', 'KOTA SUKABUMI', -6.95, 106.93333),
	(3273, 32, 'KOTA BANDUNG', 'KOTA BANDUNG', -6.9175, 107.62444),
	(3274, 32, 'KOTA CIREBON', 'KOTA CIREBON', -6.75, 108.55),
	(3275, 32, 'KOTA BEKASI', 'KOTA BEKASI', -6.28333, 106.98333),
	(3276, 32, 'KOTA DEPOK', 'KOTA DEPOK', -6.4, 106.81667),
	(3277, 32, 'KOTA CIMAHI', 'KOTA CIMAHI', -6.89167, 107.55),
	(3278, 32, 'KOTA TASIKMALAYA', 'KOTA TASIKMALAYA', -7.35, 108.21667),
	(3279, 32, 'KOTA BANJAR', 'KOTA BANJAR', -7.36996, 108.53209),
	(3301, 33, 'KABUPATEN CILACAP', 'KABUPATEN CILACAP', -7.57417, 108.98861),
	(3302, 33, 'KABUPATEN BANYUMAS', 'KABUPATEN BANYUMAS', -7.45, 109.16667),
	(3303, 33, 'KABUPATEN PURBALINGGA', 'KABUPATEN PURBALINGGA', -7.28417, 109.35028),
	(3304, 33, 'KABUPATEN BANJARNEGARA', 'KABUPATEN BANJARNEGARA', -7.35111, 109.5875),
	(3305, 33, 'KABUPATEN KEBUMEN', 'KABUPATEN KEBUMEN', -7.63917, 109.66056),
	(3306, 33, 'KABUPATEN PURWOREJO', 'KABUPATEN PURWOREJO', -7.7, 109.96667),
	(3307, 33, 'KABUPATEN WONOSOBO', 'KABUPATEN WONOSOBO', -7.36139, 109.92667),
	(3308, 33, 'KABUPATEN MAGELANG', 'KABUPATEN MAGELANG', -7.4275, 110.16194),
	(3309, 33, 'KABUPATEN BOYOLALI', 'KABUPATEN BOYOLALI', -7.5, 110.7),
	(3310, 33, 'KABUPATEN KLATEN', 'KABUPATEN KLATEN', -7.68333, 110.61667),
	(3311, 33, 'KABUPATEN SUKOHARJO', 'KABUPATEN SUKOHARJO', -7.68333, 110.83333),
	(3312, 33, 'KABUPATEN WONOGIRI', 'KABUPATEN WONOGIRI', -7.91667, 111),
	(3313, 33, 'KABUPATEN KARANGANYAR', 'KABUPATEN KARANGANYAR', -7.62806, 111.0625),
	(3314, 33, 'KABUPATEN SRAGEN', 'KABUPATEN SRAGEN', -7.41278, 110.935),
	(3315, 33, 'KABUPATEN GROBOGAN', 'KABUPATEN GROBOGAN', -7.11667, 110.91667),
	(3316, 33, 'KABUPATEN BLORA', 'KABUPATEN BLORA', -7.06667, 111.38333),
	(3317, 33, 'KABUPATEN REMBANG', 'KABUPATEN REMBANG', -6.78333, 111.46667),
	(3318, 33, 'KABUPATEN PATI', 'KABUPATEN PATI', -6.76667, 111.1),
	(3319, 33, 'KABUPATEN KUDUS', 'KABUPATEN KUDUS', -6.8, 110.86667),
	(3320, 33, 'KABUPATEN JEPARA', 'KABUPATEN JEPARA', -6.58333, 110.76667),
	(3321, 33, 'KABUPATEN DEMAK', 'KABUPATEN DEMAK', -6.8993, 110.6122),
	(3322, 33, 'KABUPATEN SEMARANG', 'KABUPATEN SEMARANG', -7.20667, 110.44139),
	(3323, 33, 'KABUPATEN TEMANGGUNG', 'KABUPATEN TEMANGGUNG', -7.25, 110.11667),
	(3324, 33, 'KABUPATEN KENDAL', 'KABUPATEN KENDAL', -7.0256, 110.1685),
	(3325, 33, 'KABUPATEN BATANG', 'KABUPATEN BATANG', -7.03333, 109.88333),
	(3326, 33, 'KABUPATEN PEKALONGAN', 'KABUPATEN PEKALONGAN', -7.0319, 109.624),
	(3327, 33, 'KABUPATEN PEMALANG', 'KABUPATEN PEMALANG', -7.03333, 109.4),
	(3328, 33, 'KABUPATEN TEGAL', 'KABUPATEN TEGAL', -7.03333, 109.16667),
	(3329, 33, 'KABUPATEN BREBES', 'KABUPATEN BREBES', -7.05, 108.9),
	(3371, 33, 'KOTA MAGELANG', 'KOTA MAGELANG', -7.5, 110.225),
	(3372, 33, 'KOTA SURAKARTA', 'KOTA SURAKARTA', -7.55, 110.81667),
	(3373, 33, 'KOTA SALATIGA', 'KOTA SALATIGA', -7.33278, 110.48333),
	(3374, 33, 'KOTA SEMARANG', 'KOTA SEMARANG', -7.03333, 110.38333),
	(3375, 33, 'KOTA PEKALONGAN', 'KOTA PEKALONGAN', -6.9, 109.68333),
	(3376, 33, 'KOTA TEGAL', 'KOTA TEGAL', -6.8686, 109.1129),
	(3401, 34, 'KABUPATEN KULON PROGO', 'KABUPATEN KULON PROGO', -7.645, 110.02694),
	(3402, 34, 'KABUPATEN BANTUL', 'KABUPATEN BANTUL', -7.9, 110.36667),
	(3403, 34, 'KABUPATEN GUNUNG KIDUL', 'KABUPATEN GUNUNG KIDUL', -7.98333, 110.61667),
	(3404, 34, 'KABUPATEN SLEMAN', 'KABUPATEN SLEMAN', -7.68167, 110.32333),
	(3471, 34, 'KOTA YOGYAKARTA', 'KOTA YOGYAKARTA', -7.8, 110.375),
	(3501, 35, 'KABUPATEN PACITAN', 'KABUPATEN PACITAN', -8.13333, 111.16667),
	(3502, 35, 'KABUPATEN PONOROGO', 'KABUPATEN PONOROGO', -7.93333, 111.5),
	(3503, 35, 'KABUPATEN TRENGGALEK', 'KABUPATEN TRENGGALEK', -8.16667, 111.61667),
	(3504, 35, 'KABUPATEN TULUNGAGUNG', 'KABUPATEN TULUNGAGUNG', -8.11667, 111.91667),
	(3505, 35, 'KABUPATEN BLITAR', 'KABUPATEN BLITAR', -8.13333, 112.25),
	(3506, 35, 'KABUPATEN KEDIRI', 'KABUPATEN KEDIRI', -7.83333, 112.16667),
	(3507, 35, 'KABUPATEN MALANG', 'KABUPATEN MALANG', -8.16667, 112.66667),
	(3508, 35, 'KABUPATEN LUMAJANG', 'KABUPATEN LUMAJANG', -8.11667, 113.15),
	(3509, 35, 'KABUPATEN JEMBER', 'KABUPATEN JEMBER', -8.25, 113.65),
	(3510, 35, 'KABUPATEN BANYUWANGI', 'KABUPATEN BANYUWANGI', -8.33333, 114.2),
	(3511, 35, 'KABUPATEN BONDOWOSO', 'KABUPATEN BONDOWOSO', -7.9404, 113.9834),
	(3512, 35, 'KABUPATEN SITUBONDO', 'KABUPATEN SITUBONDO', -7.71667, 114.05),
	(3513, 35, 'KABUPATEN PROBOLINGGO', 'KABUPATEN PROBOLINGGO', -7.86667, 113.31667),
	(3514, 35, 'KABUPATEN PASURUAN', 'KABUPATEN PASURUAN', -7.73333, 112.83333),
	(3515, 35, 'KABUPATEN SIDOARJO', 'KABUPATEN SIDOARJO', -7.45, 112.7),
	(3516, 35, 'KABUPATEN MOJOKERTO', 'KABUPATEN MOJOKERTO', -7.55, 112.5),
	(3517, 35, 'KABUPATEN JOMBANG', 'KABUPATEN JOMBANG', -7.55, 112.25),
	(3518, 35, 'KABUPATEN NGANJUK', 'KABUPATEN NGANJUK', -7.6, 111.93333),
	(3519, 35, 'KABUPATEN MADIUN', 'KABUPATEN MADIUN', -7.61667, 111.65),
	(3520, 35, 'KABUPATEN MAGETAN', 'KABUPATEN MAGETAN', -7.64472, 111.35917),
	(3521, 35, 'KABUPATEN NGAWI', 'KABUPATEN NGAWI', -7.47444, 111.33444),
	(3522, 35, 'KABUPATEN BOJONEGORO', 'KABUPATEN BOJONEGORO', -7.25, 111.8),
	(3523, 35, 'KABUPATEN TUBAN', 'KABUPATEN TUBAN', -6.96667, 111.9),
	(3524, 35, 'KABUPATEN LAMONGAN', 'KABUPATEN LAMONGAN', -7.13333, 112.31667),
	(3525, 35, 'KABUPATEN GRESIK', 'KABUPATEN GRESIK', -7.1933, 112.553),
	(3526, 35, 'KABUPATEN BANGKALAN', 'KABUPATEN BANGKALAN', -7.05, 112.93333),
	(3527, 35, 'KABUPATEN SAMPANG', 'KABUPATEN SAMPANG', -7.05, 113.25),
	(3528, 35, 'KABUPATEN PAMEKASAN', 'KABUPATEN PAMEKASAN', -7.06667, 113.5),
	(3529, 35, 'KABUPATEN SUMENEP', 'KABUPATEN SUMENEP', -7.11667, 114.33333),
	(3571, 35, 'KOTA KEDIRI', 'KOTA KEDIRI', -7.83333, 112.01667),
	(3572, 35, 'KOTA BLITAR', 'KOTA BLITAR', -8.1, 112.16667),
	(3573, 35, 'KOTA MALANG', 'KOTA MALANG', -7.975, 112.63333),
	(3574, 35, 'KOTA PROBOLINGGO', 'KOTA PROBOLINGGO', -7.78333, 113.21667),
	(3575, 35, 'KOTA PASURUAN', 'KOTA PASURUAN', -7.65, 112.9),
	(3576, 35, 'KOTA MOJOKERTO', 'KOTA MOJOKERTO', -7.46667, 112.43333),
	(3577, 35, 'KOTA MADIUN', 'KOTA MADIUN', -7.63333, 111.53333),
	(3578, 35, 'KOTA SURABAYA', 'KOTA SURABAYA', -7.26667, 112.71667),
	(3579, 35, 'KOTA BATU', 'KOTA BATU', -7.83272, 112.53751),
	(3601, 36, 'KABUPATEN PANDEGLANG', 'KABUPATEN PANDEGLANG', -6.63333, 105.75),
	(3602, 36, 'KABUPATEN LEBAK', 'KABUPATEN LEBAK', -6.65, 106.21667),
	(3603, 36, 'KABUPATEN TANGERANG', 'KABUPATEN TANGERANG', -6.2, 106.46667),
	(3604, 36, 'KABUPATEN SERANG', 'KABUPATEN SERANG', -6.15, 106),
	(3671, 36, 'KOTA TANGERANG', 'KOTA TANGERANG', -6.17944, 106.62991),
	(3672, 36, 'KOTA CILEGON', 'KOTA CILEGON', -6.01667, 106.01667),
	(3673, 36, 'KOTA SERANG', 'KOTA SERANG', -6.12563, 106.14999),
	(3674, 36, 'KOTA TANGERANG SELATAN', 'KOTA TANGERANG SELATAN', -6.29373, 106.71244),
	(5101, 51, 'KABUPATEN JEMBRANA', 'KABUPATEN JEMBRANA', -8.3, 114.66667),
	(5102, 51, 'KABUPATEN TABANAN', 'KABUPATEN TABANAN', -8.43333, 115.06667),
	(5103, 51, 'KABUPATEN BADUNG', 'KABUPATEN BADUNG', -8.51667, 115.2),
	(5104, 51, 'KABUPATEN GIANYAR', 'KABUPATEN GIANYAR', -8.46667, 115.28333),
	(5105, 51, 'KABUPATEN KLUNGKUNG', 'KABUPATEN KLUNGKUNG', -8.55, 115.4),
	(5106, 51, 'KABUPATEN BANGLI', 'KABUPATEN BANGLI', -8.28333, 115.35),
	(5107, 51, 'KABUPATEN KARANG ASEM', 'KABUPATEN KARANG ASEM', -8.3891, 115.5393),
	(5108, 51, 'KABUPATEN BULELENG', 'KABUPATEN BULELENG', -8.25, 114.96667),
	(5171, 51, 'KOTA DENPASAR', 'KOTA DENPASAR', -8.66667, 115.21663),
	(5201, 52, 'KABUPATEN LOMBOK BARAT', 'KABUPATEN LOMBOK BARAT', -8.69583, 116.11667),
	(5202, 52, 'KABUPATEN LOMBOK TENGAH', 'KABUPATEN LOMBOK TENGAH', -8.7, 116.3),
	(5203, 52, 'KABUPATEN LOMBOK TIMUR', 'KABUPATEN LOMBOK TIMUR', -8.53333, 116.53333),
	(5204, 52, 'KABUPATEN SUMBAWA', 'KABUPATEN SUMBAWA', -8.7439, 117.3324),
	(5205, 52, 'KABUPATEN DOMPU', 'KABUPATEN DOMPU', -8.5094, 118.4816),
	(5206, 52, 'KABUPATEN BIMA', 'KABUPATEN BIMA', -8.6, 118.61667),
	(5207, 52, 'KABUPATEN SUMBAWA BARAT', 'KABUPATEN SUMBAWA BARAT', -8.75159, 116.92132),
	(5208, 52, 'KABUPATEN LOMBOK UTARA', 'KABUPATEN LOMBOK UTARA', -8.35214, 116.40152),
	(5271, 52, 'KOTA MATARAM', 'KOTA MATARAM', -8.5833, 116.1167),
	(5272, 52, 'KOTA BIMA', 'KOTA BIMA', -8.46728, 118.75259),
	(5301, 53, 'KABUPATEN SUMBA BARAT', 'KABUPATEN SUMBA BARAT', -9.56667, 119.45),
	(5302, 53, 'KABUPATEN SUMBA TIMUR', 'KABUPATEN SUMBA TIMUR', -9.88333, 120.25),
	(5303, 53, 'KABUPATEN KUPANG', 'KABUPATEN KUPANG', -9.91667, 123.83333),
	(5304, 53, 'KABUPATEN TIMOR TENGAH SELATAN', 'KABUPATEN TIMOR TENGAH SELATAN', -9.83333, 124.4),
	(5305, 53, 'KABUPATEN TIMOR TENGAH UTARA', 'KABUPATEN TIMOR TENGAH UTARA', -9.33136, 124.51904),
	(5306, 53, 'KABUPATEN BELU', 'KABUPATEN BELU', -9.41258, 124.95066),
	(5307, 53, 'KABUPATEN ALOR', 'KABUPATEN ALOR', -8.3, 124.56667),
	(5308, 53, 'KABUPATEN LEMBATA', 'KABUPATEN LEMBATA', -8.41396, 123.55225),
	(5309, 53, 'KABUPATEN FLORES TIMUR', 'KABUPATEN FLORES TIMUR', -8.24224, 122.96817),
	(5310, 53, 'KABUPATEN SIKKA', 'KABUPATEN SIKKA', -8.66667, 122.36667),
	(5311, 53, 'KABUPATEN ENDE', 'KABUPATEN ENDE', -8.84056, 121.66389),
	(5312, 53, 'KABUPATEN NGADA', 'KABUPATEN NGADA', -8.66667, 121),
	(5313, 53, 'KABUPATEN MANGGARAI', 'KABUPATEN MANGGARAI', -8.56667, 120.41667),
	(5314, 53, 'KABUPATEN ROTE NDAO', 'KABUPATEN ROTE NDAO', -10.73617, 123.12054),
	(5315, 53, 'KABUPATEN MANGGARAI BARAT', 'KABUPATEN MANGGARAI BARAT', -8.64484, 119.88281),
	(5316, 53, 'KABUPATEN SUMBA TENGAH', 'KABUPATEN SUMBA TENGAH', -9.62941, 119.61914),
	(5317, 53, 'KABUPATEN SUMBA BARAT DAYA', 'KABUPATEN SUMBA BARAT DAYA', -9.56216, 119.08905),
	(5318, 53, 'KABUPATEN NAGEKEO', 'KABUPATEN NAGEKEO', -8.8721, 121.20963),
	(5319, 53, 'KABUPATEN MANGGARAI TIMUR', 'KABUPATEN MANGGARAI TIMUR', -8.55533, 120.59761),
	(5320, 53, 'KABUPATEN SABU RAIJUA', 'KABUPATEN SABU RAIJUA', -10.56286, 121.78894),
	(5321, 53, 'KABUPATEN MALAKA', 'KABUPATEN MALAKA', -9.5632, 124.89481),
	(5371, 53, 'KOTA KUPANG', 'KOTA KUPANG', -10.21667, 123.6),
	(6101, 61, 'KABUPATEN SAMBAS', 'KABUPATEN SAMBAS', 1.41667, 109.33333),
	(6102, 61, 'KABUPATEN BENGKAYANG', 'KABUPATEN BENGKAYANG', 1.06911, 109.66393),
	(6103, 61, 'KABUPATEN LANDAK', 'KABUPATEN LANDAK', 0.42373, 109.75917),
	(6104, 61, 'KABUPATEN MEMPAWAH', 'KABUPATEN MEMPAWAH', 0.25, 109.16667),
	(6105, 61, 'KABUPATEN SANGGAU', 'KABUPATEN SANGGAU', 0.25472, 110.45),
	(6106, 61, 'KABUPATEN KETAPANG', 'KABUPATEN KETAPANG', -1.58333, 110.5),
	(6107, 61, 'KABUPATEN SINTANG', 'KABUPATEN SINTANG', -0.08333, 112.08333),
	(6108, 61, 'KABUPATEN KAPUAS HULU', 'KABUPATEN KAPUAS HULU', 0.81667, 112.76667),
	(6109, 61, 'KABUPATEN SEKADAU', 'KABUPATEN SEKADAU', 0.03485, 110.95066),
	(6110, 61, 'KABUPATEN MELAWI', 'KABUPATEN MELAWI', -0.33617, 111.698),
	(6111, 61, 'KABUPATEN KAYONG UTARA', 'KABUPATEN KAYONG UTARA', -1.43711, 110.79781),
	(6112, 61, 'KABUPATEN KUBU RAYA', 'KABUPATEN KUBU RAYA', 0.01637, 109.33731),
	(6171, 61, 'KOTA PONTIANAK', 'KOTA PONTIANAK', -0.08333, 109.36667),
	(6172, 61, 'KOTA SINGKAWANG', 'KOTA SINGKAWANG', 0.90734, 109.00103),
	(6201, 62, 'KABUPATEN KOTAWARINGIN BARAT', 'KABUPATEN KOTAWARINGIN BARAT', -2.4, 111.73333),
	(6202, 62, 'KABUPATEN KOTAWARINGIN TIMUR', 'KABUPATEN KOTAWARINGIN TIMUR', -2.08333, 112.75),
	(6203, 62, 'KABUPATEN KAPUAS', 'KABUPATEN KAPUAS', -2.01667, 114.38333),
	(6204, 62, 'KABUPATEN BARITO SELATAN', 'KABUPATEN BARITO SELATAN', -1.86667, 114.73333),
	(6205, 62, 'KABUPATEN BARITO UTARA', 'KABUPATEN BARITO UTARA', -0.98333, 115.1),
	(6206, 62, 'KABUPATEN SUKAMARA', 'KABUPATEN SUKAMARA', -2.62675, 111.23681),
	(6207, 62, 'KABUPATEN LAMANDAU', 'KABUPATEN LAMANDAU', -1.83828, 111.2869),
	(6208, 62, 'KABUPATEN SERUYAN', 'KABUPATEN SERUYAN', -2.33333, 112.25),
	(6209, 62, 'KABUPATEN KATINGAN', 'KABUPATEN KATINGAN', -2.06667, 113.4),
	(6210, 62, 'KABUPATEN PULANG PISAU', 'KABUPATEN PULANG PISAU', -3.11858, 113.8623),
	(6211, 62, 'KABUPATEN GUNUNG MAS', 'KABUPATEN GUNUNG MAS', -0.95, 113.5),
	(6212, 62, 'KABUPATEN BARITO TIMUR', 'KABUPATEN BARITO TIMUR', -1.93333, 115.1),
	(6213, 62, 'KABUPATEN MURUNG RAYA', 'KABUPATEN MURUNG RAYA', -0.01667, 114.26667),
	(6271, 62, 'KOTA PALANGKA RAYA', 'KOTA PALANGKA RAYA', -1.76979, 113.73126),
	(6301, 63, 'KABUPATEN TANAH LAUT', 'KABUPATEN TANAH LAUT', -3.88333, 114.86667),
	(6302, 63, 'KABUPATEN KOTA BARU', 'KABUPATEN KOTA BARU', -3, 116),
	(6303, 63, 'KABUPATEN BANJAR', 'KABUPATEN BANJAR', -3.31667, 115.08333),
	(6304, 63, 'KABUPATEN BARITO KUALA', 'KABUPATEN BARITO KUALA', -3.08333, 114.61667),
	(6305, 63, 'KABUPATEN TAPIN', 'KABUPATEN TAPIN', -2.91667, 115.03333),
	(6306, 63, 'KABUPATEN HULU SUNGAI SELATAN', 'KABUPATEN HULU SUNGAI SELATAN', -2.75, 115.2),
	(6307, 63, 'KABUPATEN HULU SUNGAI TENGAH', 'KABUPATEN HULU SUNGAI TENGAH', -2.61667, 115.41667),
	(6308, 63, 'KABUPATEN HULU SUNGAI UTARA', 'KABUPATEN HULU SUNGAI UTARA', -2.45, 115.13333),
	(6309, 63, 'KABUPATEN TABALONG', 'KABUPATEN TABALONG', -1.88333, 115.5),
	(6310, 63, 'KABUPATEN TANAH BUMBU', 'KABUPATEN TANAH BUMBU', -3.45413, 115.70372),
	(6311, 63, 'KABUPATEN BALANGAN', 'KABUPATEN BALANGAN', -2.32314, 115.62922),
	(6371, 63, 'KOTA BANJARMASIN', 'KOTA BANJARMASIN', -3.32444, 114.59102),
	(6372, 63, 'KOTA BANJAR BARU', 'KOTA BANJAR BARU', -3.41667, 114.83333),
	(6401, 64, 'KABUPATEN PASER', 'KABUPATEN PASER', -1.43517, 116.23535),
	(6402, 64, 'KABUPATEN KUTAI BARAT', 'KABUPATEN KUTAI BARAT', -0.59417, 115.51575),
	(6403, 64, 'KABUPATEN KUTAI KARTANEGARA', 'KABUPATEN KUTAI KARTANEGARA', -0.44019, 116.98139),
	(6404, 64, 'KABUPATEN KUTAI TIMUR', 'KABUPATEN KUTAI TIMUR', 1.03769, 117.83112),
	(6405, 64, 'KABUPATEN BERAU', 'KABUPATEN BERAU', 2, 117.3),
	(6409, 64, 'KABUPATEN PENAJAM PASER UTARA', 'KABUPATEN PENAJAM PASER UTARA', -1.25, 116.83333),
	(6411, 64, 'KABUPATEN MAHAKAM HULU', 'KABUPATEN MAHAKAM HULU', 0.37822, 115.38048),
	(6471, 64, 'KOTA BALIKPAPAN', 'KOTA BALIKPAPAN', -1.16667, 116.88333),
	(6472, 64, 'KOTA SAMARINDA', 'KOTA SAMARINDA', -0.43333, 117.18333),
	(6474, 64, 'KOTA BONTANG', 'KOTA BONTANG', 0.12526, 117.49603),
	(6501, 65, 'KABUPATEN MALINAU', 'KABUPATEN MALINAU', 2.45, 115.68333),
	(6502, 65, 'KABUPATEN BULUNGAN', 'KABUPATEN BULUNGAN', 3, 117.16667),
	(6503, 65, 'KABUPATEN TANA TIDUNG', 'KABUPATEN TANA TIDUNG', 3.55, 117.25),
	(6504, 65, 'KABUPATEN NUNUKAN', 'KABUPATEN NUNUKAN', 4.13333, 116.7),
	(6571, 65, 'KOTA TARAKAN', 'KOTA TARAKAN', 3.36667, 117.6),
	(7101, 71, 'KABUPATEN BOLAANG MONGONDOW', 'KABUPATEN BOLAANG MONGONDOW', 0.75, 124.08333),
	(7102, 71, 'KABUPATEN MINAHASA', 'KABUPATEN MINAHASA', 1.2537, 124.83),
	(7103, 71, 'KABUPATEN KEPULAUAN SANGIHE', 'KABUPATEN KEPULAUAN SANGIHE', 3.5, 125.55),
	(7104, 71, 'KABUPATEN KEPULAUAN TALAUD', 'KABUPATEN KEPULAUAN TALAUD', 4.31178, 126.78085),
	(7105, 71, 'KABUPATEN MINAHASA SELATAN', 'KABUPATEN MINAHASA SELATAN', 1.21291, 124.59708),
	(7106, 71, 'KABUPATEN MINAHASA UTARA', 'KABUPATEN MINAHASA UTARA', 1.4025, 124.96),
	(7107, 71, 'KABUPATEN BOLAANG MONGONDOW UTARA', 'KABUPATEN BOLAANG MONGONDOW UTARA', 0.78527, 123.41766),
	(7108, 71, 'KABUPATEN SIAU TAGULANDANG BIARO', 'KABUPATEN SIAU TAGULANDANG BIARO', 2.11728, 125.37512),
	(7109, 71, 'KABUPATEN MINAHASA TENGGARA', 'KABUPATEN MINAHASA TENGGARA', 1.05633, 124.7925),
	(7110, 71, 'KABUPATEN BOLAANG MONGONDOW SELATAN', 'KABUPATEN BOLAANG MONGONDOW SELATAN', 0.40912, 123.75961),
	(7111, 71, 'KABUPATEN BOLAANG MONGONDOW TIMUR', 'KABUPATEN BOLAANG MONGONDOW TIMUR', 0.72073, 124.50256),
	(7171, 71, 'KOTA MANADO', 'KOTA MANADO', 1.51667, 124.88333),
	(7172, 71, 'KOTA BITUNG', 'KOTA BITUNG', 1.48333, 125.15),
	(7173, 71, 'KOTA TOMOHON', 'KOTA TOMOHON', 1.31307, 124.83404),
	(7174, 71, 'KOTA KOTAMOBAGU', 'KOTA KOTAMOBAGU', 0.68915, 124.32678),
	(7201, 72, 'KABUPATEN BANGGAI KEPULAUAN', 'KABUPATEN BANGGAI KEPULAUAN', -1.6424, 123.54881),
	(7202, 72, 'KABUPATEN BANGGAI', 'KABUPATEN BANGGAI', -1.2835, 122.8892),
	(7203, 72, 'KABUPATEN MOROWALI', 'KABUPATEN MOROWALI', -1.89342, 121.25473),
	(7204, 72, 'KABUPATEN POSO', 'KABUPATEN POSO', -1.65, 120.5),
	(7205, 72, 'KABUPATEN DONGGALA', 'KABUPATEN DONGGALA', -0.58333, 119.85),
	(7206, 72, 'KABUPATEN TOLI-TOLI', 'KABUPATEN TOLI-TOLI', 1.30862, 120.88643),
	(7207, 72, 'KABUPATEN BUOL', 'KABUPATEN BUOL', 0.75, 120.75),
	(7208, 72, 'KABUPATEN PARIGI MOUTONG', 'KABUPATEN PARIGI MOUTONG', 0.3368, 120.17841),
	(7209, 72, 'KABUPATEN TOJO UNA-UNA', 'KABUPATEN TOJO UNA-UNA', -1.2036, 121.48201),
	(7210, 72, 'KABUPATEN SIGI', 'KABUPATEN SIGI', -1.385, 119.96694),
	(7211, 72, 'KABUPATEN BANGGAI LAUT', 'KABUPATEN BANGGAI LAUT', -1.61841, 123.49388),
	(7212, 72, 'KABUPATEN MOROWALI UTARA', 'KABUPATEN MOROWALI UTARA', -1.7207, 121.24649),
	(7271, 72, 'KOTA PALU', 'KOTA PALU', -0.86972, 119.9),
	(7301, 73, 'KABUPATEN KEPULAUAN SELAYAR', 'KABUPATEN KEPULAUAN SELAYAR', -6.81667, 120.8),
	(7302, 73, 'KABUPATEN BULUKUMBA', 'KABUPATEN BULUKUMBA', -5.41667, 120.23333),
	(7303, 73, 'KABUPATEN BANTAENG', 'KABUPATEN BANTAENG', -5.48333, 119.98333),
	(7304, 73, 'KABUPATEN JENEPONTO', 'KABUPATEN JENEPONTO', -5.63333, 119.73333),
	(7305, 73, 'KABUPATEN TAKALAR', 'KABUPATEN TAKALAR', -5.41667, 119.51667),
	(7306, 73, 'KABUPATEN GOWA', 'KABUPATEN GOWA', -5.31667, 119.75),
	(7307, 73, 'KABUPATEN SINJAI', 'KABUPATEN SINJAI', -5.21667, 120.15),
	(7308, 73, 'KABUPATEN MAROS', 'KABUPATEN MAROS', -5.05, 119.71667),
	(7309, 73, 'KABUPATEN PANGKAJENE DAN KEPULAUAN', 'KABUPATEN PANGKAJENE DAN KEPULAUAN', -4.7827, 119.5506),
	(7310, 73, 'KABUPATEN BARRU', 'KABUPATEN BARRU', -4.43333, 119.68333),
	(7311, 73, 'KABUPATEN BONE', 'KABUPATEN BONE', -4.7, 120.13333),
	(7312, 73, 'KABUPATEN SOPPENG', 'KABUPATEN SOPPENG', -4.3842, 119.89),
	(7313, 73, 'KABUPATEN WAJO', 'KABUPATEN WAJO', -4, 120.16667),
	(7314, 73, 'KABUPATEN SIDENRENG RAPPANG', 'KABUPATEN SIDENRENG RAPPANG', -3.85, 119.96667),
	(7315, 73, 'KABUPATEN PINRANG', 'KABUPATEN PINRANG', -3.61667, 119.6),
	(7316, 73, 'KABUPATEN ENREKANG', 'KABUPATEN ENREKANG', -3.5, 119.86667),
	(7317, 73, 'KABUPATEN LUWU', 'KABUPATEN LUWU', -2.5577, 121.3242),
	(7318, 73, 'KABUPATEN TANA TORAJA', 'KABUPATEN TANA TORAJA', -3.0024, 119.79655),
	(7322, 73, 'KABUPATEN LUWU UTARA', 'KABUPATEN LUWU UTARA', -2.6, 120.25),
	(7325, 73, 'KABUPATEN LUWU TIMUR', 'KABUPATEN LUWU TIMUR', -2.50957, 120.3978),
	(7326, 73, 'KABUPATEN TORAJA UTARA', 'KABUPATEN TORAJA UTARA', -2.92738, 119.79218),
	(7371, 73, 'KOTA MAKASSAR', 'KOTA MAKASSAR', -5.15, 119.45),
	(7372, 73, 'KOTA PARE-PARE', 'KOTA PARE-PARE', -4.03333, 119.65),
	(7373, 73, 'KOTA PALOPO', 'KOTA PALOPO', -2.97841, 120.11078),
	(7401, 74, 'KABUPATEN BUTON', 'KABUPATEN BUTON', -5.31667, 122.58333),
	(7402, 74, 'KABUPATEN MUNA', 'KABUPATEN MUNA', -4.96667, 122.66667),
	(7403, 74, 'KABUPATEN KONAWE', 'KABUPATEN KONAWE', -3.91717, 122.08823),
	(7404, 74, 'KABUPATEN KOLAKA', 'KABUPATEN KOLAKA', -4.08333, 121.66667),
	(7405, 74, 'KABUPATEN KONAWE SELATAN', 'KABUPATEN KONAWE SELATAN', -4.19191, 122.44854),
	(7406, 74, 'KABUPATEN BOMBANA', 'KABUPATEN BOMBANA', -4.6257, 121.81641),
	(7407, 74, 'KABUPATEN WAKATOBI', 'KABUPATEN WAKATOBI', -5.31934, 123.5948),
	(7408, 74, 'KABUPATEN KOLAKA UTARA', 'KABUPATEN KOLAKA UTARA', -3.10452, 121.12427),
	(7409, 74, 'KABUPATEN BUTON UTARA', 'KABUPATEN BUTON UTARA', -5.01457, 122.93015),
	(7410, 74, 'KABUPATEN KONAWE UTARA', 'KABUPATEN KONAWE UTARA', -3.41552, 121.99081),
	(7411, 74, 'KABUPATEN KOLAKA TIMUR', 'KABUPATEN KOLAKA TIMUR', -4.01807, 121.86172),
	(7412, 74, 'KABUPATEN KONAWE KEPULAUAN', 'KABUPATEN KONAWE KEPULAUAN', -4.11656, 123.10181),
	(7413, 74, 'KABUPATEN MUNA BARAT', 'KABUPATEN MUNA BARAT', -4.83333, 122.48333),
	(7414, 74, 'KABUPATEN BUTON TENGAH', 'KABUPATEN BUTON TENGAH', -5.31667, 122.33333),
	(7415, 74, 'KABUPATEN BUTON SELATAN', 'KABUPATEN BUTON SELATAN', -5.56667, 122.7),
	(7471, 74, 'KOTA KENDARI', 'KOTA KENDARI', -3.98333, 122.5),
	(7472, 74, 'KOTA BAUBAU', 'KOTA BAUBAU', -5.477, 122.6166),
	(7501, 75, 'KABUPATEN BOALEMO', 'KABUPATEN BOALEMO', 0.62689, 122.3568),
	(7502, 75, 'KABUPATEN GORONTALO', 'KABUPATEN GORONTALO', 0.5728, 122.2337),
	(7503, 75, 'KABUPATEN POHUWATO', 'KABUPATEN POHUWATO', 0.7098, 121.59582),
	(7504, 75, 'KABUPATEN BONE BOLANGO', 'KABUPATEN BONE BOLANGO', 0.50296, 123.27501),
	(7505, 75, 'KABUPATEN GORONTALO UTARA', 'KABUPATEN GORONTALO UTARA', 0.77, 122.31667),
	(7571, 75, 'KOTA GORONTALO', 'KOTA GORONTALO', 0.53333, 123.1),
	(7601, 76, 'KABUPATEN MAJENE', 'KABUPATEN MAJENE', -3.15, 118.86667),
	(7602, 76, 'KABUPATEN POLEWALI MANDAR', 'KABUPATEN POLEWALI MANDAR', -3.3, 119.16667),
	(7603, 76, 'KABUPATEN MAMASA', 'KABUPATEN MAMASA', -2.96492, 119.30631),
	(7604, 76, 'KABUPATEN MAMUJU', 'KABUPATEN MAMUJU', -2.5, 119.41667),
	(7605, 76, 'KABUPATEN MAMUJU UTARA', 'KABUPATEN MAMUJU UTARA', -1.51639, 119.42139),
	(7606, 76, 'KABUPATEN MAMUJU TENGAH', 'KABUPATEN MAMUJU TENGAH', -2.8212, 119.2662),
	(8101, 81, 'KABUPATEN MALUKU TENGGARA BARAT', 'KABUPATEN MALUKU TENGGARA BARAT', -7.61186, 131.38),
	(8102, 81, 'KABUPATEN MALUKU TENGGARA', 'KABUPATEN MALUKU TENGGARA', -5.75, 132.73334),
	(8103, 81, 'KABUPATEN MALUKU TENGAH', 'KABUPATEN MALUKU TENGAH', -3.29167, 128.9675),
	(8104, 81, 'KABUPATEN BURU', 'KABUPATEN BURU', -3.32767, 126.68413),
	(8105, 81, 'KABUPATEN KEPULAUAN ARU', 'KABUPATEN KEPULAUAN ARU', -6.17059, 134.46991),
	(8106, 81, 'KABUPATEN SERAM BAGIAN BARAT', 'KABUPATEN SERAM BAGIAN BARAT', -3.1027, 128.42996),
	(8107, 81, 'KABUPATEN SERAM BAGIAN TIMUR', 'KABUPATEN SERAM BAGIAN TIMUR', -3.39851, 130.39166),
	(8108, 81, 'KABUPATEN MALUKU BARAT DAYA', 'KABUPATEN MALUKU BARAT DAYA', -7.8296, 126.17386),
	(8109, 81, 'KABUPATEN BURU SELATAN', 'KABUPATEN BURU SELATAN', -3.52187, 126.59271),
	(8171, 81, 'KOTA AMBON', 'KOTA AMBON', -3.7, 128.18333),
	(8172, 81, 'KOTA TUAL', 'KOTA TUAL', -5.64301, 132.74934),
	(8201, 82, 'KABUPATEN HALMAHERA BARAT', 'KABUPATEN HALMAHERA BARAT', 1.41709, 127.55264),
	(8202, 82, 'KABUPATEN HALMAHERA TENGAH', 'KABUPATEN HALMAHERA TENGAH', 0.48056, 128.25),
	(8203, 82, 'KABUPATEN KEPULAUAN SULA', 'KABUPATEN KEPULAUAN SULA', -1.8646, 125.69046),
	(8204, 82, 'KABUPATEN HALMAHERA SELATAN', 'KABUPATEN HALMAHERA SELATAN', -0.3955, 127.90833),
	(8205, 82, 'KABUPATEN HALMAHERA UTARA', 'KABUPATEN HALMAHERA UTARA', 1.73194, 128.00778),
	(8206, 82, 'KABUPATEN HALMAHERA TIMUR', 'KABUPATEN HALMAHERA TIMUR', 1.33517, 128.48627),
	(8207, 82, 'KABUPATEN PULAU MOROTAI', 'KABUPATEN PULAU MOROTAI', 2.19924, 128.40546),
	(8208, 82, 'KABUPATEN PULAU TALIABU', 'KABUPATEN PULAU TALIABU', -1.84578, 124.78992),
	(8271, 82, 'KOTA TERNATE', 'KOTA TERNATE', 0.89618, 127.31016),
	(8272, 82, 'KOTA TIDORE KEPULAUAN', 'KOTA TIDORE KEPULAUAN', 0.60962, 127.56981),
	(9101, 91, 'KABUPATEN FAK-FAK', 'KABUPATEN FAK-FAK', -2.92641, 132.29608),
	(9102, 91, 'KABUPATEN KAIMANA', 'KABUPATEN KAIMANA', -3.66093, 133.77451),
	(9103, 91, 'KABUPATEN TELUK WONDAMA', 'KABUPATEN TELUK WONDAMA', -2.7, 134.5),
	(9104, 91, 'KABUPATEN TELUK BINTUNI', 'KABUPATEN TELUK BINTUNI', -1.88037, 133.33105),
	(9105, 91, 'KABUPATEN MANOKWARI', 'KABUPATEN MANOKWARI', -0.9, 133.75),
	(9106, 91, 'KABUPATEN SORONG SELATAN', 'KABUPATEN SORONG SELATAN', -1.50495, 132.28638),
	(9107, 91, 'KABUPATEN SORONG', 'KABUPATEN SORONG', -1.16667, 131.5),
	(9108, 91, 'KABUPATEN RAJA AMPAT', 'KABUPATEN RAJA AMPAT', -0.5, 130),
	(9109, 91, 'KABUPATEN TAMBRAUW', 'KABUPATEN TAMBRAUW', -0.60515, 132.48962),
	(9110, 91, 'KABUPATEN MAYBRAT', 'KABUPATEN MAYBRAT', -1.2155, 132.35092),
	(9111, 91, 'KABUPATEN MANOKWARI SELATAN', 'KABUPATEN MANOKWARI SELATAN', -1.0798, 133.96729),
	(9112, 91, 'KABUPATEN PEGUNUNGAN ARFAK', 'KABUPATEN PEGUNUNGAN ARFAK', -0.93523, 133.89587),
	(9171, 91, 'KOTA SORONG', 'KOTA SORONG', -0.86507, 131.25153),
	(9401, 94, 'KABUPATEN MERAUKE', 'KABUPATEN MERAUKE', -7.66667, 139.66667),
	(9402, 94, 'KABUPATEN JAYAWIJAYA', 'KABUPATEN JAYAWIJAYA', -4.08333, 139.08333),
	(9403, 94, 'KABUPATEN JAYAPURA', 'KABUPATEN JAYAPURA', -3, 139.95),
	(9404, 94, 'KABUPATEN NABIRE', 'KABUPATEN NABIRE', -3.54016, 135.55511),
	(9408, 94, 'KABUPATEN KEPULAUAN YAPEN', 'KABUPATEN KEPULAUAN YAPEN', -1.78773, 136.27716),
	(9409, 94, 'KABUPATEN BIAK NUMFOR', 'KABUPATEN BIAK NUMFOR', -1.03333, 136),
	(9410, 94, 'KABUPATEN PANIAI', 'KABUPATEN PANIAI', -3.9, 136.60001),
	(9411, 94, 'KABUPATEN PUNCAK JAYA', 'KABUPATEN PUNCAK JAYA', -3.67241, 137.43896),
	(9412, 94, 'KABUPATEN MIMIKA', 'KABUPATEN MIMIKA', -4.54357, 136.56555),
	(9413, 94, 'KABUPATEN BOVEN DIGOEL', 'KABUPATEN BOVEN DIGOEL', -5.70519, 140.36349),
	(9414, 94, 'KABUPATEN MAPPI', 'KABUPATEN MAPPI', -6.49971, 139.34441),
	(9415, 94, 'KABUPATEN ASMAT', 'KABUPATEN ASMAT', -5.3795, 138.46344),
	(9416, 94, 'KABUPATEN YAHUKIMO', 'KABUPATEN YAHUKIMO', -4.60403, 139.58405),
	(9417, 94, 'KABUPATEN PEGUNUNGAN BINTANG', 'KABUPATEN PEGUNUNGAN BINTANG', -4.52167, 140.29541),
	(9418, 94, 'KABUPATEN TOLIKARA', 'KABUPATEN TOLIKARA', -3.42661, 137.41699),
	(9419, 94, 'KABUPATEN SARMI', 'KABUPATEN SARMI', -2.41667, 139.08333),
	(9420, 94, 'KABUPATEN KEEROM', 'KABUPATEN KEEROM', -3.3, 140.61667),
	(9426, 94, 'KABUPATEN WAROPEN', 'KABUPATEN WAROPEN', -2.286, 137.01837),
	(9427, 94, 'KABUPATEN SUPIORI', 'KABUPATEN SUPIORI', -0.73881, 135.61111),
	(9428, 94, 'KABUPATEN MAMBERAMO RAYA', 'KABUPATEN MAMBERAMO RAYA', -2.23561, 137.78229),
	(9429, 94, 'KABUPATEN NDUGA', 'KABUPATEN NDUGA', -4.45093, 138.10089),
	(9430, 94, 'KABUPATEN LANNY JAYA', 'KABUPATEN LANNY JAYA', -3.91244, 138.28766),
	(9431, 94, 'KABUPATEN MAMBERAMO TENGAH', 'KABUPATEN MAMBERAMO TENGAH', -2.46064, 138.45245),
	(9432, 94, 'KABUPATEN YALIMO', 'KABUPATEN YALIMO', -3.86037, 138.47305),
	(9433, 94, 'KABUPATEN PUNCAK', 'KABUPATEN PUNCAK', -4.14204, 137.09702),
	(9434, 94, 'KABUPATEN DOGIYAI', 'KABUPATEN DOGIYAI', -4.03186, 135.43945),
	(9435, 94, 'KABUPATEN INTAN JAYA', 'KABUPATEN INTAN JAYA', -3.41016, 136.70837),
	(9436, 94, 'KABUPATEN DEIYAI', 'KABUPATEN DEIYAI', -3.94737, 135.95032),
	(9471, 94, 'KOTA JAYAPURA', 'KOTA JAYAPURA', -2.64647, 140.77779);

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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table adunmancing.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'webadmin', 'bagas.topati@gmail.com', NULL, '$2y$10$glK4yhCis1z8BOdbWZtR.eYCi83acrD5TpO2qmBvy6LwvZtESfgy6', '9IOJ2Nm7ZJSFKrApAoPJTSNDI9iNp4OpeOWcXeDy0y4msOpv50ByPRKezH2d', '2025-06-29 21:26:05', '2025-06-29 21:26:05');

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
