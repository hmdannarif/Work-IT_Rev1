-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Waktu pembuatan: 06 Jun 2024 pada 05.52
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
-- Database: `jobfinder`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `histori`
--

CREATE TABLE `histori` (
  `Id_user` int(11) NOT NULL,
  `Id_lamaran` int(11) NOT NULL,
  `Nama_lamaran` text NOT NULL,
  `Id_histori` int(11) NOT NULL,
  `Status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `histori`
--

INSERT INTO `histori` (`Id_user`, `Id_lamaran`, `Nama_lamaran`, `Id_histori`, `Status`) VALUES
(1, 12, 'FRONTEND BENer', 12, 'Ditolak'),
(1, 13, 'Backend bagus', 15, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lamaran`
--

CREATE TABLE `lamaran` (
  `ID_lamaran` int(11) NOT NULL,
  `NamaLamaran` text NOT NULL,
  `Tanggal_lamaran` date NOT NULL,
  `Spesifikasi` text NOT NULL,
  `Id_user` int(11) NOT NULL,
  `Max_lamaran` int(50) NOT NULL,
  `Total_lamaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lamaran`
--

INSERT INTO `lamaran` (`ID_lamaran`, `NamaLamaran`, `Tanggal_lamaran`, `Spesifikasi`, `Id_user`, `Max_lamaran`, `Total_lamaran`) VALUES
(12, 'FRONTEND BENer', '2024-05-28', 'maknyus', 4, 2, 6),
(13, 'Backend bagus', '2023-10-12', 'Bagus banget', 4, 2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelamar`
--

CREATE TABLE `pelamar` (
  `Id_Pelamar` int(11) NOT NULL,
  `Foto` varchar(200) NOT NULL,
  `Keahlian` text NOT NULL,
  `CV` varchar(200) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelamar`
--

INSERT INTO `pelamar` (`Id_Pelamar`, `Foto`, `Keahlian`, `CV`, `id_user`) VALUES
(3, 'h.jpeg', 'PHP Jos', '', 1),
(6, 'foto/WhatsApp Image 2024-04-03 at 14.58.16.jpeg', 'MAKNA AJA DULU', 'Kuis 9_OAK.pdf', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembuat_lamaran`
--

CREATE TABLE `pembuat_lamaran` (
  `Id_pembuat_lamaran` int(11) NOT NULL,
  `Nama_tempat` text NOT NULL,
  `Nama_perusahaan` text NOT NULL,
  `Id_user` int(11) NOT NULL,
  `FotoPerusahaan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembuat_lamaran`
--

INSERT INTO `pembuat_lamaran` (`Id_pembuat_lamaran`, `Nama_tempat`, `Nama_perusahaan`, `Id_user`, `FotoPerusahaan`) VALUES
(1, 'Berlinus karambus', 'NAYA THE EMPEROR', 4, 'KTM Zahran-1.png'),
(9, '', '', 8, ''),
(10, 'Bali', 'Bali Travel', 11, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `terlamar`
--

CREATE TABLE `terlamar` (
  `Id_user` int(11) NOT NULL,
  `Id_lamaran` int(11) NOT NULL,
  `user_CV` text NOT NULL,
  `User_photo` text NOT NULL,
  `Id_terlamar` int(11) NOT NULL,
  `Nama_user` text NOT NULL,
  `Nama_lamaran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `terlamar`
--

INSERT INTO `terlamar` (`Id_user`, `Id_lamaran`, `user_CV`, `User_photo`, `Id_terlamar`, `Nama_user`, `Nama_lamaran`) VALUES
(1, 12, '', 'h.jpeg', 44, 'Berluni', 'FRONTEND BENer'),
(1, 13, '', 'h.jpeg', 45, 'Berluni', 'Backend bagus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `Nama` text NOT NULL,
  `user_password` text NOT NULL,
  `user_Email` text NOT NULL,
  `User_telepon` int(11) NOT NULL,
  `jenis_user` enum('Pelamar','Pembuat_lamaran') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `Nama`, `user_password`, `user_Email`, `User_telepon`, `jenis_user`) VALUES
(1, 'Berlin Napoleon', 'Berluni', 'LEXISU', 'berlina@gmail.com', 8677019, 'Pelamar'),
(4, 'Darrel', 'Darrel Azmi', '1234', 'Darrel@gmail.com', 8789016, 'Pembuat_lamaran'),
(8, 'Itadori', 'Yuji', 'YUGI123', 'Yuji@gmail.com', 8991232, 'Pembuat_lamaran'),
(9, 'Yudanor', 'Yuda tringara', 'LEXISU1212', 'Yuda@gmail.com', 8677019, 'Pembuat_lamaran'),
(10, 'Berlina', 'dablin', 'LEXIS', 'dablin@gmail.com', 211111, 'Pelamar'),
(11, 'cahya', 'Cahya Ganteng', 'cahya123', 'cahya@gmail.com', 98111882, 'Pembuat_lamaran');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `histori`
--
ALTER TABLE `histori`
  ADD PRIMARY KEY (`Id_histori`),
  ADD KEY `Id_user` (`Id_user`),
  ADD KEY `Id_lamaran` (`Id_lamaran`);

--
-- Indeks untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`ID_lamaran`),
  ADD KEY `Id_user` (`Id_user`);

--
-- Indeks untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  ADD PRIMARY KEY (`Id_Pelamar`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pembuat_lamaran`
--
ALTER TABLE `pembuat_lamaran`
  ADD PRIMARY KEY (`Id_pembuat_lamaran`),
  ADD KEY `Id_user` (`Id_user`);

--
-- Indeks untuk tabel `terlamar`
--
ALTER TABLE `terlamar`
  ADD PRIMARY KEY (`Id_terlamar`),
  ADD KEY `Id_user` (`Id_user`),
  ADD KEY `Id_lamaran` (`Id_lamaran`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `histori`
--
ALTER TABLE `histori`
  MODIFY `Id_histori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `ID_lamaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  MODIFY `Id_Pelamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pembuat_lamaran`
--
ALTER TABLE `pembuat_lamaran`
  MODIFY `Id_pembuat_lamaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `terlamar`
--
ALTER TABLE `terlamar`
  MODIFY `Id_terlamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD CONSTRAINT `lamaran_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  ADD CONSTRAINT `pelamar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembuat_lamaran`
--
ALTER TABLE `pembuat_lamaran`
  ADD CONSTRAINT `pembuat_lamaran_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
