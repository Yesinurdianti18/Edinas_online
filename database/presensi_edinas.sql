-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Des 2024 pada 15.03
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi_edinas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatan_dinas`
--

CREATE TABLE `catatan_dinas` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `tanggal_catatan` date NOT NULL,
  `jam_catatan` time NOT NULL,
  `judul` varchar(225) NOT NULL,
  `catatan` varchar(225) NOT NULL,
  `jenis_catatan` varchar(50) NOT NULL,
  `file` varchar(225) NOT NULL,
  `latitude_catatan` varchar(30) NOT NULL,
  `longitude_catatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `catatan_dinas`
--

INSERT INTO `catatan_dinas` (`id`, `id_pegawai`, `tanggal_catatan`, `jam_catatan`, `judul`, `catatan`, `jenis_catatan`, `file`, `latitude_catatan`, `longitude_catatan`) VALUES
(12, 3, '2024-12-04', '15:32:29', 'Capek', '<p>aaaaaaaa</p>', '', 'agile.png', '', ''),
(16, 1, '2024-12-05', '13:00:47', 'Dunia Aneh', '<p>Teuing wkwkwkwk</p>', '', 'scene1.png', '', ''),
(17, 1, '2024-12-06', '21:43:02', 'Curhatan Indah', '<p>Kemaren Rehan Post sama cewe, indah kecewa. tamat</p>', '', 'iPhone-13-PRO-localhost.png', '', ''),
(19, 1, '2024-12-07', '13:40:47', 'Hari ini kerja kelompok', '<p>Hasilnya ada ga yaaaaa</p>', '', 'doraemon.png', '', ''),
(21, 1, '2024-12-07', '23:31:37', 'Capek banget co', '<p>Harus gmn lagi sama semua ini, aku <strong>lelahhh</strong></p>', '', '17335891349215767869464009312401.jpg', '', ''),
(22, 1, '2024-12-08', '23:55:04', 'Alhamdulillah', '<p>I hope your happy even with out me, huekk cuih</p>', '', 'IMG20241208173218.jpg', '', ''),
(23, 1, '2024-12-10', '19:29:36', 'Diskusi booth', '<p>Ngapain lagi sih ini</p>', '', 'absensi-online-carousel-1.png', '', ''),
(24, 3, '2024-12-13', '16:44:25', 'testing lagi', '<p>kenapa banyak banget eror nya</p>', '', 'logo4.png', '', ''),
(25, 1, '2024-12-14', '06:38:41', 'sscs', '<p>scsc</p>', '', '1_20241213_000339_0000.png', '', ''),
(26, 1, '2024-12-14', '10:25:48', 'Dhdjd', '<p>Dhdjdh</p>', '', '17341467599468501449232716724634.jpg', '', ''),
(27, 28, '2024-12-14', '11:06:21', 'Rating', '<p>bagus&nbsp;</p>', '', '17341492158323436093638979804138.jpg', '', ''),
(28, 44, '2024-12-14', '12:51:58', 'Belajar', '<p>Hajsgakahsihajagak</p>', '', '17341555335834128563679220360430.jpg', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `jabatan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `jabatan`) VALUES
(1, 'Administrator'),
(3, 'Kepala Polsek'),
(13, 'Bhabinsa'),
(14, 'Kepala Kelapa'),
(15, 'Programmer'),
(16, 'Desainer'),
(17, 'Sekretaris');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ketidakhadiran`
--

CREATE TABLE `ketidakhadiran` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `keterangan` varchar(225) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` varchar(225) NOT NULL,
  `file` varchar(225) NOT NULL,
  `status_pengajuan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ketidakhadiran`
--

INSERT INTO `ketidakhadiran` (`id`, `id_pegawai`, `keterangan`, `tanggal`, `deskripsi`, `file`, `status_pengajuan`) VALUES
(2, 2, 'Sakit', '2024-11-30', 'Mencintaimu', 'LATP10_IndahLM_4337857201230031.pdf', 'REJECTED'),
(3, 3, 'Sakit', '2024-12-18', 'fdefefefefefe', '', 'PENDING'),
(4, 1, 'Sakit', '2024-12-28', 'khvhkvkhvmblblblblk', '', 'APPROVED');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi_presensi`
--

CREATE TABLE `lokasi_presensi` (
  `id` int(11) NOT NULL,
  `nama_lokasi` varchar(225) NOT NULL,
  `alamat_lokasi` varchar(225) NOT NULL,
  `tipe_lokasi` varchar(225) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `radius` int(11) NOT NULL,
  `zona_waktu` varchar(4) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lokasi_presensi`
--

INSERT INTO `lokasi_presensi` (`id`, `nama_lokasi`, `alamat_lokasi`, `tipe_lokasi`, `latitude`, `longitude`, `radius`, `zona_waktu`, `jam_masuk`, `jam_pulang`) VALUES
(2, 'OS Cloth Konveksi', 'Perum Citra Gardenia Jl. Wijaya Kusuma No. 01, Cibalongsari, Klari, Karawang, Jawa Barat 41371', 'Kantor', '-6.353453', '107.367544', 500, 'WIB', '07:00:00', '17:00:00'),
(3, 'Work From Anywhere (WFA)', 'Jl. Doang tapi gak jadian', 'Lapangan', '-6.289407646987708', '107.29233335545122', 10000, 'WIB', '08:00:00', '20:00:00'),
(7, 'Horizon University', 'Jl. Pangkal Perjuangan By Pass No.KM.1, Tanjungpura, Kec. Karawang Bar., Karawang, Jawa Barat 41316', 'Kantor', '-6.289407646987708', '107.29233335545122', 80000, 'WIB', '08:00:00', '10:00:00'),
(8, 'Work From Home (WFH)', 'Your Home', 'Lapangan', '-6.289407646987708', '107.29233335545122', 15000, 'WIB', '08:00:00', '20:00:00'),
(9, 'Jadwal Piket', 'Jl. Pangkal Perjuangan By Pass No.KM.1, Tanjungpura, Kec. Karawang Bar., Karawang, Jawa Barat 41316', 'Kantor', '-6.289407646987708', '107.29233335545122', 1000, 'WIB', '08:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `no_handphone` varchar(20) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `lokasi_presensi` varchar(50) NOT NULL,
  `foto` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nama`, `jenis_kelamin`, `alamat`, `no_handphone`, `jabatan`, `lokasi_presensi`, `foto`) VALUES
(1, '4337857201230011', 'Bintang Aditya Ramadhan', 'Laki-laki', 'Perum Citra Gardenia Jl. Wijaya Kusuma No. 01, Kel. Cibalongsari, Kec. Klari, Kab. Karawang, Jawa Barat 41371', '083879049625', 'Programmer', 'Horizon University', '20241211_030646.jpg'),
(2, '4337857201230045', 'Yuli Noviani', 'Perempuan', 'Jl. Doang Tapi Gk Jadian', '08998899888', 'Desainer', 'Horizon University', '20241211_030811.jpg'),
(3, '4337857201230031', 'Indah Laelatul Muawanah', 'Perempuan', 'Jl. Sama Siapa?', '089506098929', 'Administrator', 'Horizon University', '20241211_030725.jpg'),
(4, '4337857201230059', 'Yesi Nurdianti', 'Perempuan', 'Perum Pereum', '0889988989', 'Sekretaris', 'Horizon University', '20241211_030843.jpg'),
(5, '4337857201230049', 'Iman Fauzi', 'Laki-laki', 'Subang Lur', '086969696969', 'Administrator', 'Horizon University', 'iman.jpeg'),
(6, '131', '12', '', '12', '', '', 'lokasi_presensi', ''),
(12, '32152620111231231', 'Rangga Abdullah', 'Laki-laki', 'Laki-laki', '0898', 'Kepala Kelapa', 'Horizon University', 'reza.png'),
(13, '321526201112314141', 'Asep', 'Laki-laki', 'Laki-laki', '0898', 'Bhabinsa', 'OSCLOTH', 'agile.png'),
(14, '20104665', 'Shara Muawanach', 'Mars belah', 'Perempuan', '0898', 'Kepala Kelapa', 'Horizon University', 'indah.jpeg'),
(22, '111', '111', '', '', '', '', 'Horizon University', ''),
(23, '122', '122', '', '', '', '', 'Horizon University', ''),
(24, '123', '123', '', '', '', '', 'Horizon University', ''),
(25, '20104661', 'Rizal', '', '', '', '', 'Horizon University', ''),
(26, '4337855201230044', 'Agus Sullivan', '', '', '', '', 'Horizon University', ''),
(27, '4337857201230057', 'Ginashafa Suganda', '', '', '', '', 'Horizon University', ''),
(28, '4337855201230084', 'Adhi Nur Fajar ', '', '', '', '', 'Horizon University', ''),
(29, '5638477', 'Anwar', '', '', '', '', 'Horizon University', ''),
(30, '1080', 'fhazar', '', '', '', '', 'Horizon University', ''),
(31, '1005554996', 'DANA SUPRIADI', '', '', '', '', 'Horizon University', ''),
(32, '3215021011060002', 'Angga Muhtarudin ', '', '', '', '', 'Horizon University', ''),
(33, '12345677', 'Egawati ', '', '', '', '', 'Horizon University', ''),
(34, '0012', 'Aldi Ardiansah', '', '', '', '', 'Horizon University', ''),
(35, '089655627216', 'ghina ulum dwiyanti', '', '', '', '', 'Horizon University', ''),
(36, '2223103014', 'Intan purnama sari ', '', '', '', '', 'Horizon University', ''),
(37, '085819913273', 'mutia zahra', '', '', '', '', 'Horizon University', ''),
(38, '12345', 'Iin Fadilah ', '', '', '', '', 'Horizon University', ''),
(39, '123456789', 'IFA FAUZIYAH ', '', '', '', '', 'Horizon University', ''),
(40, '123456', 'SOPIYATUN MARWAH ', '', '', '', '', 'Horizon University', ''),
(41, '081574799370', 'IFA FAUZIYAH ', '', '', '', '', 'Horizon University', ''),
(42, '7363626', 'Iman', '', '', '', '', 'Horizon University', ''),
(43, '1234', 'AHMAD JEFRI CHANIAGO ', '', '', '', '', 'Horizon University', ''),
(44, '12345678910', 'Rian kamal', '', '', '', '', 'Horizon University', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `foto_masuk` varchar(225) NOT NULL,
  `latitude_masuk` varchar(30) NOT NULL,
  `longitude_masuk` varchar(30) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `jam_keluar` time NOT NULL,
  `foto_keluar` varchar(225) NOT NULL,
  `latitude_keluar` varchar(30) NOT NULL,
  `longitude_keluar` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `id_pegawai`, `tanggal_masuk`, `jam_masuk`, `foto_masuk`, `latitude_masuk`, `longitude_masuk`, `tanggal_keluar`, `jam_keluar`, `foto_keluar`, `latitude_keluar`, `longitude_keluar`) VALUES
(56, 1, '2024-12-06', '21:55:53', 'masuk-2024-12-06.png', '-6.2892813', '107.2919469', '0000-00-00', '00:00:00', '', '', ''),
(57, 3, '2024-12-06', '22:05:11', 'masuk-2024-12-06.png', '-6.2892853', '107.2919485', '0000-00-00', '00:00:00', '', '', ''),
(58, 1, '2024-12-07', '05:25:45', 'masuk-2024-12-06.png', '-6.3536922', '107.3677128', '2024-12-07', '23:16:51', 'keluar-2024-12-07.png', '', ''),
(59, 12, '2024-12-07', '05:28:33', 'masuk-2024-12-06.png', '-6.3537042', '107.3677364', '0000-00-00', '00:00:00', '', '', ''),
(60, 3, '2024-12-07', '05:54:10', 'masuk-2024-12-06.png', '-6.3537061', '107.3677317', '0000-00-00', '00:00:00', '', '', ''),
(61, 5, '2024-12-07', '05:59:15', 'masuk-2024-12-07.png', '-6.3537061', '107.3677317', '0000-00-00', '00:00:00', '', '', ''),
(62, 2, '2024-12-07', '10:15:09', 'masuk-2024-12-07.png', '-6.290392192199159', '107.28679123998114', '0000-00-00', '00:00:00', '', '', ''),
(65, 1, '2024-12-08', '17:16:26', 'masuk-2024-12-08.png', '-6.3537062', '107.3677381', '2024-12-08', '22:55:02', 'keluar-2024-12-08.png', '', ''),
(66, 3, '2024-12-08', '23:12:44', 'masuk-2024-12-08.png', '-6.3537031', '107.3677342', '2024-12-08', '23:13:59', 'keluar-2024-12-08.png', '', ''),
(67, 4, '2024-12-08', '23:17:29', 'masuk-2024-12-08.png', '-6.3537031', '107.3677342', '2024-12-08', '23:22:56', 'keluar-2024-12-08.png', '', ''),
(68, 12, '2024-12-08', '23:32:34', 'masuk-2024-12-08.png', '-6.3537031', '107.3677342', '2024-12-08', '23:33:17', 'keluar-2024-12-08.png', '', ''),
(69, 13, '2024-12-08', '23:35:54', 'masuk-2024-12-08.png', '-6.3537031', '107.3677342', '2024-12-08', '23:36:22', 'keluar-2024-12-08.png', '', ''),
(73, 1, '2024-12-10', '19:27:44', 'masuk-2024-12-10-1.png', '-6.2892815', '107.2919574', '2024-12-10', '19:31:35', 'keluar-2024-12-10-.png', '', ''),
(74, 1, '2024-12-11', '01:09:07', 'masuk-2024-12-10-1.png', '-6.2892756', '107.2919627', '2024-12-11', '21:19:02', 'keluar-2024-12-11-.png', '', ''),
(75, 3, '2024-12-11', '02:41:04', 'masuk-2024-12-10-3.png', '-6.353695', '107.3677299', '0000-00-00', '00:00:00', '', '', ''),
(76, 2, '2024-12-11', '02:53:29', 'masuk-2024-12-10-2.png', '-6.3536758', '107.3677493', '0000-00-00', '00:00:00', '', '', ''),
(77, 4, '2024-12-11', '02:53:44', 'masuk-2024-12-10-4.png', '-6.3536758', '107.3677493', '0000-00-00', '00:00:00', '', '', ''),
(78, 5, '2024-12-11', '02:58:32', 'masuk-2024-12-10-5.png', '-6.3536758', '107.3677493', '0000-00-00', '00:00:00', '', '', ''),
(79, 1, '2024-12-12', '00:22:39', 'masuk-2024-12-11-1.png', '-6.3536674', '107.3677541', '0000-00-00', '00:00:00', '', '', ''),
(82, 3, '2024-12-12', '09:09:31', 'masuk-2024-12-12-3.png', '-6.3536965', '107.3678058', '0000-00-00', '00:00:00', '', '', ''),
(83, 4, '2024-12-12', '09:13:39', 'masuk-2024-12-12-4.png', '-6.353697', '107.3677633', '0000-00-00', '00:00:00', '', '', ''),
(84, 1, '2024-12-13', '10:28:36', 'masuk-2024-12-13-1.png', '-6.3517804', '107.3699149', '0000-00-00', '00:00:00', '', '', ''),
(85, 2, '2024-12-14', '09:53:41', 'masuk-2024-12-14-2.png', '-6.2894024', '107.2921819', '0000-00-00', '00:00:00', '', '', ''),
(86, 3, '2024-12-14', '10:23:35', 'masuk-2024-12-14-3.png', '-6.2894175', '107.2921813', '0000-00-00', '00:00:00', '', '', ''),
(87, 1, '2024-12-14', '10:26:57', 'masuk-2024-12-14-1.png', '-6.2868726', '107.2897297', '0000-00-00', '00:00:00', '', '', ''),
(88, 25, '2024-12-14', '10:36:39', 'masuk-2024-12-14-25.png', '-6.2932022', '107.2912075', '0000-00-00', '00:00:00', '', '', ''),
(89, 4, '2024-12-14', '10:44:32', 'masuk-2024-12-14-4.png', '-6.2910068', '107.2900991', '0000-00-00', '00:00:00', '', '', ''),
(90, 26, '2024-12-14', '10:48:09', 'masuk-2024-12-14-26.png', '-6.289412953804234', '107.29212769983558', '0000-00-00', '00:00:00', '', '', ''),
(91, 27, '2024-12-14', '11:02:08', 'masuk-2024-12-14-27.png', '-6.2868726', '107.2897297', '0000-00-00', '00:00:00', '', '', ''),
(92, 28, '2024-12-14', '11:03:41', 'masuk-2024-12-14-28.png', '-6.2894032', '107.2921842', '0000-00-00', '00:00:00', '', '', ''),
(93, 29, '2024-12-14', '11:06:51', 'masuk-2024-12-14-29.png', '-6.2932022', '107.2912075', '0000-00-00', '00:00:00', '', '', ''),
(94, 29, '2024-12-14', '11:06:51', 'masuk-2024-12-14-29.png', '-6.2932022', '107.2912075', '0000-00-00', '00:00:00', '', '', ''),
(95, 30, '2024-12-14', '11:21:14', 'masuk-2024-12-14-30.png', '-6.2893629', '107.292184', '0000-00-00', '00:00:00', '', '', ''),
(96, 30, '2024-12-14', '11:21:14', 'masuk-2024-12-14-30.png', '-6.2893629', '107.292184', '0000-00-00', '00:00:00', '', '', ''),
(97, 32, '2024-12-14', '11:31:14', 'masuk-2024-12-14-32.png', '-6.2893757', '107.2921831', '0000-00-00', '00:00:00', '', '', ''),
(98, 33, '2024-12-14', '11:31:10', 'masuk-2024-12-14-33.png', '-6.2893692', '107.292185', '0000-00-00', '00:00:00', '', '', ''),
(99, 31, '2024-12-14', '11:31:40', 'masuk-2024-12-14-31.png', '-6.2893772', '107.2921859', '2024-12-14', '11:32:08', 'keluar-2024-12-14-.png', '', ''),
(100, 34, '2024-12-14', '11:32:58', 'masuk-2024-12-14-34.png', '-6.2893978', '107.2921749', '0000-00-00', '00:00:00', '', '', ''),
(101, 35, '2024-12-14', '11:39:01', 'masuk-2024-12-14-35.png', '-6.2893967119013725', '107.29210144541366', '0000-00-00', '00:00:00', '', '', ''),
(102, 35, '2024-12-14', '11:39:01', 'masuk-2024-12-14-35.png', '-6.2893967119013725', '107.29210144541366', '0000-00-00', '00:00:00', '', '', ''),
(103, 38, '2024-12-14', '11:48:57', 'masuk-2024-12-14-38.png', '-6.2893655', '107.2921778', '0000-00-00', '00:00:00', '', '', ''),
(104, 36, '2024-12-14', '11:49:06', 'masuk-2024-12-14-36.png', '-6.2894026', '107.2921749', '0000-00-00', '00:00:00', '', '', ''),
(105, 37, '2024-12-14', '11:51:25', 'masuk-2024-12-14-37.png', '-6.2893835', '107.2921809', '0000-00-00', '00:00:00', '', '', ''),
(106, 37, '2024-12-14', '11:51:25', 'masuk-2024-12-14-37.png', '-6.2893835', '107.2921809', '0000-00-00', '00:00:00', '', '', ''),
(107, 41, '2024-12-14', '11:52:15', 'masuk-2024-12-14-41.png', '-6.2896671', '107.2921596', '0000-00-00', '00:00:00', '', '', ''),
(108, 41, '2024-12-14', '11:52:15', 'masuk-2024-12-14-41.png', '-6.2896671', '107.2921596', '0000-00-00', '00:00:00', '', '', ''),
(109, 42, '2024-12-14', '12:02:51', 'masuk-2024-12-14-42.png', '-6.2893612', '107.292184', '0000-00-00', '00:00:00', '', '', ''),
(110, 43, '2024-12-14', '12:11:58', 'masuk-2024-12-14-43.png', '-6.289369', '107.292182', '0000-00-00', '00:00:00', '', '', ''),
(111, 5, '2024-12-14', '12:25:32', 'masuk-2024-12-14-5.png', '-6.2894124', '107.2921797', '0000-00-00', '00:00:00', '', '', ''),
(112, 44, '2024-12-14', '12:51:17', 'masuk-2024-12-14-44.png', '-6.2893984', '107.2921835', '2024-12-14', '12:53:28', 'keluar-2024-12-14-.png', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `status` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_pegawai`, `username`, `password`, `status`, `role`) VALUES
(1, 1, 'bintang', '$2y$10$GZw5n5Wwrj.0xQkMPxlMwuzN6WewsSEnIZifFD4i64qppyMj1a9Ou', 'Aktif', 'admin'),
(2, 2, 'yuli', '$2y$10$nYAzS45jgMba2NUBStsce.gOX6mkdLleKOkvP/m3nPbS5ntUAWSey', 'Aktif', 'admin'),
(3, 3, 'indah', '$2y$10$azHBT5PqGdEaXf9JnSMvReCc8Qfwczpx/M8II54/q3bLlMNTGAJU6', 'Aktif', 'admin'),
(4, 4, 'yesi', '$2y$10$nYAzS45jgMba2NUBStsce.gOX6mkdLleKOkvP/m3nPbS5ntUAWSey', 'Aktif', 'admin'),
(5, 5, 'iman', '$2y$10$nYAzS45jgMba2NUBStsce.gOX6mkdLleKOkvP/m3nPbS5ntUAWSey', 'Aktif', 'admin'),
(11, 12, 'rangga', '$2y$10$koJODFuR.0PeeyiFD3brsOL0Qw63Mct.JgmA4/48sls8rODBF1J8m', 'Aktif', 'pegawai'),
(12, 13, 'asep', '$2y$10$AV8zjR14AhubRn7yHgE80.WNevrhA/BQkZhIucU403G2FwAJQrrh.', 'Aktif', 'pegawai'),
(13, 14, 'shara', '$2y$10$jBpjZcXlQQsphRGponyaeOdWF/H.Un0yQ.WYRHLN5BneOPClZ1tDW', 'Aktif', 'admin'),
(21, 22, '111', '$2y$10$p5lL2f1qpkY0CNd.phYiTuoKJOWJOuM9zts5qUfvutDRUegbciv92', 'Aktif', 'pegawai'),
(22, 23, '122', '$2y$10$JpJZ5Ysx/2lFui16WOJ.N.c6ii.Fgp2t1DfMB5NtAkQlzSs89h1GW', 'Aktif', 'pegawai'),
(23, 24, '123', '$2y$10$4ExzHGGoPIbn7gVNejeHLuPhmmgim2fzXiCQnHYDPoLBqEezjLahu', 'Aktif', 'pegawai'),
(24, 25, 'rizal', '$2y$10$Yp4YW5Gsoi6o3QKSg.Izre15zzhsUC/OJSGk3SkiYTGwVNsbn.QHG', 'Aktif', 'pegawai'),
(25, 26, 'masaguss__', '$2y$10$iCkbyNK2VDI5Hf4faBuCVODgGmP1sAhJTLypGOs.XvShJLsCwlgCS', 'Aktif', 'pegawai'),
(26, 27, 'apaaja', '$2y$10$zN/SzS9845pV3Z5G7QoCnueS16LKFG9omXRYFTyoAqpZozwKJQLEK', 'Aktif', 'pegawai'),
(27, 28, 'Adhi', '$2y$10$zbynb0LoJaHJJPV8k3Dq0eOcT9OGvBAKA5vXqBQ0hdNYi.voWqUqK', 'Aktif', 'pegawai'),
(28, 29, 'anwar', '$2y$10$aqv6FgM0WCEd9Zf7FNVD8etcTQVbhEivOfswk.eMuVnyiOGnW9vU.', 'Aktif', 'pegawai'),
(29, 30, 'Fhazar', '$2y$10$r5nXS58wQUPeYuepxTLBF.08POFvvKkp/L/GYcgLszAtedPHUTZYW', 'Aktif', 'pegawai'),
(30, 31, 'Danaspryadi', '$2y$10$AytSZ0e1t4ltJeoPrjiUuen.8nCi6LWvBcV3NrvPqWGyJmKIF3q/a', 'Aktif', 'pegawai'),
(31, 32, 'angga', '$2y$10$wmZPocO4iiGy6Diia8jcA.kZc5zyv2pEqQxL2B36YWR0l726.dVCK', 'Aktif', 'pegawai'),
(32, 33, 'Ega', '$2y$10$QVGvoMtjf0Iuf.EFmCKBcukVds4aQqo88Lp5Kne3RTGupOH6pUn3G', 'Aktif', 'pegawai'),
(33, 34, 'Aldi', '$2y$10$4sko8nTUBkT6/tP9A44WYeCGmROVnFhuZeDPNUMOAIvrVjnaC8gGW', 'Aktif', 'pegawai'),
(34, 35, 'ghina', '$2y$10$3G77bstueGsc6/HX45dzIe.7bDtQvwJJLuTUE7uDMyJq5sgb8XFkS', 'Aktif', 'pegawai'),
(35, 36, 'intaannn', '$2y$10$PqG7PwzT85T5HjMQoYmaAO3NxoE23uFC181B2J9xYKxLUMm4AQzq.', 'Aktif', 'pegawai'),
(36, 37, 'mutiazahra_', '$2y$10$6Tb8pCQMb5jjaZs45lnrSOcr.hhRd4U2d1rH3OcJYTT6hTBb6QBDS', 'Aktif', 'pegawai'),
(37, 38, 'iin fadilah', '$2y$10$1krkna/aaTlMO6tqFwBcO.nH0zz7odi91FZCNYj1bqZHAtsiUl5lS', 'Aktif', 'pegawai'),
(38, 39, 'ifa_07', '$2y$10$lQhAYUSpfRYsITBN0tiOJeOC0VsY8Q620JgaYg68IQII2h.o/ouwS', 'Aktif', 'pegawai'),
(39, 40, '08122008', '$2y$10$.iogE7HcT25OMcPcdA3lq.v.vdsA9cQ92Tk7LQYlhEh/R5Qz1Ms76', 'Aktif', 'pegawai'),
(40, 41, 'fauzyah', '$2y$10$ekfMVuBKb9Dm8OTYUXPJouGY04KL4cB9o/anEtyZfIyvW56NOSErq', 'Aktif', 'pegawai'),
(41, 42, 'imansanjaya800', '$2y$10$rC4DQ8gNuUdbJRjFkZCe1uD8sam7QVrEu58Vd5vE9xnA3Z5T7AJki', 'Aktif', 'pegawai'),
(42, 43, 'jefri', '$2y$10$qpxkSRzhIwVvu9hruMgFPe2tZrDyRFlkw014MUxPIO9UBH9qrwV0S', 'Aktif', 'pegawai'),
(43, 44, 'rian', '$2y$10$rtlLITRsjkkYRVPzcjVSVeonM2MtaGe.5nZrImcxFt..Y/gggRuau', 'Aktif', 'pegawai');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `catatan_dinas`
--
ALTER TABLE `catatan_dinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ketidakhadiran`
--
ALTER TABLE `ketidakhadiran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `lokasi_presensi`
--
ALTER TABLE `lokasi_presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `catatan_dinas`
--
ALTER TABLE `catatan_dinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `ketidakhadiran`
--
ALTER TABLE `ketidakhadiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `lokasi_presensi`
--
ALTER TABLE `lokasi_presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `catatan_dinas`
--
ALTER TABLE `catatan_dinas`
  ADD CONSTRAINT `catatan_dinas_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ketidakhadiran`
--
ALTER TABLE `ketidakhadiran`
  ADD CONSTRAINT `ketidakhadiran_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
