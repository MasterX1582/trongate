-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Gegenereerd op: 29 mei 2019 om 18:20
-- Serverversie: 5.7.26-0ubuntu0.16.04.1
-- PHP-versie: 7.0.33-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trongate_framework_test`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `age` varchar(3) NOT NULL,
  `hometown` varchar(60) NOT NULL,
  `job` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `staff`
--

INSERT INTO `staff` (`id`, `firstname`, `lastname`, `age`, `hometown`, `job`) VALUES
(18, 'Glenn', 'Quagmire', '41', 'Quahog', 'Pilot'),
(27, 'Peter', 'Griffin', '41', 'Quahog', 'Brewery'),
(59, 'Lois', 'Griffin', '40', 'Newport', 'Piano Teacher'),
(64, 'Homer', 'Simpson', '40', 'Newport', 'Power Plant Worker'),
(198, 'Henry', 'Lejeune', '48', 'Paris', 'Judge'),
(5165, 'Christopher', 'Colombus', '37', 'Madrid', 'Sailor'),
(5698, 'Christian', 'Andressen', '39', 'Glasgow', 'Web Developer');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5997;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;