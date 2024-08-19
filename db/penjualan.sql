-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Apr 2021 pada 08.21
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `kode_admin` varchar(50) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`kode_admin`, `nama_admin`, `username`, `password`) VALUES
('ADM001', 'Taufik Rahman', 'taufikrahman', '$2y$10$J08yH3fRMzvJvOKIkKsg7e4VWgBBBolScPmebEmw55osy8Ht3bcSO'),
('ADM002', 'Novian', 'novian', '$2y$10$.StOppvgR/6WXQNffOcrCOugK.A8HkC5AUeXDUhwRmacPCNjO3xGq'),
('ADM003', 'Andi', 'andi', '$2y$10$mAxb3tJUFQsjrQzt/xJwqedjFlgMDa.YWjSAtO4BL7OGsAEcJR6wW');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` varchar(100) NOT NULL,
  `stok` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `harga`, `stok`) VALUES
('BRG001', 'Printer Canon 237', '1000000', '4'),
('BRG002', 'Printer Canon 287', '1200000', '5'),
('BRG003', 'Stik PS', '120000', '5'),
('BRG004', 'Keyboard External', '500000', '6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_jual`
--

CREATE TABLE `detail_jual` (
  `kode_jual` varchar(50) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `harga` int(50) NOT NULL,
  `jumlah` int(50) NOT NULL,
  `subtotal` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_jual`
--

INSERT INTO `detail_jual` (`kode_jual`, `kode_barang`, `harga`, `jumlah`, `subtotal`) VALUES
('JUAL000000001', 'BRG001', 1000000, 1, 1000000),
('JUAL000000002', 'BRG001', 1000000, 1, 1000000),
('JUAL000000003', 'BRG002', 1200000, 1, 1200000),
('JUAL000000004', 'BRG001', 1000000, 1, 1000000),
('JUAL000000005', 'BRG002', 1200000, 2, 2400000),
('JUAL000000006', 'BRG002', 1200000, 1, 1200000),
('JUAL000000007', 'BRG003', 120000, 4, 480000),
('JUAL000000008', 'BRG002', 1200000, 1, 1200000),
('JUAL000000009', 'BRG003', 120000, 1, 120000),
('JUAL000000010', 'BRG004', 500000, 3, 1500000),
('JUAL000000011', 'BRG001', 1000000, 1, 1000000),
('JUAL000000012', 'BRG004', 500000, 1, 500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jual`
--

CREATE TABLE `jual` (
  `kode_jual` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_admin` varchar(50) NOT NULL,
  `kode_pelanggan` varchar(50) NOT NULL,
  `total` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jual`
--

INSERT INTO `jual` (`kode_jual`, `tanggal`, `kode_admin`, `kode_pelanggan`, `total`) VALUES
('JUAL000000001', '2021-04-07', 'ADM002', 'PGN001', 1000000),
('JUAL000000002', '2021-04-07', 'ADM002', 'PGN001', 1000000),
('JUAL000000003', '2021-04-07', 'ADM002', 'PGN001', 1200000),
('JUAL000000004', '2021-04-08', 'ADM001', 'PGN001', 1000000),
('JUAL000000005', '2021-04-08', 'ADM001', 'PGN001', 2400000),
('JUAL000000006', '2021-04-08', 'ADM002', 'PGN001', 1200000),
('JUAL000000007', '2021-04-17', 'ADM002', 'PGN002', 480000),
('JUAL000000008', '2021-04-17', 'ADM002', 'PGN001', 1200000),
('JUAL000000009', '2021-04-17', 'ADM002', 'PGN001', 120000),
('JUAL000000010', '2021-04-18', 'ADM001', 'PGN002', 1500000),
('JUAL000000011', '2021-04-18', 'ADM001', 'PGN002', 1000000),
('JUAL000000012', '2021-04-18', 'ADM001', 'PGN002', 500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `kode_jual` varchar(50) NOT NULL,
  `kode_admin` varchar(50) NOT NULL,
  `kode_pelanggan` varchar(50) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `harga` int(50) NOT NULL,
  `jumlah` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `kode_pelanggan` varchar(50) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`kode_pelanggan`, `nama_pelanggan`, `alamat`, `telepon`) VALUES
('PGN001', 'Andi', 'Tanjung ', '082147483647'),
('PGN002', 'Ainur Rahmah', 'Balangan', '081565403576'),
('PGN003', 'Nimatul Izati', 'Banjarmasin', '085245672584');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`kode_admin`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indeks untuk tabel `detail_jual`
--
ALTER TABLE `detail_jual`
  ADD PRIMARY KEY (`kode_jual`);

--
-- Indeks untuk tabel `jual`
--
ALTER TABLE `jual`
  ADD PRIMARY KEY (`kode_jual`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`kode_jual`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`kode_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
