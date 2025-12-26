-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 12:16 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pokebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`username`, `password`) VALUES
('Admin1', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'),
('Admin2', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8');

-- --------------------------------------------------------

--
-- Table structure for table `pokemons`
--

CREATE TABLE `pokemons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type1` varchar(255) NOT NULL,
  `type2` varchar(255) NOT NULL,
  `hp` int(11) NOT NULL,
  `attack` int(11) NOT NULL,
  `defense` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pokemons`
--

INSERT INTO `pokemons` (`id`, `name`, `type1`, `type2`, `hp`, `attack`, `defense`) VALUES
(1, 'Bulbasaur', 'Grass', 'Poison', 45, 49, 49),
(2, 'Charmander', 'Fire', '', 39, 52, 43),
(3, 'Squirtle', 'Water', '', 44, 48, 65),
(4, 'Caterpie', 'Bug', '', 45, 30, 35),
(5, 'Weedle', 'Bug', 'Poison', 40, 35, 30),
(6, 'Pidgey', 'Normal', 'Flying', 40, 45, 40),
(7, 'Rattata', 'Normal', '', 30, 56, 35),
(8, 'Spearow', 'Normal', 'Flying', 40, 60, 30),
(9, 'Ekans', 'Poison', '', 35, 60, 44),
(10, 'Pikachu', 'Electric', '', 35, 55, 40),
(11, 'Sandshrew', 'Ground', '', 50, 75, 85),
(12, 'Nidoran-F', 'Poison', '', 55, 47, 52),
(13, 'Nidoran-M', 'Poison', '', 46, 57, 40),
(14, 'Clefairy', 'Fairy', '', 70, 45, 48),
(15, 'Vulpix', 'Fire', '', 38, 41, 40),
(16, 'Jigglypuff', 'Normal', 'Fairy', 115, 45, 20),
(17, 'Zubat', 'Poison', 'Flying', 40, 45, 35),
(18, 'Oddish', 'Grass', 'Poison', 45, 50, 55),
(19, 'Paras', 'Bug', 'Grass', 35, 70, 55),
(20, 'Venonat', 'Bug', 'Poison', 60, 55, 50),
(21, 'Diglett', 'Ground', '', 10, 55, 25),
(22, 'Meowth', 'Normal', '', 40, 45, 35),
(23, 'Psyduck', 'Water', '', 50, 52, 48),
(24, 'Mankey', 'Fighting', '', 40, 80, 35),
(25, 'Growlithe', 'Fire', '', 55, 70, 45),
(26, 'Poliwag', 'Water', '', 40, 50, 40),
(27, 'Abra', 'Psychic', '', 25, 20, 15),
(28, 'Machop', 'Fighting', '', 70, 80, 50),
(29, 'Bellsprout', 'Grass', 'Poison', 50, 75, 35),
(30, 'Tentacool', 'Water', 'Poison', 40, 40, 35),
(31, 'Ponyta', 'Fire', '', 50, 85, 55),
(32, 'Slowpoke', 'Water', 'Psychic', 90, 65, 65),
(33, 'Magnemite', 'Electric', 'Steel', 25, 35, 70),
(34, 'Doduo', 'Normal', 'Flying', 35, 85, 45),
(35, 'Seel', 'Water', '', 65, 45, 55),
(36, 'Grimer', 'Poison', '', 80, 80, 50),
(37, 'Shellder', 'Water', '', 30, 65, 100),
(38, 'Gastly', 'Ghost', 'Poison', 30, 35, 30),
(39, 'Drowzee', 'Psychic', '', 60, 48, 45),
(40, 'Krabby', 'Water', '', 30, 105, 90),
(41, 'Voltorb', 'Electric', '', 40, 30, 50),
(42, 'Exeggcute', 'Grass', 'Psychic', 60, 40, 80),
(43, 'Cubone', 'Ground', '', 50, 50, 95),
(44, 'Koffing', 'Poison', '', 40, 65, 95),
(45, 'Rhyhorn', 'Ground', 'Rock', 80, 85, 95),
(46, 'Horsea', 'Water', '', 30, 40, 70),
(47, 'Goldeen', 'Water', '', 45, 67, 60),
(48, 'Staryu', 'Water', '', 30, 45, 55),
(49, 'Magikarp', 'Water', '', 20, 10, 55),
(50, 'Eevee', 'Normal', '', 55, 55, 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pokemons`
--
ALTER TABLE `pokemons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pokemons`
--
ALTER TABLE `pokemons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
