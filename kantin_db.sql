-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table e_canteen_uin.announcements
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcements_user_id_foreign` (`user_id`),
  CONSTRAINT `announcements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table e_canteen_uin.announcements: ~0 rows (approximately)
REPLACE INTO `announcements` (`id`, `user_id`, `title`, `content`, `published_at`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 1, 'test', 'testt', '2025-05-22 02:47:00', 1, '2025-05-22 02:47:02', '2025-05-22 02:47:12');

-- Dumping structure for table e_canteen_uin.canteens
DROP TABLE IF EXISTS `canteens`;
CREATE TABLE IF NOT EXISTS `canteens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_description` text COLLATE utf8mb4_unicode_ci,
  `operating_hours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table e_canteen_uin.canteens: ~3 rows (approximately)
REPLACE INTO `canteens` (`id`, `name`, `location_description`, `operating_hours`, `image`, `created_at`, `updated_at`) VALUES
	(1, 'Kantin Ushulludin', 'Kantin Ushulludin terletak di ...', '08.00 – 16.00 WIB', 'canteens/Yb63P3ZuDziD05rA0WoijIBVXZOpgtG3RvK0ImXs.jpg', '2025-05-20 11:34:15', '2025-05-21 02:09:33'),
	(2, 'Kantin Kontainer', 'kantin kontainer terletak di ...', '08.00 – 16.00 WIB', 'canteens/NLp1rSNbMU0De8RsCSIYCt0fBi4l63y2JPo5Tllq.jpg', '2025-05-21 02:12:06', '2025-05-21 02:12:06'),
	(3, 'FoodCard UIN RIL', 'foodcart ini terletak di...', '06.00 – 16.00 WIB', 'canteens/cnVqtZnyQh8grzI2o2zqDCAOcOuZLTdT25MKCGQf.jpg', '2025-05-21 02:14:15', '2025-05-21 02:14:15');

-- Dumping structure for table e_canteen_uin.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
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

-- Dumping data for table e_canteen_uin.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table e_canteen_uin.menu_items
DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `menu_items_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table e_canteen_uin.menu_items: ~0 rows (approximately)
REPLACE INTO `menu_items` (`id`, `tenant_id`, `name`, `description`, `price`, `image`, `stock`, `is_available`, `category`, `created_at`, `updated_at`) VALUES
	(9, 5, 'Siomay', NULL, 10000.00, 'menu_items_images/oQo7nO1Fp2abhBVtBA6bfu89h6z9m1dg3Go8FmVj.jpg', -1, 1, 'Makanan Berat', '2025-05-23 05:29:53', '2025-05-23 05:29:53'),
	(10, 6, 'Es Teh', NULL, 3000.00, 'menu_items_images/FeqVbm97XhVZnw13jTFJCgiv26fFSkPTg3Xkl93S.jpg', -1, 1, 'Minuman Dingin', '2025-05-23 05:30:41', '2025-05-23 05:30:41');

-- Dumping structure for table e_canteen_uin.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table e_canteen_uin.migrations: ~11 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_05_20_174709_add_role_to_users_table', 2),
	(6, '2025_05_20_174919_create_canteens_table', 3),
	(7, '2025_05_20_174927_create_tenants_table', 3),
	(8, '2025_05_20_174935_create_menu_items_table', 3),
	(9, '2025_05_20_174946_create_orders_table', 3),
	(10, '2025_05_20_174953_create_order_items_table', 3),
	(11, '2025_05_20_175002_create_announcements_table', 3),
	(12, '2025_05_22_055044_add_delivery_fee_to_orders_table', 4);

-- Dumping structure for table e_canteen_uin.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tenant_id` bigint unsigned NOT NULL,
  `order_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending_payment','paid','processing','ready_for_pickup','out_for_delivery','delivered','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending_payment',
  `pickup_time` datetime DEFAULT NULL,
  `delivery_method` enum('pickup','delivery') COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_address` text COLLATE utf8mb4_unicode_ci,
  `customer_notes` text COLLATE utf8mb4_unicode_ci,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('unpaid','paid','failed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `payment_details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_code_unique` (`order_code`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `orders_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table e_canteen_uin.orders: ~0 rows (approximately)

-- Dumping structure for table e_canteen_uin.order_items
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `menu_item_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL,
  `sub_total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_menu_item_id_foreign` (`menu_item_id`),
  CONSTRAINT `order_items_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table e_canteen_uin.order_items: ~0 rows (approximately)

-- Dumping structure for table e_canteen_uin.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table e_canteen_uin.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table e_canteen_uin.personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
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

-- Dumping data for table e_canteen_uin.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table e_canteen_uin.tenants
DROP TABLE IF EXISTS `tenants`;
CREATE TABLE IF NOT EXISTS `tenants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `canteen_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenants_user_id_foreign` (`user_id`),
  KEY `tenants_canteen_id_foreign` (`canteen_id`),
  CONSTRAINT `tenants_canteen_id_foreign` FOREIGN KEY (`canteen_id`) REFERENCES `canteens` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tenants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table e_canteen_uin.tenants: ~2 rows (approximately)
REPLACE INTO `tenants` (`id`, `user_id`, `canteen_id`, `name`, `description`, `logo`, `is_open`, `created_at`, `updated_at`) VALUES
	(5, 8, 3, 'Kios Samsul', 'test...', 'tenants_logos/fs3QaezsN2dmO6bs6ShEFGRKujLVo2AQIRjqynUs.png', 1, '2025-05-21 10:37:29', '2025-05-23 05:28:12'),
	(6, 10, 2, 'Jokowi Oke', 'test', 'tenants_logos/wot3bXV1u8CoUGB2nOfJGL41uy45TRYc5Nj4Zoa1.png', 1, '2025-05-22 02:45:49', '2025-05-22 02:45:49');

-- Dumping structure for table e_canteen_uin.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','tenant','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table e_canteen_uin.users: ~5 rows (approximately)
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin UIN', 'admin@uin.ac.id', NULL, '$2y$12$oyJzrYj23xJQh8hSmUhMUOzIfpbZNLuGW1VKZyv7KyScjO8jFAik6', 'admin', 'mq9TOJpbViuiFM7vwcxWD8Bh2i6xsaE3tyrrk1quJYwrTiF1ZVlQybviEyLd', '2025-05-20 10:58:33', '2025-05-20 10:58:33'),
	(5, 'fredli', 'fredli@gmail.com', NULL, '$2y$12$OcxUDPB2bYvO76ct0xIAlOxbrQksFpqGBX.QdHJ38hk8XzP.vhdva', 'customer', NULL, '2025-05-20 23:05:12', '2025-05-20 23:05:12'),
	(8, 'Samsul', 'tenant4@gmail.com', NULL, '$2y$12$KYRDA.KO71QrI265XcziiugzS.iCc8sEAo70hBG32t7ehc2LXuPae', 'tenant', NULL, '2025-05-21 10:37:29', '2025-05-21 10:37:29'),
	(9, 'Nisa', 'nisa@gmail.com', NULL, '$2y$12$AQ09ovn6d274JU7qiZbTm.CdLaKbwH2uM28h6cTz9pfFOqcUUCp4u', 'customer', NULL, '2025-05-22 00:05:40', '2025-05-22 00:05:40'),
	(10, 'Jokowi', 'tenant5@gmail.com', NULL, '$2y$12$dkkX80reaV7gkFWrFd9pXudd/UGRdoBkKNtqcBGp4sJVbL8lP9skq', 'tenant', NULL, '2025-05-22 02:45:49', '2025-05-22 02:45:49');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
e_canteen_uin