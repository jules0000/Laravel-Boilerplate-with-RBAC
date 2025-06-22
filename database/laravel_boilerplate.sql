-- ===================================================================
-- Laravel Boilerplate Database Structure & Demo Data
-- Database: laravel_boilerplate
-- Version: 1.0
-- Created: 2025
-- ===================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ===================================================================
-- Database Creation
-- ===================================================================
CREATE DATABASE IF NOT EXISTS `laravel_boilerplate` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `laravel_boilerplate`;

-- ===================================================================
-- Table Structure: users
-- ===================================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- Table Structure: roles (Spatie Permission Package)
-- ===================================================================
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- Table Structure: permissions (Spatie Permission Package)
-- ===================================================================
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- Table Structure: role_has_permissions (Spatie Permission Package)
-- ===================================================================
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- Table Structure: model_has_roles (Spatie Permission Package)
-- ===================================================================
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- Table Structure: model_has_permissions (Spatie Permission Package)
-- ===================================================================
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- Table Structure: migrations (Laravel Framework)
-- ===================================================================
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- Table Structure: password_reset_tokens (Laravel Framework)
-- ===================================================================
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- Table Structure: personal_access_tokens (Laravel Sanctum)
-- ===================================================================
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
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

-- ===================================================================
-- DEMO DATA INSERTION
-- ===================================================================

-- Insert Roles
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(2, 'manager', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(3, 'user', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00');

-- Insert Permissions
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin-access', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(2, 'manager-access', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(3, 'dashboard-access', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(4, 'profile-edit', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(5, 'users-view', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(6, 'users-create', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(7, 'users-edit', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(8, 'users-delete', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(9, 'roles-view', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(10, 'roles-create', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(11, 'roles-edit', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(12, 'roles-delete', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(13, 'permissions-view', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(14, 'permissions-create', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(15, 'permissions-edit', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(16, 'permissions-delete', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(17, 'system-settings', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(18, 'system-info', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(19, 'logs-view', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(20, 'reports-view', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(21, 'backup-create', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(22, 'maintenance-mode', 'web', '2025-01-01 12:00:00', '2025-01-01 12:00:00');

-- Insert Demo Users (passwords are all 'password' hashed with bcrypt)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_active`, `last_login_at`, `last_login_ip`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'admin@example.com', '2025-01-01 12:00:00', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(2, 'Department Manager', 'manager@example.com', '2025-01-01 12:00:00', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, '2025-01-01 12:00:00', '2025-01-01 12:00:00'),
(3, 'Standard User', 'user@example.com', '2025-01-01 12:00:00', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, '2025-01-01 12:00:00', '2025-01-01 12:00:00');

-- Assign Admin Role All Permissions
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), (10, 1),
(11, 1), (12, 1), (13, 1), (14, 1), (15, 1), (16, 1), (17, 1), (18, 1), (19, 1), (20, 1), (21, 1), (22, 1);

-- Assign Manager Role Limited Permissions
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 2), (3, 2), (4, 2), (5, 2), (6, 2), (7, 2), (9, 2), (13, 2), (20, 2);

-- Assign User Role Basic Permissions
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(3, 3), (4, 3);

-- Assign Roles to Users
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- Insert Migration Records
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_01_000000_create_permission_tables', 1);

-- ===================================================================
-- AUTO INCREMENT VALUES
-- ===================================================================
ALTER TABLE `users` AUTO_INCREMENT = 4;
ALTER TABLE `roles` AUTO_INCREMENT = 4;
ALTER TABLE `permissions` AUTO_INCREMENT = 23;
ALTER TABLE `migrations` AUTO_INCREMENT = 6;

COMMIT;

-- ===================================================================
-- NOTES FOR DEVELOPERS
-- ===================================================================
-- 
-- Demo Accounts:
-- Admin: admin@example.com / password
-- Manager: manager@example.com / password  
-- User: user@example.com / password
--
-- This SQL file creates a complete Laravel boilerplate database with:
-- - User authentication system
-- - Role-based access control (RBAC) using Spatie Permission package
-- - 3 roles: admin, manager, user
-- - 22 granular permissions
-- - Demo users for testing
-- 
-- To use this file:
-- 1. Create a MySQL database named 'laravel_boilerplate'
-- 2. Import this SQL file into your database
-- 3. Configure your .env file with database credentials
-- 4. Run: php artisan migrate:status (to verify migrations)
-- 
-- =================================================================== 