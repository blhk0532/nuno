/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ulid` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_fields` json DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`),
  UNIQUE KEY `admins_ulid_unique` (`ulid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_addressables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_addressables` (
  `address_id` bigint unsigned NOT NULL,
  `booking_addressable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_addressable_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `bk_addrable_type_id` (`booking_addressable_type`,`booking_addressable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_booking_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_booking_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_booking_id` bigint unsigned NOT NULL,
  `booking_service_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sort` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_booking_items_booking_booking_id_foreign` (`booking_booking_id`),
  KEY `booking_booking_items_booking_service_id_foreign` (`booking_service_id`),
  CONSTRAINT `booking_booking_items_booking_booking_id_foreign` FOREIGN KEY (`booking_booking_id`) REFERENCES `booking_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_booking_items_booking_service_id_foreign` FOREIGN KEY (`booking_service_id`) REFERENCES `booking_services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sort` int unsigned NOT NULL DEFAULT '0',
  `number` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_event_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `status` enum('new','booked','confirmed','processing','cancelled','updated','complete') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'booked',
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_location_id` bigint unsigned DEFAULT NULL,
  `booking_calendar_id` bigint unsigned DEFAULT NULL,
  `shipping_price` decimal(8,2) DEFAULT NULL,
  `shipping_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `schedulable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedulable_id` bigint unsigned DEFAULT NULL,
  `service_note` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `notified_at` timestamp NULL DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `service_id` bigint unsigned DEFAULT NULL,
  `service_user_id` bigint unsigned DEFAULT NULL,
  `booking_user_id` bigint unsigned DEFAULT NULL,
  `booking_client_id` bigint unsigned DEFAULT NULL,
  `service_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `admin_id` bigint unsigned DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'booked',
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_bookings_number_unique` (`number`),
  KEY `booking_bookings_service_id_foreign` (`service_id`),
  KEY `booking_bookings_service_user_id_foreign` (`service_user_id`),
  KEY `booking_bookings_booking_user_id_foreign` (`booking_user_id`),
  KEY `booking_bookings_booking_client_id_foreign` (`booking_client_id`),
  KEY `booking_bookings_admin_id_foreign` (`admin_id`),
  KEY `booking_bookings_booking_calendar_id_foreign` (`booking_calendar_id`),
  KEY `booking_bookings_booking_location_id_foreign` (`booking_location_id`),
  CONSTRAINT `booking_bookings_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_bookings_booking_calendar_id_foreign` FOREIGN KEY (`booking_calendar_id`) REFERENCES `booking_calendars` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_bookings_booking_client_id_foreign` FOREIGN KEY (`booking_client_id`) REFERENCES `booking_clients` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_bookings_booking_location_id_foreign` FOREIGN KEY (`booking_location_id`) REFERENCES `booking_locations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_bookings_booking_user_id_foreign` FOREIGN KEY (`booking_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `booking_bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `booking_services` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_bookings_service_user_id_foreign` FOREIGN KEY (`service_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `position` smallint unsigned NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0',
  `seo_title` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_brands_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_calendars` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_calendar_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_id` bigint unsigned NOT NULL,
  `owner_id` bigint unsigned NOT NULL,
  `brand_id` bigint unsigned DEFAULT NULL,
  `service_ids` json DEFAULT NULL,
  `notify_emails` text COLLATE utf8mb4_unicode_ci,
  `access` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `public_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `embed_code` text COLLATE utf8mb4_unicode_ci,
  `public_address_ical` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secret_address_ical` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shareable_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_numbers` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notification_user_ids` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_calendars_creator_id_foreign` (`creator_id`),
  KEY `booking_calendars_owner_id_foreign` (`owner_id`),
  KEY `booking_calendars_whatsapp_id_foreign` (`whatsapp_id`),
  KEY `booking_calendars_brand_id_foreign` (`brand_id`),
  CONSTRAINT `booking_calendars_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `booking_brands` (`id`),
  CONSTRAINT `booking_calendars_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  CONSTRAINT `booking_calendars_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  CONSTRAINT `booking_calendars_whatsapp_id_foreign` FOREIGN KEY (`whatsapp_id`) REFERENCES `whatsapp_instances` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_call_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_call_stats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `lead_id` bigint unsigned DEFAULT NULL,
  `booking_id` bigint unsigned DEFAULT NULL,
  `outcome` enum('answered','voicemail','no_answer','busy','failed','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_answer',
  `duration` int NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `booked_meeting` tinyint(1) NOT NULL DEFAULT '0',
  `call_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_call_stats_user_id_foreign` (`user_id`),
  KEY `booking_call_stats_booking_id_foreign` (`booking_id`),
  CONSTRAINT `booking_call_stats_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_bookings` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_call_stats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `position` smallint unsigned NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0',
  `seo_title` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_categories_slug_unique` (`slug`),
  KEY `booking_categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `booking_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `booking_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_category_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_category_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_category_id` bigint unsigned NOT NULL,
  `booking_product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_category_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_category_service` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_category_id` bigint unsigned NOT NULL,
  `booking_service_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ulid` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phones` json DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'person',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_clients_ulid_unique` (`ulid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned DEFAULT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint unsigned NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `is_visible` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_comments_customer_id_foreign` (`customer_id`),
  KEY `booking_comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`),
  CONSTRAINT `booking_comments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `booking_customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ulid` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phones` json DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'person',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_customers_ulid_unique` (`ulid`),
  UNIQUE KEY `booking_customers_phone_unique` (`phone`),
  UNIQUE KEY `booking_customers_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_daily_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_daily_locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `service_user_id` bigint unsigned NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_daily_locations_date_service_user_id_unique` (`date`,`service_user_id`),
  KEY `booking_daily_locations_service_user_id_foreign` (`service_user_id`),
  KEY `booking_daily_locations_created_by_foreign` (`created_by`),
  KEY `booking_daily_locations_date_index` (`date`),
  CONSTRAINT `booking_daily_locations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_daily_locations_service_user_id_foreign` FOREIGN KEY (`service_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_data_leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_data_leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `luid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int DEFAULT NULL,
  `sex` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('new','contacted','interested','not_interested','converted','do_not_call') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `assigned_to` bigint unsigned DEFAULT NULL,
  `attempt_count` int NOT NULL DEFAULT '0',
  `last_contacted_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_data_leads_luid_unique` (`luid`),
  KEY `booking_data_leads_assigned_to_foreign` (`assigned_to`),
  CONSTRAINT `booking_data_leads_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_exports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_exports_user_id_foreign` (`user_id`),
  CONSTRAINT `booking_exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_imports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_imports_user_id_foreign` (`user_id`),
  CONSTRAINT `booking_imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sweden',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_locations_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_media_uuid_unique` (`uuid`),
  KEY `booking_media_model_type_model_id_index` (`model_type`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_meeting_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_meeting_user` (
  `booking_meeting_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`booking_meeting_id`,`user_id`),
  KEY `booking_meeting_user_user_id_foreign` (`user_id`),
  CONSTRAINT `booking_meeting_user_booking_meeting_id_foreign` FOREIGN KEY (`booking_meeting_id`) REFERENCES `booking_meetings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_meeting_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_meetings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `starts_at` datetime NOT NULL,
  `ends_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_order_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_order_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_addressable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_addressable_id` bigint unsigned NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bk_addr_type_id` (`booking_addressable_type`,`booking_addressable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_order_id` bigint unsigned DEFAULT NULL,
  `booking_product_id` bigint unsigned DEFAULT NULL,
  `qty` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sort` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `booking_order_items_booking_order_id_foreign` (`booking_order_id`),
  KEY `booking_order_items_booking_product_id_foreign` (`booking_product_id`),
  CONSTRAINT `booking_order_items_booking_order_id_foreign` FOREIGN KEY (`booking_order_id`) REFERENCES `booking_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_order_items_booking_product_id_foreign` FOREIGN KEY (`booking_product_id`) REFERENCES `booking_products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sort` int unsigned NOT NULL DEFAULT '0',
  `booking_customer_id` bigint unsigned DEFAULT NULL,
  `number` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `status` enum('new','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_price` decimal(8,2) DEFAULT NULL,
  `shipping_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_orders_number_unique` (`number`),
  KEY `booking_orders_booking_customer_id_foreign` (`booking_customer_id`),
  CONSTRAINT `booking_orders_booking_customer_id_foreign` FOREIGN KEY (`booking_customer_id`) REFERENCES `booking_customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_outcall_queues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_outcall_queues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `luid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maps` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempts` int NOT NULL DEFAULT '0',
  `user_id` bigint unsigned DEFAULT NULL,
  `service_user_id` bigint unsigned DEFAULT NULL,
  `booking_user_id` bigint unsigned DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_outcall_queues_user_id_foreign` (`user_id`),
  KEY `booking_outcall_queues_service_user_id_foreign` (`service_user_id`),
  KEY `booking_outcall_queues_booking_user_id_foreign` (`booking_user_id`),
  CONSTRAINT `booking_outcall_queues_booking_user_id_foreign` FOREIGN KEY (`booking_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_outcall_queues_service_user_id_foreign` FOREIGN KEY (`service_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_outcall_queues_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_brand_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `qty` bigint unsigned NOT NULL DEFAULT '0',
  `security_stock` bigint unsigned NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0',
  `old_price` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `type` enum('deliverable','downloadable') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backorder` tinyint(1) NOT NULL DEFAULT '0',
  `requires_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` date DEFAULT NULL,
  `seo_title` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight_value` decimal(10,2) unsigned DEFAULT '0.00',
  `weight_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kg',
  `height_value` decimal(10,2) unsigned DEFAULT '0.00',
  `height_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cm',
  `width_value` decimal(10,2) unsigned DEFAULT '0.00',
  `width_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cm',
  `depth_value` decimal(10,2) unsigned DEFAULT '0.00',
  `depth_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cm',
  `volume_value` decimal(10,2) unsigned DEFAULT '0.00',
  `volume_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'l',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_products_slug_unique` (`slug`),
  UNIQUE KEY `booking_products_sku_unique` (`sku`),
  UNIQUE KEY `booking_products_barcode_unique` (`barcode`),
  KEY `booking_products_booking_brand_id_foreign` (`booking_brand_id`),
  CONSTRAINT `booking_products_booking_brand_id_foreign` FOREIGN KEY (`booking_brand_id`) REFERENCES `booking_brands` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_location_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `max_bookings` int NOT NULL DEFAULT '10',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_schedules_booking_location_id_date_unique` (`booking_location_id`,`date`),
  CONSTRAINT `booking_schedules_booking_location_id_foreign` FOREIGN KEY (`booking_location_id`) REFERENCES `booking_locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_service_periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_service_periods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_date` date NOT NULL,
  `service_user_id` bigint unsigned NOT NULL,
  `service_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `period_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'unavailable',
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_service_periods_service_user_id_foreign` (`service_user_id`),
  KEY `booking_service_periods_created_by_foreign` (`created_by`),
  KEY `booking_service_periods_service_date_index` (`service_date`),
  CONSTRAINT `booking_service_periods_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `booking_service_periods_service_user_id_foreign` FOREIGN KEY (`service_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_brand_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `time_duration` int NOT NULL DEFAULT '60',
  `status` enum('booked','confirmed','processing','cancelled','updated','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'processing',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` date DEFAULT NULL,
  `seo_title` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_services_slug_unique` (`slug`),
  UNIQUE KEY `booking_services_service_code_unique` (`service_code`),
  KEY `booking_services_booking_brand_id_foreign` (`booking_brand_id`),
  CONSTRAINT `booking_services_booking_brand_id_foreign` FOREIGN KEY (`booking_brand_id`) REFERENCES `booking_brands` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `payload` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_settings_group_index` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_sprints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_sprints` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `starts_at` datetime NOT NULL,
  `ends_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_taggables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_taggables` (
  `tag_id` bigint unsigned NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taggable_id` bigint unsigned NOT NULL,
  UNIQUE KEY `booking_taggables_tag_id_taggable_id_taggable_type_unique` (`tag_id`,`taggable_id`,`taggable_type`),
  KEY `booking_taggables_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`),
  CONSTRAINT `booking_taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` json NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_column` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `booking_user_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_user_stats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `stats_date` date NOT NULL,
  `total_calls` int NOT NULL DEFAULT '0',
  `answered_calls` int NOT NULL DEFAULT '0',
  `voicemail_calls` int NOT NULL DEFAULT '0',
  `no_answer_calls` int NOT NULL DEFAULT '0',
  `busy_calls` int NOT NULL DEFAULT '0',
  `failed_calls` int NOT NULL DEFAULT '0',
  `other_calls` int NOT NULL DEFAULT '0',
  `booked_meetings_count` int NOT NULL DEFAULT '0',
  `total_duration` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_user_stats_user_id_stats_date_unique` (`user_id`,`stats_date`),
  CONSTRAINT `booking_user_stats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bulk_action_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bulk_action_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bulk_action_id` bigint unsigned NOT NULL,
  `record_id` bigint unsigned NOT NULL,
  `record_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'queued',
  `message` text COLLATE utf8mb4_unicode_ci,
  `started_at` timestamp NULL DEFAULT NULL,
  `failed_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bulk_action_records_bulk_action_id_foreign` (`bulk_action_id`),
  KEY `bulk_action_records_record_id_record_type_index` (`record_id`,`record_type`),
  CONSTRAINT `bulk_action_records_bulk_action_id_foreign` FOREIGN KEY (`bulk_action_id`) REFERENCES `bulk_actions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bulk_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bulk_actions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'queued',
  `job` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `total_records` bigint unsigned DEFAULT NULL,
  `data` json DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `dismissed_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `failed_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bulk_actions_user_id_foreign` (`user_id`),
  KEY `bulk_actions_type_identifier_index` (`type`,`identifier`),
  CONSTRAINT `bulk_actions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `calendar_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendar_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `all_day` tinyint(1) NOT NULL DEFAULT '0',
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calendar_events_user_id_foreign` (`user_id`),
  CONSTRAINT `calendar_events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `calendar_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendar_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `opening_hour_start` time DEFAULT NULL,
  `opening_hour_end` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `confirmation_sms` text COLLATE utf8mb4_unicode_ci,
  `confirmation_email` text COLLATE utf8mb4_unicode_ci,
  `calendar_weekends` tinyint(1) NOT NULL DEFAULT '0',
  `calendar_theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',
  `confirmation_sms_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmation_email_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telavox_jwt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calendar_timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Europe/Stockholm',
  PRIMARY KEY (`id`),
  KEY `calendar_settings_user_id_foreign` (`user_id`),
  CONSTRAINT `calendar_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `calling_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calling_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `call_sid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_seconds` int DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'initiated',
  `recording_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calling_logs_user_id_foreign` (`user_id`),
  KEY `calling_logs_call_sid_index` (`call_sid`),
  KEY `calling_logs_target_number_index` (`target_number`),
  KEY `calling_logs_started_at_index` (`started_at`),
  KEY `calling_logs_ended_at_index` (`ended_at`),
  KEY `calling_logs_status_index` (`status`),
  CONSTRAINT `calling_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `carry_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carry_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `person_lopnr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personnr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civilstand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `namn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fornamn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `efternamn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `co_adress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postnr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ort` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobiltelefon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epost_privat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epost_sekundar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_hus` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `is_phone` tinyint(1) DEFAULT NULL,
  `is_epost` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `category_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `categories_deleted_at_index` (`deleted_at`),
  KEY `categories_category_name_index` (`category_name`),
  KEY `categories_category_type_index` (`category_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `lang_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_translations_category_id_lang_code_unique` (`category_id`,`lang_code`),
  CONSTRAINT `categories_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `client_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_type` (
  `type_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`type_id`),
  KEY `client_type_type_name_index` (`type_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `client_type_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_type_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type_id` bigint unsigned NOT NULL,
  `lang_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_type_translations_type_id_lang_code_unique` (`type_id`,`lang_code`),
  CONSTRAINT `client_type_translations_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `client_type` (`type_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `client_types_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_types_relation` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned DEFAULT NULL,
  `type_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `client_types_relation_type_id_foreign` (`type_id`),
  KEY `client_types_relation_client_id_type_id_index` (`client_id`,`type_id`),
  CONSTRAINT `client_types_relation_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE SET NULL,
  CONSTRAINT `client_types_relation_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `client_type` (`type_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `client_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `clients_email_unique` (`email`),
  KEY `clients_client_fname_client_lname_index` (`client_fname`,`client_lname`),
  KEY `clients_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `clients_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `lang_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_translations_client_id_lang_code_unique` (`client_id`,`lang_code`),
  CONSTRAINT `clients_translations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `command_runs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `command_runs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `process_id` int unsigned DEFAULT NULL,
  `command` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ran_by` bigint unsigned DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `killed_at` timestamp NULL DEFAULT NULL,
  `exit_code` int unsigned DEFAULT NULL,
  `output` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `comment_reactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment_reactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint unsigned NOT NULL,
  `reactor_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reactor_id` bigint unsigned NOT NULL,
  `reaction` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_reactions_comment_id_foreign` (`comment_id`),
  KEY `comment_reactions_reactor_type_reactor_id_index` (`reactor_type`,`reactor_id`),
  CONSTRAINT `comment_reactions_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `comment_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subscribable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscribable_id` bigint unsigned NOT NULL,
  `subscriber_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscriber_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `commentions_subscriptions_unique` (`subscribable_type`,`subscribable_id`,`subscriber_type`,`subscriber_id`),
  KEY `comment_subscriptions_subscribable_type_subscribable_id_index` (`subscribable_type`,`subscribable_id`),
  KEY `comment_subscriptions_subscriber_type_subscriber_id_index` (`subscriber_type`,`subscriber_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `author_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` bigint unsigned NOT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint unsigned NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_author_type_author_id_index` (`author_type`,`author_id`),
  KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_automation_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_automation_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `automation_rule_id` bigint unsigned NOT NULL,
  `ticket_id` bigint unsigned NOT NULL,
  `trigger_event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conditions_met` json NOT NULL,
  `actions_performed` json NOT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `success` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ct_automation_logs_ticket_id_created_at_index` (`ticket_id`,`created_at`),
  KEY `ct_automation_logs_automation_rule_id_success_index` (`automation_rule_id`,`success`),
  CONSTRAINT `ct_automation_logs_automation_rule_id_foreign` FOREIGN KEY (`automation_rule_id`) REFERENCES `ct_automation_rules` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ct_automation_logs_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `ct_tickets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_automation_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_automation_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `trigger_event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trigger_conditions` json DEFAULT NULL,
  `conditions` json NOT NULL,
  `actions` json NOT NULL,
  `execution_order` int NOT NULL DEFAULT '0',
  `stop_processing` tinyint(1) NOT NULL DEFAULT '0',
  `times_triggered` int NOT NULL DEFAULT '0',
  `last_triggered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ct_automation_rules_is_active_trigger_event_index` (`is_active`,`trigger_event`),
  KEY `ct_automation_rules_execution_order_index` (`execution_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_department_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_department_forms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint unsigned NOT NULL,
  `form_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ct_department_forms_department_id_form_id_unique` (`department_id`,`form_id`),
  KEY `ct_department_forms_form_id_foreign` (`form_id`),
  CONSTRAINT `ct_department_forms_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `ct_departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ct_department_forms_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `ct_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_department_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_department_users` (
  `department_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'agent',
  `can_create_tickets` tinyint(1) NOT NULL DEFAULT '0',
  `can_view_all_tickets` tinyint(1) NOT NULL DEFAULT '0',
  `can_assign_tickets` tinyint(1) NOT NULL DEFAULT '0',
  `can_change_departments` tinyint(1) NOT NULL DEFAULT '0',
  `can_change_status` tinyint(1) NOT NULL DEFAULT '0',
  `can_change_priority` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete_tickets` tinyint(1) NOT NULL DEFAULT '0',
  `can_reply_to_tickets` tinyint(1) NOT NULL DEFAULT '0',
  `can_add_internal_notes` tinyint(1) NOT NULL DEFAULT '0',
  `can_view_internal_notes` tinyint(1) NOT NULL DEFAULT '0',
  `can_manage_automations` tinyint(1) NOT NULL DEFAULT '0',
  `can_view_automation_logs` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`department_id`,`user_id`),
  KEY `ct_department_users_user_id_foreign` (`user_id`),
  CONSTRAINT `ct_department_users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `ct_departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ct_department_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `visibility` enum('public','internal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ct_departments_name_unique` (`name`),
  UNIQUE KEY `ct_departments_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_form_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_form_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` json DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `help_text` text COLLATE utf8mb4_unicode_ci,
  `validation_rules` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ct_form_fields_form_id_foreign` (`form_id`),
  CONSTRAINT `ct_form_fields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `ct_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_forms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ct_forms_name_unique` (`name`),
  UNIQUE KEY `ct_forms_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_ticket_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_ticket_activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ct_ticket_activities_ticket_id_foreign` (`ticket_id`),
  KEY `ct_ticket_activities_user_id_foreign` (`user_id`),
  CONSTRAINT `ct_ticket_activities_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `ct_tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ct_ticket_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_ticket_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_ticket_replies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_internal_note` tinyint(1) NOT NULL DEFAULT '0',
  `is_seen` tinyint(1) NOT NULL DEFAULT '0',
  `seen_by` bigint unsigned DEFAULT NULL,
  `seen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ct_ticket_replies_ticket_id_foreign` (`ticket_id`),
  KEY `ct_ticket_replies_user_id_foreign` (`user_id`),
  KEY `ct_ticket_replies_seen_by_foreign` (`seen_by`),
  CONSTRAINT `ct_ticket_replies_seen_by_foreign` FOREIGN KEY (`seen_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ct_ticket_replies_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `ct_tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ct_ticket_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_ticket_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_ticket_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#84cc16',
  `is_default_for_new` tinyint(1) NOT NULL DEFAULT '0',
  `is_closing_status` tinyint(1) NOT NULL DEFAULT '0',
  `order_column` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ct_ticket_statuses_name_unique` (`name`),
  UNIQUE KEY `ct_ticket_statuses_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ct_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ct_tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `form_id` bigint unsigned DEFAULT NULL,
  `assignee_id` bigint unsigned DEFAULT NULL,
  `ticket_status_id` bigint unsigned NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'low',
  `custom_fields` json DEFAULT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT '0',
  `seen_by` bigint unsigned DEFAULT NULL,
  `seen_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ct_tickets_ticket_uid_unique` (`ticket_uid`),
  KEY `ct_tickets_user_id_foreign` (`user_id`),
  KEY `ct_tickets_department_id_foreign` (`department_id`),
  KEY `ct_tickets_assignee_id_foreign` (`assignee_id`),
  KEY `ct_tickets_ticket_status_id_foreign` (`ticket_status_id`),
  KEY `ct_tickets_seen_by_foreign` (`seen_by`),
  KEY `ct_tickets_form_id_foreign` (`form_id`),
  CONSTRAINT `ct_tickets_assignee_id_foreign` FOREIGN KEY (`assignee_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ct_tickets_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `ct_departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ct_tickets_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `ct_forms` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ct_tickets_seen_by_foreign` FOREIGN KEY (`seen_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ct_tickets_ticket_status_id_foreign` FOREIGN KEY (`ticket_status_id`) REFERENCES `ct_ticket_statuses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ct_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_config` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_config_group_key_unique` (`group`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discounts` (
  `discount_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(8,2) DEFAULT NULL,
  `fixed_amount` decimal(10,2) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`discount_id`),
  KEY `discounts_name_index` (`name`),
  KEY `discounts_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `eniro_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eniro_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personnamn` text COLLATE utf8mb4_unicode_ci,
  `alder` text COLLATE utf8mb4_unicode_ci,
  `kon` text COLLATE utf8mb4_unicode_ci,
  `gatuadress` text COLLATE utf8mb4_unicode_ci,
  `postnummer` text COLLATE utf8mb4_unicode_ci,
  `postort` text COLLATE utf8mb4_unicode_ci,
  `telefon` text COLLATE utf8mb4_unicode_ci,
  `karta` text COLLATE utf8mb4_unicode_ci,
  `link` text COLLATE utf8mb4_unicode_ci,
  `bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `bostadspris` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_telefon` tinyint(1) NOT NULL DEFAULT '0',
  `is_ratsit` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `event_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exports_user_id_foreign` (`user_id`),
  CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `filament_email_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filament_email_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint unsigned DEFAULT NULL,
  `from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bcc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_body` longtext COLLATE utf8mb4_unicode_ci,
  `html_body` longtext COLLATE utf8mb4_unicode_ci,
  `raw_body` longtext COLLATE utf8mb4_unicode_ci,
  `sent_debug_info` longtext COLLATE utf8mb4_unicode_ci,
  `attachments` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `filament_exceptions_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filament_exceptions_table` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line` int unsigned NOT NULL,
  `trace` json NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headers` json DEFAULT NULL,
  `cookies` json DEFAULT NULL,
  `body` json DEFAULT NULL,
  `query` json DEFAULT NULL,
  `route_context` json DEFAULT NULL,
  `route_parameters` json DEFAULT NULL,
  `markdown` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filament_exceptions_table_created_at_index` (`created_at`),
  KEY `filament_exceptions_table_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `file_system_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_system_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned DEFAULT NULL,
  `duration` int unsigned DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storage_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_system_items_parent_id_name_unique` (`parent_id`,`name`),
  KEY `file_system_items_type_index` (`type`),
  KEY `file_system_items_file_type_index` (`file_type`),
  CONSTRAINT `file_system_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `file_system_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `general_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `general_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_description` text COLLATE utf8mb4_unicode_ci,
  `site_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_analytics_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posthog_html_snippet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_metadata` json DEFAULT NULL,
  `email_settings` json DEFAULT NULL,
  `email_from_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_network` json DEFAULT NULL,
  `more_configs` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `hitta_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hitta_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personnamn` text COLLATE utf8mb4_unicode_ci,
  `alder` text COLLATE utf8mb4_unicode_ci,
  `kon` text COLLATE utf8mb4_unicode_ci,
  `gatuadress` text COLLATE utf8mb4_unicode_ci,
  `postnummer` text COLLATE utf8mb4_unicode_ci,
  `postort` text COLLATE utf8mb4_unicode_ci,
  `telefon` text COLLATE utf8mb4_unicode_ci,
  `telefonnummer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `karta` text COLLATE utf8mb4_unicode_ci,
  `link` text COLLATE utf8mb4_unicode_ci,
  `bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `bostadspris` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_telefon` tinyint(1) NOT NULL DEFAULT '0',
  `is_ratsit` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_hus` tinyint(1) NOT NULL DEFAULT '0',
  `telefonnumer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`id`),
  CONSTRAINT `hitta_data_chk_1` CHECK (json_valid(`telefonnummer`)),
  CONSTRAINT `hitta_data_chk_2` CHECK (json_valid(`telefonnumer`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `hitta_personer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hitta_personer` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personnamn` text COLLATE utf8mb4_unicode_ci,
  `alder` text COLLATE utf8mb4_unicode_ci,
  `kon` text COLLATE utf8mb4_unicode_ci,
  `gatuadress` text COLLATE utf8mb4_unicode_ci,
  `postnummer` text COLLATE utf8mb4_unicode_ci,
  `postort` text COLLATE utf8mb4_unicode_ci,
  `telefon` json DEFAULT NULL,
  `telefonnumer` json DEFAULT NULL,
  `karta` text COLLATE utf8mb4_unicode_ci,
  `link` text COLLATE utf8mb4_unicode_ci,
  `bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `bostadspris` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_telefon` tinyint(1) NOT NULL DEFAULT '0',
  `is_ratsit` tinyint(1) NOT NULL DEFAULT '0',
  `is_hus` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `hitta_se`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hitta_se` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personnamn` text COLLATE utf8mb4_unicode_ci,
  `alder` text COLLATE utf8mb4_unicode_ci,
  `kon` text COLLATE utf8mb4_unicode_ci,
  `gatuadress` text COLLATE utf8mb4_unicode_ci,
  `postnummer` text COLLATE utf8mb4_unicode_ci,
  `postort` text COLLATE utf8mb4_unicode_ci,
  `telefon` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `karta` text COLLATE utf8mb4_unicode_ci,
  `link` text COLLATE utf8mb4_unicode_ci,
  `bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `bostadspris` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_telefon` tinyint(1) NOT NULL DEFAULT '0',
  `is_ratsit` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_hus` tinyint(1) NOT NULL DEFAULT '0',
  `telefonnumer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`id`),
  CONSTRAINT `hitta_se_chk_1` CHECK (json_valid(`telefon`)),
  CONSTRAINT `hitta_se_chk_2` CHECK (json_valid(`telefonnumer`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `income_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `income_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `income_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `income_translations_income_id_lang_code_unique` (`income_id`,`lang_code`),
  CONSTRAINT `income_translations_income_id_foreign` FOREIGN KEY (`income_id`) REFERENCES `incomes` (`income_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `incomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incomes` (
  `income_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subcategory_id` bigint unsigned NOT NULL,
  `discount_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `final_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `next_payment` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`income_id`),
  KEY `incomes_discount_id_foreign` (`discount_id`),
  KEY `incomes_subcategory_id_foreign` (`subcategory_id`),
  KEY `incomes_client_id_status_index` (`client_id`,`status`),
  KEY `incomes_deleted_at_index` (`deleted_at`),
  KEY `incomes_status_index` (`status`),
  KEY `incomes_payment_type_index` (`payment_type`),
  KEY `incomes_next_payment_index` (`next_payment`),
  CONSTRAINT `incomes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE SET NULL,
  CONSTRAINT `incomes_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`discount_id`) ON DELETE CASCADE,
  CONSTRAINT `incomes_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`subcategory_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `invoice_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `income_id` bigint unsigned NOT NULL,
  `payment_id` bigint unsigned DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `issue_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `invoices_income_id_foreign` (`income_id`),
  KEY `invoices_payment_id_foreign` (`payment_id`),
  CONSTRAINT `invoices_income_id_foreign` FOREIGN KEY (`income_id`) REFERENCES `incomes` (`income_id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `completed_jobs` int NOT NULL DEFAULT '0',
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meetings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `starts_at` datetime NOT NULL,
  `ends_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `membership_team_id_user_id_unique` (`team_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `merinfo_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `merinfo_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personnamn` text COLLATE utf8mb4_unicode_ci,
  `alder` text COLLATE utf8mb4_unicode_ci,
  `kon` text COLLATE utf8mb4_unicode_ci,
  `gatuadress` text COLLATE utf8mb4_unicode_ci,
  `postnummer` text COLLATE utf8mb4_unicode_ci,
  `postort` text COLLATE utf8mb4_unicode_ci,
  `telefon` text COLLATE utf8mb4_unicode_ci,
  `telefonnummer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `telefoner` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `karta` text COLLATE utf8mb4_unicode_ci,
  `link` text COLLATE utf8mb4_unicode_ci,
  `bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `bostadspris` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_telefon` tinyint(1) NOT NULL DEFAULT '0',
  `is_ratsit` tinyint(1) NOT NULL DEFAULT '0',
  `is_hus` tinyint(1) NOT NULL DEFAULT '0',
  `merinfo_personer_total` int DEFAULT NULL,
  `merinfo_foretag_total` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `merinfo_personer_count` int DEFAULT '0',
  `merinfo_personer_queue` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `merinfo_person_gata_unique` (`personnamn`(191),`gatuadress`(191)),
  CONSTRAINT `merinfo_data_chk_1` CHECK (json_valid(`telefonnummer`)),
  CONSTRAINT `merinfo_data_chk_2` CHECK (json_valid(`telefoner`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `merinfos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `merinfos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `givenNameOrFirstName` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personalNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pnr` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_celebrity` tinyint(1) NOT NULL DEFAULT '0',
  `has_company_engagement` tinyint(1) NOT NULL DEFAULT '0',
  `number_plus_count` int NOT NULL DEFAULT '0',
  `phone_number` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `same_address_url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merinfos_short_uuid_index` (`short_uuid`),
  KEY `merinfos_personalnumber_index` (`personalNumber`),
  KEY `merinfos_type_index` (`type`),
  CONSTRAINT `merinfos_chk_1` CHECK (json_valid(`pnr`)),
  CONSTRAINT `merinfos_chk_2` CHECK (json_valid(`address`)),
  CONSTRAINT `merinfos_chk_3` CHECK (json_valid(`phone_number`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` json NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifier_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifier_channels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notifier_channels_type_unique` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifier_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifier_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notifier_events_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifier_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifier_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `notification_template_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `channel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `opened_at` timestamp NULL DEFAULT NULL,
  `clicked_at` timestamp NULL DEFAULT NULL,
  `opens_count` int unsigned NOT NULL DEFAULT '0',
  `clicks_count` int unsigned NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `error` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifier_notifications_notification_template_id_foreign` (`notification_template_id`),
  KEY `notifier_notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifier_notifications_notification_template_id_foreign` FOREIGN KEY (`notification_template_id`) REFERENCES `notifier_templates` (`id`),
  CONSTRAINT `notifier_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifier_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifier_preferences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `notification_event_id` bigint unsigned NOT NULL,
  `channels` json NOT NULL,
  `settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notifier_preferences_user_id_notification_event_id_unique` (`user_id`,`notification_event_id`),
  KEY `notifier_preferences_notification_event_id_foreign` (`notification_event_id`),
  CONSTRAINT `notifier_preferences_notification_event_id_foreign` FOREIGN KEY (`notification_event_id`) REFERENCES `notifier_events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifier_preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifier_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifier_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notifier_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifier_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifier_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `variables` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifier_templates_event_key_foreign` (`event_key`),
  CONSTRAINT `notifier_templates_event_key_foreign` FOREIGN KEY (`event_key`) REFERENCES `notifier_events` (`key`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_uris` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `grant_types` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_device_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_device_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_code` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  KEY `oauth_device_codes_user_id_index` (`user_id`),
  KEY `oauth_device_codes_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `outcome_delay_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `outcome_delay_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `outcome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delay_minutes` int NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `max_retry_count` int NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  UNIQUE KEY `outcome_delay_settings_outcome_unique` (`outcome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `outcome_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `outcome_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `outcome` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delay_minutes` int DEFAULT NULL,
  `max_retry_count` int DEFAULT NULL,
  `retry` tinyint(1) NOT NULL DEFAULT '0',
  `quarantine` tinyint(1) NOT NULL DEFAULT '0',
  `quarantine_days` int unsigned NOT NULL DEFAULT '0',
  `dmc` tinyint(1) NOT NULL DEFAULT '0',
  `aterkom` tinyint(1) NOT NULL DEFAULT '0',
  `order` int unsigned NOT NULL DEFAULT '0',
  `bokad` tinyint(1) NOT NULL DEFAULT '0',
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `outcome_settings_type_unique` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `outcome_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `outcome_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `outcome_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `outcome_translations_outcome_id_lang_code_unique` (`outcome_id`,`lang_code`),
  CONSTRAINT `outcome_translations_outcome_id_foreign` FOREIGN KEY (`outcome_id`) REFERENCES `outcomes` (`outcome_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `outcomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `outcomes` (
  `outcome_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subcategory_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`outcome_id`),
  KEY `outcomes_subcategory_id_date_index` (`subcategory_id`,`date`),
  KEY `outcomes_deleted_at_index` (`deleted_at`),
  CONSTRAINT `outcomes_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`subcategory_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `panel_accesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `panel_accesses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `panel_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_access` json NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'partner',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_fields` json DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `passport_scope_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `passport_scope_actions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passport_scope_actions_name_unique` (`name`),
  KEY `passport_scope_actions_resource_id_foreign` (`resource_id`),
  CONSTRAINT `passport_scope_actions_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `passport_scope_resources` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `passport_scope_grants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `passport_scope_grants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `context_client_id` bigint unsigned DEFAULT NULL,
  `resource_id` bigint unsigned NOT NULL,
  `action_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passport_scope_grant_unique` (`tokenable_type`,`tokenable_id`,`resource_id`,`action_id`,`context_client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `passport_scope_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `passport_scope_resources` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passport_scope_resources_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payment_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_translations_payment_id_lang_code_unique` (`payment_id`,`lang_code`),
  CONSTRAINT `payment_translations_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `payment_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `income_id` bigint unsigned NOT NULL,
  `discount_id` bigint unsigned DEFAULT NULL,
  `payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_priority` tinyint(1) NOT NULL DEFAULT '0',
  `next_payment` date DEFAULT NULL,
  `paid_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `payments_discount_id_foreign` (`discount_id`),
  KEY `payments_income_id_status_index` (`income_id`,`status`),
  KEY `payments_deleted_at_index` (`deleted_at`),
  KEY `payments_status_index` (`status`),
  KEY `payments_next_payment_index` (`next_payment`),
  CONSTRAINT `payments_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`discount_id`) ON DELETE CASCADE,
  CONSTRAINT `payments_income_id_foreign` FOREIGN KEY (`income_id`) REFERENCES `incomes` (`income_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `post_nums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_nums` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_nummer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_ort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_lan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merinfo_personer_total` int DEFAULT NULL,
  `merinfo_personer_phone_total` int DEFAULT NULL,
  `merinfo_personer_house_total` int DEFAULT NULL,
  `merinfo_foretag_total` int DEFAULT NULL,
  `merinfo_foretag_phone_total` int DEFAULT NULL,
  `merinfo_personer_saved` int DEFAULT NULL,
  `merinfo_personer_phone_saved` int DEFAULT NULL,
  `merinfo_personer_house_saved` int DEFAULT NULL,
  `merinfo_foretag_saved` int DEFAULT NULL,
  `merinfo_foretag_phone_saved` int DEFAULT NULL,
  `hitta_personer_total` int DEFAULT NULL,
  `hitta_foretag_total` int DEFAULT NULL,
  `hitta_personer_saved` int DEFAULT NULL,
  `hitta_personer_phone_saved` int DEFAULT NULL,
  `hitta_personer_house_saved` int DEFAULT NULL,
  `hitta_foretag_saved` int DEFAULT NULL,
  `ratsit_personer_total` int DEFAULT NULL,
  `ratsit_foretag_total` int DEFAULT NULL,
  `ratsit_personer_saved` int DEFAULT NULL,
  `ratsit_foretag_saved` int DEFAULT NULL,
  `ratsit_personer_phone_saved` int DEFAULT NULL,
  `ratsit_personer_house_saved` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'idle',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_personer_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_foretag_active` tinyint(1) NOT NULL DEFAULT '1',
  `merinfo_personer_queue` tinyint(1) NOT NULL DEFAULT '0',
  `merinfo_foretag_queue` tinyint(1) NOT NULL DEFAULT '0',
  `merinfo_personer_count` tinyint(1) NOT NULL DEFAULT '0',
  `merinfo_foretag_count` tinyint(1) NOT NULL DEFAULT '0',
  `hitta_personer_queue` tinyint(1) NOT NULL DEFAULT '0',
  `hitta_postort_total_pages` int DEFAULT NULL,
  `hitta_postort_processed_pages` int NOT NULL DEFAULT '0',
  `hitta_postort_last_page` int DEFAULT NULL,
  `hitta_foretag_queue` tinyint(1) NOT NULL DEFAULT '0',
  `ratsit_personer_queue` tinyint(1) NOT NULL DEFAULT '0',
  `ratsit_foretag_queue` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hitta_personer_phone_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_nums_post_ort_index` (`post_ort`),
  KEY `post_nums_post_nummer_index` (`post_nummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `postnummer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `postnummer` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_nummer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_ort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_lan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merinfo_personer_total` int DEFAULT NULL,
  `merinfo_personer_phone_total` int DEFAULT NULL,
  `merinfo_personer_house_total` int DEFAULT NULL,
  `merinfo_foretag_total` int DEFAULT NULL,
  `merinfo_foretag_phone_total` int DEFAULT NULL,
  `merinfo_personer_saved` int DEFAULT NULL,
  `merinfo_personer_phone_saved` int DEFAULT NULL,
  `merinfo_personer_house_saved` int DEFAULT NULL,
  `merinfo_foretag_saved` int DEFAULT NULL,
  `merinfo_foretag_phone_saved` int DEFAULT NULL,
  `hitta_personer_total` int DEFAULT NULL,
  `hitta_foretag_total` int DEFAULT NULL,
  `hitta_personer_saved` int DEFAULT NULL,
  `hitta_personer_phone_saved` int DEFAULT NULL,
  `hitta_personer_house_saved` int DEFAULT NULL,
  `hitta_foretag_saved` int DEFAULT NULL,
  `ratsit_personer_total` int DEFAULT NULL,
  `ratsit_foretag_total` int DEFAULT NULL,
  `ratsit_personer_saved` int DEFAULT NULL,
  `ratsit_foretag_saved` int DEFAULT NULL,
  `ratsit_personer_phone_saved` int DEFAULT NULL,
  `ratsit_personer_house_saved` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'idle',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_personer_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_foretag_active` tinyint(1) NOT NULL DEFAULT '1',
  `merinfo_personer_queue` tinyint(1) NOT NULL DEFAULT '0',
  `merinfo_foretag_queue` tinyint(1) NOT NULL DEFAULT '0',
  `merinfo_personer_count` tinyint(1) NOT NULL DEFAULT '0',
  `merinfo_foretag_count` tinyint(1) NOT NULL DEFAULT '0',
  `hitta_personer_queue` tinyint(1) NOT NULL DEFAULT '0',
  `hitta_foretag_queue` tinyint(1) NOT NULL DEFAULT '0',
  `ratsit_personer_queue` tinyint(1) NOT NULL DEFAULT '0',
  `ratsit_foretag_queue` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `postnummer_post_ort_index` (`post_ort`),
  KEY `postnummer_post_nummer_index` (`post_nummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `private_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `private_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gatuadress` text COLLATE utf8mb4_unicode_ci,
  `postnummer` text COLLATE utf8mb4_unicode_ci,
  `postort` text COLLATE utf8mb4_unicode_ci,
  `forsamling` text COLLATE utf8mb4_unicode_ci,
  `kommun` text COLLATE utf8mb4_unicode_ci,
  `lan` text COLLATE utf8mb4_unicode_ci,
  `adressandring` text COLLATE utf8mb4_unicode_ci,
  `bo_gatuadress` text COLLATE utf8mb4_unicode_ci,
  `bo_postnummer` text COLLATE utf8mb4_unicode_ci,
  `bo_postort` text COLLATE utf8mb4_unicode_ci,
  `bo_forsamling` text COLLATE utf8mb4_unicode_ci,
  `bo_kommun` text COLLATE utf8mb4_unicode_ci,
  `bo_lan` text COLLATE utf8mb4_unicode_ci,
  `telfonnummer` json DEFAULT NULL,
  `telefon` json DEFAULT NULL,
  `stjarntacken` text COLLATE utf8mb4_unicode_ci,
  `fodelsedag` text COLLATE utf8mb4_unicode_ci,
  `personnummer` text COLLATE utf8mb4_unicode_ci,
  `alder` text COLLATE utf8mb4_unicode_ci,
  `kon` text COLLATE utf8mb4_unicode_ci,
  `civilstand` text COLLATE utf8mb4_unicode_ci,
  `fornamn` text COLLATE utf8mb4_unicode_ci,
  `efternamn` text COLLATE utf8mb4_unicode_ci,
  `personnamn` text COLLATE utf8mb4_unicode_ci,
  `ps_fodelsedag` text COLLATE utf8mb4_unicode_ci,
  `ps_personnummer` text COLLATE utf8mb4_unicode_ci,
  `ps_alder` text COLLATE utf8mb4_unicode_ci,
  `ps_kon` text COLLATE utf8mb4_unicode_ci,
  `ps_civilstand` text COLLATE utf8mb4_unicode_ci,
  `ps_fornamn` text COLLATE utf8mb4_unicode_ci,
  `ps_efternamn` text COLLATE utf8mb4_unicode_ci,
  `ps_personnamn` text COLLATE utf8mb4_unicode_ci,
  `ps_telefon` json DEFAULT NULL,
  `ps_epost_adress` json DEFAULT NULL,
  `ps_bolagsengagemang` json DEFAULT NULL,
  `agandeform` text COLLATE utf8mb4_unicode_ci,
  `bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `boarea` text COLLATE utf8mb4_unicode_ci,
  `byggar` text COLLATE utf8mb4_unicode_ci,
  `bo_agandeform` text COLLATE utf8mb4_unicode_ci,
  `bo_bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `bo_boarea` text COLLATE utf8mb4_unicode_ci,
  `bo_byggar` text COLLATE utf8mb4_unicode_ci,
  `bo_fastighet` text COLLATE utf8mb4_unicode_ci,
  `fastighet` text COLLATE utf8mb4_unicode_ci,
  `personer` json DEFAULT NULL,
  `foretag` json DEFAULT NULL,
  `grannar` json DEFAULT NULL,
  `fordon` json DEFAULT NULL,
  `hundar` json DEFAULT NULL,
  `bolagsengagemang` json DEFAULT NULL,
  `epost_adress` json DEFAULT NULL,
  `bo_personer` int DEFAULT NULL,
  `bo_foretag` int DEFAULT NULL,
  `bo_grannar` json DEFAULT NULL,
  `bo_fordon` json DEFAULT NULL,
  `bo_hundar` json DEFAULT NULL,
  `longitude` text COLLATE utf8mb4_unicode_ci,
  `latitud` text COLLATE utf8mb4_unicode_ci,
  `google_maps` text COLLATE utf8mb4_unicode_ci,
  `google_streetview` text COLLATE utf8mb4_unicode_ci,
  `ratsit_link` text COLLATE utf8mb4_unicode_ci,
  `bo_longitude` text COLLATE utf8mb4_unicode_ci,
  `bo_latitud` text COLLATE utf8mb4_unicode_ci,
  `hitta_link` text COLLATE utf8mb4_unicode_ci,
  `hitta_karta` text COLLATE utf8mb4_unicode_ci,
  `bostad_typ` text COLLATE utf8mb4_unicode_ci,
  `bostad_pris` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_update` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pulse_aggregates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pulse_aggregates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bucket` int unsigned NOT NULL,
  `period` mediumint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `aggregate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(20,2) NOT NULL,
  `count` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pulse_aggregates_bucket_period_type_aggregate_key_hash_unique` (`bucket`,`period`,`type`,`aggregate`,`key_hash`),
  KEY `pulse_aggregates_period_bucket_index` (`period`,`bucket`),
  KEY `pulse_aggregates_type_index` (`type`),
  KEY `pulse_aggregates_period_type_aggregate_bucket_index` (`period`,`type`,`aggregate`,`bucket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pulse_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pulse_entries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pulse_entries_timestamp_index` (`timestamp`),
  KEY `pulse_entries_type_index` (`type`),
  KEY `pulse_entries_key_hash_index` (`key_hash`),
  KEY `pulse_entries_timestamp_type_key_hash_value_index` (`timestamp`,`type`,`key_hash`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pulse_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pulse_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pulse_values_type_key_hash_unique` (`type`,`key_hash`),
  KEY `pulse_values_timestamp_index` (`timestamp`),
  KEY `pulse_values_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ratsit_adresser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratsit_adresser` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_ort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_nummer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gatuadress_namn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personer_count` int NOT NULL DEFAULT '0',
  `foretag_count` int NOT NULL DEFAULT '0',
  `personer_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foretag_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratsit_adresser_unique_key` (`post_ort`,`post_nummer`,`gatuadress_namn`),
  KEY `ratsit_adresser_post_ort_index` (`post_ort`),
  KEY `ratsit_adresser_post_nummer_index` (`post_nummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ratsit_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratsit_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gatuadress` text COLLATE utf8mb4_unicode_ci,
  `postnummer` text COLLATE utf8mb4_unicode_ci,
  `postort` text COLLATE utf8mb4_unicode_ci,
  `forsamling` text COLLATE utf8mb4_unicode_ci,
  `kommun` text COLLATE utf8mb4_unicode_ci,
  `lan` text COLLATE utf8mb4_unicode_ci,
  `adressandring` text COLLATE utf8mb4_unicode_ci,
  `telfonnummer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `stjarntacken` text COLLATE utf8mb4_unicode_ci,
  `fodelsedag` text COLLATE utf8mb4_unicode_ci,
  `personnummer` text COLLATE utf8mb4_unicode_ci,
  `alder` text COLLATE utf8mb4_unicode_ci,
  `kon` text COLLATE utf8mb4_unicode_ci,
  `civilstand` text COLLATE utf8mb4_unicode_ci,
  `fornamn` text COLLATE utf8mb4_unicode_ci,
  `efternamn` text COLLATE utf8mb4_unicode_ci,
  `personnamn` text COLLATE utf8mb4_unicode_ci,
  `telefon` text COLLATE utf8mb4_unicode_ci,
  `epost_adress` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `agandeform` text COLLATE utf8mb4_unicode_ci,
  `bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `boarea` text COLLATE utf8mb4_unicode_ci,
  `byggar` text COLLATE utf8mb4_unicode_ci,
  `fastighet` text COLLATE utf8mb4_unicode_ci,
  `personer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `foretag` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `grannar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `fordon` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `hundar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `bolagsengagemang` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `longitude` text COLLATE utf8mb4_unicode_ci,
  `latitud` text COLLATE utf8mb4_unicode_ci,
  `google_maps` text COLLATE utf8mb4_unicode_ci,
  `google_streetview` text COLLATE utf8mb4_unicode_ci,
  `ratsit_se` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_hus` tinyint(1) NOT NULL DEFAULT '0',
  `is_telefon` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kommun_ratsit` text COLLATE utf8mb4_unicode_ci,
  `is_queued` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_gatuadress_personnamn` (`gatuadress`(255),`personnamn`(255)),
  CONSTRAINT `ratsit_data_chk_1` CHECK (json_valid(`telfonnummer`)),
  CONSTRAINT `ratsit_data_chk_2` CHECK (json_valid(`epost_adress`)),
  CONSTRAINT `ratsit_data_chk_3` CHECK (json_valid(`personer`)),
  CONSTRAINT `ratsit_data_chk_4` CHECK (json_valid(`foretag`)),
  CONSTRAINT `ratsit_data_chk_5` CHECK (json_valid(`grannar`)),
  CONSTRAINT `ratsit_data_chk_6` CHECK (json_valid(`fordon`)),
  CONSTRAINT `ratsit_data_chk_7` CHECK (json_valid(`hundar`)),
  CONSTRAINT `ratsit_data_chk_8` CHECK (json_valid(`bolagsengagemang`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ratsit_kommuner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratsit_kommuner` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kommun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personer_count` int NOT NULL DEFAULT '0',
  `foretag_count` int NOT NULL DEFAULT '0',
  `personer_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personer_postorter` int NOT NULL DEFAULT '0',
  `foretag_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foretag_postorter` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratsit_kommuner_kommun_unique` (`kommun`),
  KEY `ratsit_kommuner_kommun_index` (`kommun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ratsit_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratsit_persons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `scraped_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratsit_persons_name_postal_code_street_unique` (`name`,`postal_code`,`street`),
  KEY `ratsit_persons_postal_code_index` (`postal_code`),
  KEY `ratsit_persons_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ratsit_postorter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratsit_postorter` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_ort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_nummer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personer_count` int NOT NULL DEFAULT '0',
  `foretag_count` int NOT NULL DEFAULT '0',
  `personer_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personer_link_status` tinyint(1) NOT NULL DEFAULT '0',
  `foretag_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personer_kommun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foretag_kommun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foretag_link_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratsit_postorter_unique_key` (`post_ort`,`post_nummer`),
  KEY `ratsit_postorter_post_ort_index` (`post_ort`),
  KEY `ratsit_postorter_post_nummer_index` (`post_nummer`),
  KEY `ratsit_postorter_personer_kommun_index` (`personer_kommun`),
  KEY `ratsit_postorter_foretag_kommun_index` (`foretag_kommun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ratsit_streets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratsit_streets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `street_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `person_count` int NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `scraped_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratsit_streets_street_name_postal_code_unique` (`street_name`,`postal_code`),
  KEY `ratsit_streets_postal_code_index` (`postal_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ringa_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ringa_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gatuadress` text COLLATE utf8mb4_unicode_ci,
  `postnummer` text COLLATE utf8mb4_unicode_ci,
  `postort` text COLLATE utf8mb4_unicode_ci,
  `forsamling` text COLLATE utf8mb4_unicode_ci,
  `kommun` text COLLATE utf8mb4_unicode_ci,
  `kommun_ratsit` text COLLATE utf8mb4_unicode_ci,
  `lan` text COLLATE utf8mb4_unicode_ci,
  `adressandring` text COLLATE utf8mb4_unicode_ci,
  `telfonnummer` json DEFAULT NULL,
  `stjarntacken` text COLLATE utf8mb4_unicode_ci,
  `fodelsedag` text COLLATE utf8mb4_unicode_ci,
  `personnummer` text COLLATE utf8mb4_unicode_ci,
  `alder` text COLLATE utf8mb4_unicode_ci,
  `kon` text COLLATE utf8mb4_unicode_ci,
  `civilstand` text COLLATE utf8mb4_unicode_ci,
  `fornamn` text COLLATE utf8mb4_unicode_ci,
  `efternamn` text COLLATE utf8mb4_unicode_ci,
  `personnamn` text COLLATE utf8mb4_unicode_ci,
  `telefon` text COLLATE utf8mb4_unicode_ci,
  `epost_adress` json DEFAULT NULL,
  `agandeform` text COLLATE utf8mb4_unicode_ci,
  `bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `boarea` text COLLATE utf8mb4_unicode_ci,
  `byggar` text COLLATE utf8mb4_unicode_ci,
  `fastighet` text COLLATE utf8mb4_unicode_ci,
  `personer` json DEFAULT NULL,
  `foretag` json DEFAULT NULL,
  `grannar` json DEFAULT NULL,
  `fordon` json DEFAULT NULL,
  `hundar` json DEFAULT NULL,
  `bolagsengagemang` json DEFAULT NULL,
  `longitude` text COLLATE utf8mb4_unicode_ci,
  `latitud` text COLLATE utf8mb4_unicode_ci,
  `google_maps` text COLLATE utf8mb4_unicode_ci,
  `google_streetview` text COLLATE utf8mb4_unicode_ci,
  `ratsit_se` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_hus` tinyint(1) NOT NULL DEFAULT '0',
  `is_telefon` tinyint(1) NOT NULL DEFAULT '0',
  `is_queued` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `outcome` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `outcome_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_outcome` tinyint(1) NOT NULL DEFAULT '0',
  `attempts` int NOT NULL DEFAULT '0',
  `booking_id` bigint unsigned DEFAULT NULL,
  `calendar_id` bigint unsigned DEFAULT NULL,
  `booked_at` timestamp NULL DEFAULT NULL,
  `aterkom_at` timestamp NULL DEFAULT NULL,
  `available_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` text COLLATE utf8mb4_unicode_ci,
  `service_user_id` text COLLATE utf8mb4_unicode_ci,
  `started_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `team_id` bigint unsigned DEFAULT NULL,
  `retry_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ringa_data_team_id_foreign` (`team_id`),
  CONSTRAINT `ringa_data_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `schedule_periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedule_periods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ulid` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'service',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_first` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_last` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_private` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_private` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_fields` json DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_ulid_unique` (`ulid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `payload` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_group_name_unique` (`group`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sprints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sprints` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `starts_at` datetime NOT NULL,
  `ends_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcategories` (
  `subcategory_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sub_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`subcategory_id`),
  KEY `subcategories_category_id_foreign` (`category_id`),
  KEY `subcategories_deleted_at_index` (`deleted_at`),
  KEY `subcategories_sub_name_index` (`sub_name`),
  CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `subcategories_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcategories_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory_id` bigint unsigned NOT NULL,
  `sub_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subcategories_translations_subcategory_id_lang_code_unique` (`subcategory_id`,`lang_code`),
  CONSTRAINT `subcategories_translations_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`subcategory_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `supers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'super',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_fields` json DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supers_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `table_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `resource` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `styles` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `taggables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taggables` (
  `tag_id` bigint unsigned NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taggable_id` bigint unsigned NOT NULL,
  UNIQUE KEY `taggables_tag_id_taggable_id_taggable_type_unique` (`tag_id`,`taggable_id`,`taggable_type`),
  KEY `taggables_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`),
  CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` json NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_column` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `team_invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_invitations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_invitations_team_id_email_unique` (`team_id`,`email`),
  CONSTRAINT `team_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ulid` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_team` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teams_ulid_unique` (`ulid`),
  KEY `teams_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `upplysning_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `upplysning_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personnamn` text COLLATE utf8mb4_unicode_ci,
  `alder` text COLLATE utf8mb4_unicode_ci,
  `kon` text COLLATE utf8mb4_unicode_ci,
  `gatuadress` text COLLATE utf8mb4_unicode_ci,
  `postnummer` text COLLATE utf8mb4_unicode_ci,
  `postort` text COLLATE utf8mb4_unicode_ci,
  `telefon` text COLLATE utf8mb4_unicode_ci,
  `karta` text COLLATE utf8mb4_unicode_ci,
  `link` text COLLATE utf8mb4_unicode_ci,
  `bostadstyp` text COLLATE utf8mb4_unicode_ci,
  `bostadspris` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_telefon` tinyint(1) NOT NULL DEFAULT '0',
  `is_ratsit` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_has_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_has_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'pusher',
  `provider_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_read_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_read_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `notification_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `open` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_read_notifications_notification_id_foreign` (`notification_id`),
  CONSTRAINT `user_read_notifications_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_types_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_widget_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_widget_preferences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `widget_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL,
  `show_widget` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_widget_preferences_user_id_widget_name_unique` (`user_id`,`widget_name`),
  CONSTRAINT `user_widget_preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `author_id` bigint unsigned DEFAULT NULL,
  `assigned_to_id` bigint unsigned DEFAULT NULL,
  `ulid` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `type_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_first` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_last` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_private` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_private` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_fields` json DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'offline',
  `active_at` timestamp NULL DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ui_preferences` json DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_ulid_unique` (`ulid`),
  KEY `users_type_id_foreign` (`type_id`),
  KEY `users_author_id_foreign` (`author_id`),
  KEY `users_assigned_to_id_foreign` (`assigned_to_id`),
  CONSTRAINT `users_assigned_to_id_foreign` FOREIGN KEY (`assigned_to_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `user_types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `whatsapp_agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_agents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `whatsapp_instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_instances` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reject_call` tinyint(1) NOT NULL DEFAULT '0',
  `msg_call` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groups_ignore` tinyint(1) NOT NULL DEFAULT '0',
  `always_online` tinyint(1) NOT NULL DEFAULT '0',
  `read_messages` tinyint(1) NOT NULL DEFAULT '0',
  `read_status` tinyint(1) NOT NULL DEFAULT '0',
  `sync_full_history` tinyint(1) NOT NULL DEFAULT '0',
  `count` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pairing_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code` longtext COLLATE utf8mb4_unicode_ci,
  `qr_code_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whatsapp_instances_name_index` (`name`),
  KEY `whatsapp_instances_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `whatsapp_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_messages` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remote_jid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `content` text COLLATE utf8mb4_unicode_ci,
  `media` json DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `raw_payload` json DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whatsapp_messages_instance_id_phone_index` (`instance_id`,`phone`),
  KEY `whatsapp_messages_instance_id_created_at_index` (`instance_id`,`created_at`),
  KEY `whatsapp_messages_direction_index` (`direction`),
  KEY `whatsapp_messages_status_index` (`status`),
  KEY `whatsapp_messages_message_id_index` (`message_id`),
  CONSTRAINT `whatsapp_messages_instance_id_foreign` FOREIGN KEY (`instance_id`) REFERENCES `whatsapp_instances` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `whatsapp_webhooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_webhooks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `instance_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` json NOT NULL,
  `processed` tinyint(1) NOT NULL DEFAULT '0',
  `error` text COLLATE utf8mb4_unicode_ci,
  `processing_time_ms` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whatsapp_webhooks_instance_id_foreign` (`instance_id`),
  KEY `whatsapp_webhooks_event_processed_index` (`event`,`processed`),
  KEY `whatsapp_webhooks_created_at_index` (`created_at`),
  CONSTRAINT `whatsapp_webhooks_instance_id_foreign` FOREIGN KEY (`instance_id`) REFERENCES `whatsapp_instances` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wirechat_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wirechat_actions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `actionable_id` bigint unsigned NOT NULL,
  `actionable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actor_id` bigint unsigned NOT NULL,
  `actor_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Some additional information about the action',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wirechat_actions_actionable_id_actionable_type_index` (`actionable_id`,`actionable_type`),
  KEY `wirechat_actions_actor_id_actor_type_index` (`actor_id`,`actor_type`),
  KEY `wirechat_actions_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wirechat_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wirechat_attachments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attachable_id` bigint unsigned NOT NULL,
  `attachable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wirechat_attachments_attachable_id_attachable_type_index` (`attachable_id`,`attachable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wirechat_conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wirechat_conversations` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Private is 1-1 , group or channel',
  `disappearing_started_at` timestamp NULL DEFAULT NULL,
  `disappearing_duration` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wirechat_conversations_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wirechat_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wirechat_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'private',
  `allow_members_to_send_messages` tinyint(1) NOT NULL DEFAULT '1',
  `allow_members_to_add_others` tinyint(1) NOT NULL DEFAULT '1',
  `allow_members_to_edit_group_info` tinyint(1) NOT NULL DEFAULT '0',
  `admins_must_approve_new_members` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'when turned on, admins must approve anyone who wants to join group',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wirechat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wirechat_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sendable_id` bigint unsigned NOT NULL,
  `sendable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_id` bigint unsigned DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `kept_at` timestamp NULL DEFAULT NULL COMMENT 'filled when a message is kept from disappearing',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wirechat_messages_reply_id_foreign` (`reply_id`),
  KEY `wirechat_messages_conversation_id_index` (`conversation_id`),
  KEY `wirechat_messages_sendable_id_sendable_type_index` (`sendable_id`,`sendable_type`),
  CONSTRAINT `wirechat_messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `wirechat_conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wirechat_messages_reply_id_foreign` FOREIGN KEY (`reply_id`) REFERENCES `wirechat_messages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wirechat_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wirechat_participants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `participantable_id` bigint unsigned NOT NULL,
  `participantable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exited_at` timestamp NULL DEFAULT NULL,
  `last_active_at` timestamp NULL DEFAULT NULL,
  `conversation_cleared_at` timestamp NULL DEFAULT NULL,
  `conversation_deleted_at` timestamp NULL DEFAULT NULL,
  `conversation_read_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conv_part_id_type_unique` (`conversation_id`,`participantable_id`,`participantable_type`),
  KEY `wirechat_participants_role_index` (`role`),
  KEY `wirechat_participants_exited_at_index` (`exited_at`),
  KEY `wirechat_participants_conversation_cleared_at_index` (`conversation_cleared_at`),
  KEY `wirechat_participants_conversation_deleted_at_index` (`conversation_deleted_at`),
  KEY `wirechat_participants_conversation_read_at_index` (`conversation_read_at`),
  CONSTRAINT `wirechat_participants_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `wirechat_conversations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0000_00_00_024836_create_user_types_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'0001_01_01_000001_create_supers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'0001_01_01_000002_create_admins_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'0001_01_01_000003_create_partners_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'0001_01_01_000004_create_services_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'0001_01_01_000005_create_teams_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'0001_01_01_000006_create_membership_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'0001_01_01_000007_create_team_invitations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'0001_01_01_000010_create_notifications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2000_01_01_005619_create_booking_customers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2022_01_01_005621_create_booking_orders_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2022_05_29_032309_create_user_has_notifications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2022_05_29_032652_create_user_read_notifications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2023_01_01_005616_create_booking_brands_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2023_01_01_005623_create_tag_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2024_01_02_100000_create_booking_outcall_queues_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2024_11_01_000001_create_wirechat_conversations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2024_11_01_000002_create_wirechat_attachments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2024_11_01_000003_create_wirechat_messages_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2024_11_01_000004_create_wirechat_participants_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2024_11_01_000006_create_wirechat_actions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2024_11_01_000007_create_wirechat_groups_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2025_02_19_154211_create_notification_channels_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2025_02_19_154225_create_notification_events_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2025_02_19_154251_create_notification_templates',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2025_02_19_154304_create_notification_preferences',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2025_02_19_154314_create_notifications',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2025_02_20_000000_add_settings_to_notification_events_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2025_02_23_104342_create_notification_settings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2025_02_24_000000_add_analytics_to_notifications',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2025_10_09_001423_create_command_runs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2025_10_16_062805_create_calendar_events_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2025_11_15_200002_create_hitta_se_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2025_11_15_200005_create_private_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2025_11_15_200038_create_ratsit_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2025_11_15_200041_create_hitta_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2025_11_15_200046_create_eniro_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2025_11_15_200047_create_upplysning_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2025_11_16_192901_create_post_nums_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2025_11_17_043920_add_name_to_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2025_11_17_054437_change_telefon_column_to_text_in_ratsit_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2025_11_17_062223_add_kommun_ratsit_column_to_ratsit_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2025_11_17_065607_add_is_hus_column_to_hitta_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2025_11_17_065614_add_is_hus_column_to_hitta_se_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2025_11_26_011928_add_telefonnumer_column_to_hitta_se_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2025_11_26_011938_add_telefonnumer_column_to_hitta_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2025_11_26_020759_add_is_queued_column_to_ratsit_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2025_11_26_043300_add_completed_jobs_column_to_job_batches_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2025_11_26_094717_add_status_to_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2025_11_26_094717_add_status_to_tasks_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2025_11_26_094726_add_status_to_job_batches_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2025_11_28_000001_create_ratsit_adresser_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2025_11_28_000002_create_ratsit_postorter_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2025_11_28_000003_create_ratsit_kommuner_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2025_11_28_121423_fix_ratsit_kommuner_duplicate_names',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (59,'2025_11_28_161900_add_hitta_postort_progress_to_post_nums',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (60,'2025_12_04_024548_add_telefonnummer_json_to_hitta_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (61,'2025_12_04_034057_add_postorter_columns_to_ratsit_kommuner_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (62,'2025_12_04_034935_change_postorter_columns_to_int_in_ratsit_kommuner_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (63,'2025_12_05_041421_create_merinfos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (64,'2025_12_09_020138_create_ratsit_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (65,'2025_12_11_213522_create_teams_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (66,'2025_12_11_223107_add_is_active_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (67,'2025_12_11_223115_add_is_active_to_teams_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (68,'2025_12_11_230318_add_avatar_url_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (69,'2025_12_11_233224_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (70,'2025_12_12_021235_create_booking_meetings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (71,'2025_12_12_021235_create_meetings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (72,'2025_12_12_021241_create_booking_sprints_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (73,'2025_12_12_021241_create_sprints_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (74,'2025_12_12_021816_create_booking_meeting_user_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (75,'2025_12_14_014332_create_postnummer_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (76,'2025_12_14_045211_create_bulk_actions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (77,'2025_12_14_045212_create_bulk_action_records_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (78,'2025_12_15_210054_create_merinfo_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (79,'2025_12_15_235912_create_carry_data_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (80,'2025_12_16_164006_create_hitta_personer_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (81,'2025_12_24_121800_create_calendar_settings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (82,'2025_12_25_105804_create_db_en',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (83,'2025_12_25_120626_create_db_translations',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (84,'2026_01_01_000000_create_media_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (85,'2026_01_01_000001_create_booking_daily_locations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (86,'2026_01_01_005606_create_booking_addressable_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (87,'2026_01_01_005607_create_booking_addresses_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (88,'2026_01_01_005608_create_booking_comments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (89,'2026_01_01_005609_create_booking_exports_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (90,'2026_01_01_005611_create_booking_imports_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (91,'2026_01_01_005612_create_booking_media_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (92,'2026_01_01_005613_create_booking_notifications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (93,'2026_01_01_005614_create_booking_payments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (94,'2026_01_01_005615_create_booking_settings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (95,'2026_01_01_005617_create_booking_categories_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (96,'2026_01_01_005618_create_booking_category_product_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (97,'2026_01_01_005619_create_booking_customers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (98,'2026_01_01_005620_create_booking_order_items_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (99,'2026_01_01_005621_create_booking_orders_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (100,'2026_01_01_005622_create_booking_products_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (101,'2026_01_01_005622_create_booking_services_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (102,'2026_01_01_005623_create_booking_tag_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (103,'2026_01_01_005624_create_booking_bookings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (104,'2026_01_01_005625_create_booking_booking_items_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (105,'2026_01_01_010001_create_booking_locations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (106,'2026_01_01_010002_create_booking_schedules_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (107,'2026_01_01_021039_rename_comments_table_to_booking_comments',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (108,'2026_01_01_022321_create_booking_category_service_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (109,'2026_01_01_022322_create_booking_clients_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (110,'2026_01_01_099999_add_foreign_key_to_booking_comments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (111,'2026_01_01_099999_add_foreign_keys_to_booking_order_items_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (112,'2026_01_01_099999_add_service_and_user_columns_to_booking_bookings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (113,'2026_01_01_099999_add_sort_column_to_booking_order_items_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (114,'2026_01_01_099999_fix_booking_bookings_client_column',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (115,'2026_01_01_099999_rename_addressable_columns_in_booking_addressables_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (116,'2026_01_01_099999_rename_addressable_columns_in_booking_order_addresses_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (117,'2026_01_01_099999_update_booking_status_enum',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (118,'2026_01_01_120000_update_booking_status_enum',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (119,'2026_01_01_199999_add_foreign_key_to_booking_bookings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (120,'2026_01_02_022152_create_booking_service_periods',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (121,'2026_01_03_234912_create_booking_call_stats_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (122,'2026_01_03_234912_create_booking_data_leads_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (123,'2026_01_03_234912_create_booking_user_stats_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (124,'2026_01_04_072119_create_user_widget_preferences_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (125,'2026_01_04_110126_add_service_date_and_time_columns_to_booking_bookings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (126,'2026_01_04_113403_add_is_priority_to_payments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (127,'2026_01_05_070850_create_booking_calendars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (128,'2026_01_05_192934_update_booking_services_status_enum',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (129,'2026_01_05_203831_create_booking_addresses_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (130,'2026_01_07_084340_create_whatsapp_instances_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (131,'2026_01_07_084341_create_whatsapp_messages_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (132,'2026_01_07_084342_create_whatsapp_webhooks_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (133,'2026_01_07_130000_add_schedulable_to_booking_bookings',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (134,'2026_01_08_000001_add_admin_id_to_booking_bookings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (135,'2026_01_08_030148_add_google_calendar_id_to_booking_calendars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (136,'2026_01_08_030258_add_google_event_id_and_calendar_id_to_bookings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (137,'2026_01_08_100000_make_booking_user_id_nullable_on_booking_bookings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (138,'2026_01_08_120000_add_qr_code_updated_at_to_whatsapp_instances_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (139,'2026_01_08_130500_add_whatsapp_id_to_booking_calendars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (140,'2026_01_09_011154_add_notification_user_id_to_booking_calendars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (141,'2026_01_09_011435_change_notification_user_id_to_json_in_booking_calendars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (142,'2026_01_09_012607_change_notification_user_ids_to_reference_admins_in_booking_calendars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (143,'2026_01_09_231531_create_commentions_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (144,'2026_01_09_231532_create_commentions_reactions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (145,'2026_01_09_231533_create_commentions_subscriptions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (146,'2026_01_09_233314_add_ulid_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (147,'2026_01_09_233328_add_ulid_to_admins_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (148,'2026_01_09_235445_add_ulid_to_teams_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (149,'2026_01_09_235828_add_ulid_to_services_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (150,'2026_01_10_000000_create_calling_logs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (151,'2026_01_10_001714_add_foreign_key_booking_location_id_to_booking_bookings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (152,'2026_01_10_003144_create_permission_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (153,'2026_01_10_010000_create_filament_exceptions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (154,'2026_01_13_051930_add_columns_to_booking_calendars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (155,'2026_01_13_054852_add_brand_service_email_fields_to_booking_calendars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (156,'2026_01_13_064610_add_missing_columns_to_booking_calendars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (157,'2026_01_13_224204_create_filament_email_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (158,'2026_01_13_224205_add_attachments_field_to_filament_email_log_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (159,'2026_01_13_224206_add_team_id_field_to_filament_email_log_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (160,'2026_01_14_005329_create_panel_access_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (161,'2026_01_14_054152_create_pulse_tables',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (162,'2026_01_14_144122_add_to_booking_bookings',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (163,'2026_01_15_121800_add_missing_fields_to_calendar_settings_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (164,'create_file_system_items_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (165,'add_add_create_passport_scope_grant_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (166,'add_add_create_passport_scope_resources_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (167,'2026_01_15_174944_create_oauth_access_tokens_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (168,'2026_01_15_174944_create_oauth_auth_codes_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (169,'2026_01_15_174944_create_oauth_clients_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (170,'2026_01_15_174944_create_oauth_device_codes_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (171,'2026_01_15_174944_create_oauth_refresh_tokens_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (172,'change_passport_scope_grant_unique_index',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (173,'create_passport_scope_actions_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (174,'2026_01_16_000000_create_passport_scope_resources_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (175,'2026_01_16_000001_create_passport_scope_actions_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (176,'2026_01_16_000002_create_passport_scope_grants_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (177,'2026_01_16_012842_create_activity_log_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (178,'2026_01_16_012843_add_event_column_to_activity_log_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (179,'2026_01_16_012844_add_batch_uuid_column_to_activity_log_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (180,'2026_01_16_013517_create_whatsapp_agents_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (181,'2025_10_09_152551_create_departments_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (182,'2025_10_09_152554_create_forms_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (183,'2025_10_09_152559_create_department_forms_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (184,'2025_10_09_152559_create_form_fields_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (185,'2025_10_09_152559_create_ticket_statuses_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (186,'2025_10_09_152600_create_tickets_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (187,'2025_10_09_152601_create_ticket_replies_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (188,'2025_10_09_152602_create_department_users_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (189,'2025_10_11_073108_create_ticket_activities_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (190,'2025_12_01_161739_add_form_id_to_tickets_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (191,'2025_12_22_161901_create_automation_rules_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (192,'2025_12_23_153000_add_automation_permissions_to_department_users_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (193,'2026_01_16_030902_add_state_to_booking_bookings_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (194,'2026_01_16_104548_create_general-settings_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (195,'2026_01_16_104549_add_logo_favicon_columns_to_general_settings_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (196,'2026_01_18_201831_fix_booking_state_values',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (197,'2026_01_19_031833_add_avatar_to_teams_table',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (198,'2026_01_19_145340_add_color_to_booking_service_periods_table',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (199,'2026_01_20_112604_add_ui_preferences_to_users_table',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (200,'2026_11_15_200038_create_ringa_data_table',16);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (201,'2026_01_24_105710_add_status_outcome_attempts_booking_columns_to_ringa_data_table',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (202,'2026_01_24_135506_add_user_notes_to_ringa_data_table',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (203,'2026_01_24_150928_update_outcome_values_in_ringa_data_table',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (204,'2026_01_25_000000_add_aterkom_at_to_ringa_data_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (205,'2026_01_25_223805_add_online_status_to_users_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (206,'2026_01_26_101809_add_team_id_to_ringa_data_table',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (207,'2022_12_14_083707_create_settings_table',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (208,'2026_01_28_222928_add_booking_settings_to_settings_table',24);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (209,'2026_01_29_174711_add_author_and_assigned_to_to_users_table',25);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (210,'2026_01_29_181356_create_table_settings_table',26);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (211,'2026_01_30_115236_create_db_config_table',27);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (212,'2026_02_03_062553_add_available_at_to_ringa_data',28);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (213,'2026_02_03_063236_create_outcome_delay_settings_table',29);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (214,'2026_02_03_065823_add_max_retry_count_to_outcome_delay_settings',30);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (215,'2026_02_03_065840_add_retry_count_to_ringa_data',30);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (216,'2026_02_03_084444_add_is_outcome_to_ringa_data',31);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (217,'2026_02_05_035917_create_outcome_settings_table',32);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (218,'2026_02_05_000000_create_exports_table',33);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (219,'2026_02_05_145928_add_fields_to_outcome_settings_table',34);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (220,'2026_02_05_150521_add_missing_fields_to_outcome_settings_table',34);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (221,'2026_02_05_155807_add_title_and_aterkom_to_outcome_settings_table',35);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (222,'2026_02_05_215148_add_order_and_bokad_to_outcome_settings_table',36);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (223,'2026_02_05_230256_add_quarantine_days_and_retry_to_outcome_settings_table',37);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (224,'2026_02_06_005708_add_category_and_access_to_outcome_settings_table',38);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (225,'2026_02_07_213207_add_notes_to_users_table',39);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (226,'2026_02_08_114257_add_outcome_category_to_ringa_data_table',40);
