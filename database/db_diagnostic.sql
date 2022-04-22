-- --------------------------------------------------------
-- Host:                         alamraya.site
-- Versi server:                 10.3.32-MariaDB-cll-lve - MariaDB Server
-- OS Server:                    Linux
-- HeidiSQL Versi:               11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- membuang struktur untuk table alamrayasite_diagnosis.d_diagnosa
DROP TABLE IF EXISTS `d_diagnosa`;
CREATE TABLE IF NOT EXISTS `d_diagnosa` (
  `d_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `d_user_id` int(10) unsigned NOT NULL,
  `d_penyakit_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel alamrayasite_diagnosis.d_diagnosa: ~0 rows (lebih kurang)
DELETE FROM `d_diagnosa`;
/*!40000 ALTER TABLE `d_diagnosa` DISABLE KEYS */;
/*!40000 ALTER TABLE `d_diagnosa` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.d_kasus
DROP TABLE IF EXISTS `d_kasus`;
CREATE TABLE IF NOT EXISTS `d_kasus` (
  `k_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `k_kode_gejala` int(10) unsigned NOT NULL,
  `k_kode_penyakit` int(10) unsigned NOT NULL,
  `k_hasil` varchar(50) DEFAULT NULL,
  `k_kategori` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `upadted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`k_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel alamrayasite_diagnosis.d_kasus: ~0 rows (lebih kurang)
DELETE FROM `d_kasus`;
/*!40000 ALTER TABLE `d_kasus` DISABLE KEYS */;
/*!40000 ALTER TABLE `d_kasus` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.d_rule
DROP TABLE IF EXISTS `d_rule`;
CREATE TABLE IF NOT EXISTS `d_rule` (
  `r_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `r_penyakit_id` int(10) unsigned NOT NULL,
  `r_gejala_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`r_id`),
  KEY `FK_d_rule_m_penyakit` (`r_penyakit_id`),
  KEY `FK_d_rule_m_gejala` (`r_gejala_id`),
  CONSTRAINT `FK_d_rule_m_gejala` FOREIGN KEY (`r_gejala_id`) REFERENCES `m_gejala` (`g_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_d_rule_m_penyakit` FOREIGN KEY (`r_penyakit_id`) REFERENCES `m_penyakit` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel alamrayasite_diagnosis.d_rule: ~20 rows (lebih kurang)
DELETE FROM `d_rule`;
/*!40000 ALTER TABLE `d_rule` DISABLE KEYS */;
INSERT INTO `d_rule` (`r_id`, `r_penyakit_id`, `r_gejala_id`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, '2021-12-30 03:37:24', '2021-12-30 03:37:24'),
	(2, 2, 8, '2021-12-30 03:38:55', '2021-12-30 03:38:55'),
	(3, 2, 10, '2021-12-30 03:39:04', '2021-12-30 03:39:04'),
	(4, 2, 13, '2021-12-30 03:39:13', '2021-12-30 03:39:13'),
	(5, 2, 16, '2021-12-30 03:39:26', '2021-12-30 03:39:26'),
	(6, 3, 2, '2021-12-30 03:39:58', '2021-12-30 03:39:58'),
	(7, 3, 6, '2021-12-30 03:40:06', '2021-12-30 03:40:06'),
	(8, 3, 12, '2021-12-30 03:40:15', '2021-12-30 03:40:15'),
	(9, 3, 17, '2021-12-30 03:40:21', '2021-12-30 03:40:21'),
	(10, 3, 19, '2021-12-30 03:40:28', '2021-12-30 03:40:28'),
	(11, 4, 3, '2021-12-30 03:40:44', '2021-12-30 03:40:44'),
	(12, 4, 7, '2021-12-30 03:40:53', '2021-12-30 03:40:53'),
	(13, 4, 11, '2021-12-30 03:40:59', '2021-12-30 03:40:59'),
	(14, 4, 15, '2021-12-30 03:41:06', '2021-12-30 03:41:06'),
	(15, 4, 20, '2021-12-30 03:41:15', '2021-12-30 03:41:15'),
	(16, 5, 4, '2021-12-30 03:41:56', '2021-12-30 03:41:56'),
	(17, 5, 5, '2021-12-30 03:42:04', '2021-12-30 03:42:04'),
	(18, 5, 9, '2021-12-30 03:42:21', '2021-12-30 03:42:21'),
	(19, 5, 14, '2021-12-30 03:42:30', '2021-12-30 03:42:30'),
	(20, 5, 18, '2021-12-30 03:42:40', '2021-12-30 03:42:40');
/*!40000 ALTER TABLE `d_rule` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.d_user_kasus
DROP TABLE IF EXISTS `d_user_kasus`;
CREATE TABLE IF NOT EXISTS `d_user_kasus` (
  `uk_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uk_user_id` bigint(20) unsigned NOT NULL,
  `uk_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`uk_id`) USING BTREE,
  KEY `FK_d_user_kasus_users` (`uk_user_id`),
  CONSTRAINT `FK_d_user_kasus_users` FOREIGN KEY (`uk_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel alamrayasite_diagnosis.d_user_kasus: ~0 rows (lebih kurang)
DELETE FROM `d_user_kasus`;
/*!40000 ALTER TABLE `d_user_kasus` DISABLE KEYS */;
INSERT INTO `d_user_kasus` (`uk_id`, `uk_user_id`, `uk_date`, `created_at`, `updated_at`) VALUES
	(1, 2, '2022-01-19 22:37:27', '2022-01-19 22:37:27', '2022-01-19 22:37:27'),
	(2, 5, '2022-01-20 20:37:26', '2022-01-20 20:37:26', '2022-01-20 20:37:26');
/*!40000 ALTER TABLE `d_user_kasus` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.d_user_kasus_penyakit
DROP TABLE IF EXISTS `d_user_kasus_penyakit`;
CREATE TABLE IF NOT EXISTS `d_user_kasus_penyakit` (
  `ukp_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ukp_user_kasus_id` bigint(20) unsigned NOT NULL,
  `ukp_penyakit_id` int(10) unsigned NOT NULL,
  `ukp_skor` decimal(10,1) NOT NULL DEFAULT 0.0,
  `ukp_hasil` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ukp_id`) USING BTREE,
  KEY `FK_d_user_kasus_penyakit_d_user_kasus` (`ukp_user_kasus_id`),
  KEY `FK_d_user_kasus_penyakit_m_penyakit` (`ukp_penyakit_id`),
  CONSTRAINT `FK_d_user_kasus_penyakit_d_user_kasus` FOREIGN KEY (`ukp_user_kasus_id`) REFERENCES `d_user_kasus` (`uk_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_d_user_kasus_penyakit_m_penyakit` FOREIGN KEY (`ukp_penyakit_id`) REFERENCES `m_penyakit` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel alamrayasite_diagnosis.d_user_kasus_penyakit: ~8 rows (lebih kurang)
DELETE FROM `d_user_kasus_penyakit`;
/*!40000 ALTER TABLE `d_user_kasus_penyakit` DISABLE KEYS */;
INSERT INTO `d_user_kasus_penyakit` (`ukp_id`, `ukp_user_kasus_id`, `ukp_penyakit_id`, `ukp_skor`, `ukp_hasil`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, 30.4, 'KECENDERUNGAN', '2022-01-19 22:37:27', '2022-01-19 22:37:28'),
	(2, 1, 3, 99.3, 'GANGGUAN', '2022-01-19 22:37:28', '2022-01-19 22:37:29'),
	(3, 1, 4, 27.3, 'TERINDIKASI', '2022-01-19 22:37:29', '2022-01-19 22:37:29'),
	(4, 1, 5, 44.9, 'KECENDERUNGAN', '2022-01-19 22:37:29', '2022-01-19 22:37:30'),
	(5, 2, 2, 19.0, 'TIDAK TERINDIKASI', '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(6, 2, 3, 13.7, 'TIDAK TERINDIKASI', '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(7, 2, 4, 0.0, 'TIDAK TERINDIKASI', '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(8, 2, 5, 9.6, 'TIDAK TERINDIKASI', '2022-01-20 20:37:26', '2022-01-20 20:37:26');
/*!40000 ALTER TABLE `d_user_kasus_penyakit` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.d_user_kasus_penyakit_detail
DROP TABLE IF EXISTS `d_user_kasus_penyakit_detail`;
CREATE TABLE IF NOT EXISTS `d_user_kasus_penyakit_detail` (
  `ukpd_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ukpd_kasus_penyakit_id` bigint(20) unsigned NOT NULL,
  `ukpd_gejala_id` int(10) unsigned NOT NULL,
  `ukpd_value` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ukpd_id`),
  KEY `FK_d_user_kasus_penyakit_detail_d_user_kasus_penyakit` (`ukpd_kasus_penyakit_id`),
  KEY `FK_d_user_kasus_penyakit_detail_m_gejala` (`ukpd_gejala_id`),
  CONSTRAINT `FK_d_user_kasus_penyakit_detail_d_user_kasus_penyakit` FOREIGN KEY (`ukpd_kasus_penyakit_id`) REFERENCES `d_user_kasus_penyakit` (`ukp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_d_user_kasus_penyakit_detail_m_gejala` FOREIGN KEY (`ukpd_gejala_id`) REFERENCES `m_gejala` (`g_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel alamrayasite_diagnosis.d_user_kasus_penyakit_detail: ~40 rows (lebih kurang)
DELETE FROM `d_user_kasus_penyakit_detail`;
/*!40000 ALTER TABLE `d_user_kasus_penyakit_detail` DISABLE KEYS */;
INSERT INTO `d_user_kasus_penyakit_detail` (`ukpd_id`, `ukpd_kasus_penyakit_id`, `ukpd_gejala_id`, `ukpd_value`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 0, '2022-01-19 22:37:27', '2022-01-19 22:37:27'),
	(2, 1, 8, 1, '2022-01-19 22:37:27', '2022-01-19 22:37:27'),
	(3, 1, 10, 1, '2022-01-19 22:37:27', '2022-01-19 22:37:27'),
	(4, 1, 13, 0, '2022-01-19 22:37:27', '2022-01-19 22:37:27'),
	(5, 1, 16, 0, '2022-01-19 22:37:28', '2022-01-19 22:37:28'),
	(6, 2, 2, 1, '2022-01-19 22:37:28', '2022-01-19 22:37:28'),
	(7, 2, 6, 1, '2022-01-19 22:37:28', '2022-01-19 22:37:28'),
	(8, 2, 12, 1, '2022-01-19 22:37:28', '2022-01-19 22:37:28'),
	(9, 2, 17, 1, '2022-01-19 22:37:28', '2022-01-19 22:37:28'),
	(10, 2, 19, 1, '2022-01-19 22:37:29', '2022-01-19 22:37:29'),
	(11, 3, 3, 1, '2022-01-19 22:37:29', '2022-01-19 22:37:29'),
	(12, 3, 7, 0, '2022-01-19 22:37:29', '2022-01-19 22:37:29'),
	(13, 3, 11, 0, '2022-01-19 22:37:29', '2022-01-19 22:37:29'),
	(14, 3, 15, 0, '2022-01-19 22:37:29', '2022-01-19 22:37:29'),
	(15, 3, 20, 0, '2022-01-19 22:37:29', '2022-01-19 22:37:29'),
	(16, 4, 4, 0, '2022-01-19 22:37:29', '2022-01-19 22:37:29'),
	(17, 4, 5, 1, '2022-01-19 22:37:30', '2022-01-19 22:37:30'),
	(18, 4, 9, 0, '2022-01-19 22:37:30', '2022-01-19 22:37:30'),
	(19, 4, 14, 1, '2022-01-19 22:37:30', '2022-01-19 22:37:30'),
	(20, 4, 18, 0, '2022-01-19 22:37:30', '2022-01-19 22:37:30'),
	(21, 5, 1, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(22, 5, 8, 1, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(23, 5, 10, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(24, 5, 13, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(25, 5, 16, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(26, 6, 2, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(27, 6, 6, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(28, 6, 12, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(29, 6, 17, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(30, 6, 19, 1, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(31, 7, 3, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(32, 7, 7, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(33, 7, 11, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(34, 7, 15, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(35, 7, 20, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(36, 8, 4, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(37, 8, 5, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(38, 8, 9, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(39, 8, 14, 0, '2022-01-20 20:37:26', '2022-01-20 20:37:26'),
	(40, 8, 18, 1, '2022-01-20 20:37:26', '2022-01-20 20:37:26');
/*!40000 ALTER TABLE `d_user_kasus_penyakit_detail` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel alamrayasite_diagnosis.failed_jobs: ~0 rows (lebih kurang)
DELETE FROM `failed_jobs`;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel alamrayasite_diagnosis.migrations: ~4 rows (lebih kurang)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.m_gejala
DROP TABLE IF EXISTS `m_gejala`;
CREATE TABLE IF NOT EXISTS `m_gejala` (
  `g_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `g_kode` varchar(50) NOT NULL,
  `g_nama` varchar(255) NOT NULL,
  `g_percent` decimal(10,2) NOT NULL DEFAULT 0.00,
  `g_bel` decimal(10,1) NOT NULL,
  `g_pls` decimal(10,1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel alamrayasite_diagnosis.m_gejala: ~20 rows (lebih kurang)
DELETE FROM `m_gejala`;
/*!40000 ALTER TABLE `m_gejala` DISABLE KEYS */;
INSERT INTO `m_gejala` (`g_id`, `g_kode`, `g_nama`, `g_percent`, `g_bel`, `g_pls`, `created_at`, `updated_at`) VALUES
	(1, 'G1', 'Sangat sensitif terhadap kritikan serta penolakan', 11.38, 0.3, 0.7, '2021-12-30 03:20:54', '2022-01-19 18:47:01'),
	(2, 'G2', 'Melebihkan dan mengumbar kesuksesan , daya tarik, prestasi dan pencapaiannya', 30.77, 0.9, 0.1, '2021-12-30 03:21:31', '2022-01-19 18:47:12'),
	(3, 'G3', 'Berperilaku agresif dan impulsif tanpa mementingkan keselamatan diri dan orang', 27.30, 0.9, 0.1, '2021-12-30 03:22:18', '2022-01-19 18:48:09'),
	(4, 'G4', 'Gangguan identitas, citra, dan kesadaran diri yang tidak stabil', 19.25, 0.6, 0.4, '2021-12-30 03:23:00', '2022-01-19 18:48:25'),
	(5, 'G5', 'Cenderung berperilaku impulsif serta Berupaya berulang-ulang melakukan tindakan,', 25.66, 0.8, 0.2, '2021-12-30 03:23:45', '2022-01-19 18:48:38'),
	(6, 'G6', 'Memiliki pandangan berlebihan mengenai keunikan dan kemampuan diri serta', 27.55, 0.8, 0.2, '2021-12-30 03:24:14', '2022-01-19 18:48:52'),
	(7, 'G7', 'Memperlakukan orang lain dengan kasar dan tidak merasa menyesal berperilaku', 20.48, 0.6, 0.4, '2021-12-30 03:24:44', '2022-01-19 18:49:01'),
	(8, 'G8', 'Merasa hubungan dengan orang lain lebih dekat dari yang sebenarnya dan afektif', 18.97, 0.5, 0.5, '2021-12-30 03:25:05', '2022-01-19 18:49:15'),
	(9, 'G9', 'Suasana hati yang berubah-ubah, merasa kosong/hampa secara terus menerus, mudah', 25.66, 0.9, 0.1, '2021-12-30 03:25:26', '2022-01-19 18:49:24'),
	(10, 'G10', 'Menjadi provokatif secara seksual', 11.38, 0.3, 0.7, '2021-12-30 03:25:45', '2022-01-19 18:49:31'),
	(11, 'G11', 'Kecenderungan memanipulasi , sering mencuri dan berbohong serta menyalahkan', 12.65, 0.4, 0.6, '2021-12-30 03:26:03', '2022-01-19 18:49:42'),
	(12, 'G12', 'Kurang berempati pada orang lain', 10.25, 0.3, 0.7, '2021-12-30 03:26:22', '2022-01-19 18:49:52'),
	(13, 'G13', 'Selalu ingin menjadi pusat perhatian dengan cara yang dramatis', 30.35, 0.8, 0.2, '2021-12-30 03:26:42', '2022-01-19 18:49:59'),
	(14, 'G14', 'Pola interpersonal yang tidak stabil namun intens', 19.25, 0.5, 0.5, '2021-12-30 03:26:58', '2022-01-19 18:50:07'),
	(15, 'G15', 'Tidak memerdulikan perasaan orang lain serta tidak mampu menjaga hubungan yang', 23.89, 0.7, 0.3, '2021-12-30 03:27:22', '2022-01-19 18:50:16'),
	(16, 'G16', 'Sangat mudah dipengaruhi orang lain', 26.55, 0.7, 0.3, '2021-12-30 03:27:40', '2022-01-19 18:50:26'),
	(17, 'G17', 'Cenderung mengambil keuntungan dan iri kepada orang lain', 17.09, 0.5, 0.5, '2021-12-30 03:27:59', '2022-01-19 18:50:32'),
	(18, 'G18', 'Takut berlebihan bahwa akan ditinggalkan', 9.62, 0.3, 0.7, '2021-12-30 03:28:21', '2022-01-19 18:50:42'),
	(19, 'G19', 'Hubungan interpersonal kurang baik', 13.67, 0.4, 0.6, '2021-12-30 03:28:41', '2022-01-19 18:50:51'),
	(20, 'G20', 'Menyalahgunakan alcohol dan obat-obatan', 30.72, 0.3, 0.7, '2021-12-30 03:29:05', '2022-01-19 18:50:58');
/*!40000 ALTER TABLE `m_gejala` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.m_penyakit
DROP TABLE IF EXISTS `m_penyakit`;
CREATE TABLE IF NOT EXISTS `m_penyakit` (
  `p_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `p_kode` varchar(50) NOT NULL,
  `p_nama` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`p_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel alamrayasite_diagnosis.m_penyakit: ~5 rows (lebih kurang)
DELETE FROM `m_penyakit`;
/*!40000 ALTER TABLE `m_penyakit` DISABLE KEYS */;
INSERT INTO `m_penyakit` (`p_id`, `p_kode`, `p_nama`, `created_at`, `updated_at`) VALUES
	(1, 'P0000', 'Tidak Diketahui', '2021-12-30 03:15:40', '2021-12-30 03:15:40'),
	(2, 'P0001', 'Gangguan Kepribadian Histrionik', '2021-12-30 03:16:06', '2021-12-30 03:16:06'),
	(3, 'P0002', 'Gangguan Kepribadian Narsistik', '2021-12-30 03:16:20', '2021-12-30 03:16:20'),
	(4, 'P0003', 'Gangguan Kepribadian Antisosial', '2021-12-30 03:16:33', '2021-12-30 03:16:33'),
	(5, 'P0004', 'Gangguan Kepribadian Borderline (ambang)', '2021-12-30 03:16:47', '2021-12-30 03:16:47');
/*!40000 ALTER TABLE `m_penyakit` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel alamrayasite_diagnosis.password_resets: ~0 rows (lebih kurang)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel alamrayasite_diagnosis.personal_access_tokens: ~0 rows (lebih kurang)
DELETE FROM `personal_access_tokens`;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- membuang struktur untuk table alamrayasite_diagnosis.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('M','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bod` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('admin','pasien') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pasien',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel alamrayasite_diagnosis.users: ~0 rows (lebih kurang)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `gender`, `address`, `bod`, `email`, `email_verified_at`, `password`, `type`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'ADMIN SISTEM', 'M', NULL, NULL, 'admin@mail.com', NULL, '$2y$10$hjPYZ/J3F6Dqt4jUqfhsreiWRhP6epep1sG0Y.rDC2cJoqZ0vxJia', 'admin', NULL, '2022-01-19 20:24:50', '2022-01-19 20:24:58', NULL),
	(2, 'Achmad Khotibul Umam', 'M', 'Surabaya', '1995-01-06', 'aku.masumam@gmail.com', NULL, '$2y$10$hjPYZ/J3F6Dqt4jUqfhsreiWRhP6epep1sG0Y.rDC2cJoqZ0vxJia', 'pasien', NULL, '2021-12-29 17:34:46', '2021-12-30 04:27:32', NULL),
	(3, 'Taufiq', 'M', 'Batam', '2016-01-06', 'taufiqkardiansyah19@gmail.com', NULL, '$2y$10$fUyfGoQCzGazJtzp9hEN6OHbNcZ0OCxeruZdYBGFgvU5WkPpSAIzS', 'pasien', NULL, '2021-12-30 21:00:46', '2021-12-30 21:00:46', NULL),
	(4, 'chusnul chotimah putri', 'F', 'komplek timah, tg.balai karimun', '1998-01-31', 'chusnulcputri@gmail.com', NULL, '$2y$10$csqDzworE7gzxV1IJbgvf.5gdLl9/avZZd2Nkf5LqbAcyQwI0Zuxe', 'pasien', NULL, '2021-12-31 16:46:48', '2021-12-31 16:46:48', NULL),
	(5, 'Cindy Carissa Puteri', 'F', 'Jl. Lupus bukit meral karimun', '1990-10-13', 'cindycarissacindy@gmail.com', NULL, '$2y$10$IzMRnG.7XNM4O6lnAGnlwua2DY75ajDCbty97FksQEQfBh8GF3o3y', 'pasien', NULL, '2022-01-20 20:35:57', '2022-01-20 20:35:57', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
