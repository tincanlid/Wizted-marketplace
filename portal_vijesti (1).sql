-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 08:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portal_vijesti`
--
CREATE DATABASE IF NOT EXISTS `portal_vijesti` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `portal_vijesti`;

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(255) NOT NULL,
  `prezime` varchar(255) NOT NULL,
  `korisnicko_ime` varchar(255) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razina` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(1, 'tin', 'tkalec', 'admin', '$2y$10$YLGH3A3IO6VqsTg2hbe0Uu1NT7FVGw5UyqFY70dZAo3Gs5E8qp4i.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `naslov` varchar(255) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(255) NOT NULL,
  `kategorija` varchar(50) NOT NULL,
  `arhiva` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(5, '2026-06-21 19:26:16', 'Zlobni štapić iz tamnice', 'Cijena: 35 Galeona | Stanje rabljenosti: Novo', 'Izuzetno moćan štapić, dužine 20 inča, krut. Idealan za napredne čarolije i kletve.', 'wand1.jpg', 'Štapići', 0),
(6, '2026-06-21 19:30:47', 'Štapić od mahagonija', 'Cijena: 5 Galeona | Stanje rabljenosti: Korišteno', 'običan štapić našo sam ga u svojoj šumi\r\nmuislim da je neopasan', 'wand2.jpg', 'Štapići', 0),
(7, '2026-06-21 19:34:33', 'Kraljevska grimizna', 'Cijena: 55 Galeona | Stanje rabljenosti: Novo', 'Čarobni štapić naslijeđen iz kraljevske loze. Utjelovljuje život u krvi, ali i smrt koja dolazi za sve.', 'wand3.jpg', 'Štapići', 0),
(8, '2026-06-21 19:38:55', 'Ručno izrađeni vještičji štapić od ametista', 'Cijena: 42 Galeona | Stanje rabljenosti: Relativno novo', 'Մի՛ գնեք', 'wand4.jpg', 'Štapići', 0),
(9, '2026-06-21 19:43:21', 'Bijela čarobnjačka odura', 'Cijena: 60 Galeona | Stanje rabljenosti: Dobro', 'Izrađena od teškog, prirodnog pamuka, izražava mudrost koja nadilazi stoljeća. Ovaj trodijelni ansambl uključuje unutarnju haljinu, vanjski ogrtač i dugi pojas.', 'roba1.jpg', 'Odjeća i odore', 0),
(10, '2026-06-21 19:46:10', 'Zlobni ogrtač: Dugi ogrtač s kapuljačom', 'Cijena: 6 Duša | Stanje rabljenosti: Izrazito rabljeno', 'Ovaj dugi ogrtač s kapuljačom je poderan kao da je vidio dubine bitke u divljini.', 'roba2.jpg', 'Odjeća i odore', 0),
(12, '2026-06-21 19:53:51', 'Roba drevnog čarobnjaka', 'Cijena: 120 Galeona | Stanje rabljenosti: Staro', 'Roba od odumrlog čarobnjaka nađena na vrhu planine', 'roba4.jpg', 'Odjeća i odore', 0),
(13, '2026-06-21 20:09:10', 'Uniforma sjenskih čarobnjaka', 'Cijena: 30 Galeona | Stanje: Novo', 'Od bande sjenskih čarobnjaka!!!', 'roba5.jpg', 'Odjeća i odore', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`),
  ADD UNIQUE KEY `korisnicko_ime_2` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
