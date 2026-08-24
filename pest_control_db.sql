-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 14 Agu 2026 pada 10.39
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pest_control_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@fixla.com|127.0.0.1', 'i:4;', 1786694876),
('laravel-cache-admin@fixla.com|127.0.0.1:timer', 'i:1786694876;', 1786694876);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `entries`
--

CREATE TABLE `entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trap_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `tindakan` varchar(255) DEFAULT NULL,
  `aktivitas` enum('LOW','MEDIUM','HIGH') NOT NULL DEFAULT 'LOW',
  `hasil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `entries`
--

INSERT INTO `entries` (`id`, `trap_id`, `tanggal`, `tindakan`, `aktivitas`, `hasil`, `created_at`, `updated_at`) VALUES
(1, 8, '2026-08-13', 'Mengganti Pipet', 'HIGH', 'ga jGFGK jhbcjh', '2026-08-13 01:05:24', '2026-08-13 01:05:24'),
(2, 15, '2026-08-14', 'mengganti lem perangkap', 'MEDIUM', 'kajfkjahskah', '2026-08-13 20:07:47', '2026-08-13 20:07:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_13_064921_create_traps_table', 1),
(5, '2026_08_13_065125_create_entries_table', 1),
(6, '2026_08_13_065253_create_rekomendasi_perbaikans_table', 1),
(7, '2026_08_14_011948_add_role_to_users_table', 2),
(8, '2026_08_14_025117_split_rekomendasi_perbaikan_columns', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekomendasi_perbaikans`
--

CREATE TABLE `rekomendasi_perbaikans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entry_id` bigint(20) UNSIGNED NOT NULL,
  `rekomendasi_catatan` text DEFAULT NULL,
  `rekomendasi_gambar` varchar(255) DEFAULT NULL,
  `perbaikan_catatan` text DEFAULT NULL,
  `perbaikan_gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rekomendasi_perbaikans`
--

INSERT INTO `rekomendasi_perbaikans` (`id`, `entry_id`, `rekomendasi_catatan`, `rekomendasi_gambar`, `perbaikan_catatan`, `perbaikan_gambar`, `created_at`, `updated_at`) VALUES
(1, 1, 'hfsf', 'rekomendasi/x6bGFFaoLGhFZDfaxP6BNcOwebchEOjVSBBAEiUF.jpg', NULL, NULL, '2026-08-13 01:05:24', '2026-08-13 01:05:24'),
(2, 2, 'ncabcm', 'rekomendasi/Pw72ccSpABSUi9n9znQ5PF5pFX63lnTyc7MzcTKj.jpg', 'sfs', 'perbaikan/dM5NJ5RImnVwL6riNDZjbl0V7R7sPaiNwKF6JCWh.jpg', '2026-08-13 20:07:47', '2026-08-13 20:07:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4RIa72UA9I5MdJ7WVsXXU9TbTchVaBIpd5qhld33', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVW5ZM3NQVkF5SmhQOU14dXhUN3dxVHU0OWZSWVN4a0E1emhPaFlTbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yaXdheWF0IjtzOjU6InJvdXRlIjtzOjE1OiJlbnRyaWVzLnJpd2F5YXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1786695408),
('G8WVA5KLJja9NP1tCFnLyKaknpCCek8N7UttzZnm', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiejRlczVEVHcyR1laaWptTUZzbTdYT2dGTDVZS1RHM1VwUmRTcDd1YyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9pbnB1dCI7czo1OiJyb3V0ZSI7czoxNDoiZW50cmllcy5jcmVhdGUiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1786693065);

-- --------------------------------------------------------

--
-- Struktur dari tabel `traps`
--

CREATE TABLE `traps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `no_trap` varchar(255) NOT NULL,
  `type_detector` varchar(255) NOT NULL,
  `spesies_hama` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `traps`
--

INSERT INTO `traps` (`id`, `created_at`, `updated_at`, `no_trap`, `type_detector`, `spesies_hama`, `lokasi`) VALUES
(1, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '10', 'P. Lalat', 'Lalat', 'Halaman Depan'),
(2, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '11', 'P. Lalat', 'Lalat', 'Halaman Depan'),
(3, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '01', 'P. Lalat', 'Lalat', 'Penerimaan Surimi'),
(4, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '02', 'P. Lalat', 'Lalat', 'Penerimaan Surimi'),
(5, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '05', 'P. Lalat', 'Lalat', 'Penerimaan FM'),
(6, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '04', 'P. Lalat', 'Lalat', 'Penerimaan FM'),
(7, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '07', 'P. Lalat', 'Lalat', 'Halaman Timur FM'),
(8, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '06', 'P. Lalat', 'Lalat', 'TPS'),
(9, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '08', 'P. Lalat', 'Lalat', 'TPS'),
(10, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '09', 'P. Lalat', 'Lalat', 'Taman'),
(11, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '01', 'P. Kucing', 'Kucing', 'PN FF'),
(12, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '05', 'Insect Light', 'Lalat', 'Loker Laki-Laki'),
(13, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '03', 'Insect Light', 'Lalat', 'Penerimaan Surimi'),
(14, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '04', 'Insect Light', 'Lalat', 'Penerimaan FF'),
(15, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '06', 'Insect Light', 'Lalat', 'Ruang Proses FF'),
(16, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '07', 'Insect Light', 'Lalat', 'Ruang Packing FF'),
(17, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '01', 'Insect Light', 'Lalat', 'Packing Surimi'),
(18, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '02', 'Insect Light', 'Lalat', 'Ruang Proses Surimi Mesin 6'),
(19, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '08', 'Insect Light', 'Lalat', 'R. PK'),
(20, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '09', 'Insect Light', 'Lalat', 'R. PK'),
(21, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '10', 'Insect Light', 'Lalat', 'R. Proses FM'),
(22, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '11', 'Insect Light', 'Lalat', 'Packing FM'),
(23, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '12', 'Insect Light', 'Lalat', 'FO Fish Oil'),
(24, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '01', 'Rodent Baint Stat', 'Tikus', 'Lobby'),
(25, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '02', 'Rodent Baint Stat', 'Tikus', 'Lobby'),
(26, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '03', 'Rodent Baint Stat', 'Tikus', 'Dapur'),
(27, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '04', 'Rodent Baint Stat', 'Tikus', 'Dapur'),
(28, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '41', 'Rodent Baint Stat', 'Tikus', 'Kantor Lt 2'),
(29, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '42', 'Rodent Baint Stat', 'Tikus', 'Kantor Lt 2'),
(30, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '05', 'Rodent Baint Stat', 'Tikus', 'Antoroom'),
(31, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '06', 'Rodent Baint Stat', 'Tikus', 'Antoroom'),
(32, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '07', 'Rodent Baint Stat', 'Tikus', 'Proses FF'),
(33, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '08', 'Rodent Baint Stat', 'Tikus', 'Proses FF'),
(34, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '09', 'Rodent Baint Stat', 'Tikus', 'Proses FF'),
(35, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '10', 'Rodent Baint Stat', 'Tikus', 'Proses FF'),
(36, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '11', 'Rodent Baint Stat', 'Tikus', 'Proses FF'),
(37, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '45', 'Rodent Baint Stat', 'Tikus', 'Packing FF'),
(38, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '46', 'Rodent Baint Stat', 'Tikus', 'Packing FF'),
(39, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '12', 'Rodent Baint Stat', 'Tikus', 'Loker Wanita'),
(40, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '13', 'Rodent Baint Stat', 'Tikus', 'Loker Laki-laki'),
(41, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '14', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(42, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '15', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(43, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '16', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(44, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '17', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(45, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '18', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(46, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '19', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(47, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '20', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(48, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '34', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(49, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '35', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(50, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '36', 'Rodent Baint Stat', 'Tikus', 'Gudang NBB'),
(51, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '21', 'Rodent Baint Stat', 'Tikus', 'Stufing FM'),
(52, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '22', 'Rodent Baint Stat', 'Tikus', 'Stufing FM'),
(53, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '23', 'Rodent Baint Stat', 'Tikus', 'Gudang FM'),
(54, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '24', 'Rodent Baint Stat', 'Tikus', 'Gudang FM'),
(55, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '37', 'Rodent Baint Stat', 'Tikus', 'Gudang FO'),
(56, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '38', 'Rodent Baint Stat', 'Tikus', 'Gudang FO'),
(57, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '39', 'Rodent Baint Stat', 'Tikus', 'Chili Room'),
(58, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '25', 'Rodent Baint Stat', 'Tikus', 'Packing FM'),
(59, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '26', 'Rodent Baint Stat', 'Tikus', 'Packing FM'),
(60, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '44', 'Rodent Baint Stat', 'Tikus', 'Packing FM'),
(61, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '27', 'Rodent Baint Stat', 'Tikus', 'Packing FM'),
(62, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '28', 'Rodent Baint Stat', 'Tikus', 'Proses FM'),
(63, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '29', 'Rodent Baint Stat', 'Tikus', 'Proses FM'),
(64, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '40', 'Rodent Baint Stat', 'Tikus', 'Panel Boiler FM'),
(65, '2026-08-13 00:27:38', '2026-08-13 19:20:40', '43', 'Rodent Baint Stat', 'Tikus', 'Panel Boiler FM'),
(66, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '30', 'Rodent Baint Stat', 'Tikus', 'R. Proses Surimi'),
(67, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '31', 'Rodent Baint Stat', 'Tikus', 'R. Proses Surimi'),
(68, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '32', 'Rodent Baint Stat', 'Tikus', 'R. Proses Surimi'),
(69, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '33', 'Rodent Baint Stat', 'Tikus', 'Water Chiller 1'),
(70, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '01', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Depan'),
(71, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '02', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Depan'),
(72, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '03', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Timur'),
(73, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '04', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Timur'),
(74, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '05', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Timur'),
(75, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '06', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Penerimaan'),
(76, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '07', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Barat'),
(77, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '14', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Barat'),
(78, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '08', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Depan FM'),
(79, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '12', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Depan FM'),
(80, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '13', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Depan FM'),
(81, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '09', 'Rodent Baint Stat Box', 'Tikus', 'P. Karyawan'),
(82, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '10', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Belakang FM'),
(83, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '11', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Belakang FM'),
(84, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '15', 'Rodent Baint Stat Box', 'Tikus', 'Halaman Belakang FM'),
(85, '2026-08-13 00:27:38', '2026-08-13 00:27:38', '16', 'Rodent Baint Stat Box', 'Tikus', 'Ruang Istirahat FM');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','pengelola') NOT NULL DEFAULT 'pengelola',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', 'pengelola', '2026-08-13 00:27:38', '$2y$12$RqPQELVKz7l7SZ84FTYPe.lxmvjps6toFoRWeF7vvjjHZEjyWWDsq', 'z7ErQHXB3W', '2026-08-13 00:27:38', '2026-08-13 00:27:38'),
(2, 'Admin QC', 'admin@starfood.com', 'admin', NULL, '$2y$12$1nJF/s8hZ94rqI3xlo6VrO9GmwnPtqxvXC3O8fY3ygNCjGAPnjaGG', 'OH9w1vKUN2QnH8fzgG9udDrzU12Htm38HT7jCwQHffwYJqqz0DKVSHdsq6SD', '2026-08-13 18:51:39', '2026-08-13 18:51:39'),
(3, 'Pengelola Hama', 'pengelola@starfood.com', 'pengelola', NULL, '$2y$12$XoRJIL/Ml54Gt2jFE41aOu/cEeZ/C3cdGHeI/cQkPe13tmz2d22eS', NULL, '2026-08-13 18:51:40', '2026-08-13 18:51:40');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entries_trap_id_foreign` (`trap_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `rekomendasi_perbaikans`
--
ALTER TABLE `rekomendasi_perbaikans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekomendasi_perbaikans_entry_id_foreign` (`entry_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `traps`
--
ALTER TABLE `traps`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `entries`
--
ALTER TABLE `entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `rekomendasi_perbaikans`
--
ALTER TABLE `rekomendasi_perbaikans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `traps`
--
ALTER TABLE `traps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `entries`
--
ALTER TABLE `entries`
  ADD CONSTRAINT `entries_trap_id_foreign` FOREIGN KEY (`trap_id`) REFERENCES `traps` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekomendasi_perbaikans`
--
ALTER TABLE `rekomendasi_perbaikans`
  ADD CONSTRAINT `rekomendasi_perbaikans_entry_id_foreign` FOREIGN KEY (`entry_id`) REFERENCES `entries` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
