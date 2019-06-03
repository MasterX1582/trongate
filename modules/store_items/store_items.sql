-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 03 jun 2019 om 13:33
-- Serverversie: 10.1.38-MariaDB
-- PHP-versie: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Tabelstructuur voor tabel `store_items`
--

CREATE TABLE `store_items` (
  `id` int(11) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `url_title` varchar(255) NOT NULL,
  `item_price` decimal(7,0) NOT NULL,
  `price_discount` decimal(7,0) NOT NULL,
  `item_description` text NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `store_items`
--

INSERT INTO `store_items` (`id`, `item_title`, `url_title`, `item_price`, `price_discount`, `item_description`, `picture`) VALUES
(16, 'an item 123', 'an-item-123', '123', '0', 'an item 123', 'cirquit board.jpg'),
(17, '(almost) free beer', 'almost-free-beer', '2', '0', 'Cara pils\r\n(my precious)', 'GollCarpil.jpg'),
(24, 'whaterevkldfj', 'whaterevkldfj', '1', '1000', 'whaterevkldfj', NULL),
(25, 'whaterevkldfj5458', 'whaterevkldfj5458', '2', '0', 'whaterevkldfj5458', NULL),
(26, 'whaterevkldfj545877', 'whaterevkldfj545877', '3', '0', 'whaterevkldfj545877', NULL),
(28, '111th item', '111th-item', '111', '0', '111th item', NULL),
(29, 'This is a joke', 'this-is-a-joke', '99', '0', 'This is a joke 123', NULL),
(30, 'This is a joke123', 'this-is-a-joke123', '9999', '0', 'This is a joke123', '');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `store_items`
--
ALTER TABLE `store_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `store_items`
--
ALTER TABLE `store_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
